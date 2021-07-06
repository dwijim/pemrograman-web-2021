<?php
  include "koneksi.php";
  $tempat  =  $_POST['ket_tempat'];
  $result  = mysqli_query($conn, "INSERT INTO ket_tempat (ket_tempat) VALUES ('$tempat')");
  if ($result) {
    echo "Input berhasil";
	$_SESSION['pesan'] = 'Data berhasil di tambahkan';
  } else {
    echo "Input gagal";
  }
	header("location:ket_tempat.php");

?>