<?php
  include "koneksi.php";
  $dasar  =  $_POST['kata_dasar'];
  $result  = mysqli_query($conn, "INSERT INTO kata_dasar (kata_dasar) VALUES ('$dasar')");
  if ($result) {
    echo "Input berhasil";
	$_SESSION['pesan'] = 'Data berhasil di tambahkan';
  } else {
    echo "Input gagal";
  }
	header("location:kamuskbbi.php");

?>