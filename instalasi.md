# Instalasi

Berikut langkah demi langkah instalasi aplikasi sampai dengan siap digunakan, baik level development maupun production.

Sebelum mengikuti langkah berikut, oastikan sudah familiar dengan command line di Linux maupun OSX. Sesuaikan apabila menggunakan sistem operasi berbasis Windows, karena ada beberapa perintah yang berbeda.

## Inisiasi

1. Salin repositori aplikasi dengan perintah ```git clone https://github.com/arvernester/newsletter```
2. Masuk ke direktori aplikasi, kemudian perbarui framework dan librari dependensi dengan perintah ```composer update```

Sampai di sini, pada dasarnya aplikasi siap digunakan. Jalankan buil-tin server dengan perintah ```php artisan serve``` kemudian akses melalui peramban.

## Instal Contoh Data
Pada aplikasi, terdapat sebuah seeder untuk membuat beberapa contoh data untuk memudahkan ketika dalam environment development. Adapun untuk meng-generate contoh data tersebut, dapat menggunakan perintah berikut:

```php artisa db:seed --class=ExampleDataSeeder```

Beberapa contoh data yang akan dibuat secara otomatis adalah:
- User
- List (group)
- Contact
- Subscriber
- Newsletter template
- Unsubscribe reason