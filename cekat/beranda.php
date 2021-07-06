<html>
<head>
	<title>Utility Kata</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
</head>
<header>
	<h1 class="judul">PEKAT ( Pengoreksi Kata )</h1>
	<h1 class="deskripsi"><i>Utility pendeteksi kesalahan penulisan pada dokumen bertipe LATEX (.tex)</i></h1>
</header>
<body> 
	<div id="menu">
	<?php include("menubar.php"); ?>
	</div>
	<div id="isi">
		<article id="postingan">
			<!-- Mulai Tabel-->
			<?php
			include "koneksi.php";
			$query = mysqli_query($connection,"SELECT kata,jumlah,keterangan FROM jumlahkata");
			?>
			
			<table align="center" border="2" cellpadding="0" cellspacing="2" class="tabel1">
				<tr>
					<th>Kata</th>
					<th>Jumlah</th>
					<th>Keterangan</th>
				</tr>
				<?php if(mysqli_num_rows($query)>0){ ?>
				<?php
				$no = 1;
				while($data = mysqli_fetch_array($query)){
				?>
				<tr>
					<td><?php echo $data["kata"];?></td>
					<td><?php echo $data["jumlah"];?></td>
					<td><?php echo $data["keterangan"];?></td>
					 
				</tr>
				<?php $no++; } ?>
				<?php } ?>
			</table>
		</article>
	</div>
 
	<div id="footer">
		Copyright@ 2019  Muhammad Aryadinata
	</div>
	</div>
	<script>
	$("tr").each(function(){
    var col_val = $(this).find("td:last").text();
    if ($.trim(col_val) == "BENAR"){
        $(this).addClass('white');  
    } else if ($.trim(col_val) == "TERINDIKASI SALAH KETIK")  {
        $(this).addClass('red');
    }
});
	</script>
	
</body>
</html>