# Proyek Aplikasi SBP (Surat Bukti Penindakan)

## Ikhtisar

Aplikasi ini adalah aplikasi web berbasis Laravel untuk mengelola Surat Bukti Penindakan (SBP). Aplikasi ini memungkinkan pengguna untuk membuat, melihat, mengedit, dan mencetak dokumen SBP beserta dokumen terkait lainnya seperti Berita Acara Pemeriksaan, Penegahan, Penyegelan, dan Laporan Pelaksanaan Tugas (LPT).

## Desain dan Fitur

### Skema Warna (Dasbor)

*   **Total SBP:** Gradien biru.
*   **Total Petugas:** Gradien hijau.
*   **Hasil Tembakau:** Gradien oranye.
*   **Kepabeanan:** Gradien ungu (baru).
*   **Cukai:** Gradien indigo (baru).

### Fitur Utama

*   **Dashboard:** Halaman utama setelah login, menampilkan ringkasan data statistik dan visualisasi.
*   **Manajemen SBP, Petugas, Pangkat, Surat Perintah, LPT:** Fitur CRUD lengkap untuk semua entitas inti.
*   **Cetak & Pratinjau Dokumen:** Kemampuan untuk mencetak semua dokumen terkait SBP dalam format PDF.

---

## Rencana Perubahan Saat Ini: Penambahan Kartu Statistik

**Tujuan:** Menambahkan dua kartu statistik baru ("Kepabeanan" dan "Cukai") ke dasbor untuk memberikan ringkasan data yang lebih komprehensif.

**Langkah-langkah Implementasi:**

1.  **Pembaruan Controller (`DashboardController.php`):**
    *   Tambahkan logika untuk mengambil jumlah total SBP yang termasuk dalam kategori `Kepabeanan` dan `Cukai` berdasarkan kolom `jenis_pelanggaran`.
    *   Kirim dua variabel hitungan baru ini ke *view* `dashboard`.

2.  **Pembaruan Tampilan (`dashboard.blade.php`):**
    *   Ubah tata letak baris kartu statistik untuk mengakomodasi lima kartu secara responsif.
    *   Tambahkan dua elemen kartu HTML baru untuk menampilkan data "Kepabeanan" dan "Cukai".
    *   Buat kelas CSS baru (`stat-card-kepabeanan`, `stat-card-cukai`) dengan skema warna gradien yang unik.
    *   Tetapkan ikon yang relevan (`cil-building` untuk Kepabeanan, `cil-wallet` untuk Cukai) untuk kartu-kartu baru.

3.  **Penyempurnaan Ikon:**
    *   Memperbarui ikon pada kartu yang ada agar lebih relevan dan menarik secara visual.
    *   Menambahkan animasi halus pada ikon saat kartu disorot oleh kursor.
