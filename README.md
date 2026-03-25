# Sistem Informasi Arsip Surat (Berbasis Web)

Aplikasi manajemen arsip surat masuk dan keluar berbasis Web menggunakan framework **Laravel 10**, tampilan AJAX dinamis tanpa reload halaman, dan Server-side DataTables.

## 📋 Persyaratan Sistem minimal
Sebelum memulai, pastikan komputer/laptop Anda telah terpasang aplikasi pendukung berikut:
1. **PHP versi 8.1** atau yang lebih baru.
2. **MySQL Database** (Sudah include di dalam XAMPP / Laragon).
3. **Composer** (Package Manager untuk bahasa PHP).

---

## 🚀 Panduan Instalasi (Langkah Demi Langkah untuk Pemula)

### Langkah 1: Instalasi Web Server (Laragon / XAMPP)
Web server dibutuhkan untuk menjalankan PHP dan database MySQL Anda di komputer lokal (localhost). Untuk pemula berbasis Windows, kami sangat merekomendasikan **Laragon** karena lebih ringan, minim error, dan sangat modern.

- **Download Laragon:** Kunjungi situs [laragon.org/download](https://laragon.org/download) dan unduh versi **Laragon Full**.
- Klik 2x file yang sudah di-download, dan lakukan instalasi biasa (Next > Next > Install) hingga selaesai.
- Buka aplikasi Laragon dari Desktop, lalu klik tombol **Start All** untuk menyalakan Apache dan MySQL.

*(Apabila Anda kebetulan sudah memiliki XAMPP terinstall di laptop, pastikan XAMPP tersebut adalah versi terbaru yang sudah mendukung PHP 8.1 ke atas).*

### Langkah 2: Instalasi Composer
Composer adalah alat wajib yang dibutuhkan untuk mengunduh library inti dari Laravel.
- **Download Composer:** Kunjungi situs [getcomposer.org/download](https://getcomposer.org/download/) dan unduh file `Composer-Setup.exe`.
- Buka file installer-nya. Terdapat halaman di mana form akan meminta letak spesifik file `php.exe`. Arahkan direktori tersebut sejajar dengan folder Web Server Anda. Contoh:
  - Jika pakai Laragon: `C:\laragon\bin\php\php-8.x.x\php.exe`
  - Jika pakai XAMPP: `C:\xampp\php\php.exe`
- Lanjutkan klik *Next* terus menerus hingga tahap akhir (*Install*).

### Langkah 3: Setup Folder Project Laravel
1. Buka aplikasi **Terminal** atau **Command Prompt (CMD)** pada Windows Anda. Apabila menggunakan Laragon, cukup cukup menekan tombol `Terminal` yang ada di panel dashboard Laragon.
2. Arahkan direktori penulisan di terminal ke dalam folder tempat *source code* / file project *Arsip Surat* ini berada. Contoh jika Anda menyimpannya di folder `kerja`:
   ```bash
   cd d:\kerja\arsip-surat
   ```
3. Install seluruh library yang dibutuhkan sistem dengan mengetikkan perintah sakti ini:
   ```bash
   composer install
   ```
   *(Note: Tunggu proses download otomatis berjalan menggunakan internet sampai selesai)*.

### Langkah 4: Konfigurasi Database (.env)
File `.env` bertanggung-jawab untuk menyetel koneksi ke database Anda.
1. Masuk ke dalam folder project ini, **Copy / gandakan** file yang bernama `.env.example`, lalu *Rename* (ubah nama) copian tersebut menjadi hanya `.env` (tanpa kata example).
2. Buka file `.env` tersebut menggunakan aplikasi text editor biasa seperti Notepad, VS Code, atau Sublime Text.
3. Cari bagian pengaturan database, dan sesuaikan isiannya menjadi seperti ini:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=arsip_surat
   DB_USERNAME=root
   DB_PASSWORD=
   ```
   *(Catatan: Secara default untuk aplikasi Laragon/XAMPP lokal, baris Username selalu `root` dan nilai Password di biarkan KOSONG).*

### Langkah 5: Buat Kunci Keamanan & Migrasi Database
Kembali lagi ke **Terminal** yang belum Anda tutup pada tahap 3, lalu ketikkan serta 'Enter' ketiga perintah di bawah ini secara satu per satu berurutan:

1. Membuat kunci sistem keamanan Laravel:
   ```bash
   php artisan key:generate
   ```
2. Membuat jalur shortcut public (symlink) khusus agar file Surat Lampiran yang PDF/Gambar bisa terakses sistem:
   ```bash
   php artisan storage:link
   ```
3. Membuat tabel-tabel di Database sekaligus men-generate Data *dummy* untuk Setup User Admin awal:
   ```bash
   php artisan migrate --seed
   ```
   *(Hint: Jika terminal bertanya bahasa inggris apakah Anda berniat membuat database baru karena 'arsip_surat' sebelumnya tidak ditemukan, ketik **yes** lalu tekan Enter).*

### Langkah 6: Jalankan Aplikasi! 🎉
Masih di jendela Terminal yang sama, aktifkan server pengembangan Laravel menggunakan perintah berikut:
```bash
php artisan serve
```

Biarkan Terminal terus terbuka (jangan di-close). Sekarang buka aplikasi Web Browser kesayangan Anda (seperti Google Chrome atau Microsoft Edge), dan ketik alamat berikut:
**[http://127.0.0.1:8000](http://127.0.0.1:8000)**

#### Akses Login Default Ke Sistem:
Anda dapat mencicipi hak akses maksimum selaku Super Admin via kredensial di bawah ini:
- **Email:** `admin@admin.com`
- **Password:** `password`

Terima kasih, semoga bermanfaat! Memanfaatkan implementasi Laravel 10 dan Modern UI Bootstrap 5 yang Responsif.
