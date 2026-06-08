# Aplikasi Persediaan Barang Toko Sembako

Aplikasi web berbasis Laravel 10 untuk mengelola persediaan barang toko sembako. Sistem ini mendukung pengelolaan master data, transaksi stok masuk dan stok keluar, laporan mutasi stok, serta pembatasan akses berdasarkan role pengguna.

## Teknologi

- Laravel 10
- PHP 8.1 atau lebih baru
- MySQL atau MariaDB
- Bootstrap 5
- Bootstrap Icons
- Blade Template Engine

## Fitur Utama

- Login dan logout pengguna
- Hak akses berdasarkan role: Admin, Staff Inventory, dan Owner
- Dashboard ringkasan stok
- 5 stok tertinggi dan 5 stok terendah
- Master data kategori
- Master data barang atau produk
- Master data pengguna
- Transaksi stok masuk
- Transaksi stok keluar
- Validasi stok keluar agar tidak melebihi stok tersedia
- Laporan mutasi stok dengan filter tanggal
- Show entries dan pagination pada tabel
- Riwayat transaksi tetap tersimpan walaupun produk dihapus
- Pencatatan stok awal dan stok akhir pada setiap mutasi
- Status barang otomatis berubah menjadi `tidak tersedia` jika stok 0

## Hak Akses Role

### Admin

- Dashboard
- Master Data Kategori
- Master Data Barang
- Master Data Pengguna
- Transaksi Stok Masuk/Keluar
- Laporan Mutasi Stok

### Staff Inventory

- Dashboard
- Daftar Produk, hanya lihat
- Transaksi Stok Masuk/Keluar
- Laporan Mutasi Stok

### Owner

- Dashboard
- Daftar Produk, hanya lihat
- Laporan Mutasi Stok

## Aturan Sistem

- Semua primary key menggunakan UUID, bukan auto increment.
- Kategori tidak bisa dihapus jika masih memiliki barang dengan stok tersedia.
- Barang tidak bisa dihapus jika stok masih tersedia.
- Riwayat transaksi tidak hilang saat barang dihapus.
- Jika barang sudah dihapus, laporan tetap menampilkan snapshot nama produk lama.
- Setiap transaksi menyimpan `stock_before` dan `stock_after`.

## Struktur Database Utama

Tabel utama:

- `users`
- `categories`
- `items`
- `inventory_logs`

Relasi:

- `categories.id` ke `items.category_id`
- `items.id` ke `inventory_logs.item_id`
- `users.id` ke `inventory_logs.user_id`

## Kebutuhan Instalasi

Pastikan sudah terpasang:

- PHP 8.1+
- Composer
- MySQL/MariaDB
- XAMPP, Laragon, atau server lokal sejenis
- Git, jika menggunakan clone repository

## Cara Instalasi

Clone repository:

```bash
git clone https://github.com/daf167/toko_sembako.git
cd toko_sembako
```

Install dependency Laravel:

```bash
composer install
```

Salin file environment:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

## Konfigurasi Database

Buat database MySQL, misalnya:

```sql
CREATE DATABASE toko_sembako;
```

Lalu sesuaikan file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=toko_sembako
DB_USERNAME=root
DB_PASSWORD=
```

Jika memakai XAMPP dengan password MySQL kosong, biarkan `DB_PASSWORD=` kosong.

## Migrasi dan Seeder

Jalankan migrasi dan data awal:

```bash
php artisan migrate:fresh --seed
```

Perintah ini akan membuat ulang semua tabel dan mengisi akun demo.

## Akun Demo

Admin:

```text
Email: admin@example.com
Password: password
```

Staff Inventory:

```text
Email: staff@example.com
Password: password
```

Owner:

```text
Email: owner@example.com
Password: password
```

## Menjalankan Aplikasi

Jalankan server Laravel:

```bash
php artisan serve --host=127.0.0.1 --port=8000
```

Buka browser:

```text
http://127.0.0.1:8000
```

## Menjalankan Test

```bash
php artisan test
```

## Catatan Fitur Export Laporan

Fitur export CSV dan PDF untuk laporan mutasi stok sudah disiapkan di `ReportController`, tetapi saat ini route dan tombol di view dinonaktifkan dengan komentar.

Untuk mengaktifkan kembali:

1. Buka komentar route di `routes/web.php`.
2. Buka komentar tombol export di `resources/views/reports/index.blade.php`.
3. Jalankan:

```bash
php artisan route:clear
php artisan view:clear
```

## Catatan Filter Tipe Mutasi

Filter tipe mutasi `masuk` dan `keluar` sudah tersedia di controller, tetapi dropdown UI di view masih dikomentari.

Untuk mengaktifkan kembali, buka komentar bagian filter `Tipe Mutasi` di:

```text
resources/views/reports/index.blade.php
```

Lalu jalankan:

```bash
php artisan view:clear
```

## Dokumentasi Tambahan

Folder `docs` berisi beberapa dokumen pendukung, seperti:

- Mockup Figma dalam format SVG
- Wireframe Figma dalam format SVG
- Dokumentasi blackbox testing dalam format Excel

## Troubleshooting

Jika muncul error:

```text
Could not open input file: artisan
```

Pastikan terminal berada di folder project Laravel yang memiliki file `artisan`.

Jika port 8000 sudah digunakan:

```bash
php artisan serve --host=127.0.0.1 --port=8001
```

Jika konfigurasi `.env` tidak terbaca:

```bash
php artisan config:clear
php artisan cache:clear
```
