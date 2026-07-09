# 🫧 Fresh Laundry — Sistem Informasi Laundry

Sistem Informasi / Aplikasi Laundry berbasis web yang dibangun menggunakan **Laravel 13** dan **Tailwind CSS v4**, dikembangkan sebagai project Ujikom Junior Web Programming — PPKD Jakarta Pusat, Tahun Ajaran 2026.

Aplikasi ini mengelola alur bisnis laundry secara end-to-end: pendataan customer, transaksi laundry multi-jasa dengan perhitungan otomatis, proses pengambilan pakaian, hingga laporan penjualan — dengan 3 level akses (Administrator, Operator, Pimpinan) yang masing-masing punya hak akses berbeda.

---

## ✨ Fitur Utama

### 👑 Administrator
- Kelola master data **Customer** (tambah, edit, hapus)
- Kelola master data **User** — termasuk menambahkan akun baru dengan level Operator/Pimpinan
- Kelola master data **Jenis Service** laundry beserta harga per kg

### 🧑‍🔧 Operator
- Membuat **transaksi laundry** baru:
  - Pilih customer (yang sudah terdaftar)
  - Pilih satu atau lebih jenis jasa sekaligus dalam satu transaksi
  - Subtotal dan total dihitung otomatis (`subtotal = harga × qty`)
- Memproses **pengambilan laundry**:
  - Menampilkan daftar transaksi berstatus "Baru" (status `0`)
  - Konfirmasi pengambilan akan mengubah status menjadi "Sudah Diambil" (status `1`)

### 📊 Pimpinan
- Melihat **laporan penjualan** (read-only):
  - Filter berdasarkan rentang tanggal
  - Ringkasan total omzet, jumlah transaksi baru, dan jumlah transaksi selesai
  - Detail rincian jasa per transaksi

---

## 🗂️ Struktur Database

Struktur database mengikuti ERD yang telah ditentukan dan **tidak diubah** dari dokumentasi awal:

| Tabel | Keterangan |
|---|---|
| `level` | Data role: Administrator, Operator, Pimpinan |
| `users` | Akun login (tabel bawaan Laravel + kolom `id_level`) |
| `customer` | Data pelanggan laundry |
| `type_of_service` | Jenis jasa laundry & harga per kg |
| `trans_order` | Header transaksi laundry |
| `trans_order_detail` | Detail jasa per transaksi (bisa lebih dari satu jasa per order) |
| `trans_laundry_pickup` | Catatan pengambilan pakaian oleh customer |

**Alur bisnis:**

```
Customer datang
   → Input data customer baru (jika belum terdaftar)
   → Buat transaksi laundry (pilih jasa + qty)
   → Subtotal & total dihitung otomatis
   → Status order: 0 (Baru)
   → Customer datang mengambil pakaian
   → Status order berubah: 1 (Sudah Diambil)
```

---

## 🛠️ Tech Stack

| Kategori | Teknologi |
|---|---|
| Backend | Laravel 13 (PHP) |
| Database | MySQL |
| Frontend | Blade Template + Tailwind CSS v4 (via Vite) |
| Font | Baloo 2 (heading), Plus Jakarta Sans (body), IBM Plex Mono (angka/kode) |
| Autentikasi | Manual (Laravel Auth + custom Middleware role) |

---

## 🎨 Desain UI

Tema visual **"Laundry Fresh"** — full color, tidak menggunakan template admin panel generik:

| Warna | Hex | Fungsi |
|---|---|---|
| Ink | `#10192E` | Teks utama & elemen gelap |
| Suds Blue | `#2D8CFF` | Warna primer |
| Detergent Teal | `#17B8A6` | Warna sekunder |
| Bubblegum | `#FF5D8F` | Aksen (highlight/hapus) |
| Sunbeam | `#FFC94A` | Aksen (status baru/warning) |
| Cloud | `#F4F8FC` | Background terang |

Fitur UI tambahan:
- Layout **Sidebar + Topbar** dengan navigasi otomatis sesuai level user
- **Realtime clock** di halaman login & topbar
- Status online (titik hijau) pada avatar user
- Efek **"sobekan tiket laundry"** (perforated edge) pada kartu statistik & total transaksi

---

## 🚀 Instalasi & Setup

### 1. Clone repository

```bash
git clone <url-repository-ini>
cd WEB_[NAMA]_LAUNDRY
```

### 2. Install dependency PHP

```bash
composer install
```

### 3. Install dependency frontend (Tailwind CSS v4)

```bash
npm install
```

### 4. Konfigurasi environment

```bash
cp .env.example .env
php artisan key:generate
```

Buka file `.env`, sesuaikan koneksi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_laundry
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Buat database

```sql
CREATE DATABASE db_laundry;
```

### 6. Migrasi & seeding database

```bash
php artisan migrate:fresh --seed
```

> Perintah ini akan membuat seluruh tabel sesuai ERD, sekaligus mengisi data awal (3 level dan 3 akun user).

### 7. Build asset frontend

```bash
npm run build
```

Untuk mode development (auto-reload saat edit CSS/JS):

```bash
npm run dev
```

### 8. Jalankan server

```bash
php artisan serve
```

Buka browser ke **http://127.0.0.1:8000**

---

## 🔑 Akun Default (Hasil Seeder)

| Role | Email | Password |
|---|---|---|
| Administrator | `admin@laundry.com` | `password` |
| Operator | `operator@laundry.com` | `password` |
| Pimpinan | `pimpinan@laundry.com` | `password` |

> ⚠️ Disarankan mengganti password default ini sebelum digunakan di lingkungan produksi.

---

## 📋 Alur Penggunaan Aplikasi

1. **Login** menggunakan salah satu akun di atas — sistem otomatis mengarahkan ke dashboard sesuai role.
2. **Sebagai Administrator:**
   - Tambahkan data Customer melalui menu *Customer*
   - Tambahkan Jenis Service beserta harga (contoh: Cuci & Gosok Rp5.000/kg)
   - Tambahkan akun Operator/Pimpinan baru jika diperlukan melalui menu *User*
3. **Sebagai Operator:**
   - Buka menu *Transaksi Laundry* → *Buat Transaksi Baru*
   - Pilih customer, pilih satu/lebih jenis jasa, isi berat (qty)
   - Simpan — total otomatis terhitung
   - Saat customer datang mengambil, buka menu *Pengambilan Laundry* → pilih transaksi → konfirmasi
4. **Sebagai Pimpinan:**
   - Buka menu *Laporan Penjualan* untuk melihat ringkasan omzet dan seluruh riwayat transaksi
   - Gunakan filter tanggal untuk melihat laporan pada periode tertentu

---

## 📁 Struktur Folder Penting

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/          # Controller untuk Administrator
│   │   ├── Operator/        # Controller untuk Operator
│   │   ├── Pimpinan/        # Controller untuk Pimpinan
│   │   └── AuthController.php
│   └── Middleware/
│       ├── CheckRole.php              # Middleware pembatas akses per role
│       └── PreventBackHistory.php     # Mencegah cache halaman setelah logout
├── Models/                  # Level, User, Customer, TypeOfService, TransOrder, dst.
database/
├── migrations/               # Struktur 7 tabel sesuai ERD
└── seeders/                  # LevelSeeder & UserSeeder
resources/
├── views/
│   ├── admin/                # View master data (Customer, User, Jenis Service)
│   ├── operator/              # View transaksi & pengambilan laundry
│   ├── pimpinan/               # View laporan penjualan
│   ├── components/             # Layout Blade (layout-app, layout-guest)
│   └── layouts/partials/        # Sidebar & topbar
```

---

## 🔒 Catatan Keamanan

- Setiap route dilindungi middleware `role` — user hanya bisa mengakses halaman sesuai level-nya (akses ke halaman role lain akan menghasilkan `403 Forbidden`).
- Password disimpan ter-enkripsi menggunakan `bcrypt` (`Hash::make`).
- Middleware `PreventBackHistory` mencegah halaman ter-cache di browser, sehingga tombol *back* tidak dapat menampilkan halaman yang membutuhkan login setelah user logout.

---

## 📄 Lisensi

Project ini dibuat untuk keperluan **Ujikom Junior Web Programming — PPKD Jakarta Pusat, Tahun Ajaran 2026**.