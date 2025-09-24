<p align="center"><img src="../main/public/images/LogoSonic.png" width="600" alt="Aplikasi Logo"></p>

<br><br>


<br><br><br><br>


# About Sonic
Aplikasi Web ***Sonic*** merupakan **Aplikasi pemesanan _tiket kereta api_**.
Aplikasi Sonic bertujuan untuk menyajikan proses transaksi pemesanan tiket yang nyaman serta efisien.


<br><br><br><br>


# Fitur dalam Sonic

- <h3>Login Multilevel User</h3>
     Aplikasi ini dapat login multilever user menggunakan 2 role, yaiut customer dan admin.

- <h3>Forgot Password</h3>
     Kami memungkinkan pengguna untuk mendapat email untuk mereset password jika pengguna melupakan password akun.
     
- <h3>Email Verification</h3>
     Email untuk verifikasi akun yang bertujuan untuk autentikasi akan dikirim setelah melakukan registrasi akun

- <h3>Update Profile</h3>
     Pengguna dapat memperbarui data profil.
     
 - <h3>Hapus Akun</h3>
     Admin dapat menghapus akun beserta datanya jika diperlukan.
     
- <h3>Pemesanan Tiket Kereta</h3>
     Pengguna dapat memesan tiket kereta api yang tersedia di aplikasi.
     
- <h3>Saran/Report</h3>
     Pengguna dapat mengirimkan pesan kepada admin berupa saran maupun report berdasarkan pengalaman menggunakan aplikasi.

- <h3>Printing</h3>
     Admin dapat mencetak data users, tiket, kereta api, dan jadwal keberangkatan.
     
     Sedangkan untuk pengguna, dapat mencetak data tiket.
  
- <h3>Pembuatan Jadwal Keberangkatan</h3>
     Admin dapat membuat jadwal Keberangkatan Kereta Api.
     
- <h3>Pagination</h3>

<br><br><br>

# Panduan Menjalankan Source Code

- <h3>Buat Folder di htdocs atau www</h3>
     
     Extract folder sonic.zip 

- <h3>Copy File .env</h3>

     Command -> `cp .env.example .env`

- <h3>Buat database anda</h3>
     Silakan buat database anda.

     Lalu, Ganti nama database pada file .env anda. {DB_DATABASE=`nama_db`}
     
- <h3>Key:Generate</h3>

     Command -> `php artisan key:generate`

     
- <h3>Jalankan Migrate</h3>

     Command -> `php artisan migrate`

- <h3>Modifikasi File Seeder dan Jalankan</h3>
    Dalam File Seeder, Ubah email admin nerooireborn88@gmailcom menjadi email yang anda miliki.
    
    Command jalankan Seeder -> ` php artisan db:seed --class=DummyUsersSeeder `

- <h3>Run Code</h3>
     Command -> `php artisan ser`


