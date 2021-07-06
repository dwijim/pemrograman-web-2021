<html>
<head>
	<title>Tambah Data</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
	<script src="http://code.jquery.com/jquery-2.2.1.min.js"></script>
	<script>
			$(document).ready(function(){$(".preloader").delay(300).fadeOut("slow");});
	</script>
	
	<style>
		.tengah{
	margin : 126px auto;
	margin-bottom : 155px;
	width  : 400px;
	padding: 40px;
	border : 1px solid #000;
	background: rgba(51, 51, 51, 0.5);
	}
	</style>
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
	
	<div class="tengah">
		<form method="post" action="tambah_di.php">
			<h2>Tambah Data: 
				<input type="text" name="ket_tempat"/></h2></br>
				</br><input type="submit" value="Tambah" />
		</form>
	</div>

		<div id ="footer">
		Copyright@ 2020  Andika Saputra(Jerambai)
		</div>
	</div>
</body>
</html>
