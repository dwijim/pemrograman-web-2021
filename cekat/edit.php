<html>
<head>
	<title>Ganti Data</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
	<script src="http://code.jquery.com/jquery-2.2.1.min.js"></script>
	<script>
			$(document).ready(function(){$(".preloader").delay(3000).fadeOut("slow");});
	</script>
</head>

<body>

	<div class="preloader">
		<div class="loading">
			<img src="load.gif" width="80">
			<p>Harap Tunggu</p>
		</div>
	</div>
	
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

<?php
include  "koneksi.php";
$id         = $_GET['id'];
$ket_tempat  = mysqli_query($conn, "select * from ket_tempat where id ='$id'");
$row        = mysqli_fetch_array($ket_tempat);
?>

	
	<div class="login">
		<form method="post" action="edit.php">
			<h2>Data Sebelumnya : <?php echo $row['id'];?></h2>
			<h2>Ganti Dengan : <input type="text" name="datanya" /></h2>
			<input type="hidden" name="data" value=<?php echo $_GET['id'];?> /><br>
			<input type="submit" name="update" value="Ubah" />
		</form>
	</div>
	
	<div id="footer">
	Copyright@ 2020  Andika Saputra(Jerambai)
	</div>
		
	</div>
</body>
</html>