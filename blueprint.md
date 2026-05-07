# Proyek Aplikasi SBP (Surat Bukti Penindakan)

## Ikhtisar

Aplikasi ini adalah aplikasi web berbasis Laravel untuk mengelola Surat Bukti Penindakan (SBP). Aplikasi ini memungkinkan pengguna untuk membuat, melihat, mengedit, dan mencetak dokumen SBP beserta dokumen terkait lainnya seperti Berita Acara Pemeriksaan, Penegahan, Penyegelan, dan Laporan Pelaksanaan Tugas (LPT).

## Desain dan Fitur

### Skema Warna

*   **Primer:** Biru (misalnya, `#007bff`)
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
*   **Manajemen Petugas:**
    *   Membuat, membaca, memperbarui, dan menghapus (CRUD) data petugas.
*   **Manajemen Pangkat/Golongan:**
    *   CRUD untuk data pangkat/golongan.
*   **Manajemen Surat Perintah:**
    *   CRUD untuk data Surat Perintah (Nomor & Tanggal).
*   **Manajemen LPT (Laporan Pelaksanaan Tugas):**
    *   Membuat, membaca, memperbarui, dan menghapus (CRUD) data LPT.
*   **Cetak & Pratinjau Dokumen:**
    *   Mencetak SBP dan dokumen terkait (Berita Acara Pemeriksaan, Penegahan, Penyegelan, LPT) dalam format PDF.
    *   Menampilkan pratinjau PDF dari semua dokumen yang dapat dicetak langsung di browser.
    *   Terdapat satu tombol untuk mencetak semua dokumen terkait SBP (SBP, BA Riksa, BA Tegah, BA Segel) menjadi satu file PDF.

## Rencana Perubahan Saat Ini

### Menambahkan Visualisasi Data Tambahan ke Dasbor

**Tujuan:** Memperkaya dasbor dengan menambahkan tiga grafik baru untuk memberikan wawasan yang lebih dalam mengenai distribusi penindakan.

**Langkah-langkah:**

1.  **Memperbarui Controller:** Modifikasi `DashboardController` untuk mengambil dan mengagregasi data berikut:
    *   Distribusi penindakan berdasarkan **Jenis Barang**.
    *   Agregasi jumlah penindakan berdasarkan **Kota**.
    *   Agregasi jumlah penindakan berdasarkan **Kecamatan**.
2.  **Menambahkan Kartu Grafik Baru:** Tambahkan baris baru di `dashboard.blade.php` yang berisi tiga kartu grafik:
    *   Satu kartu untuk **Grafik Jenis Barang** (disarankan *Pie* atau *Doughnut Chart*).
    *   Satu kartu untuk **Grafik Kota Penindakan** (disarankan *Horizontal Bar Chart*).
    *   Satu kartu untuk **Grafik Kecamatan Penindakan** (disarankan *Horizontal Bar Chart*).
3.  **Implementasi Skrip Grafik:** Tulis logika JavaScript yang diperlukan menggunakan Chart.js untuk membuat dan mengisi tiga grafik baru dengan data yang disediakan oleh controller.
4.  **Menyesuaikan Tata Letak:** Pastikan tata letak dasbor tetap rapi dan responsif setelah penambahan grafik-grafik baru.
