<?php
echo "Data Kode Pekerjaan<br>";
echo "Pekerjaan Ayah:";
echo "<input type=text><br>";
echo "<select>
       <option value=1>Agen ASURANSI</option>
       <option value=2>Amil Zakat</option>
       <option value=3>Anggota DPRD Kota</option>
       <option value=4>Angkutan, pergudangan dan komunikasi</option>
     </select>
     <br>
     <br>
     <br>
     ";

// membuat koneksi
$konek = mysqli_connect('localhost','dwijim','12345678','latihan');

// membuat kueri
$sql = "
         select nama_bidang_pekerjaan,kode_bidang_pekerjaan
         from kode_pekerjaan
         order by nama_bidang_pekerjaan
       ";

$pilihan = "<select>";

// menjalankan kueri dan menyimpan hasilnya
$hasil_sql = mysqli_query($konek,$sql);

// memotong hasil kueri dengan mysqli_fetch_array
// dan meletakkannya dalam looping while
while ($isi_data=mysqli_fetch_array($hasil_sql))
{
   $kode =$isi_data[kode_bidang_pekerjaan] ;
   $ket  = $isi_data[nama_bidang_pekerjaan];

   // <option value=xxx>-------</option>

   $pilihan=$pilihan."<option value=".$kode.">".$ket."</option>";
   
   //echo "$ket<br>";
}

$pilihan = $pilihan."</select>";

echo $pilihan;
// jumlah = jumlah + nilai

?>