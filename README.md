MyBukutamu

MyBukutamu adalah aplikasi buku tamu digital yang dibangun dengan framework PHP CodeIgniter 4. Aplikasi ini memudahkan pencatatan tamu yang berkunjung, lengkap dengan fitur persetujuan dan rekapitulasi data.

Aplikasi yang Dibutuhkan
Untuk menjalankan aplikasi ini, pastikan Anda telah menginstal beberapa aplikasi dasar berikut:

Web Server: XAMPP, Laragon, atau WAMPP (disarankan menggunakan salah satu yang sudah terintegrasi).

Database Server: MySQL/MariaDB (biasanya sudah termasuk dalam paket XAMPP/Laragon).

Composer: Alat manajemen dependensi untuk PHP.

Git: Untuk mengelola versi kode.

Cara Pemasangan dan Menjalankan Program
Ikuti langkah-langkah berikut untuk menginstal dan menjalankan proyek ini di lingkungan lokal Anda.

1. Kloning Repositori
Buka terminal atau Command Prompt, lalu klon repositori ini ke folder htdocs (untuk XAMPP) atau folder proyek server web lokal Anda.

git clone [URL_REPOSITORI_ANDA]

2. Instalasi Dependensi
Masuk ke dalam folder proyek yang baru saja Anda klon, lalu jalankan perintah Composer untuk menginstal semua dependensi yang diperlukan.

cd MyBukutamu
composer install

3. Konfigurasi Database
Buat database baru di phpMyAdmin atau SQLyog dengan nama mybukutamu.

note : database mysql (mybukutamu) ada fi folder file database

Setelah itu, salin file .env.example menjadi file .env di root folder proyek, lalu edit file .env untuk mengatur konfigurasi database Anda.

# .env

database.default.hostname = localhost
database.default.database = mybukutamu
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi

Pastikan Anda mengubah username dan password sesuai dengan konfigurasi database Anda.

4. Migrasi Database
Jalankan migrasi untuk membuat tabel yang diperlukan secara otomatis.

php spark migrate

5. Jalankan Aplikasi
Jalankan server pengembangan CodeIgniter 4 dengan perintah berikut:

php spark serve

Aplikasi akan berjalan di http://localhost:8080 (atau port lain jika sudah digunakan). Buka URL tersebut di browser Anda untuk mulai menggunakan aplikasi.

Selamat, sekarang Anda sudah berhasil menjalankan aplikasi MyBukutamu!
