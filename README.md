# Tugas 2 IF3110 Pengembangan Aplikasi Berbasis Web

## 1. Deskripsi Aplikasi Web

Setelah aplikasi web Engima diluncurkan, bioskop Engi menjadi sangat laku. Sebelumnya, Engi mengurus semua transaksi tiket film dan penambahan data film secara manual. Karena kewalahan, akhirnya Engi pergi ke seorang konsultan IT untuk menemukan solusi dari permasalahannya. Konsultan menyarankan Engi untuk menggunakan web service untuk mempermudah pekerjaannya. Melihat aplikasi web yang Anda kerjakan memuaskan, Engi meminta Anda untuk mengimplementasikan perubahan tersebut beserta web service dan aplikasi Bank yang digunakan untuk transaksi tiket film di Engima.

## 2. Requirements and Installation
In order to run this web on your local server, you need to run it on **PHP 7.1** and install:

1. PHP 7.1
```
apt-get install php7.1
```
2. PDO Extension
```
apt-get install php7.1-pdo-mysql
```
3. MySql
```
apt-get install mysql
apt-get install mysql-server
```
4. XAMPP (alternative way from mysql)
Install XAMPP application at https://www.apachefriends.org/download.html

## 3. How to run server

1. Place the source code in  ..\xampp\htdocs directory
2. Run XAMPP
3. Try to open Engima in your browser in URL localhost

## 4. Aplication MockUp
### Login Page

![](mockup/Login.jpg)

### Register Page

![](mockup/Register.jpg)

### Home Page

![](mockup/Home.jpg)

### Search Result page

![](mockup/Search.jpg)

### Film Detail page

![](mockup/MovieDetail.jpg)

### Buy Ticket page

![](mockup/BookTicket-Noticketselected.jpg)

![](mockup/BookTicket-Selectedticket.jpg)

![](mockup/BookTicket-Success.jpg)

### Transaction History page

![](mockup/Transactions.jpg)

### User Review page

![](mockup/Reviews-Add.jpg)


## 5. Pembagian Tugas
Setiap anggota kelompok diwajibkan untuk mengerjakan bagian REST, SOAP, dan ReactJS. Jika Anda akan mengerjakan bonus, dicantumkan juga pembagian kerjanya.

Berikut adalah pembagian tugas sementara dari kelompok kami: 

### REST
1. Inisiator : 13516042
2. Menambah transaksi baru  : 13517084
3. Mengubah status transaksi   : 13517084
4. Mengembalikan seluruh data transaksi  : 13517006
5. TheMovieDB   : 13516125


### SOAP
1. Inisiator  : 13517006
2. Validasi  : 13516125
3. Memberikan data rekening : 13517084
4. Melakukan transaksi Transfer  : 13517006
5. Membuat akun virtual : 13517006
6. Cek Transaksi : 13516042


### REACTJS
1. Inisiator  : 13516125
2. Halaman Login : 13516125
3. Halaman Utama   : 13517084
4. Riwayat     : 13516042
5. Transfer    : 13517006

### Perubahan ENGIMA
1. Konektor ke WS Transaksi : 13516042
2. Konektor ke WS Bank  : 13517006
3. Perubahan Home   : 13517084
4. Perubahan Film Details   : 13516125
5. Perubahan Buy Ticket : 13516125
6. Perubahan Transaction History  : 13516125

## About

Kelompok 14 IF3110 - 2019

Lukas | Vijjasena | Aldo | Seldi
