<?php

include "koneksi.php";
	$kosongin_dulu=mysqli_query($conn,"TRUNCATE TABLE jumlahkata");
	$kosongin_upload=mysqli_query($conn,"truncate table upload");

?>
<html>
<head>
	<title>Koreksi Kata (Sikat)</title>
	<link rel="stylesheet" href="style.css">
	<script src="https://code.jquery.com/jquery-2.2.1.min.js"></script>
	<script>
			$(document).ready(function(){$(".preloader").delay(30).fadeOut("slow");});
			function preventBack(){window.history.forward();} setTimeout("preventBack()", 0); window.onunload=function(){null};
	</script>
</head>

<body>

	<div class="preloader">
		<div class="loading">
			<img src="load.gif" width="100">
			<p>mohon Tunggu</p>
		</div>
	</div>
	
	<div class="latar">
<div class="header">	
<header>
	<header class="judul"><b>S  I  K  A  T</b></header>
	<header class="deskripsi"><i>Koreksi Kata</i></header>
</header>
</div>

<div id="menu">
	<?php include("menubar.php"); ?>
</div>

	<div class="login">
		<form method="post" enctype="multipart/form-data" action="aksei.php">
			<h2> Pilih Dokumen :</h2> 
				<input type="file" name="fupload"> 
				<input type=hidden name='upload' value='bingung'>
				<input type="submit" name="upload" value="Lihat">
		</form>
	</div>

<div id="footer">
Copyright@ 2020  Andika Saputra (Jerambai)
</div>
	</div>
</body>

<a href="https://info.flagcounter.com/Yx5b"><img src="https://s11.flagcounter.com/count2/Yx5b/bg_FFFFFF/txt_000000/border_CCCCCC/columns_2/maxflags_10/viewers_0/labels_0/pageviews_0/flags_0/percent_0/" alt="Flag Counter" border="0"></a>

</html>
