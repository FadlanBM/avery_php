# My Simple PHP Native Framework (with Booking System)

Framework PHP Native minimalis dengan struktur modern (MVC-ish) yang dioptimalkan untuk berjalan di **Devilbox**. Proyek ini telah dikembangkan untuk mendukung sistem pemesanan ruangan (Booking System).

## 🚀 Fitur Utama

- **Zero Dependency**: Tidak butuh Composer atau library eksternal. Semua *core* ditulis *native*.
- **Modern Structure**: Menggunakan konsep *Separation of Concerns* (Controller, View, Config terpisah).
- **Environment Variables**: Dukungan file `.env` untuk konfigurasi sensitif.
- **Eloquent-like Models**: Sistem Model sederhana untuk interaksi database yang lebih mudah (`find`, `where`, `create`, `all`).
- **Database Migrations**: Sistem version control untuk skema database menggunakan CLI.
- **Authentication**: Sistem login/register dengan hashing password dan session management.
- **Logging & Debugging**: Helper `dd()` ala Laravel dan error logging terintegrasi.
- **Booking System**: Alur kerja lengkap untuk pemesanan ruangan (Cek Ketersediaan, Reservasi, Pembayaran, Check-in).

## 📂 Struktur Folder

```
htdocs/                  # Root Web Server (Document Root)
├── .env                 # Konfigurasi Environment
├── .htaccess            # Keamanan (melindungi folder app)
├── index.php            # Entry Point Aplikasi
├── bin/                 # Executable Scripts (CLI)
│   └── migrate.php      # Runner Migrasi Database
├── assets/              # File Statis (CSS, JS, Gambar)
└── app/                 # Inti Aplikasi (LOGIC)
    ├── config/          # Konfigurasi Global
    ├── database/        # File Database
    │   └── migrations/  # File Migrasi (*.php)
    ├── src/             # Source Code PHP (Namespace: App\)
    │   ├── Controllers/ # Logika Bisnis & Request Handler
    │   ├── Core/        # Core Framework (Model, Database, Env)
    │   ├── Helpers/     # Helper Functions (dd, etc)
    │   └── Models/      # Model Database (User, Booking, Room)
    └── templates/       # File Tampilan / View
        ├── auth/        # View Login/Register
        └── partials/    # Potongan View (Header, Footer)
```

## 🛠️ Manajemen Database

### 1. Migrasi Database
Sistem ini memiliki tool migrasi bawaan untuk mengelola struktur database.

**Cara Menjalankan Migrasi (di dalam container Devilbox):**
```bash
# Masuk ke container (jika belum)
./shell.bat
cd /shared/httpd/my-project/htdocs

# Jalankan migrasi
php bin/migrate.php
```

**Membuat File Migrasi Baru:**
Buat file PHP di `app/database/migrations/` dengan format nama `YYYY_MM_DD_HHMMSS_NamaMigrasi.php`.
Contoh struktur file migrasi bisa dilihat di `app/database/migrations/2026_02_15_000000_CreateUsersTable.php`.

### 2. Menggunakan Model
Gunakan class Model untuk berinteraksi dengan database tanpa menulis SQL mentah.

**Contoh Penggunaan:**
```php
use App\Models\User;

$userModel = new User();

// Ambil semua data
$users = $userModel->all();

// Cari berdasarkan ID
$user = $userModel->find(1);

// Cari dengan kondisi
$activeUsers = $userModel->where('status', 'active');
$admin = $userModel->firstWhere('role', 'admin');

// Tambah data baru
$userModel->create([
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'password' => password_hash('secret', PASSWORD_DEFAULT)
]);
```

## 🐞 Debugging & Logging

### Helper `dd()`
Anda bisa menggunakan fungsi `dd($variable)` (Dump and Die) di mana saja dalam kode untuk men-debug variabel dengan tampilan yang rapi.

```php
$users = $userModel->all();
dd($users); // Aplikasi akan berhenti dan menampilkan isi $users
```

### Error Logging
Gunakan `error_log()` untuk mencatat error ke file log server (biasanya bisa dicek via Devilbox dashboard atau file log PHP).

## 📅 Fitur Booking System

Sistem ini mencakup 4 fase alur kerja pemesanan:

1.  **Fase Pencarian (Availability Check)**: User memilih tanggal/jam, sistem mengecek bentrokan jadwal di tabel `bookings`.
2.  **Fase Reservasi**: Slot dikunci sementara (status `pending`), data masuk ke database.
3.  **Fase Pembayaran**: Integrasi pembayaran, status berubah menjadi `confirmed`, generate QR Code.
4.  **Fase Operasional**: Check-in di lokasi menggunakan QR Code.

Tabel pendukung: `users`, `rooms`, `bookings`, `payments`.

## 🚀 Cara Menjalankan Project

1.  Pastikan **Devilbox** sudah berjalan.
2.  Salin `.env.example` ke `.env` dan sesuaikan konfigurasi database.
3.  Jalankan migrasi database: `php bin/migrate.php`.
4.  Buka browser: `http://localhost/my-project` (atau sesuai konfigurasi vhost Devilbox Anda).
