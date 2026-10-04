# BlogCRUD — Tugas Rutin Pertemuan 10

**BlogCRUD** (ditampilkan sebagai **Ruang Kata**) adalah aplikasi blog sederhana berbasis Laravel untuk membuat, membaca, memperbarui, dan menghapus artikel. Proyek ini hanya mengerjakan **Tugas Rutin Pertemuan 10** pada materi Pemrograman Web; tugas Rekayasa Ide dan fitur bonus tidak termasuk dalam cakupan.

## Requirement tugas

| Requirement pertemuan 10 | Implementasi |
| --- | --- |
| `Route::resource('posts')` dan named routes | Seluruh route resource didefinisikan di `routes/web.php`; view menggunakan helper `route()`. |
| `PostController` dengan 7 method resource | `index`, `create`, `store`, `show`, `edit`, `update`, dan `destroy` berada di controller. |
| Blade master layout dengan `@extends` / `@yield` | `resources/views/layouts/app.blade.php` dipakai oleh seluruh halaman posts. |
| Minimal dua komponen Blade: Alert dan Card | Komponen reusable `x-alert` dan `x-card` berada di `resources/views/components`. |
| Validasi, error per field, dan old input | Validasi judul (wajib, maks. 200 karakter) serta isi (wajib, min. 10 karakter); pesan ditampilkan di field masing-masing dan formulir mengisi kembali `old()`. |
| Flash message sukses/gagal | Operasi CRUD mengirim flash sukses. Kesalahan validasi ditampilkan dengan alert gagal dan error per field. |
| `@csrf` di semua form dan `@method('PUT'/'DELETE')` | Form buat, edit, dan hapus menggunakan token CSRF serta spoofing method untuk PUT/DELETE. |
| Route model binding dan pagination | `Post $post` otomatis di-bind; daftar artikel memakai `latest()->paginate(6)`. |

Implementasi ditata mengikuti MVC: route meneruskan request ke controller, model Eloquent membaca/menulis tabel, dan view Blade menampilkan data. Output user menggunakan echo Blade `{{ }}` yang di-escape otomatis; semua form menulis data menggunakan validasi Laravel dan mass assignment memakai `$fillable`.

## Teknologi dan prasyarat

- PHP **8.3+** dengan ekstensi `pdo_mysql`.
- Composer 2.
- MySQL 8+ (dapat dijalankan lewat Laragon), untuk aplikasi dan pengujian.
- Browser modern.

CSS aplikasi berada di `public/css/app.css`, sehingga Node.js dan build Vite tidak diperlukan untuk menjalankan aplikasi.

## Menyiapkan dan menjalankan

Jalankan perintah dari folder proyek `Tugas P10`.

### 1. Instal dependency

```powershell
composer install
```

### 2. Siapkan konfigurasi lokal

```powershell
Copy-Item .env.example .env
php artisan key:generate
```

Konfigurasi bawaan menggunakan MySQL Laragon. Pastikan MySQL aktif, lalu buat database bernama `blogcrud` melalui HeidiSQL/phpMyAdmin atau MySQL CLI. Nilai `.env` harus cocok dengan setelan lokal:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=blogcrud
DB_USERNAME=root
DB_PASSWORD=
```

Pengaturan di atas memakai akun `root` tanpa password, seperti konfigurasi Laragon yang umum; sesuaikan `DB_USERNAME` dan `DB_PASSWORD` bila mesin Anda memakai kredensial lain. Jangan commit `.env`; file tersebut memuat konfigurasi khusus mesin lokal.
Session dan cache secara default menggunakan penyimpanan file, sedangkan queue memakai mode sinkron, sehingga aplikasi tidak memerlukan tabel tambahan untuk session/cache/queue pada database.

SQLite tidak digunakan aplikasi maupun pengujiannya; database artikel dan tes sama-sama memakai MySQL. Tes diarahkan ke database khusus `blogcrud_test` agar perubahan tes tidak menghapus atau mengubah data di `blogcrud`. Pastikan akun MySQL pada `phpunit.xml` sesuai dengan konfigurasi MySQL lokal.

### 3. Buat tabel dan data contoh

```powershell
php artisan migrate --seed
```

Jika database `blogcrud` belum ada, buat terlebih dahulu lewat phpMyAdmin atau jalankan `CREATE DATABASE blogcrud CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;` di MySQL. Migration membuat tabel `posts` dengan `id`, `title`, `body`, dan timestamps. Seeder menambahkan dua artikel contoh hanya ketika tabel `posts` masih kosong; seeder aman dijalankan kembali tanpa menggandakan contoh.

### 4. Jalankan server

```powershell
php artisan serve
```

Buka <http://127.0.0.1:8000>. Beranda dialihkan ke daftar artikel `/posts`. Hentikan server dengan `Ctrl+C`.

## Fitur dan route

| Method | URL | Nama route | Fungsi |
| --- | --- | --- | --- |
| GET | `/posts` | `posts.index` | Daftar artikel, urutan terbaru, 6 per halaman |
| GET | `/posts/create` | `posts.create` | Form artikel baru |
| POST | `/posts` | `posts.store` | Validasi dan simpan artikel |
| GET | `/posts/{post}` | `posts.show` | Baca artikel |
| GET | `/posts/{post}/edit` | `posts.edit` | Form edit artikel |
| PUT/PATCH | `/posts/{post}` | `posts.update` | Validasi dan perbarui artikel |
| DELETE | `/posts/{post}` | `posts.destroy` | Hapus artikel |

Periksa semua route dengan:

```powershell
php artisan route:list --name=posts
```

## Struktur folder

```text
Tugas P10/
├── app/
│   ├── Http/Controllers/PostController.php  # logika CRUD
│   └── Models/Post.php                      # model Eloquent dan mass assignment
├── database/
│   ├── migrations/                          # skema tabel posts
│   └── seeders/                              # data awal blog
├── public/css/app.css                       # gaya antarmuka Ruang Kata
├── resources/views/
│   ├── components/                           # alert dan card
│   ├── layouts/app.blade.php                 # layout induk
│   └── posts/                                # index, create, show, edit
├── routes/web.php                            # redirect dan resource routes
├── tests/Feature/PostCrudTest.php             # uji route, CRUD, validasi, XSS, pagination
├── .env.example                              # contoh konfigurasi lokal
└── README.md
```

## Menjalankan pengujian

Suite pengujian menggunakan database MySQL terpisah bernama `blogcrud_test`. Buat database ini satu kali melalui phpMyAdmin atau MySQL CLI. **Jangan arahkan konfigurasi tes ke `blogcrud`**: `RefreshDatabase` mereset skema database tes.

```powershell
mysql -h 127.0.0.1 -P 3306 -u root -e "CREATE DATABASE IF NOT EXISTS blogcrud_test CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
php artisan test --compact
```

Tes mencakup rendering route, siklus CRUD dan flash message, validasi create/update dengan error dan old input, 404 dari model binding, pagination, serta escaping output.
