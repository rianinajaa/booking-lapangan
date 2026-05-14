# 🚀 SpaceGo — Sistem Booking Fasilitas Sekolah

<div align="center">

![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-CDN-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)

**Sistem peminjaman fasilitas sekolah terpadu — lapangan, lab, dan ruang multimedia.**

</div>

---

## 📋 Daftar Isi

- [Deskripsi](#-deskripsi)
- [Tujuan & Target Sistem](#-tujuan--target-sistem)
- [Fitur Utama](#-fitur-utama)
- [Struktur Database (ERD)](#-struktur-database-erd)
- [Alur Sistem](#-alur-sistem)
- [Style Guide](#-style-guide)
- [Struktur Folder Project](#-struktur-folder-project)
- [Cara Menjalankan Project](#-cara-menjalankan-project)
- [Panduan Kolaborasi Tim](#-panduan-kolaborasi-tim)
- [Pembagian Jobdesk](#-pembagian-jobdesk)

---

## 📖 Deskripsi

**SpaceGo** adalah sistem booking fasilitas sekolah berbasis web yang dibangun dengan **Laravel 11**. Sistem ini memungkinkan pengguna untuk memesan lapangan olahraga, lab komputer, lab bahasa, dan ruang multimedia secara online — kapan saja dan dari mana saja.

Sistem ini dirancang untuk menggantikan proses peminjaman manual yang sering menimbulkan bentrok jadwal, ketidaktransparanan, dan sulitnya pelacakan pembayaran.

---

## 🎯 Tujuan & Target Sistem

### Tujuan

- Mempermudah proses peminjaman fasilitas sekolah secara digital
- Mencegah double booking melalui sistem pengecekan jadwal real-time
- Menyediakan sistem pembayaran dua tahap (DP + pelunasan) yang transparan
- Memberikan laporan dan rekapitulasi booking yang akurat untuk admin

### Target Pengguna

| Role | Deskripsi | Hak Akses |
|------|-----------|-----------|
| **Admin** | Pengelola sistem sekolah | Kelola semua data, konfirmasi booking, verifikasi pembayaran |
| **Guru** | Tenaga pendidik sekolah | Booking gratis semua fasilitas, langsung aktif tanpa konfirmasi |
| **Siswa Internal** | Siswa sekolah sendiri | Booking dengan diskon 50%, wajib isi NIS & kelas |
| **Siswa Luar** | Siswa dari sekolah lain | Booking dengan diskon 30%, wajib upload kartu pelajar |
| **Umum** | Masyarakat umum | Booking harga normal, tanpa syarat tambahan |

### Fasilitas yang Tersedia

- 🏃 **Lapangan Olahraga** — Futsal Indoor, Basket, Voli
- 🖥️ **Lab Akademik** — Lab Komputer, Lab Bahasa
- 🎭 **Ruang Acara** — Ruang Multimedia, Aula Sekolah

---

## ✨ Fitur Utama

- ✅ Autentikasi multi-role (Admin, Guru, Siswa Internal, Siswa Luar, Umum)
- ✅ Login dengan Google OAuth
- ✅ Verifikasi akun via OTP Email
- ✅ Progressive Profiling — register simpel, lengkapi profil belakangan
- ✅ Booking multi-fasilitas dalam satu transaksi
- ✅ Input jam booking fleksibel (bukan slot kaku per jam)
- ✅ Pengecekan overlap jadwal otomatis
- ✅ Sistem diskon otomatis berdasarkan role pengguna
- ✅ Pembayaran dua tahap — DP dulu, pelunasan kemudian
- ✅ Upload bukti transfer (untuk metode transfer bank)
- ✅ Konfirmasi admin sebelum booking aktif
- ✅ Laporan & ekspor data booking

---

## 🗄️ Struktur Database (ERD)

### Daftar Tabel

```
booking_lapangan/
├── users                — Data semua pengguna (5 role)
├── fasilitas            — Data fasilitas yang bisa dipesan
├── jadwal               — Jam operasional per fasilitas
├── bookings             — Data booking utama
├── detail_bookings      — Rincian per fasilitas per booking
└── pembayaran           — Data pembayaran DP & pelunasan
```

### Skema Tabel

#### `users`
| Kolom | Tipe | Keterangan |
|-------|------|-----------|
| id | INT PK | Primary key |
| name | VARCHAR | Nama lengkap |
| email | VARCHAR UNIQUE | Email login |
| password | VARCHAR | Password terenkripsi |
| no_hp | VARCHAR NULL | Nomor HP |
| role | ENUM | `admin` / `guru` / `siswa_internal` / `siswa_luar` / `umum` |
| nis | VARCHAR NULL | Wajib untuk siswa_internal |
| kelas | VARCHAR NULL | Wajib untuk siswa_internal |
| asal_sekolah | VARCHAR NULL | Wajib siswa_internal & siswa_luar |
| foto_kartu_pelajar | VARCHAR NULL | Wajib untuk siswa_luar |
| google_id | VARCHAR NULL | ID akun Google (untuk OAuth) |
| avatar | VARCHAR NULL | URL foto profil dari Google |
| created_at | TIMESTAMP | Waktu dibuat |

#### `fasilitas`
| Kolom | Tipe | Keterangan |
|-------|------|-----------|
| id | INT PK | Primary key |
| nama | VARCHAR | Nama fasilitas |
| jenis | ENUM | `lapangan` / `ruang_multimedia` / `lab` |
| deskripsi | TEXT NULL | Deskripsi fasilitas |
| foto | VARCHAR NULL | Path foto fasilitas |
| harga_per_jam | DECIMAL | Harga dasar per jam (harga umum) |
| status | ENUM | `aktif` / `nonaktif` |
| created_at | TIMESTAMP | Waktu dibuat |

#### `jadwal`
| Kolom | Tipe | Keterangan |
|-------|------|-----------|
| id | INT PK | Primary key |
| fasilitas_id | INT FK | Referensi ke tabel fasilitas |
| jam_buka | TIME | Jam mulai operasional (default 08:00) |
| jam_tutup | TIME | Jam tutup operasional (lapangan: 21:00, lainnya: 17:00) |
| is_libur | BOOLEAN | Tandai hari libur (default false) |
| created_at | TIMESTAMP | Waktu dibuat |

#### `bookings`
| Kolom | Tipe | Keterangan |
|-------|------|-----------|
| id | INT PK | Primary key |
| kode_booking | VARCHAR UNIQUE | Kode unik booking |
| user_id | INT FK | Referensi ke tabel users |
| diskon_persen | INT | 0 / 30 / 50 / 100 (guru gratis) |
| total_diskon | DECIMAL | Nominal diskon dalam rupiah |
| total_harga | DECIMAL | Total setelah diskon |
| status_booking | ENUM | `menunggu` / `dikonfirmasi` / `dibatalkan` / `selesai` |
| role_booker | ENUM | Role saat booking dibuat |
| created_at | TIMESTAMP | Waktu dibuat |

#### `detail_bookings`
| Kolom | Tipe | Keterangan |
|-------|------|-----------|
| id | INT PK | Primary key |
| booking_id | INT FK | Referensi ke tabel bookings |
| fasilitas_id | INT FK | Referensi ke tabel fasilitas |
| tanggal | DATE | Tanggal booking |
| jam_mulai | TIME | Jam mulai (fleksibel, contoh: 08:30) |
| jam_selesai | TIME | Jam selesai (fleksibel, contoh: 11:00) |
| durasi_jam | DECIMAL(4,1) | Durasi dalam jam (contoh: 2.5) |
| subtotal | DECIMAL | Harga per fasilitas sudah dipotong diskon |
| created_at | TIMESTAMP | Waktu dibuat |

#### `pembayaran`
| Kolom | Tipe | Keterangan |
|-------|------|-----------|
| id | INT PK | Primary key |
| booking_id | INT FK | Referensi ke tabel bookings |
| metode | ENUM | `transfer` / `cash` |
| nominal_dp | DECIMAL | Jumlah uang DP |
| nominal_lunas | DECIMAL | Jumlah pelunasan |
| total_tagihan | DECIMAL | Total tagihan keseluruhan |
| status_bayar | ENUM | `belum_bayar` / `dp` / `lunas` |
| bukti_dp | VARCHAR NULL | Path foto bukti DP (untuk transfer) |
| bukti_lunas | VARCHAR NULL | Path foto bukti pelunasan |
| waktu_dp | TIMESTAMP NULL | Waktu DP diterima |
| waktu_lunas | TIMESTAMP NULL | Waktu pelunasan dikonfirmasi |
| verifikator_dp | INT FK NULL | Admin yang verifikasi DP |
| verifikator_lunas | INT FK NULL | Admin yang konfirmasi lunas |
| created_at | TIMESTAMP | Waktu dibuat |

### Relasi Antar Tabel

```
USERS ──(1:N)──► BOOKINGS ──(1:N)──► DETAIL_BOOKINGS ──(N:1)──► FASILITAS
                     │                                                 │
                  (1:0..1)                                          (1:1)
                     │                                             JADWAL
                 PEMBAYARAN ──(N:1)──► USERS (verifikator)
```

---

## 🔄 Alur Sistem

### Alur Pengguna (User — Siswa Internal / Siswa Luar / Umum)

```
1. REGISTER
   └─ Daftar dengan nama, email, password
   └─ Role otomatis: umum
   └─ Verifikasi OTP via email

2. LOGIN
   └─ Masuk dengan email & password, atau Google OAuth
   └─ Redirect otomatis ke dashboard sesuai role

3. LENGKAPI PROFIL (Opsional tapi disarankan)
   └─ Buka halaman Profil
   └─ Pilih tipe akun:
      ├─ Siswa Internal → isi NIS, Kelas, Asal Sekolah → diskon 50%
      ├─ Siswa Luar    → upload Kartu Pelajar + Asal Sekolah → diskon 30%
      └─ Umum          → tidak perlu isi apa-apa → harga normal

4. BOOKING FASILITAS
   └─ Buka Katalog Fasilitas
   └─ Pilih fasilitas (bisa lebih dari satu)
   └─ Pilih tanggal, jam mulai, jam selesai
   └─ Sistem hitung durasi & subtotal otomatis
   └─ Sistem cek overlap jadwal otomatis
   └─ Review & submit booking

5. TUNGGU KONFIRMASI ADMIN
   └─ Status: menunggu
   └─ Admin review dan setujui atau tolak booking

6. BAYAR DP
   └─ Status: dikonfirmasi
   └─ User bayar DP (transfer / cash ke petugas)
   └─ Jika transfer: upload foto bukti transfer
   └─ Status: dp_menunggu

7. ADMIN VERIFIKASI DP
   └─ Admin cek bukti transfer atau terima uang cash
   └─ Status: dp_lunas

8. LUNASI SISA TAGIHAN
   └─ User bayar sisa ke petugas (transfer / cash)
   └─ Status: pelunasan_menunggu

9. ADMIN KONFIRMASI LUNAS
   └─ Admin konfirmasi pelunasan diterima
   └─ Status: lunas / selesai
   └─ Booking aktif!
```

### Alur Guru

```
1. Login dengan akun guru (dibuat oleh admin)
2. Pilih fasilitas & jadwal
3. Submit booking
4. Booking LANGSUNG aktif — tanpa konfirmasi & tanpa pembayaran
```

### Alur Admin

```
1. Login ke panel admin
2. Terima notifikasi booking masuk dari user
3. Review dan konfirmasi atau tolak booking
4. Verifikasi bukti DP dari user
5. Konfirmasi pelunasan setelah terima pembayaran
6. Kelola data fasilitas, jadwal, dan pengguna
7. Lihat laporan & ekspor data
```

### Sistem Diskon Otomatis

```
Harga dasar  = harga_per_jam × durasi_jam
Total diskon = harga dasar × (diskon_persen / 100)
Total bayar  = harga dasar - total diskon

Contoh: Lapangan Futsal Rp100.000/jam, booking 2 jam
├─ Umum           : 200.000 × 0%  = Rp200.000
├─ Siswa Luar     : 200.000 × 30% = Rp140.000
├─ Siswa Internal : 200.000 × 50% = Rp100.000
└─ Guru           : 200.000 × 100% = GRATIS
```

---

## 🎨 Style Guide

### Tema & Warna

Sistem menggunakan **Dark Mode Futuristik** dengan aksen hijau neon.

| Elemen | Warna | Hex |
|--------|-------|-----|
| Background utama | Gelap | `#1e1e1e` |
| Background sidebar | Lebih gelap | `#161616` |
| Background card | Abu gelap | `#252525` |
| Aksen utama | Hijau neon | `#00c853` |
| Teks utama | Putih | `#ffffff` |
| Teks sekunder | Putih redup | `rgba(255,255,255,0.55)` |
| Danger / Error | Merah | `#ef4444` |
| Warning | Kuning | `#f59e0b` |
| Info | Biru | `#3b82f6` |

### Tipografi

- **Font Utama:** Plus Jakarta Sans (Google Fonts)
- **Font Monospace:** Untuk kode booking, jam, dan ID

```html
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
```

### Icon

Menggunakan **Font Awesome 6.5** (CDN):

```html
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
```

### CSS Framework

Menggunakan **Tailwind CSS** via CDN (tidak perlu `npm run dev`):

```html
<script src="https://cdn.tailwindcss.com"></script>
```

### Komponen UI

| Komponen | Class |
|----------|-------|
| Button Hijau | `btn btn-green` |
| Button Outline | `btn btn-outline` |
| Button Kecil | `btn btn-sm` |
| Badge Hijau | `badge badge-green` |
| Badge Merah | `badge badge-red` |
| Badge Kuning | `badge badge-yellow` |
| Badge Biru | `badge badge-blue` |
| Card | `card` |
| Tabel | `tbl-wrap > table` |
| Form Input | `form-control` |

### Konvensi Penamaan

- **File Blade**: `snake_case.blade.php`
- **Controller**: `PascalCaseController.php`
- **Model**: `PascalCase.php`
- **Route name**: `admin.fasilitas.index`
- **CSS variable**: `--color-green`, `--bg`, `--card`

---

## 📁 Struktur Folder Project

```
booking-lapangan/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── FasilitasController.php
│   │   │   │   ├── JadwalController.php
│   │   │   │   ├── BookingController.php
│   │   │   │   ├── PembayaranController.php
│   │   │   │   ├── UserController.php
│   │   │   │   └── LaporanController.php
│   │   │   ├── Auth/
│   │   │   │   ├── AuthenticatedSessionController.php
│   │   │   │   ├── RegisteredUserController.php
│   │   │   │   ├── GoogleController.php
│   │   │   │   └── ForgotPasswordOtpController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── BookingController.php       ← user
│   │   │   └── ProfileController.php
│   │   └── Middleware/
│   │       └── RoleMiddleware.php
│   └── Models/
│       ├── User.php
│       ├── Fasilitas.php
│       ├── Jadwal.php
│       ├── Booking.php
│       ├── DetailBooking.php
│       └── Pembayaran.php
├── database/
│   ├── migrations/
│   │   ├── xxxx_create_users_table.php
│   │   ├── xxxx_create_fasilitas_table.php
│   │   ├── xxxx_create_jadwal_table.php
│   │   ├── xxxx_create_bookings_table.php
│   │   ├── xxxx_create_detail_bookings_table.php
│   │   └── xxxx_create_pembayaran_table.php
│   └── seeders/
│       ├── AdminSeeder.php
│       ├── FasilitasSeeder.php
│       ├── JadwalSeeder.php
│       └── DatabaseSeeder.php
├── resources/views/
│   ├── layouts/
│   │   └── admin.blade.php
│   ├── auth/
│   │   ├── login.blade.php
│   │   ├── register.blade.php
│   │   └── ...
│   ├── admin/
│   │   ├── dashboard.blade.php
│   │   ├── fasilitas/
│   │   ├── jadwal/
│   │   ├── booking/
│   │   ├── pembayaran/
│   │   └── users/
│   ├── user/
│   │   ├── dashboard.blade.php
│   │   ├── katalog.blade.php
│   │   ├── booking/
│   │   ├── pembayaran/
│   │   └── profil.blade.php
│   └── guru/
│       └── dashboard.blade.php
├── routes/
│   ├── web.php
│   └── auth.php
├── .env.example
└── README.md
```

---

## ⚙️ Cara Menjalankan Project

### Prasyarat

- PHP >= 8.3
- Composer
- Node.js >= 20 & NPM
- MySQL / XAMPP (untuk Windows)

### Langkah Instalasi

```bash
# 1. Clone repository
git clone https://github.com/USERNAME/booking-lapangan.git
cd booking-lapangan

# 2. Install dependencies PHP
composer install

# 3. Copy file environment
cp .env.example .env

# 4. Generate app key
php artisan key:generate

# 5. Konfigurasi database di .env
# DB_DATABASE=booking_lapangan
# DB_USERNAME=root
# DB_PASSWORD=isi_password_kamu

# 6. Buat database (via phpMyAdmin atau terminal)
mysql -u root -p -e "CREATE DATABASE booking_lapangan;"

# 7. Jalankan migration & seeder
php artisan migrate --seed

# 8. Buat symlink storage
php artisan storage:link

# 9. Jalankan server
php artisan serve
```

Buka browser: `http://localhost:8000`

### Akun Default (Setelah Seeder)

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@spacego.com | admin123 |
| Guru | guru@spacego.com | guru123 |
| User (umum) | user@spacego.com | user123 |

---

## 👥 Panduan Kolaborasi Tim

### Alur Kerja Harian (WAJIB diikuti)

```
SETIAP HARI SEBELUM MULAI CODING:

1. Pindah ke branch main
   git checkout main

2. Ambil update terbaru dari GitHub
   git pull origin main

3. Pindah ke branch kamu
   git checkout feature/nama-branch-kamu

4. Gabungkan update terbaru
   git merge main

5. Mulai coding...

SETELAH SELESAI CODING:

6. Cek file yang berubah
   git status

7. Tambahkan semua perubahan
   git add .

8. Commit dengan pesan yang jelas
   git commit -m "feat: deskripsi yang kamu kerjakan"

9. Push ke branch kamu
   git push origin feature/nama-branch-kamu

10. Buat Pull Request di GitHub → minta ketua review & merge
```

### Format Pesan Commit

```
feat:  → menambah fitur baru
fix:   → memperbaiki bug
style: → perubahan tampilan/CSS
refactor: → refactor kode tanpa ubah fungsi
docs:  → update dokumentasi

Contoh:
feat: tambah halaman booking fasilitas user
fix: perbaiki error validasi jam booking
style: update tampilan kartu fasilitas di katalog
```

### Aturan Branch

| Aturan | Penjelasan |
|--------|-----------|
| ❌ Jangan push ke `main` langsung | Selalu lewat Pull Request |
| ✅ Satu branch per fitur | Pisahkan branch per jobdesk |
| 🔄 Pull setiap hari | Hindari conflict |
| 🚫 Jangan push `.env` | Sudah ada di `.gitignore` |
| 🚫 Jangan push folder `vendor/` | Sudah ada di `.gitignore` |

### Cara Cek Branch Aktif

```bash
git branch        # lihat branch lokal (tanda * = aktif)
git branch -r     # lihat branch di GitHub
git branch -a     # semua branch
```

---

## 📋 Pembagian Jobdesk

| Anggota | Branch | Jobdesk |
|---------|--------|---------|
| **Ketua** | `feature/backend-admin` | Migration DB, Model, Seeder, CRUD backend admin, Routes, Middleware |
| **Anggota 2** | `feature/frontend-admin` | Semua tampilan halaman admin (Blade views) |
| **Anggota 3 & 4** | `feature/user-guru` | Backend + Frontend halaman user & guru (booking, pembayaran, profil) |

### Detail Jobdesk Ketua (Backend Admin)

- [x] Migration semua tabel (users, fasilitas, jadwal, bookings, detail_bookings, pembayaran)
- [x] Model semua tabel beserta relasi
- [x] Seeder data awal (Admin, Fasilitas, Jadwal)
- [x] RoleMiddleware (5 role)
- [x] Routes admin, guru, user
- [ ] Controller CRUD Fasilitas
- [ ] Controller CRUD Jadwal
- [ ] Controller Kelola Booking (konfirmasi/tolak)
- [ ] Controller Verifikasi Pembayaran
- [ ] Controller Kelola User
- [ ] Controller Laporan

### Detail Jobdesk Anggota 2 (Frontend Admin)

- [ ] Layout admin (sidebar, topbar)
- [ ] Dashboard admin
- [ ] Halaman daftar & CRUD fasilitas
- [ ] Halaman jadwal operasional
- [ ] Halaman kelola booking
- [ ] Halaman verifikasi pembayaran
- [ ] Halaman kelola pengguna
- [ ] Halaman laporan

### Detail Jobdesk Anggota 3 & 4 (User & Guru)

- [ ] Dashboard user
- [ ] Halaman profil & update tipe akun (progressive profiling)
- [ ] Katalog fasilitas dengan filter
- [ ] Form booking (pilih fasilitas, tanggal, jam)
- [ ] Halaman checkout & konfirmasi harga
- [ ] Halaman pembayaran (upload bukti DP & pelunasan)
- [ ] Riwayat booking & status
- [ ] Dashboard guru
- [ ] Halaman booking guru (langsung aktif)

---

## 📞 Kontak Tim

> Untuk pertanyaan dan koordinasi, hubungi ketua tim melalui grup WhatsApp tim.

---

<div align="center">

**SpaceGo System** © 2026 — Dibuat dengan ❤️ oleh Tim Kelompok

</div>
