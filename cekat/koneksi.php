<?php
	
	/* 
	ini_set('max_execution_time',0);
    ini_set('upload_max_filesize',0);
    ini_set('post_max_size',0);
    ini_set('memory_limit',0);
    */
    ini_set('display_errors',1);
    
	$host="localhost";
	$user="debian";
	$pass="12345678";
	$db  ="dasar";
	 
	$conn=mysqli_connect($host,$user,$pass,$db) or die ("Koneksi gagal ...");
	
	
	
?>
