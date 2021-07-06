<html>
<title>Ambil kata yang benar</title>

		<?php
        include "../koneksi.php";
		$query=mysqli_query($conn,"SELECT * from jumlahkata order by jumlah ASC, nama_kata ASC");
		
		foreach($query as $yok){
			if ($yok['keterangan']=='Salah Tulis')
			{
			echo "insert into kata_dasar(kata_dasar) values ('".
				  $yok['nama_kata']."');<br>";}
		}
		?>

</html>