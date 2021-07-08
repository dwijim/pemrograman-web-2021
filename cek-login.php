<?php
/* -------------------------------------------
   program untuk melakukan pengecekan login
   file ini bernama: cek-login.php

   dibuat pada tanggal 8 juli 2021
   ------------------------------------------- */

// mengambil nilai dari halaman form sebelumnya
$username = $_POST['username'];
$password = $_POST['password'];

// menampilkan nilai untuk cek
//echo "username: $username<br>";
//echo "password: $password<br>";

// membuat koneksi
$koneksi = mysqli_connect('localhost','root','','latihan');

// membuat kueri
$kueri = "
           select username from pemakai
             where (username='$username') and
                   (password='$password')
         ";


// menjalankan kueri dan menyimpan hasilnya
$hasil = mysqli_query($koneksi,$kueri);

// variabel untuk cek gagal atau sukses login
$sukses = 0;

while ($pemakai=mysqli_fetch_array($hasil))
 {
   // jika kueri ada hasilnya maka
   // proses akan masuk ke dalam looping
   $sukses = 1;
 }

if ($sukses==0)
{
  echo "Anda tidak berhasil login<br>";
  echo "Silahkan klik <a href=form-login.php>di sini ...</a>";

} 
else {
       echo "Anda berhasil login ..."; 
     }
?>
