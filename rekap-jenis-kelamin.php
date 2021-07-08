<?php
/* ---------------------------------------------
   program untuk menghitung jumlah laki-laki
   dan perempuan menggunakan kueri SQL
   dibuat pada tanggal 8 juli 2021
   file ini diberi nama: rekap-jenis-kelamin.php

   --------------------------------------------- */

echo "<table border=1>";
// membuat koneksi
$koneksi = mysqli_connect('localhost','root','','latihan');

// membuat kueri SQL
$kueri = "
           select jenis_kelamin as jenis_kelamin, 
                  count(jenis_kelamin) as jumlah
           from manusia
           group by jenis_kelamin
         ";

// menjalankan kueri dan menyimpan hasilnya
$hasil_kueri = mysqli_query($koneksi,$kueri);

//hasil kueri diletakkan di dalam looping while
//dipotong-potong menggunakan mysqli_fetch_array
while($rekap=mysqli_fetch_array($hasil_kueri))
{
  $jumlah = $rekap['jumlah'];
  $jenis_kelamin = $rekap['jenis_kelamin'];

  echo "<tr>";
  echo "<td align=center>".$jenis_kelamin."</td>";  
  echo "<td align=right>".$jumlah."</td>";  
  echo "</tr>";
}

echo "<table border=1>";

?>