# Blueprint Aplikasi Laravel

## Ringkasan Proyek

Aplikasi ini adalah sistem manajemen internal untuk membantu proses administrasi dan dokumentasi terkait penindakan barang, mulai dari pembuatan Surat Bukti Penindakan (SBP) hingga pencetakan berbagai Berita Acara (BA).

## Fitur yang Sudah Diimplementasikan

*   **Autentikasi:** Sistem login untuk pengguna.
*   **Dashboard:** Halaman utama setelah login, menampilkan ringkasan data.
*   **Manajemen SBP:**
    *   Membuat SBP baru dengan formulir input yang valid.
    *   **Dropdown Surat Perintah:** Saat membuat SBP, pengguna dapat memilih Nomor Surat Perintah dari dropdown yang terisi otomatis. Tanggal Surat Perintah juga akan terisi secara otomatis.
    *   Melihat daftar SBP yang ada dengan paginasi.
    *   Mengedit data SBP yang sudah ada.
*   **Manajemen Master Data:**
    *   CRUD untuk data Petugas.
    *   CRUD untuk data Pangkat/Golongan.
    *   CRUD untuk data Surat Perintah (Nomor & Tanggal).
    *   CRUD untuk LPT (Laporan Pelaksanaan Tugas).
*   **Manajemen Pencacahan:**
    *   Membuat dokumen Berita Acara Pencacahan baru.
    *   Formulir pencacahan memungkinkan pengguna untuk memilih satu atau lebih dokumen SBP yang sudah ada melalui sebuah modal pencarian.
        *   Logika pencarian SBP yang dinamis:
            *   Saat membuat pencacahan baru, SBP yang sudah pernah dicacah akan dinonaktifkan.
            *   Saat mengedit pencacahan, SBP yang sudah dicacah di BA *lain* akan dinonaktifkan, tetapi SBP yang terikat pada BA yang sedang diedit tetap dapat dipilih/dihapus.
        *   Menyimpan relasi antara dokumen pencacahan dan SBP yang dipilih, termasuk detail barang dan foto.
    *   Mengedit data pencacahan yang sudah ada.
*   **Cetak & Pratinjau Dokumen:**
    *   Mencetak SBP dan dokumen terkait (Berita Acara Pemeriksaan, Penegahan, Penyegelan, LPT) dalam format PDF.
    *   Menampilkan pratinjau PDF dari semua dokumen yang dapat dicetak langsung di browser.

## Rencana Implementasi Saat Ini

### **Fitur: Manajemen Satuan Default Berdasarkan Jenis Barang**

**Tujuan:** Mempercepat input data dengan mengisi otomatis kolom "Satuan" berdasarkan "Jenis Barang" yang dipilih pada form Pencacahan, dan memungkinkan pengguna untuk mengubah default ini melalui UI.

**Langkah-langkah:**

1.  **Modifikasi Database:**
    *   Membuat migrasi baru untuk menambahkan kolom `id_satuan_default` (foreign key ke `ref_satuan`) ke dalam tabel `ref_jenis_barangs`.

2.  **Buat Halaman Manajemen Referensi:**
    *   **Route:** Menambahkan route `GET` dan `POST`/`PUT` di `routes/web.php` untuk menampilkan dan memperbarui referensi jenis barang.
    *   **Controller:** Membuat `RefJenisBarangController` menggunakan `php artisan make:controller` untuk mengelola logika bisnis (menampilkan data & menyimpan perubahan).
    *   **View:** Membuat file `resources/views/ref-jenis-barang.blade.php`. View ini akan menampilkan tabel jenis barang, masing-masing dengan dropdown untuk memilih dan menyimpan satuan defaultnya.

3.  **Update Sidebar:**
    *   Menambahkan link navigasi baru di `resources/views/layouts/sidebar.blade.php` yang mengarah ke halaman manajemen referensi jenis barang, di bawah kategori "Referensi Data".

4.  **Update Seeder (Opsional):**
    *   Memperbarui `RefJenisBarangSeeder.php` untuk menetapkan nilai awal untuk kolom `id_satuan_default`.

5.  **Integrasi ke Form Pencacahan:**
    *   **Backend:** Mengubah query di `PencacahanController` untuk menyertakan `id_satuan_default` pada data jenis barang yang dikirim ke view.
    *   **Frontend (Blade):** Menambahkan `data-default-satuan="{{ $jenis->id_satuan_default }}"` attribute ke setiap `<option>` pada dropdown "Jenis Barang".
    *   **Frontend (JavaScript):** Menulis script untuk mendeteksi perubahan pada dropdown "Jenis Barang". Script akan membaca `data-default-satuan` dan mengatur nilai dropdown "Satuan" secara otomatis pada baris yang sama.
