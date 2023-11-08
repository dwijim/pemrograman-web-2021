<?php
/* ----------------------------------------------
   file: prima-get.php
   8 november 2023
   dwi sakethi
   untuk menjalankan program ini, caranya adalah
   dengan menggunakan browser, pada bagian alamat
   diketikkan:
   
   prima-get.php?bilangan=46
   (mungkin ini perlu tambahan alamat localhost
    atau alamat IP, sesuai dengan kondisi)
   ---------------------------------------------- */
echo "<title>Program bilangan prima/bukan prima</title>";

echo "<h1>Program bilangan prima/bukan prima</h1>";

// menyimpan nilai bilangan yang ada di halaman sebelumnya
// dengan metod GET
$bilangan = $_GET['bilangan'];

// asumsi awal bilangan prima
$prima = 1;
for ($proses=1;$proses<=$bilangan;$proses++)
{
   // jika habis dibagi suatu bilangan
   if ($bilangan%$proses)
      { 
        $prima = 0;
        break;
       }
}

if ($prima==1)
   { echo "Bilangan $bilangan termasuk bilangan prima <br>";}
else
   { echo "Bilangan $bilangan  bukan bilangan prima <br>";}
?>