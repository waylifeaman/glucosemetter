#Cara Test Project,

1. buat database mysql
2. ubah nama db di .env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nama_database_kamu
   DB_USERNAME=root
   DB_PASSWORD=

3. jalankan (composer install)
4. jalankan (php artisan migrate)
5. jalankan php seeder (php artisan db:seed) untuk generate data di tabelnya
6. jalankan (php artisan serve)

alur aplikasi

1. #auth
   login : admin@gmail.com
   passord : password
2. #pilih pasien
   sebenarnya pilih pasien ini untuk pilih pasien yang akan di periksa dan aplikasi menghubungkan ke IoT/mikrokontroller esp8266
   untuk send data hasil pemeriksaan sensor,
   karena ini demo maka data yanng tampil adalah data dummy
3. jika penghubungan belum berhasil pencet submit di allert ssampe penghubungna berhasil,

berikut link demo sistemnya
youtube : https://www.youtube.com/watch?v=QOeLHh4UI_U
demo :
