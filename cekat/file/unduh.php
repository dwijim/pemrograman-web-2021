<?php
//Menggabungkan dengan file koneksi yang telah kita buat
include "../koneksi.php";
 
//header("Content-type: application/vnd.ms-word");
//header("Content-Disposition: attachment;Filename=Hasil.doc");
?>
<html>
<title>Error penulisan format merah putih</title>
<body>
        <h1>Jangan hanya fokus ke warna merah</h1>		
        <h1>Harus diperhatikan semua kata ...</h1>		
Data-data yang ada di sini, hanya sebagai pembantu saja.<br>
Boleh jadi keliru, baik itu benar dianggap salah.
Ataupun salah dianggap benar.<br><br>
<table border="1">
	<thead>
		<tr>
			<th>Nomor</th>
			<th>Kata</th>
			<th>Jumlah</th>
			<th style='background-color: red'>Asumsi</th>
			
		</tr>
	</thead>
	<tbody>
		<?php
// kueri aslinya seperti ini
//		$query=mysqli_query($conn,"SELECT * from jumlahkata order by keterangan ASC, nama_kata ASC");

// 20 desember 2020, saya modifikasi
        $nomor = 1;
		$query=mysqli_query($conn,"SELECT * from jumlahkata order by jumlah ASC, nama_kata ASC");
		foreach($query as $yok){
			if ($yok['keterangan']=='Salah Tulis')
			{
			echo "<tr style='background-color: red'>
				  <td align=right>".$nomor."</td>
				  <td>".$yok['nama_kata']."</td>
				  <td>".$yok['jumlah']."</td>
				  <td>".$yok['keterangan']."</td>
			</tr>";}
		    else
			{
			echo "<tr>
				  <td align=right>".$nomor."</td>
				  <td>".$yok['nama_kata']."</td>
				  <td>".$yok['jumlah']."</td>
				  <td>".$yok['keterangan']."</td>
			</tr>";}
			$nomor = $nomor + 1;
		}
		?>
	</tbody>
</table>
        <h1>Jangan hanya fokus ke warna merah</h1>		
        <h1>Harus diperhatikan semua kata ...</h1>		
</body>

</html>
