<html>

<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="http://code.jquery.com/jquery-2.2.1.min.js"></script>
	
</head>

<body>
<script>
	var loading = document.getElementByID('loading').fadeOut("slow");
	window.addEventListener('load',function(){
		loading.style.display = "none";
	});
</script>
<?php 
        include 'koneksi.php';
        $kosongin_kata  =mysqli_query($conn,"TRUNCATE table jumlahkata");
        $kosongin_upload=mysqli_query($conn,"TRUNCATE table upload");
        
        echo "Unggah berkas: $upload";

        if ($_POST['upload']) {
        
        
            $ekstensi_diperbolehkan	= array('docx');
						$nama = $_FILES['fupload']['name'];
						$x = explode('.', $nama);
						$ekstensi = strtolower(end($x));
						$ukuran	= $_FILES['fupload']['size'];
						$file_tmp = $_FILES['fupload']['tmp_name'];	
 
						if(in_array($ekstensi, $ekstensi_diperbolehkan) == true){			
								move_uploaded_file($file_tmp, 'file/'.$nama);
								// dwi sakethi 23 november 2023
								// $query = mysqli_query($conn,"INSERT INTO upload VALUES(NULL, '$nama')");
								$query = mysqli_query($conn,"INSERT INTO upload VALUES(1,'$nama')");
								echo '<META HTTP-EQUIV="Refresh" Content="0; URL=file/baca.php">';
								echo '<div class="preloader"> 
											<div class="loading">
												<img src="load.gif" width="100"> 
												<p>Mohon Tunggu</p> 
											</div> 
										</div>';
								exit;
						}
						else{
									echo 'upss';
									echo '<META HTTP-EQUIV="Refresh" Content="0; URL=index.php">';
						}
					}
					//$endang=$nama;
?>
</body>
</html>
