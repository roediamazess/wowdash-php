# Cara Menggunakan Breadcrumb Component

Breadcrumb component sekarang sudah dinamis dan dapat digunakan kembali di seluruh website.

## Cara Menggunakan

1. Di halaman yang ingin menggunakan breadcrumb, tambahkan variabel `$pageTitle` sebelum meng-include layout:

```php
<?php 
$pageTitle = 'Nama Halaman Anda';
// ... variabel lainnya
?>
```

2. Ganti kode breadcrumb yang lama dengan:

```php
<?php include './partials/breadcrumb.php' ?>
```

## Contoh Implementasi

Lihat file `add-blog.php` atau `index.php` untuk contoh implementasi yang sudah diperbarui.

## Catatan

- Jika `$pageTitle` tidak disetel, maka akan menampilkan "Dashboard" sebagai default
- Jika `$pageTitle` disetel sebagai "Dashboard", maka hanya akan menampilkan "Dashboard" tanpa level kedua
- Breadcrumb akan secara otomatis menampilkan level kedua jika `$pageTitle` disetel dan bukan "Dashboard"
