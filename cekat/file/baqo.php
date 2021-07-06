<?php
$inputan=$_GET['data'];
$hasilnya="$inputan";

if($hasilnya=="upload"){
header("location:../index.php");
}
else if($hasilnya=="tambah"){
	header("location:tambah.php");
}
else if($hasilnya=="download"){
	header("location:unduh.php");
}
else if($hasilnya=="lihat"){
	header("location:lihat.php");
}	
else if($hasilnya=="baca"){
	header("location:baca.php");
}
?>