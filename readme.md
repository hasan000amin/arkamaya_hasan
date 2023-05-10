## Tentang Aplikasi Ini

Aplikasi ini merupakan task berdasarkan soal studi kasus dalam rangka rekrutmen web developer di PT. Arkamaya. Beberapa package yang digunakan pada aplikasi ini yaitu

-   Laravel 9
-   PHP 8.0.2
-   Authentikasi menggunakan laravel breeze
-   database MySql

## Cara Install / Deploy

Berikut cara instalasi atau deploy pada localhost di directory htdocs jika menggunakan xampp, karena sudah saya sertakan juga file .htaccess dan file server.php agar tidak perlu akses ke folder public

-   git clone https://github.com/hasan000amin/arkamaya_hasan.git ke directory C:\xampp\htdocs
-   cd arkamaya_hasan
-   composer install
-   cp .env.example .env
-   php artisan key:generate
-   Sesuaikan nama database dengan db_project_hasan
-   php artisan migrate:fresh --seed
-   Akses melalui http://localhost/arkamaya_hasan
