# Newsletter

[![StyleCI](https://styleci.io/repos/70211763/shield?branch=master)](https://styleci.io/repos/70211763)

Simple newsletter app using Laravel framework.

![Screenshot](https://s16.postimg.org/tzvo9b7ut/Screenshot_from_2016_10_08_14_57_19.png)

Demo aplikasi dapat dilihat pada tautan [http://nawala.laravel.web.id](http://nawala.laravel.web.id).

## Kebutuhan Sistem

- PHP >= 7.0
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension

## Kebutuhan Lain

- Supervisor untuk menajalankan Queue Laravel
- ElasticSearch untuk Laravel Scout

## Instalasi

- Clone repositori untuk mendapatkan update terbaru.
- Ubah hak akses direktori ```storage``` dan ```bootstrap/cache``` agar dapat ditulisi oleh aplikasi.
- Jalankan perintah ```composer update``` untuk memperbarui framework dan librari dependensi. Khusus dengan pengaturan email dapat diubah pada aplikasi melalui URI ```setting```.
- Salin berkas ```.env.example``` menjadi ```.env``` dan ubah beberapa pengaturan di dalamnya sesuai dengan mesin yang digunakan.
- Jalankan perintah ```php artisan key:generate``` untuk membuat key baru.
- Jalankan perintah ```php artisan migrate``` untuk menjalankan migrations.
- Jalankan built-in server dengan perintah ```php artisan serve``` atau ```php -S localhost:8000```.
- Akses URL ```localhost:8000``` melalui peramban.

## Contoh Data

Aplikasi ini menyediakan seeder untuk membuat data dummy menggunakan package Faker. Jalankan perintah di bawah untuk menjalankan generator data dummy.

```php artisan db:seed --class=ExampleDataSeeder```

Data yang otomatis dibuat adalah:

- Default list
- Data subscriber
- User
- Unsubscribe reason
- Newsletter template

Default login ke aplikasi dengan role admin dapat menggunakan username ```admin@mail.com``` dan password ```admin```. Sedangkan untuk login dengan role user dapat menggunakan username ```user@email.com``` dan password ```user```.