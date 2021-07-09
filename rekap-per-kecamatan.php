<?php
/* ---------------------------------------------------------
   program untuk merekapitulasi data menurut kecamatan 
   tempat tinggal
   rekapitulasi ini melibatkan dua tabel basis data

   file ini diberi nama: rekap-per-kecamatan.pjp
   dibuat pada tanggal: 9 juli 2021
   --------------------------------------------------------- */

echo "<h1>Rekapitulasi Penduduk Per Kecamatan</h1>";

// menampilkan data dalan bentuk tabel
echo "<table border=1>";
echo "<tr>";
echo "<th>Nomor</th>";
echo "<th>Kecamatan</th>";
echo "<th>Jumlah</th>";
echo "</tr>";

$nomor = 1;

// membuat koneksi
$koneksi = mysqli_connect('localhost', 'root','','latihan');

// membuat kueri
$kueri = "
          select keterangan as kecamatan, count(kecamatan) as jumlah
          from manusia, kode_kecamatan
          where kecamatan=kode
          group by kecamatan
          order by keterangan
         ";

// menjalankan kueri dan menyimpan hasilnya
$hasil = mysqli_query($koneksi,$kueri);

// meletakkan di dalam looping while dan
// memotong hasil kueri dengan myssqli_fetch_array

while ($rekap=mysqli_fetch_array($hasil))
{
    echo "<tr>";
    echo "<td align=right>".$nomor."</td>";
    echo "<td align=left>".$rekap['kecamatan']."</td>";
    echo "<td align=right>".$rekap['jumlah']."</td>";
    echo "</tr>";

    $nomor++;

}

echo "</table border=1>";

?>