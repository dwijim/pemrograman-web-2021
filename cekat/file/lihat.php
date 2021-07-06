<?php
	include "../koneksi.php";
	$lis=mysqli_query($conn,"select sum(jumlah) as jono from jumlahkata where keterangan='Salah Tulis'");
	$tu=mysqli_query($conn,"select sum(jumlah) as jono from jumlahkata where keterangan='Benar'");

	$Benar=mysqli_fetch_array($tu);
	$Salah=mysqli_fetch_array($lis);
	
	$Bnar_Tulis= $Benar['jono'];
	$Salah_Tulis= $Salah['jono'];
?>
<html>
  <head>
    <title>Persentase Kesalahan</title>
	
	<link rel="stylesheet" type="text/css" href="../style.css">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
	<script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
	<script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>
	
	<script type="text/javascript">
	FusionCharts.ready(function(){
		var chartObj = new FusionCharts({
		type: 'doughnut3d',
		renderAt: 'chart-container',
		width: '550',
		height: '350',
		dataFormat: 'json',
		dataSource: {
			"chart": {
				"caption": "Persentase Hasil Proses Deteksi Penulisan",
				"subCaption": "sebagai berikut",
				"decimals": "1",
				"theme": "fusion"
			},
			"data": [{
				"label": "Benar",
				"value": "<?php echo $Bnar_Tulis?>"
			}, {
				"label": "Salah_Tulis",
				"value": "<?php echo $Salah_Tulis?>"
				}]
			}
		}
		);
			chartObj.render();
		});
	</script>
  </head>
  
	<body>
	<div class="latar">
	
	<div class="header">	
	<header>
	<header class="judul"><b>S  I  K  A  T</b></header>
	<header class="deskripsi"><i>Koreksi Kata</i></header>
</header>
</div>

<div id="menu">
	<?php include("../menubar.php"); ?>
</div>
	<div class="tengah">
	<h4></h4>
	<div class = "auto">
	<div id="chart-container" class="kuy">FusionCharts XT will load here!</div>
	</div>
<table>
	<td align="center"><a href="baqo.php?data=baca" type="submit">Kembali</a></td>
</table>
</div>
<div id="footer">
Copyright@ 2020  Andika Saputra(Jerambai)
</div>
</div>
</body>
</html>