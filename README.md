# Sistem Manajemen Blog (CMS)

Proyek **Nor Khairina_UTS Pemrograman Web** Semester Genap 2025/2026.  
Aplikasi ini dibangun menggunakan **PHP, MySQL, dan JavaScript (fetch API)** untuk mengelola data **Penulis, Artikel, dan Kategori Artikel** secara asynchronous tanpa reload halaman.

## Fitur Utama
- **Kelola Penulis**
  - Tambah, edit, hapus penulis.
  - Foto profil default (`default.png`) jika tidak diunggah.
  - Password dienkripsi dengan `password_hash()` (BCRYPT).
  - Tidak bisa dihapus jika masih memiliki artikel.

- **Kelola Artikel**
  - Tambah, edit, hapus artikel dengan upload gambar wajib.
  - Field `hari_tanggal` otomatis dari server (format: `Senin, 13 April 2026 | 15:17`).
  - Dropdown penulis & kategori diambil dari database.
  - Saat artikel dihapus, file gambar ikut dihapus dari server.

- **Kelola Kategori Artikel**
  - Tambah, edit, hapus kategori.
  - Tidak bisa dihapus jika masih memiliki artikel terkait.

- **Validasi & Keamanan**
  - Semua query menggunakan prepared statements (mysqli).
  - Validasi file upload dengan `finfo_file()`.
  - Ukuran file maksimal 2 MB.
  - Output disanitasi dengan `htmlspecialchars()`.
  - Folder `uploads_penulis/` dan `uploads_artikel/` dilindungi `.htaccess`.

## Struktur Folder
blog/
├── index.php
├── koneksi.php
├── penulis/ (CRUD Penulis)
├── artikel/ (CRUD Artikel)
├── kategori/ (CRUD Kategori)
├── uploads_penulis/ (default.png + .htaccess)
└── uploads_artikel/ (default.png + .htaccess)

## Cara Menjalankan
1. Clone repo ini ke folder `htdocs` (XAMPP) atau `www` (Laragon).
2. Pastikan konfigurasi database di `koneksi.php` sesuai (host, user, password).
3. Akses aplikasi melalui browser: `http://localhost/blog/index.php`.

## Setup Database
1. Buat database baru: `db_blog`.
2. Import file `penulis.sql`, `kategori_artikel.sql`, dan `artikel.sql` ke phpMyAdmin.
3. Pastikan tabel sudah terbentuk dengan data contoh.

## Pengumpulan
- Repo ini berisi seluruh folder `blog/` beserta file program dan database hasil ekspor `.sql`.
- Video demo aplikasi diunggah ke YouTube sesuai instruksi UTS.
- Tautan repo GitHub dan video YouTube dikumpulkan melalui Google Classroom.
