# Aplikasi Pengelola Kendaraan dalam Suatu Perusahaan
### Dibuat oleh: Icha Dewi Putriana

## Daftar Username dan Password
| Username | Password |
| --- | --- |
| admin | admin123 |
| direktur | direktur123 |
| manajer | manajer123 |
| pengelola | pengelola123 |
| driver | driver123 |

## Spesifikasi
- Database Version : MySQL - 8.0.30
- PHP Version : 8.1.10
- Framework : Laravel 10
    Aplikasi ini memiliki 5 peran pengguna yang berbeda, yaitu Admin, Direktur, Manajer, Pengelola, dan Driver, dengan hak akses masing-masing yang disesuaikan berdasarkan perannya.

    - Pengelola: Pengelola memiliki kewenangan untuk mendaftarkan pemesanan kendaraan. Setelah pemesanan didaftarkan, pemesanan tersebut akan menunggu persetujuan dari Direktur dan Manajer sebelum dapat diproses lebih lanjut. Selain itu, pengelola juga bertanggung jawab untuk menambahkan kendaraan baru ke dalam sistem dan mengelola perawatan kendaraan yang ada.
    - Direktur dan Manajer: Setelah pemesanan kendaraan didaftarkan oleh pengelola, Direktur dan Manajer memiliki hak untuk menyetujui atau menolak pemesanan tersebut. Mereka dapat memutuskan apakah kendaraan dapat digunakan atau tidak.
    - Kendaraan yang Sudah Dipesan: Ketika sebuah kendaraan sudah dipesan, status kendaraan tersebut akan berubah menjadi "sedang dipakai". Selama kendaraan tersebut dalam status ini, kendaraan tidak dapat dipesan oleh orang lain. Setelah tanggal pengembalian kendaraan lewat, status kendaraan akan otomatis berubah menjadi "tersedia", sehingga kendaraan tersebut bisa dipesan kembali oleh pengguna lain.
