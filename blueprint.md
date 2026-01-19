
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
    *   Melihat daftar SBP yang ada dengan paginasi.
    *   Mengedit data SBP yang sudah ada.
    *   Mencetak SBP dalam format PDF.
*   **Manajemen Petugas:**
    *   Membuat, membaca, memperbarui, dan menghapus (CRUD) data petugas.
*   **Manajemen Pangkat/Golongan:**
    *   CRUD untuk data pangkat/golongan.
*   **Cetak Dokumen Terkait:**
    *   Mencetak Berita Acara Pemeriksaan.
    *   Mencetak Berita Acara Penegahan.
    *   Mencetak Berita Acara Penyegelan.
*   **Pratinjau Dokumen:** Menampilkan pratinjau PDF dari semua dokumen yang dapat dicetak langsung di browser.

## Rencana Perubahan Saat Ini

### Permintaan

"untuk preview dokumen, gunakan satu preview saya dimana akan mencetak satu pdf yang berisi, sbp, ba riksa, ba tegah, ba segel, dan buat satu tombol cetak sekaligus"

### Rencana

1.  **Buat Rute Baru:** Tambahkan rute `GET /sbp/{id}/pdf/semua` di `routes/web.php`.
2.  **Buat Template Gabungan:** Buat file view baru di `resources/views/templatecetak/template-semua.blade.php` yang akan menyertakan (include) template untuk SBP, BA Riksa, BA Tegah, dan BA Segel. Ini akan memastikan semua dokumen dirender dalam satu halaman HTML.
3.  **Perbarui SbpController:** Tambahkan metode `cetakSemua` ke `SbpController.php`. Metode ini akan memuat data SBP dan merender `template-semua.blade.php` menjadi satu PDF.
4.  **Perbarui `preview-sbp.blade.php`:**
    *   Hapus empat `<iframe>` yang ada.
    *   Hapus tombol-tombol cetak yang terpisah dan dropdown.
    *   Tambahkan satu `<iframe>` yang sumbernya menunjuk ke rute baru `/sbp/{id}/pdf/semua`.
    *   Tambahkan satu tombol "Cetak Semua Dokumen" yang juga mengarah ke rute `/sbp/{id}/pdf/semua`.

