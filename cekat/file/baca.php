<html>
  <head>
    <title>Koreksi Kata</title>
	
	<link rel="stylesheet" type="text/css" href="../style.css">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
	
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
	<h2>Indikasi Penulisan:</h2> 
	<div class = "auto">
	<table id="contact-detail" class="compact" cellspacing="0" width="100%">
<thead>
	<tr>
		<th>Kata</th>
		<th>Keterangan</th>
		<th>Jumlah</th>
	</tr>
</thead>

<?php

include "stemming.php";
include "../koneksi.php";

$kosongin_dulu=mysqli_query($conn,"TRUNCATE TABLE jumlahkata");

class docxConversion{
    private $filename;

    public function __construct($filePath) {
        $this->filename = $filePath;
    }

    private function read_doc() {
        $fileHandle = fopen($this->filename, "r");
        $line = @fread($fileHandle, filesize($this->filename));   
        $lines = explode(chr(0x0D),$line);
        $outtext = "";
        foreach($lines as $thisline)
          {
            $pos = strpos($thisline, chr(0x00));
            if (($pos !== FALSE)||(strlen($thisline)==0))
              {
              } else {
                $outtext .= $thisline." ";
              }
          }
         $outtext = preg_replace("/[^a-zA-Z0-9\s\,\.\-\n\r\t@\/\_\(\)]/","",$outtext);
        return $outtext;
    }

    private function read_docx(){

        $striped_content = '';
        $content = '';

        $zip = zip_open($this->filename);

        if (!$zip || is_numeric($zip)) return false;

        while ($zip_entry = zip_read($zip)) {

            if (zip_entry_open($zip, $zip_entry) == FALSE) continue;

            if (zip_entry_name($zip_entry) != "word/document.xml") continue;

            $content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

            zip_entry_close($zip_entry);
        }// end while

        zip_close($zip);

        $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
        $content = str_replace('</w:r></w:p>', "\r\n\t", $content);

        // dwi sakethi
        $content = str_replace('</w:p>', " ", $content);  


        $striped_content = strip_tags($content);

        // modif
//        $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);  
//        $content = str_replace('</w:t><w:t>', " ", $content);  
        
        // ini untuk memperbaiki kata yang suka nyambung ketika sudah di enter 
        // misal antar kalimat pertama di awal sub bab
/*
$content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
        $content = str_replace('</w:r></w:p>', "\r\n\t", $content);
        $content = str_replace('</w:t>', " ", $content);  
        
        $content = str_replace('</w:r></w:p>', " ", $content);  
        // $striped_content = preg_replace("/[^a-zA-Z0-9\s\,\.\-\n\r\t@\/\_\(\)]/"," ",$content);
        $striped_content = preg_replace("/[^a-zA-Z0-9]/"," ",$content);
        $striped_content = strip_tags($content);  
        // modif
*/
        return $striped_content;
    }
	
public function convertToText() {

        if(isset($this->filename) && !file_exists($this->filename)) {
            return "File Not exists";
        }

        $fileArray = pathinfo($this->filename);
        $file_ext  = $fileArray['extension'];
        if($file_ext == "doc" || $file_ext == "docx" )
        {
            if($file_ext == "doc") {
                return $this->read_doc();
            } elseif($file_ext == "docx") {
                return $this->read_docx();
            } 
        } else {
            return "Invalid File Type";
        }
    }
}

// fungsi untuk membuang karakter spasi yang tidak terpakai
function hapus_spasi_spam($cus){
	$cus = trim($cus);
	while (strpos($cus,"  ")){
		$cus = str_replace("  "," ",$cus);
	}

	// dwi sakethi
	while (strpos($cus,"  ")){
		$cus = str_replace("  "," ",$cus);
	}
	while (strpos($cus,"  ")){
		$cus = str_replace("  "," ",$cus);
	}

	
	return $cus;
}

//mengambil dokumen yang diupload pada database untuk di eksekusi
$nama=mysqli_query($conn,"select nama from upload where id = 1");
$nama1=mysqli_fetch_array($nama);
$nama2= $nama1['nama'];
$gass=$nama2;

/* dwi sakethi 9 mei 2025 bikin bingung */
//$gass = "dwisakethi.docx";


$isi=new docxConversion($gass);
$isi=$isi->convertToText();

//echo $isi;
/**$target="$nama2";
if(file_exists($target)){
	unlink($target);
}**/
  
//proses preprocessing meliputi filtering, tokenizasi dkk.
$kecil=strtolower($isi);

// asline kiye
//$selain=preg_replace("/[^a-zA-Z]/"," ",$kecil);

// diubah
$selain=preg_replace("/[^a-zA-Z]/"," ",$kecil);

// tadinya pakai ini
//$dacok= hapus_spasi_spam($selain);
$dacok = $selain;


$pecah=explode(" ", $dacok);
$jumlah=count($pecah);
$tampungan=[];
$bantu=0;

foreach($pecah as $cah){
	if(preg_match('/[^a-zA-Z0-9]\z/',$cah)){
		
		while(preg_match('/[^a-zA-Z0-9]\z/',$cah))
		{
			$cah = preg_replace('/[^a-zA-Z0-9]\z/',"",$cah);
		}
		if(preg_match('/^[^a-zA-Z0-9]/',$cah)){
			$cah = preg_replace('/^[^a-zA-Z0-9]/',"",$cah);
		}
	}
	else if(preg_match('/^[^a-zA-Z0-9]/',$cah))
	{
		$cah = preg_replace('/^[^a-zA-Z0-9]/',"",$cah);
	}
	else{
		$cah=$cah;
	}
	
	$tampungan[$bantu]=$cah;
	$bantu++;
}

//penggabungan kata
$arr=array(" ");
$jml_1=count($tampungan);
$indeke=1;
$k=0;

for($i=0;$i<$jml_1;$i++){
	$jml_2=count($arr);
	for($j=0;$j<$jml_2;$j++){
		if(($tampungan[$i])!=$arr[$j]){
			$k++;		
		}

	if($jml_2==$k){
		$arr[$indeke]=$tampungan[$i];
		$indeke++;	
		}
	}
$k=0;
}

$simpan=0;
foreach ($arr as $ab){
$kueri = "SELECT * FROM kata_dasar where kata_dasar = '$ab'";
$hasil = mysqli_query($conn, $kueri);
$cek = mysqli_fetch_assoc($hasil);
$cekcek = $cek ['kata_dasar'];

if ($ab!=$cekcek){
	$simpan_arr[$simpan]= $ab;
	$simpan++;
}
}

$tampung=0;
foreach ($simpan_arr as $kkk){
   $teksAsli = $kkk;
   $stemming = stemdi($teksAsli);
   
if ($stemming==true){
	$baru[$tampung]=$teksAsli;
	$tampung++;
}
}

foreach ($simpan_arr as $cc){
   $teksAsli = $cc;
   $stemming = stemming($teksAsli);
   
if ($stemming==false){
	$baru[$tampung]=$teksAsli;
	$tampung++;
}
}


$arr1=preg_replace("/[^a-zA-Z]/","",$arr);

$p_arr=count($arr1);
$p_jumlah=count($baru);
$p_pecah=count($tampungan);
$nilainya=0;
$indikator=0;
$keterangan="-";


for($g=1;$g<$p_arr;$g++){
	for($h=0;$h<$p_pecah;$h++){
		if($arr1[$g]==$pecah[$h]){
			$nilainya++;
		}
	}
		for($i=0;$i<$p_jumlah;$i++){
		
		if($arr1[$g]!=$baru[$i]){
			$indikator++;
		}
	}
	$angka = intval($arr1[$g]);
	
	if($angka>0){
		$keterangan="Angka";
	}
	else
	{
		
		if($indikator==$p_jumlah)
		{
			$keterangan="Benar";
		}
		else
		{
			$keterangan="Salah Tulis";
		}
	}
	
	$kue=mysqli_query($conn, "insert into jumlahkata (nama_kata, jumlah, keterangan) values ('$arr1[$g]','$nilainya','$keterangan')");
	
	$nilainya=0;
	$indikator=0;
	$keterangan="-";
}

?>
<tbody>
<?php
include "../koneksi.php";
$tampil=mysqli_query($conn,"SELECT * FROM jumlahkata");
	foreach($tampil as $kuy){
		echo "
		<tr>
		<td>".$kuy['nama_kata']."</td>
		<td align='center'>".$kuy['keterangan']."</td>
		<td align='center'>".$kuy['jumlah']."</td>
		</tr>
		";
		}
		
/**foreach ($baru as $dd){
echo "<tr>
<td>".$dd."</td>
<td>salah ketik</td>
<td>".$nilainya."</td>

</tr>";
}*/
?>

</tbody>
</table>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#contact-detail').DataTable({
		rowCallback: function(row, data, index){
			if(data[1]=="Salah Tulis"){
				$(row).find('td').css('background-color','#FF6347');
			}
		}
	});
} );
</script>

</div>
<div>
<table>
<tr>
	<td align="center" width=30><a href="baqo.php?data=upload" type="submit">Selesai</a></td>
	<td align="center" width=30><a href="baqo.php?data=download" type="submit" target=new>Hasil #1</a></td>
	<td align="center" width=30><a href="unduh.php" type="submit" target=new>Hasil #2</a></td>
	<td align="center" width=30><a href="baqo.php?data=lihat" type="submit" target=new>Persentase</a></td>
</tr>
<tr>
	<td align="center" width=30><a href="karakter.php" type="submit" target=new>Cek Karakter</a></td>
	<td align="center" width=30><a href="cekjudulgambar.php" type="submit" target=new>Cek Judul Gambar</a></td>
	<td align="center" width=30><a href="cekdaftarpustaka.php" type="submit" target=new>Cek Daftar Pustaka</a></td>
</tr>
</table>
</div>
</div>
<div id="footer">
Copyright@ 2020  Andika Saputra(Jerambai) - Dwi Sakethi (2022)
</div>
</div>
</body>
</html>
