<?php
include "koneksi.php";

//$_GET[id] untuk mengambil nilai dari address bar ?id=nilainya 

$id = $_GET["id"];
$query = mysqli_query($conn, "DELETE FROM kata_dasar WHERE id = '$id'");

if($query) {
	echo "Data Terhapus";

header("location:kamuskbbi.php");

}else{

echo "Data tidak terhapus";

}

?>