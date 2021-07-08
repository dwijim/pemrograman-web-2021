<?php

echo "<h1>Hasil Pencarian</h1>";

$potongan = $_POST['potongan'];

//echo "Potongan nama: $potongan_nama<br>";

// membuat koneksi
$koneksi = mysqli_connect('localhost','root','','latihan');

// membuat kueri
$kueri = "
           select nama_lengkap,alamat from manusia
             where (nama_lengkap like '%$potongan%') or
                   (alamat like '%$potongan%')
         ";

// menjalan kueri dan menyimpan hasilnya
$hasil_kueri = mysqli_query($koneksi,$kueri);

// membuat tabel html
echo "<table border=1";
echo "<tr>
      <th>Nomor</th>
      <th>Nama</th>
      <th>Alamat</th>
      </tr>";

// harga awal nomor urut
$nomor = 1;

//hasil kueri ditaruh di dalam looping while
//dan dipotong-potong menggunakan mysqli_fetch_array
while ($hasil=mysqli_fetch_array($hasil_kueri))
{
    echo "<tr>";
    echo "<td align=right>".$nomor."</td>";
    echo "<td>".$hasil['nama_lengkap']."</td>";
    echo "<td>".$hasil['alamat']."</td>";
    echo "</tr>";
    $nomor++;
}

echo "<table>";
?>
<br>
Klik <a href=form-cari.php>Kembali</a>