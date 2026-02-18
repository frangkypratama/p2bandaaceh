
# Proyek Aplikasi SBP (Surat Bukti Penindakan)

## Ikhtisar

Aplikasi ini adalah aplikasi web berbasis Laravel untuk mengelola Surat Bukti Penindakan (SBP). Aplikasi ini memungkinkan pengguna untuk membuat, melihat, mengedit, dan mencetak dokumen SBP beserta dokumen terkait lainnya seperti Berita Acara Pemeriksaan, Penegahan, dan Penyegelan.

## Desain dan Fitur

### Skema Warna

*   **Primer:** Biru (misalnya, `#0d6efd`)
*   **Sekunder:** Abu-abu (misalnya, `#6c757d`)
*   **Success:** Hijau (misalnya, `#198754`)
*   **Warning:** Kuning (misalnya, `#ffc107`)
*   **Danger:** Merah (misalnya, `#dc3545`)
*   **Info:** Biru muda (misalnya, `#0dcaf0`)

### Tipografi

*   **Font:** Sistem UI default (misalnya, Segoe UI, Roboto, Helvetica Neue, Arial, sans-serif)

### Fitur Utama

*   **Dashboard:** Halaman utama setelah login, menampilkan ringkasan data.
*   **Manajemen SBP:**
    *   Membuat SBP baru dengan formulir input yang valid.
    *   **Dropdown Surat Perintah:** Saat membuat SBP, pengguna dapat memilih Nomor Surat Perintah dari dropdown yang terisi otomatis. Tanggal Surat Perintah juga akan terisi secara otomatis.
    *   Melihat daftar SBP yang ada dengan paginasi.
    *   Mengedit data SBP yang sudah ada.
    *   Mencetak SBP dan dokumen terkait dalam format PDF.
*   **Manajemen Petugas:**
    *   Membuat, membaca, memperbarui, dan menghapus (CRUD) data petugas.
*   **Manajemen Pangkat/Golongan:**
    *   CRUD untuk data pangkat/golongan.
*   **Manajemen Surat Perintah:**
    *   CRUD untuk data Surat Perintah (Nomor & Tanggal).
*   **Pratinjau Dokumen:** Menampilkan pratinjau PDF dari semua dokumen yang dapat dicetak langsung di browser dalam satu tampilan.
*   **Cetak Semua Dokumen:** Terdapat satu tombol untuk mencetak semua dokumen terkait SBP (SBP, BA Riksa, BA Tegah, BA Segel) menjadi satu file PDF.

## Rencana Perubahan Saat Ini

### Permintaan

"lihat input-sbp.blade, ambil data nomor prin dan tanggal prin dari tb surat_perintah"

### Rencana Implementasi

1.  **Perbarui `SbpController`:**
    *   Mengimpor model `App\Models\SuratPerintah`.
    *   Dalam metode `create`, mengambil semua data dari tabel `surat_perintah` dan mengurutkannya berdasarkan tanggal terbaru.
    *   Meneruskan data `$suratPerintahData` ke view `input-sbp`.
2.  **Perbarui `_penomoran.blade.php`:**
    *   Mengubah input teks "Nomor Surat Perintah" menjadi elemen `<select>` (dropdown).
    *   Mengisi dropdown tersebut dengan `nomor_prin` dari variabel `$suratPerintahData`.
    *   Menyimpan `tanggal_prin` yang sesuai di dalam atribut `data-tanggal` untuk setiap opsi dropdown.
    *   Mengatur input "Tanggal Surat Perintah" menjadi `readonly` untuk mencegah input manual oleh pengguna.
3.  **Tambahkan Fungsionalitas JavaScript:**
    *   Menambahkan event listener pada dropdown "Nomor Surat Perintah".
    *   Ketika pengguna memilih sebuah nomor surat, script akan mengambil nilai dari atribut `data-tanggal` pada opsi yang dipilih.
    *   Secara otomatis mengisi nilai tanggal tersebut ke dalam input "Tanggal Surat Perintah".

