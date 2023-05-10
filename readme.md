## Tentang Aplikasi Ini

Aplikasi ini merupakan task berdasarkan soal studi kasus dalam rangka rekrutmen web developer di PT. Arkamaya. Beberapa package yang digunakan pada aplikasi ini yaitu

-   Laravel 9
-   PHP 8.0.2
-   Authentikasi menggunakan laravel breeze
-   database MySql

## Cara Install / Deploy

Berikut cara instalasi atau deploy pada localhost di directory htdocs jika menggunakan xampp, karena sudah saya sertakan juga file .htaccess dan file server.php agar tidak perlu akses ke folder public

1. **Clone Repository ke directory C:\xampp\htdocs**

```bash
git clone https://github.com/hasan000amin/arkamaya_hasan.git
cd arkamaya_hasan
composer install
cp .env.example .env
```

2. **Buka `.env` lalu ubah baris berikut sesuai dengan databasemu yang ingin dipakai, secara default settingan nama database adalah seperti dibawah seuai dengan ketentuan task**

```bash
DB_PORT=3306
DB_DATABASE=db_project_hasan
DB_USERNAME=root
DB_PASSWORD=
```

3. **Instalasi Aplikasi**

```bash
php artisan key:generate
php artisan migrate --seed
```

4. **Jalankan Aplikasi cukup akses http://localhost/arkamaya_hasan atau bisa dengan local development dengan menjalankan php artisan serve**

```bash
php artisan serve
```
