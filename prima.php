<?php

echo "<title>Program bilangan prima/bukan prima</title>";

echo "<h1>Program bilangan prima/bukan prima</h1>";

// menyimpan nilai bilangan yang ada di halaman sebelumnya
// dengan metod POST
$bilangan = $_POST["bilangan"];

// asumsi awal bilangan prima
$prima = 1;
echo "Nilai asli: $bilangan <br>";
for ($proses=2;$proses<=$bilangan-1;$proses++)
{
   // jika habis dibagi suatu bilangan
   if ($bilangan%$proses==0)
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
