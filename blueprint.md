# Blueprint Aplikasi — Sistem Informasi P2 Bandara Aceh

## 1. Ringkasan Proyek

Aplikasi berbasis **Laravel 12** untuk mendukung administrasi dan dokumentasi kegiatan **Pengawasan dan Penindakan (P2)** Kantor Bea Cukai (KBC 0102 — Banda Aceh). Aplikasi ini menangani seluruh siklus dokumen sejak penindakan barang terjadi hingga barang tersebut selesai diproses: mulai dari pemeriksaan badan, pembuatan Surat Bukti Penindakan (SBP) beserta berkas turunannya, pelaporan pelaksanaan tugas, serah terima barang, pencacahan/inventarisasi rinci barang bukti, sampai pencetakan berbagai Berita Acara (BA) dalam format PDF siap tanda tangan.

Karakteristik utama:
- **Tidak ada sistem autentikasi/login.** Semua route bersifat publik (tidak ada middleware `auth`, tidak ada tabel sesi user yang dipakai, tidak ada halaman login). Aplikasi diasumsikan berjalan di jaringan internal/terbatas.
- **Database:** SQLite (`DB_CONNECTION=sqlite`), cocok untuk deployment single-instance/internal.
- **UI:** Template admin **CoreUI** (Bootstrap-based) dengan Blade templating, jQuery untuk interaksi form dinamis (modal, AJAX, dropdown berantai).
- **Pencetakan dokumen:** kombinasi **barryvdh/laravel-dompdf** (render Blade → PDF, kertas custom ukuran F4) dan **setasign/fpdi** (menggabungkan beberapa PDF hasil render menjadi satu dokumen, dipakai khusus pada cetak Pencacahan yang punya lampiran per kategori).
- **Upload foto:** dua generasi. Foto lama disimpan manual ke disk (`app/Models/LptPhoto`, `PencacahanPhoto`) — kini dipertahankan hanya sebagai arsip riwayat migrasi. Foto baru dikelola oleh **Spatie MediaLibrary** (tabel `media`), disimpan di disk `local` (privat, tidak bisa diakses langsung via URL publik) dan disajikan lewat route khusus yang stream isi file dengan header `Content-Type` sesuai mime aslinya.
- **Kompresi gambar otomatis:** `PhotoUploadService` (pakai `intervention/image`) mengecilkan foto yang lebih besar dari ambang batas (300 KB) secara bertahap (resize + turunkan kualitas JPEG) sebelum disimpan.
- **Export Excel:** `maatwebsite/excel` untuk data SBP.
- **Halaman "Database Explorer"** bawaan aplikasi: memperlihatkan seluruh tabel database dan isinya langsung dari browser — alat bantu debug/administrasi data tanpa perlu akses terminal/DB client, tapi juga berarti **seluruh isi database bisa dibuka siapa pun yang punya akses ke aplikasi** (lihat catatan keamanan di §8).

## 2. Struktur Navigasi (Sidebar)

| Grup | Menu | Route |
|---|---|---|
| — | Dashboard | `dashboard` |
| Pemeriksaan | Pemeriksaan Badan | `pemeriksaan-badan.index` |
| Penindakan | Input SBP | `sbp.create` |
| Penindakan | Data SBP | `sbp.index` |
| Penindakan | Data LPT | `lpt.index` |
| Pencacahan | Berita Acara Pencacahan | `pencacahan.index` |
| Referensi | Data Petugas | `petugas.index` |
| Referensi | Referensi Pelanggaran | `ref-pelanggaran.index` |
| Referensi | Referensi Satuan | `ref-satuan.index` |
| Referensi | Referensi Jenis Barang | `ref-jenis-barang.index` |
| Referensi | Referensi Surat Perintah | `surat-perintah.index` |
| Referensi | Referensi Tarif Cukai | `ref-tarif-cukai.index` |
| System | Database | `database.database` |

## 3. Dashboard

**Controller:** `DashboardController` · **View:** `dashboard.blade.php`

Halaman ringkasan berbasis data SBP, menampilkan:
- **Widget angka:** total SBP, total Petugas, jumlah kasus **Cukai** (jenis barang: Hasil Tembakau, Minuman Mengandung Etil Alkohol, Etil Alkohol) vs jumlah kasus **Kepabeanan** (selain itu).
- **Pie chart** — distribusi SBP per jenis barang.
- **Bar chart** — Top 5 Kota lokasi penindakan.
- **Bar chart** — Top 5 Kecamatan lokasi penindakan.
- **Line/tren chart** — jumlah penindakan per bulan (agregasi `strftime` khusus SQLite).

## 4. Modul: SBP (Surat Bukti Penindakan)

Modul inti aplikasi. **Model:** `Sbp` (soft delete) · **Controller:** `SbpController` · **Service:** `SbpService` · **Form Request:** `BaseSbpRequest` → `StoreSbpRequest`, `UpdateSbpRequest` · **Export:** `SbpExport`.

### 4.1 Skema Penomoran Otomatis

Satu SBP menghasilkan **4 nomor dokumen sekaligus** dari satu nomor urut + tahun (`Sbp::buildNomorSet()`):
- `SBP-{n}/KBC.0102/{tahun}`
- `BA-{n}/RIKSA/KBC.010202/{tahun}` (Berita Acara Pemeriksaan)
- `BA-{n}/TEGAH/KBC.010202/{tahun}` (Berita Acara Penegahan)
- `BA-{n}/SEGEL/KBC.010202/{tahun}` (Berita Acara Penyegelan)

- Endpoint `sbp.get-last-number` mengembalikan nomor urut berikutnya (nomor tertinggi tahun berjalan + 1) untuk auto-fill di form.
- **Proteksi keunikan dua lapis:**
  1. Validasi aplikatif di `BaseSbpRequest::withValidator()` — cek nomor SBP terformat belum dipakai baris aktif (bukan soft-deleted).
  2. **Unique index di level database** pada kolom tersembunyi `nomor_sbp_active` (di-set otomatis lewat model event `saving`, bernilai `null` saat baris di-soft-delete) — mencegah race condition dua user submit nomor sama bersamaan.
- **Auto-retry saat race condition:** jika constraint DB tetap terlanggar (nomor direbut proses lain persis setelah validasi lolos), `SbpService::saveWithNomorRetry()` otomatis mencoba nomor+1 hingga 5 kali, lalu menampilkan notifikasi bahwa nomor otomatis disesuaikan. Jika tetap gagal, dilempar error validasi.
- Saat SBP dihapus (soft delete), `nomor_sbp_active` dikosongkan agar nomor tersebut bisa dipakai ulang oleh SBP baru — sementara `nomor_sbp` (kolom asli) tetap tersimpan untuk histori.

### 4.2 Data yang Dicatat per SBP

- Penomoran & tanggal (SBP, BA Riksa, BA Tegah, BA Segel, Surat Perintah — surat perintah bisa dipilih dari dropdown referensi, tanggal ikut terisi otomatis).
- **Identitas pelaku:** nama, jenis & nomor identitas, jenis kelamin, no HP, alamat di Indonesia.
- **Detail penindakan:** lokasi (dengan dropdown kota → kecamatan berantai, lihat §7.3), waktu, alasan penindakan, kota/kecamatan penindakan.
- **Barang bukti:** jenis barang, jumlah, satuan (relasi ke referensi), uraian, kondisi barang.
- **Petugas:** dua petugas (`id_petugas_1`, `id_petugas_2`, wajib berbeda — validasi `different`), nama disalin ke kolom `nama_petugas_1/2` saat simpan agar histori dokumen tidak berubah walau data petugas induk diedit kemudian.
- **Flag opsional:**
  - `flag_bast` — jika dicentang, otomatis membuat/mengelola record `Bast` terkait (lihat §4.4) dengan sub-form khusus.
  - `flag_ba_musnah` — jika dicentang, mengaktifkan input nomor BA Musnah dan tombol cetak dokumen pemusnahan.

### 4.3 Relasi Data

- `Sbp` **hasOne** `Bast` (serah terima), **hasOne** `Lpt`, **belongsToMany** `Pencacahan` (lewat pivot `pencacahan_sbp`), **belongsTo** `Petugas` (×2, `withTrashed`).
- **Cascade konsisten via model event** (`Sbp::booted()`):
  - `deleting` (soft) → BAST ikut di-soft-delete; (force) → BAST ikut di-force-delete.
  - `restoring` → BAST terkait ikut direstore.
  - Menjamin dokumen SBP dan BAST-nya selalu konsisten status hapus/aktifnya tanpa perlu logic manual di controller.

### 4.4 CRUD & Alur

- **Create** (`sbp.create` / `input-sbp.blade.php`): form multi-bagian (partial: penomoran, identitas pelaku, detail penindakan, barang bukti, petugas, modal pelanggaran, modal BAST) dengan dropdown Surat Perintah yang mengisi otomatis nomor & tanggal.
- **Index** (`sbp.index` / `data-sbp.blade.php`): daftar dengan paginasi 10/hal, **pencarian** (nomor SBP, nama pelaku, jenis/nomor identitas, jenis barang) dan **filter rentang tanggal**.
- **Edit** (`sbp.edit`) — form sama dengan create, nomor urut diekstrak ulang dari `nomor_sbp` tersimpan via regex.
- **Delete** (`sbp.destroy`) — soft delete, cascading ke BAST.
- **Export Excel** (`sbp.export.excel`) — hormat filter pencarian & rentang tanggal yang sama dengan index; nama file otomatis memuat rentang tanggal.
- **API ringan** (`sbp.api.show`) — `GET /api/sbp/{id}` mengembalikan data SBP mentah dalam JSON (dipakai internal oleh form lain, misal Pencacahan, untuk mengambil detail SBP tanpa reload halaman).

### 4.5 Cetak Dokumen (PDF)

Semua di-render ke kertas kustom **F4 (595.28 × 935.43 pt)**, potret, via DomPDF, kemudian di-`stream()` langsung ke browser (bukan diunduh paksa):

| Route | Dokumen |
|---|---|
| `sbp.cetak.preview` | Pratinjau (iframe) sebelum cetak — validasi parameter `back` untuk cegah open-redirect (host harus sama dengan `config('app.url')`) |
| `sbp.pdf` | SBP |
| `sbp.pdf.ba-riksa` | Berita Acara Pemeriksaan |
| `sbp.pdf.ba-tegah` | Berita Acara Penegahan |
| `sbp.pdf.ba-segel` | Berita Acara Penyegelan |
| `sbp.pdf.bast` | Berita Acara Serah Terima (butuh `Bast` terkait; jika belum ada → redirect dengan error) |
| `sbp.pdf.semua` | Gabungan seluruh dokumen SBP dalam satu file |
| `sbp.pdf.checklist` | **Checklist kelengkapan berkas** — daftar ~35 jenis dokumen standar proses penindakan (LPPI, LKAI, NHI, dsb.), status centang otomatis untuk item yang datanya sudah ada di sistem (Surat Perintah, BA Riksa/Tegah/Segel, SBP, LPT, BAST, BA Musnah), sisanya manual |
| `sbp.pdf.label` | Label Barang ukuran kecil (12×8 cm) untuk ditempel di barang bukti fisik |
| `sbp.cetak.ba-musnah` | Berita Acara Pemusnahan (hanya jika `flag_ba_musnah` aktif & nomor terisi) |

## 5. Modul: Pemeriksaan Badan

**Model:** `PemeriksaanBadan` · **Controller:** `PemeriksaanBadanController`

Dokumentasi pemeriksaan fisik terhadap seseorang (mis. penumpang) — terpisah dari SBP karena tidak selalu berujung penindakan barang.

- Data: nomor & tanggal BA Riksa, referensi surat perintah, identitas lengkap orang yang diperiksa (nama, jenis/no identitas, tempat & tanggal lahir, jenis kelamin, **kewarganegaraan** — dropdown daftar negara lengkap hardcode di controller, alamat identitas & tempat tinggal, asal & tujuan perjalanan), lokasi & jenis pemeriksaan, hasil pemeriksaan, rekan perjalanan, data sarana angkut (nama sarkut, no register), dokumen barang terkait (jenis, nomor, tanggal), dua petugas pemeriksa (**wajib berbeda** — validasi `different:id_petugas_1`, disamakan dengan SBP & Pencacahan).
- **Penomoran otomatis:** endpoint `pemeriksaan-badan.get-last-number` menghitung nomor urut berikutnya dari pola `BA-{n}` tahun berjalan (regex, bukan kolom integer terpisah seperti SBP).
- **Soft delete** — model kini pakai `SoftDeletes` (sebelumnya hapus permanen); data terhapus tetap tersimpan di database dan bisa dipulihkan.
- CRUD lengkap kecuali `show` (tidak ada halaman detail terpisah — cukup index/edit). Form create/edit dan index sudah dirapikan ulang (perataan teks kiri pada tabel, tombol aksi diberi `title` tooltip) tanpa mengubah field data.
- **Cetak PDF** (`pemeriksaan-badan.cetak`): kertas custom (609.45 × 935.43 pt), memuat representasi tanggal dalam kalimat terbilang Bahasa Indonesia (`TerbilangHelper`, lokal Carbon `id`).

## 6. Modul: LPT (Laporan Pelaksanaan Tugas)

**Model:** `Lpt` (soft delete, `InteractsWithMedia`) · **Controller:** `LptController`

- Setiap LPT **terikat 1:1 ke sebuah SBP** (`sbp_id`, relasi `belongsTo`); tabel SBP dipilih lewat modal AJAX (partial `sbp-table.blade.php`) yang bisa dipanggil ulang saat create maupun edit.
- Jenis LPT saat ini hanya satu opsi aktif: **`bandara`** (LPT Penindakan Bandara) — struktur kode (`getJenisLptOptions()`) sudah disiapkan untuk menambah jenis LPT lain di masa depan.
- **Penomoran:** `nomor_lpt_int` diinput manual, diformat otomatis jadi `LPT-{n}/KBC.0102/{tahun}` (tahun diambil dari `tanggal_lpt`). Unique per tahun aktif (mengabaikan baris yang sudah soft-deleted).
- **Proteksi keunikan nomor di level database** (pola identik dengan `nomor_sbp_active` di SBP, §4.1): kolom tersembunyi `nomor_lpt_int_active` disinkronkan otomatis lewat model event `saving` (`null` jika baris soft-deleted), dilindungi unique index. Mencegah dua LPT punya nomor sama akibat race condition, sekaligus mengizinkan nomor dipakai ulang setelah LPT lama dihapus.
- **Upload foto (multi-file, Spatie MediaLibrary, collection `photos`):**
  - Validasi: image (`jpeg,png,jpg,gif`), maks 10 MB/file. **SVG tidak lagi diterima** (dihapus dari daftar mime yang diizinkan — mencegah risiko XSS lewat SVG yang bisa memuat script).
  - Otomatis dikompresi (`PhotoUploadService::compressInPlace`) jika ukuran > 300 KB, sebelum masuk MediaLibrary.
  - Nama file di-random (40 karakter) — mencegah tabrakan nama & mengaburkan nama asli file.
  - Saat edit, foto lama bisa dihapus satuan lewat `deleted_photos[]` (ID media), foto baru ditambahkan tanpa menghapus yang lama (append, bukan replace).
- **Akses foto privat:** route `lpt.showPhoto` men-stream isi file dari disk `local` (bukan URL publik langsung) berdasarkan ID record `Media`, dengan header `Content-Type` sesuai mime asli.
- **Preview/cetak PDF** (`lpt.preview`) — kertas F4, memuat data SBP & BAST terkait.
- **Laporan WhatsApp** (`lpt.laporan-wa`) — meng-generate **teks polos** (bukan PDF) dari template Blade (`template-laporan-wa/template-penindakan-bandara.blade.php`), dirender sebagai `text/plain`, dimaksudkan untuk disalin-tempel langsung ke pesan WhatsApp pelaporan cepat ke atasan/rekan kerja.
- Ada tabel `lpt_photos` (model `LptPhoto`) sebagai jejak riwayat foto generasi lama (sebelum migrasi ke Spatie MediaLibrary), dipertahankan hanya untuk referensi — lihat §9 (Console Commands migrasi).

## 7. Modul: Pencacahan (Berita Acara Pencacahan Barang)

Modul paling kompleks di aplikasi ini — **inventarisasi rinci per-item** dari barang bukti yang tercantum di satu atau lebih SBP.

**Model:** `Pencacahan`, `PencacahanSbp` (pivot kustom + `InteractsWithMedia`), `DetailPencacahan` · **Controller:** `PencacahanController` (488 baris — terbesar di aplikasi) · **Service:** `PhotoUploadService`.

### 7.1 Struktur Data (3 Level)

```
Pencacahan (1 dokumen BA Cacah)
 └─ PencacahanSbp (pivot: 1 SBP yang ikut dicacah dalam BA ini, + 1 foto/singleFile via MediaLibrary)
     └─ DetailPencacahan (banyak baris: setiap baris = 1 item/jenis barang spesifik)
```

- `Pencacahan` memakai **custom pivot model** `PencacahanSbp` (bukan pivot default Laravel) agar pivot bisa punya ID sendiri, relasi `details()`, dan koleksi media sendiri (`registerMediaCollections()` → collection `foto`, `singleFile()`, disk `local`).
- `Pencacahan::details()` adalah **hasManyThrough** 2 lapis melalui pivot — memudahkan ambil semua detail barang milik satu dokumen BA Cacah lintas semua SBP-nya sekaligus.
- **Klasifikasi otomatis Cukai vs Pabean:** `DetailPencacahan::kategoriLampiran()` menentukan kategori lampiran cetak berdasarkan nama jenis barang (daftar tetap: Hasil Tembakau, Etil Alkohol, Minuman Mengandung Etil Alkohol, Pita Cukai = Cukai; selain itu = Pabean). Dipakai untuk memisah lampiran cetak (§7.5) dan agar SBP yang tidak relevan tidak ikut tercetak kosong di kategori tersebut (`Pencacahan::sbpUntukKategori()`).

### 7.2 Form Barang Dinamis (Conditional Fields)

`DetailPencacahan` punya ~35 kolom opsional yang menampung atribut berbeda-beda tergantung jenis barang — field yang relevan disaring lewat `array_intersect_key` terhadap `$fillable` saat simpan (kolom yang tidak dipakai jenis barang tsb otomatis diabaikan, bukan error).

- Endpoint AJAX `pencacahan.getBarangFields` (`POST`) menerima `id_jenis_barang`, mengembalikan **fragmen HTML form** (bukan JSON) sesuai jenis barang:
  - **View kondisional** (`_conditional.blade.php`) untuk 27 jenis barang berdaftar (Hasil Tembakau, HP/Gadget, Elektronik, Kendaraan Darat/Air/Udara, MMEA, Etil Alkohol, Pita Cukai, Narkotika, Senjata Api, Uang Tunai, CITES, Logam Mulia, Crude Oil, CPO & turunannya, Bahan Kimia, Radioaktif, Hewan/Tumbuhan non-CITES, Cagar Budaya, Kayu & Rotan, Produk HAKI, Alat Kesehatan, Kosmetik, Obat-obatan, Kayu Olahan) — tiap jenis menampilkan kolom spesifik (mis. IMEI untuk HP, kadar alkohol untuk MMEA, no BPOM untuk obat, dsb.).
  - **View default** (`_default.blade.php`) untuk jenis barang di luar daftar tersebut — field generik (jumlah, satuan, uraian).
- **Satuan default otomatis:** setiap `RefJenisBarang` punya `id_satuan_default` (relasi ke `RefSatuan`); saat jenis barang dipilih di form, dropdown Satuan ikut terisi otomatis (bisa diubah manual oleh user) — nilai default dikelola lewat halaman Referensi Jenis Barang.
- **Representasi kuantitas tampilan** (`DetailPencacahan::jumlahTampil`, accessor): karena kolom "jumlah" berbeda per jenis barang, accessor ini memilih otomatis field mana yang relevan untuk ditampilkan (`jumlah`+satuan → `total_batang` → `jumlah_botol` → `jumlah_kemasan` → `berat` gram → `volume` → fallback `"1"` untuk barang yang form-nya tak punya kolom kuantitas, mis. HP/Elektronik/Kendaraan/Senjata Api/Kosmetik — dianggap 1 baris = 1 unit).

### 7.3 Pemilihan SBP (Modal Pencarian Dinamis)

Endpoint `pencacahan.searchSbp` melayani dua mode dari satu fungsi:
- **Mode Create** (tanpa `pencacahan_id`): semua SBP yang **sudah pernah dicacah** (di BA Cacah manapun) ditandai `is_disabled` — mencegah satu SBP masuk ke dua dokumen pencacahan berbeda.
- **Mode Edit** (dengan `pencacahan_id`): hanya SBP yang dicacah oleh dokumen **lain** yang ditandai disabled; SBP yang sudah terikat ke dokumen yang sedang diedit tetap bisa dipilih/dihapus bebas.
- Mendukung pencarian teks (nomor SBP/nama pelaku) + paginasi, response AJAX (JSON + HTML pagination) atau JSON biasa.

### 7.4 Alur Simpan (Create/Update)

- Transaksi DB (`DB::beginTransaction`/`commit`/`rollBack`) membungkus seluruh proses agar konsisten.
- `Pencacahan::sbp()->sync($id_sbp)` menautkan SBP terpilih ke dokumen.
- Untuk tiap SBP: detail barang (dikirim sebagai JSON per-SBP dari frontend, `detail_barang_json[sbp_id]`) di-decode lalu disimpan sebagai banyak baris `DetailPencacahan` (saat update: baris lama dihapus dulu, lalu insert ulang — bukan diff/patch).
- **Upload foto per SBP** (bukan per dokumen) — 1 foto per pasangan Pencacahan-SBP (`singleFile()`), dikompresi otomatis sama seperti LPT (>300 KB → resize+kompres bertahap), nama file random.
- **Update foto** punya 3 skenario eksplisit: (1) ada upload baru → otomatis mengganti foto lama (`singleFile`), (2) tidak ada upload baru tapi user tandai `remove_foto[sbp_id]=1` → foto lama dihapus tanpa pengganti, (3) tidak ada aksi → foto lama tetap.
- Validasi mencakup keunikan `no_ba_cacah`, minimal 1 SBP dipilih, petugas 1 & 2 wajib berbeda (jika keduanya diisi), foto opsional (image, maks 5 MB).
- **Delete**: pivot `pencacahan_sbp` dihapus eksplisit sebelum dokumen induk dihapus.

### 7.5 Cetak PDF (Multi-Dokumen Digabung via FPDI)

Proses cetak (`pencacahan.cetak`) paling rumit di aplikasi — menggabungkan **beberapa PDF terpisah menjadi satu file** karena tiap bagian punya orientasi/layout berbeda:

1. Render **halaman potret utama** (`template-ba-cacah`) → disimpan sementara ke `storage/app/temp`.
2. Render **lampiran per kategori** (`template-ba-cacah-lampiran-cukai`, `template-ba-cacah-lampiran-pabean`) — **hanya jika kategori tsb punya detail barang** (kategori kosong dilewati, tidak ikut tercetak sama sekali); tiap lampiran dapat data SBP & detail yang sudah difilter khusus kategorinya.
3. **FPDI** menggabungkan: halaman 1 dari dokumen potret → seluruh halaman lampiran Cukai → seluruh halaman lampiran Pabean → sisa halaman dokumen potret (jika halaman 1 dokumen potret sebenarnya multi-halaman, halaman 2+ disisipkan di akhir).
4. Output di-stream langsung sebagai response PDF (`inline`), file sementara dihapus setelah selesai (di blok `try`) maupun saat exception (blok `catch` tetap membersihkan file sebelum melempar ulang error).

### 7.6 Halaman Terkait

- **Index** (`pencacahan.index`) — daftar dokumen BA Cacah, dengan relasi petugas & SBP ter-eager-load.
- **Show** (`pencacahan.show`) — detail lengkap satu dokumen (petugas, semua SBP + pivot ID, semua detail barang dengan jenis & satuan).
- **Create/Edit** — form kompleks dengan modal pemilihan SBP + area detail dinamis per SBP terpilih.
- **Akses foto**: route `pencacahan.showPhoto`, mekanisme sama seperti LPT (stream dari disk privat berdasar ID `Media`).

## 8. Modul Referensi (Master Data)

Seluruhnya CRUD sederhana berbasis modal (tanpa halaman create/edit terpisah — index + modal add/edit di halaman sama), sebagian besar tanpa `Route::resource` khusus, memakai kombinasi GET/POST/PUT/DELETE manual.

| Modul | Model | Keterangan |
|---|---|---|
| **Data Petugas** | `Petugas` (soft delete) | Nama, NIP (unik di antara baris aktif, auto-format tampilan NIP 18 digit jadi `xxxxxxxx xxxxxx x xxx`), pangkat & golongan (diambil otomatis dari `PangkatGolongan` terpilih saat submit — bukan diketik manual), jabatan. |
| **Pangkat/Golongan** | `PangkatGolongan` | Daftar pasangan pangkat–golongan untuk dropdown di form Petugas. **Controller kosong (stub)** — tidak ada UI/route aktif untuk CRUD-nya sendiri; data tampaknya dikelola lewat seeder/DB langsung. |
| **Referensi Pelanggaran** | `RefPelanggaran` | Daftar jenis pelanggaran (dipakai di modal pelanggaran pada form SBP). |
| **Referensi Satuan** | `RefSatuan` | Daftar satuan barang (kg, botol, unit, dst.) — dipakai luas di SBP & Pencacahan. |
| **Referensi Jenis Barang** | `RefJenisBarang` | Daftar jenis barang beserta **satuan default**-nya (`id_satuan_default` → `RefSatuan`) — mempercepat input Pencacahan. Urutan tampil dikontrol kolom `nomor_urut`. |
| **Referensi Surat Perintah** | `SuratPerintah` (soft delete) | Nomor & tanggal Surat Perintah (Route::resource, `create/edit/show` dinonaktifkan — hanya index+modal). Dipakai sebagai sumber dropdown di form SBP & Pemeriksaan Badan. |
| **Referensi Tarif Cukai** | `RefTarifCukai` (soft delete) | Golongan/jenis, rentang HJE (Harga Jual Eceran) min-max, dan tarif cukai — dipakai pada form barang kena cukai di Pencacahan. |

Catatan: `BastController` juga masih **stub kosong** — `Bast` tidak punya UI CRUD mandiri; seluruh siklus hidupnya (create/update/delete) dikelola **implisit** lewat form SBP (`flag_bast`) via `SbpService`, bukan lewat `Route::resource('bast', ...)` yang terdaftar tapi tidak dipakai.

## 9. Fitur Pendukung / Cross-Cutting

### 9.1 Lokasi Berjenjang (Kota → Kecamatan)
`LokasiController::getKecamatan` — endpoint AJAX statis (data kecamatan hardcode di controller, cakupan: Banda Aceh, Aceh Besar, Pidie, Pidie Jaya) untuk dropdown kecamatan yang berubah sesuai kota terpilih di form SBP.

### 9.2 Terbilang (Angka & Tanggal ke Kata)
`TerbilangHelper` (autoload via `composer.json` `files`) — mengonversi angka ke kata Bahasa Indonesia secara rekursif (mendukung hingga jutaan) dan memformat tanggal lengkap dalam kalimat (mis. "Senin, tanggal Lima belas bulan Januari tahun Dua ribu dua puluh enam"). Dipakai di dokumen cetak SBP dan Pemeriksaan Badan agar sesuai kaidah penulisan berita acara resmi.

### 9.3 Kompresi & Penyimpanan Foto
`PhotoUploadService` — layanan sentral untuk seluruh upload gambar aplikasi (LPT & Pencacahan): kompresi bertahap (resize progresif 1200px→800px, kualitas JPEG turun 70%→65%) hanya dijalankan jika ukuran asli melebihi threshold (default 300 KB), berhenti begitu ukuran sudah di bawah ambang. Mendukung mode `store()` (simpan langsung ke disk Laravel) maupun `compressInPlace()` (kompres file upload sementara di tempat, sebelum diserahkan ke Spatie MediaLibrary yang mengelola disk-nya sendiri).

### 9.4 Console Commands (Migrasi Data Satu-Kali)
Tiga Artisan command khusus migrasi dari skema penyimpanan foto lama ke Spatie MediaLibrary — dijalankan sekali saat transisi, dipertahankan di codebase sebagai riwayat:
- `MigrateLptPhotosToMedia` — pindahkan `lpt_photos` → koleksi media `photos` pada `Lpt`.
- `MigratePencacahanPhotosToMedia` — pindahkan `pencacahan_photos` → koleksi media `foto` pada `PencacahanSbp`.
- `MovePencacahanPhotosToPrivate` — pindahkan file foto pencacahan dari disk publik ke disk privat (`local`), sejalan dengan keputusan desain bahwa foto barang bukti tidak boleh dapat diakses lewat URL publik langsung — hanya lewat route ber-autentikasi (potensial) `pencacahan.showPhoto`.

### 9.5 Database Explorer
`DatabaseController` (`/database`) — memuat daftar seluruh tabel di database aktif (`Schema::getTables()`) dan menampilkan isi tabel manapun secara paginasi (15 baris/hal) langsung dari sistem, tanpa perlu tool eksternal. Berguna untuk debugging cepat, namun **tidak ada pembatasan tabel yang boleh dilihat** (termasuk tabel sistem seperti `jobs`, `cache`, `sessions`) dan **tidak ada kontrol akses** — lihat catatan keamanan di §10.

## 10. Skema Database (Migrasi Kunci)

Tabel inti beserta evolusi skemanya (urut kronologis migrasi):

- `pangkat_golongan`, `petugas` (+ soft delete & NIP unik belakangan)
- `sbp` (+ flag BA musnah, soft delete, field identitas pelaku tambahan, **unique index `nomor_sbp_active`** — migrasi paling akhir & paling kritikal untuk konsistensi data)
- `bast` (dokumen jadi nullable belakangan, + soft delete)
- `ref_pelanggaran`, `ref_satuan`
- `lpt` (+ `sbp_id`, soft delete, `nomor_lpt_int`, **`nomor_lpt_int_active` + unique index** — migrasi terbaru, pola sama seperti `nomor_sbp_active`), `lpt_photos` (skema lama)
- `surat_perintah`
- `pemeriksaan_badan` (+ field surat perintah belakangan)
- `pencacahan`, `pencacahan_sbp` (pivot)
- `ref_jenis_barang` (+ `id_satuan_default` belakangan), `ref_tarif_cukai`
- `detail_pencacahan` (+ `kondisi_barang`, `negara_asal` ditambah belakangan — menunjukkan form barang terus berkembang sesuai kebutuhan lapangan)
- `pencacahan_photos` (skema lama)
- `media` (tabel Spatie MediaLibrary — migrasi paling baru, menandai transisi resmi ke pengelolaan file terpusat)

## 11. Observasi & Potensi Perbaikan (Bukan Bug — Catatan Arsitektur)

Bagian ini murni observasi berdasarkan pembacaan kode, bukan pekerjaan yang sedang berjalan:

1. **Tanpa autentikasi** — seluruh route publik. Jika aplikasi akan diakses di luar jaringan tertutup/VPN internal, ini adalah risiko akses tak terkendali terhadap data pribadi (identitas pelaku, foto barang bukti) dan terhadap Database Explorer (§9.5) yang mengekspos seluruh isi database mentah.
2. **`BastController` dan `PangkatGolonganController` adalah stub kosong** — route resource-nya terdaftar (`Route::resource('bast', ...)`) tapi tidak dipakai; siklus hidup `Bast` sepenuhnya dikelola lewat `SbpService`. Kode stub ini aman dibiarkan atau dibersihkan tergantung rencana ke depan.
3. **Dua generasi penyimpanan foto berjalan berdampingan** (`LptPhoto`/`PencacahanPhoto` model lama vs Spatie MediaLibrary) — relasi lama (`legacyPhotos()`) sengaja dipertahankan sebagai cadangan/rujukan riwayat migrasi, didokumentasikan jelas di komentar kode masing-masing model.
4. **Validasi jenis barang kondisional** (§7.2) memakai daftar nama string hardcode di dua tempat berbeda (`PencacahanController::getBarangFields()` untuk pilih view, `DetailPencacahan::JENIS_BARANG_CUKAI` untuk kategori cetak) — perubahan nama jenis barang di data referensi berisiko tidak sinkron dengan daftar hardcode ini.

---
*Dokumen ini dihasilkan dari pembacaan langsung struktur kode (routes, controllers, models, services, migrations), terakhir diperbarui 2026-08-24 mengikuti perubahan pada modul LPT (proteksi nomor via `nomor_lpt_int_active`, mime foto SVG dihapus, perbaikan null-safety template cetak) dan Pemeriksaan Badan (soft delete, validasi dua petugas wajib berbeda, perapian form). Untuk detail implementasi presisi, rujuk file sumber terkait di setiap bagian.*
