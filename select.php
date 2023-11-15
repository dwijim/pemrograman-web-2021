<?php
/* --------------------------------------------------
   contoh program untuk membuat pilihan yang isi 
   pilihan diambil dari tabel
   untuk pembelajaran materi kuliah
   dwi sakethi, 14 november 2023
   -------------------------------------------------- */


echo "Select langsung dengan html <br>";

// pilihan biasa yang tag HTML disimpan ke dalam
// suatu variabel
$a = "<select name=kecamatan>";
$b = "<option value=1>Rajabasa</option>";
$c = "<option value=2>Kedaton</option>";
$d = "<option value=3>Kemiling</option>";
$e = "</select>";

// tulisan ini kemudian digabungkan ke dalam 
// satu variabel
$f = $a.$b.$c.$d.$e;

echo "$f"; 

echo "<br><br><br>";

// untuk koneksi ke database server
//                       server      user     password   databaser
$konek = mysqli_connect("localhost","dwijim","12345678","latihan");

// kueri membaca isi kode kecamatan
$baca="select kode,keterangan from kode_kecamatan
       order by keterangan";

// kueri dijalankan dan hasilnya disimpan
// ke dalam variabel
$hasil_kueri=mysqli_query($konek,$baca);

echo "Select dari tabel basis data <br>";

// awal dari tag select
$select="<select name=kecamatan>";

// looping pembacaan data
while($kecamatan=mysqli_fetch_array($hasil_kueri))
  {
    // teksnya dijejerkan
    $select=$select."<option value=
      ".$kecamatan[kode].">".$kecamatan[keterangan]."</option>";
      
  }
  $select=$select."</select>";
  echo "$select";
?>
