<html>
  <head>
    <title>Kamus Kata Dasar</title>
	
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
	
  </head>

<body>
	<div class="latar">
	
<div class="header">	
<header>
	<header class="judul">SIKAT</header>
	<header class="deskripsi"><i>Koreksi Kata</i></header>
</header>
</div>
<div id="menu">
	<?php include("menubar.php"); ?>
</div>
	
	<div class="tengah">
	<h2>Kamus Kata Dasar:</h2> 
	<div class = "auto">
	<table id="contact-detail" class="compact" cellspacing="0" width="100%">
<thead>
	<tr>
		<th>Kata</th>
		<th>Aksi</th>
	</tr>
</thead>


<tbody>
<?php
include "koneksi.php";
$tampil=mysqli_query($conn,"SELECT * FROM kata_dasar");
	foreach($tampil as $kuy){
		echo "
		<tr>
		<td>".$kuy['kata_dasar']."</td>
		<td><a href= hapus1.php?id=$kuy[id]>Hapus</a></td>
		</tr>
		";
		}
		
/**foreach ($baru as $dd){
echo "<tr>
<td>".$dd."</td>
<td>salah ketik</td>
<td>".$nilainya."</td>

</tr>";
}*/
?>

</tbody>
</table>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#contact-detail').DataTable({
		rowCallback: function(row, data, index){
			if(data[2]=="Salah Tulis"){
				$(row).find('td').css('background-color','yellow');
			}
		}
	});
} );
</script>

</div>
<table>
<tr>
	<td align="center"><a href="index.php?" type="submit">Selesai</a></td>
	<td align="center"><a href="tambah1.php?" type="submit">Tambah</a></td>
</tr>
</table>
</div>
<div id="footer">
Copyright@ 2020  Andika Saputra(Jerambai)
</div>
</div>
</body>
</html>