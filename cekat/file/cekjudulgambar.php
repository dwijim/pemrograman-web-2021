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
	<h2>Penulisan Judul Gambar</h2> 
	<div class = "auto">
	<table id="contact-detail" class="compact" cellspacing="0" width="100%">
<thead>
	<tr>
		<th>Nomor</th>
		<th>Judul</th>
		<th>Keterangan</th>
	</tr>
</thead>

<?php
include "../koneksi.php";
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
        $striped_content = strip_tags($content);

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
	while(strpos($cus,"  ")){
		$cus = str_replace("  "," ",$cus);
	}
	return $cus;
}

//mengambil dokumen yang diupload pada database untuk di eksekusi
$nama=mysqli_query($conn,"select nama from upload where id = 1");
$nama1=mysqli_fetch_assoc($nama);
$nama2= $nama1['nama'];
$gass=$nama2;
$isi=new docxConversion($gass);
$isi=$isi->convertToText();
//echo $isi;
/* --------------------------------------------------------
   Gambar 4.
   Gambar 14.
   -------------------------------------------------------- */

$kata_yang_dicari    = "Gambar";   
$bukan_judul_gambar1 = "Gambar \*";   
$bukan_judul_gambar2 = "Gambar SE";   
$titik_satu          = 9;
$titik_dua           = 10;
$panjang_skripsi     = strlen($isi);
$panjang_kata_yang_dicari = strlen($kata_yang_dicari);   


// proses dari huruf pertama sampai dengan terakhir isi skripsi
for ($proses=0;$proses<=$panjang_skripsi;$proses++)
{
   $potongan_isi = substr($isi,$proses,$panjang_kata_yang_dicari);
   if ($potongan_isi==$kata_yang_dicari)
      {
        $cek_judul_gambar = substr($isi,$proses,$panjang_kata_yang_dicari+3);
        if ( ($cek_judul_gambar==$bukan_judul_gambar1) || 
             ($cek_judul_gambar==$bukan_judul_gambar2) 
             )
          {
            continue;
          }
        $potongan_isi_tambahan = substr($isi,$proses,$panjang_kata_yang_dicari+17);
        echo $potongan_isi_tambahan."<br>";
      }

}
// $kecil=strtolower($isi);

?>

<tbody>

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
<table>
<tr>
	<td align="center"><a href="baqo.php?data=upload" type="submit">Selesai</a></td>
  <td align="center"><a href="baqo.php?data=baca" type="submit">Kembali</a></td>
</tr>
</table>
</div>
<div id="footer">
Copyright@ 2020  Andika Saputra(Jerambai)
</div>
</div>
</body>
</html>
