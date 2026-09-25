# Tata Kelola Branch `login`

Dokumen ini mengatur cara kerja di branch `login` agar perubahan terkait fitur autentikasi/login tetap terkontrol dan mudah di-review sebelum masuk ke `main`.

## Tujuan Branch

Branch `login` digunakan khusus untuk pengembangan, perbaikan, dan penyempurnaan fitur autentikasi (login, logout, session, hak akses terkait login) pada aplikasi P2BAndaAceh.

## Ruang Lingkup

Yang **boleh** dikerjakan di branch ini:

- Perubahan pada controller, middleware, dan route yang berkaitan dengan autentikasi.
- Perubahan tampilan (view/blade) halaman login.
- Perbaikan bug terkait proses login, validasi, dan session.
- Penyesuaian hak akses (role/permission) yang terikat langsung dengan proses login.

Yang **tidak** boleh dikerjakan di branch ini:

- Perubahan modul lain yang tidak berhubungan dengan login (mis. LPHP, LPP, SBP, pencacahan, dashboard). Perubahan tersebut dikerjakan di branch masing-masing sesuai konvensi yang sudah berjalan (`lphp_lp`, `lpp_sd_lhp`, `pencacahan`, `dashboard`, dst).
- Perubahan konfigurasi environment (`.env`) yang bersifat spesifik lokal.

## Alur Kerja

1. Branch dibuat dari `main` yang sudah ter-update:
   ```bash
   git checkout main
   git pull origin main
   git checkout -b login
   ```
2. Kerjakan perubahan dalam commit kecil dan deskriptif, mengikuti gaya commit yang sudah dipakai di proyek ini (Bahasa Indonesia, jelas menyebut apa yang diperbaiki/ditambahkan). Contoh: `perbaikan validasi login`, `fix redirect setelah login gagal`.
3. Push secara berkala ke remote:
   ```bash
   git push origin login
   ```
4. Setelah fitur/perbaikan selesai dan sudah diuji, ajukan Pull Request dari `login` ke `main`.
5. Setelah PR di-review dan disetujui, merge ke `main`. Hindari `--force` push ke `main`.

## Kriteria Sebelum Merge ke `main`

- Proses login, logout, dan proteksi route sudah diuji manual di browser.
- Tidak ada kredensial, token, atau data sensitif yang ikut ter-commit.
- Tidak ada konflik dengan perubahan terbaru di `main` (lakukan `git pull origin main` atau merge `main` ke `login` sebelum PR).
- Migrasi database (jika ada) sudah diuji dan tidak merusak data yang sudah ada.

## Sinkronisasi dengan `main`

Jika `main` mendapat update dari branch lain selama `login` masih berjalan, sinkronkan secara berkala:

```bash
git checkout login
git merge main
```

Selesaikan konflik jika ada, lalu lanjutkan pekerjaan.

## Penanggung Jawab

Branch ini dikelola oleh: **frangkypratama** (frangkypratama03@gmail.com).
