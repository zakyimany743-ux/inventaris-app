# 📦 Aplikasi Manajemen Inventaris (Laravel)

Aplikasi web sederhana untuk mengelola data inventaris toko perlengkapan komputer, dibangun dengan Laravel 12, MySQL/MariaDB, dan Blade templating. Aplikasi ini memiliki sistem authentication, CRUD untuk kategori dan barang, database relasional (one-to-many), migration, dan seeder.

## 📋 Fitur Aplikasi

- ✅ **Authentication** — Login & Logout menggunakan session, password di-hash (bcrypt)
- ✅ **Middleware Protection** — Halaman inventaris dilindungi middleware `auth`
- ✅ **Database Relasional** — Dua tabel utama: `categories` & `items` (relasi one-to-many)
- ✅ **Eloquent Relationship** — `hasMany()` di Category, `belongsTo()` di Item
- ✅ **CRUD Kategori** — Tambah, tampilkan, ubah, hapus (dengan proteksi integritas referensial)
- ✅ **CRUD Barang** — Tambah, tampilkan (beserta nama kategori), ubah, hapus
- ✅ **Validasi Input** — Nama wajib, harga > 0, stok integer ≥ 0, kategori harus valid
- ✅ **Migration & Seeder** — Migration terstruktur, seeder menghasilkan 1 user + 3 kategori + 5 barang

## 🗄️ Struktur Database

```
users (untuk authentication)
├── id (BIGINT, PK)
├── name (VARCHAR)
├── email (VARCHAR, unique)
├── password (VARCHAR, hashed)
└── timestamps

categories
├── id (BIGINT, PK)
├── name (VARCHAR)
└── timestamps
        │
        │ 1
        ↓
        │ N
items
├── id (BIGINT, PK)
├── category_id (BIGINT, FK → categories.id, ON DELETE RESTRICT)
├── name (VARCHAR)
├── price (DECIMAL 12,2)
├── stock (INTEGER)
└── timestamps
```

## 🚀 Cara Instalasi & Menjalankan

### Prasyarat

Pastikan sistem Anda sudah terinstall:
- **PHP** >= 8.2
- **Composer** (PHP dependency manager)
- **MySQL** atau **MariaDB**
- **Ekstensi PHP**: pdo_mysql, pdo_sqlite (untuk pengujian), mbstring, openssl, tokenizer, xml, ctype, json, bcmath, zip

### Langkah-langkah Instalasi

#### 1. Clone atau Salin Project

```bash
# Jika menggunakan git
git clone <repository-url> inventaris-app
cd inventaris-app

# Atau ekstrak folder project yang sudah disalin
```

#### 2. Install Dependencies

```bash
composer install
```

#### 3. Konfigurasi Environment

Salin file `.env.example` menjadi `.env`:

```bash
cp .env.example .env
```

Edit file `.env` dan sesuaikan konfigurasi database:

```env
APP_NAME="Inventaris App"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inventaris_db          # nama database Anda
DB_USERNAME=root                    # username MySQL Anda
DB_PASSWORD=                        # password MySQL Anda
```

#### 4. Generate Application Key

```bash
php artisan key:generate
```

#### 5. Buat Database di MySQL

Login ke MySQL lalu buat database:

```sql
CREATE DATABASE inventaris_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Atau via terminal:

```bash
mysql -u root -p -e "CREATE DATABASE inventaris_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

#### 6. Jalankan Migration

```bash
php artisan migrate
```

#### 7. Jalankan Seeder

```bash
php artisan db:seed
```

> **Alternatif**: Untuk membangun ulang database pengujian dari awal (migration + seeder sekaligus):
> ```bash
> php artisan migrate:fresh --seed
> ```
> ⚠️ Perintah ini akan menghapus semua tabel yang ada. Hanya gunakan di database pengembangan/pengujian.

#### 8. Jalankan Server

```bash
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`.

## 🔑 Akun Demo (Hasil Seeder)

| Field    | Nilai                     |
|----------|---------------------------|
| Email    | `admin@inventaris.test`   |
| Password | `password123`             |

## 📊 Data Awal (Hasil Seeder)

### 3 Kategori:

| ID | Nama Kategori       |
|----|---------------------|
| 1  | Aksesori            |
| 2  | Perangkat Komputer  |
| 3  | Penyimpanan         |

### 5 Barang:

| Nama    | Kategori           | Harga     | Stok |
|---------|--------------------|-----------|------|
| Keyboard| Aksesori           | 150.000   | 10   |
| Mouse   | Aksesori           | 75.000    | 20   |
| Monitor | Perangkat Komputer | 1.500.000 | 5    |
| Headset | Aksesori           | 250.000   | 8    |
| Flashdisk| Penyimpanan       | 85.000    | 15   |

## 📁 Struktur Folder Penting

```
inventaris-app/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php          # Login & Logout
│   │   │   ├── DashboardController.php     # Halaman Dashboard
│   │   │   ├── CategoryController.php      # CRUD Kategori
│   │   │   ├── ItemController.php          # CRUD Barang
│   │   │   └── Controller.php              # Base controller Laravel
│   └── Models/
│       ├── User.php                        # Model User
│       ├── Category.php                    # Model Category (hasMany)
│       └── Item.php                        # Model Item (belongsTo)
├── config/                                  # Konfigurasi Laravel
├── database/
│   ├── migrations/
│   │   ├── 2024_01_01_000001_create_users_table.php
│   │   ├── 2024_01_01_000002_create_categories_table.php
│   │   └── 2024_01_01_000003_create_items_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php              # Seeder utama
│       ├── UserSeeder.php                  # Seeder user
│       ├── CategorySeeder.php              # Seeder kategori
│       └── ItemSeeder.php                 # Seeder barang
├── resources/views/
│   ├── layouts/app.blade.php               # Layout utama
│   ├── auth/login.blade.php                # Halaman login
│   ├── dashboard/index.blade.php          # Halaman dashboard
│   ├── categories/{index,create,edit}.blade.php
│   └── items/{index,create,edit}.blade.php
├── public/
│   └── index.php                            # Entry point web
├── routes/
│   └── web.php                              # Definisi route
├── tests/
│   └── Feature/InventoryApplicationTest.php # Pengujian fitur
└── phpunit.xml                              # Konfigurasi pengujian
```

## 🧪 Pengujian Fitur

Jalankan pengujian otomatis menggunakan SQLite in-memory (tidak mengubah database MySQL):

```bash
php artisan test
```

Setelah aplikasi berjalan, uji fitur-fitur berikut:

1. **Login & Logout** — Buka aplikasi, login dengan akun demo, lalu logout.
2. **Akses tanpa login** — Coba akses `http://localhost:8000/dashboard` tanpa login → harus redirect ke login.
3. **CRUD Kategori** — Tambah, ubah, hapus kategori.
4. **CRUD Barang** — Tambah, ubah, hapus barang.
5. **Pemilihan kategori** — Saat tambah/ubah barang, pilih kategori dari dropdown.
6. **Tampil nama kategori** — Di daftar barang, nama kategori tampil berdasarkan relasi.
7. **Validasi** — Coba submit form dengan data kosong/invalid.
8. **Hapus kategori berisi barang** — Sistem akan menolak dengan pesan error.
9. **Cek foreign key** — Lihat struktur tabel di MySQL.
10. **Cek seeder** — Pastikan data awal tampil di aplikasi.

## 🛠️ Perintah Artisan Berguna

```bash
# Menjalankan migration
php artisan migrate

# Rollback migration terakhir
php artisan migrate:rollback

# Reset & jalankan ulang semua migration + seeder
php artisan migrate:fresh --seed

# Menjalankan seeder saja
php artisan db:seed

# Menjalankan server development
php artisan serve

# Melihat daftar route
php artisan route:list

# Mengoptimasi autoload
composer dump-autoload
```

## 🔒 Catatan Keamanan

- File `.env` **TIDAK** boleh di-upload ke GitHub (sudah ada di `.gitignore`).
- Password pengguna disimpan menggunakan **bcrypt hashing**.
- Session di-**invalidate** saat logout untuk mencegah akses dari sesi sebelumnya.
- Foreign key dengan `ON DELETE RESTRICT` mencegah penghapusan kategori yang masih memiliki barang.

## 📝 Penjelasan Implementasi

### 1. Authentication

Sistem login menggunakan session-based authentication bawaan Laravel:
- **Halaman login** ada di `/login`
- **Middleware `auth`** melindungi semua route di grup inventaris (dashboard, categories, items)
- **Password di-hash** menggunakan `Hash::make()` (bcrypt) saat seeder dijalankan
- **Verifikasi password** menggunakan `Hash::check()` saat proses login
- **Logout** menghapus semua data session dan me-regenerate token CSRF

### 2. Database Relasional

- **categories**: tabel utama menyimpan data kategori
- **items**: tabel utama menyimpan data barang dengan `category_id` sebagai foreign key
- Relasi **one-to-many**: satu kategori dapat memiliki banyak barang
- Foreign key menggunakan `ON DELETE RESTRICT` untuk menjaga integritas referensial

### 3. Eloquent Relationship

```php
// Model Category
public function items() {
    return $this->hasMany(Item::class);
}

// Model Item
public function category() {
    return $this->belongsTo(Category::class);
}
```

### 4. Validasi

- Nama kategori/barang tidak boleh kosong (`required`)
- Harga harus angka > 0 (`numeric|gt:0`)
- Stok harus integer ≥ 0 (`integer|min:0`)
- Kategori harus tersedia di database (`exists:categories,id`)

## 🚀 Deployment ke GitHub

```bash
# Inisialisasi git repository
git init

# Tambahkan semua file
git add .

# Commit pertama
git commit -m "Initial commit: Aplikasi Manajemen Inventaris Laravel"

# Tambahkan remote repository
git remote add origin https://github.com/USERNAME/inventaris-app.git

# Push ke GitHub
git branch -M main
git push -u origin main
```

⚠️ **PENTING**: Pastikan file `.env` TIDAK ikut ter-upload ke GitHub. File sudah ada di `.gitignore`.

---

**Dibuat untuk UTS Live Coding Case Study - Pemrograman Berorientasi Objek / Pengembangan Aplikasi Web**
