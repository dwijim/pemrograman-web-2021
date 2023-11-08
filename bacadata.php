<?php
/* ------------------------------------------------------
   program untuk membaca isi suatu tabel dari basis data
   dibuat dengan PHP dan MariaDB
   dwi sakethi, 8 November 2023
   ------------------------------------------------------ */
   echo "<title>Baca Data Anggota</title>";
   echo "<h1>Baca Data Anggota</h1>";

   // membuat koneksi ke server
   $konek=mysqli_connect("localhost","dwijim","12345678","latihan");

   // membuat kueri
   $kueri = "select nama_lengkap from manusia order by nama_lengkap";

   // menjalankan kueri dan menyimpan hasilnya ke variabel
   $hasil = mysqli_query($konek,$kueri);

   // membuat tabel
   echo "<table border=1>";

   // membuat nomor urut
   $nomor = 1;

   // memotong hasil kueri
   while ($data=mysqli_fetch_array($hasil))
   {
      echo "<tr>";
         echo "<td align=right>$nomor</td>";
         echo "<td>$data[nama_lengkap]</td>";
      echo "</tr>";

      $nomor++;
   }
   echo "</table>";
?>