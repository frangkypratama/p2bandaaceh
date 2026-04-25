# Proyek Aplikasi SBP (Surat Bukti Penindakan)

## Ikhtisar

Aplikasi ini adalah aplikasi web berbasis Laravel untuk mengelola Surat Bukti Penindakan (SBP). Aplikasi ini memungkinkan pengguna untuk membuat, melihat, mengedit, dan mencetak dokumen SBP beserta dokumen terkait lainnya seperti Berita Acara Pemeriksaan, Penegahan, Penyegelan, Laporan Pelaksanaan Tugas (LPT), dan Pencacahan Barang.

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
*   **Manajemen Petugas:**
    *   Membuat, membaca, memperbarui, dan menghapus (CRUD) data petugas.
*   **Manajemen Pangkat/Golongan:**
    *   CRUD untuk data pangkat/golongan.
*   **Manajemen Surat Perintah:**
    *   CRUD untuk data Surat Perintah (Nomor & Tanggal).
*   **Manajemen LPT (Laporan Pelaksanaan Tugas):**
    *   CRUD untuk data LPT.
*   **Manajemen Pencacahan:**
    *   Membuat dokumen Berita Acara Pencacahan baru.
    *   Formulir pencacahan memungkinkan pengguna untuk memilih satu atau lebih dokumen SBP yang sudah ada melalui sebuah modal pencarian.
    *   Logika pencarian SBP yang dinamis:
        *   Saat membuat pencacahan baru, SBP yang sudah pernah dicacah akan dinonaktifkan.
        *   Saat mengedit pencacahan, SBP yang sudah dicacah di BA *lain* akan dinonaktifkan, tetapi SBP yang terikat pada BA yang sedang diedit tetap dapat dipilih/dihapus.
    *   Menyimpan relasi antara dokumen pencacahan dan SBP yang dipilih, termasuk detail barang dan foto.
    *   Mengedit data pencacahan yang sudah ada.
    *   Mencetak dokumen BA Pencacahan beserta lampiran dan foto dalam satu file PDF gabungan.
*   **Cetak & Pratinjau Dokumen:**
    *   Mencetak SBP dan dokumen terkait (Berita Acara Pemeriksaan, Penegahan, Penyegelan, LPT) dalam format PDF.
    *   Menampilkan pratinjau PDF dari semua dokumen yang dapat dicetak langsung di browser.
    *   Terdapat satu tombol untuk mencetak semua dokumen terkait SBP (SBP, BA Riksa, BA Tegah, BA Segel) menjadi satu file PDF.

## Rencana Perubahan Saat Ini

**Tugas:** Tidak ada perubahan yang sedang berlangsung.

**Langkah-langkah:**

-