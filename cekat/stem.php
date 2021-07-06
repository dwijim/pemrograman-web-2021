<?php

require_once('koneksi.php');//Koneksi ke database
// fungsi-fungsi
/*

DP + DP + root word + DS + PP + P

*/

function cekKamus($kata){
// cari di database
$sql = "SELECT * from kata_dasar where kata_dasar ='$kata' LIMIT 1";
//echo $sql.'<br/>';
$result = pg_query($sql) or die(pg_error());
if(pg_num_rows($result)==1){
return true; // True jika ada
}else{
return false; // jika tidak ada FALSE
}
}

function Del_Inflection_Suffixes($kata){
$kataAsal = $kata;
if(preg_match('/([km]u|nya|[kl]ah|pun)/$',$kata)){ // Cek Inflection Suffixes
$__kata = preg_replace('([km]u|nya|[kl]ah|pun)/$',”,$kata);

return $__kata;
}
return $kataAsal;
}

// Cek Prefix Disallowed Sufixes (Kombinasi Awalan dan Akhiran yang tidak diizinkan)
function Cek_Prefix_Disallowed_Sufixes($kata){
if(preg_match('^(be)[[:alpha:]]+(i)$',$kata)){ // be- dan -i
return true;
}

if(preg_match('^(se)[[:alpha:]]+(i|kan)$',$kata)){ // se- dan -i,-kan
return true;
}
return false;
}

// Hapus Derivation Suffixes ("-i", "-an" atau "-kan")
function Del_Derivation_Suffixes($kata){
$kataAsal = $kata;
if(preg_match('(i|an)$',$kata)){ // Cek Suffixes
$__kata = preg_replace('(i|an)$','',$kata);
if(cekKamus($__kata)){ // Cek Kamus
return $__kata;
}
/*– Jika Tidak ditemukan di kamus –*/
}
return $kataAsal;
}

// Hapus Derivation Prefix (“di-”, "ke-”, "se-”, "te-”, "be-”, "me-”, atau "pe-”)
function Del_Derivation_Prefix($kata){
$kataAsal = $kata;
/* —— Tentukan Tipe Awalan ————*/
if(preg_match('^(di|[ks]e)',$kata)){ // Jika di-,ke-,se-
$__kata = preg_replace('^(di|[ks]e)','',$kata);
if(cekKamus($__kata)){
return $__kata; // Jika ada balik
}
$__kata__ = Del_Derivation_Suffixes($__kata);
if(cekKamus($__kata__)){
return $__kata__;
}
/*————end "diper-”, ———————————————*/
if(preg_match('^(diper)',$kata)){
$__kata = preg_replace('^(diper)','',$kata);
if(cekKamus($__kata)){
return $__kata; // Jika ada balik
}
}
/*————end "diper-”, ———————————————*/
}
if(preg_match('^([tmbp]e)',$kata)){ //Jika awalannya adalah "te-”, "me-”, "be-”, atau "pe-”
}
/* — Cek Ada Tidaknya Prefik/Awalan (“di-”, "ke-”, "se-”, "te-”, "be-”, "me-”, atau "pe-”) ——*/
if(preg_match('^(di|[kstbmp]e)',$kata) == FALSE){
return $kataAsal;
}

return $kataAsal;
}

function NAZIEF($kata){

$kataAsal = $kata;

/* 1. Cek Kata di Kamus jika Ada SELESAI */
if(cekKamus($kata)){ // Cek Kamus
return $kata; // Jika Ada kembalikan
}

/* 2. Buang Infection suffixes (\-lah”, \-kah”, \-ku”, \-mu”, atau \-nya”) */
$kata = Del_Inflection_Suffixes($kata);

/* 3. Buang Derivation suffix (\-i" or \-an”) */
$kata = Del_Derivation_Suffixes($kata);

/* 4. Buang Derivation prefix */
$kata = Del_Derivation_Prefix($kata);

return $kata;

}

?>


<h3>STEMMING KATA DASAR</h3>
<form method="post" action="">
<input type="text" name="katadasar" id="katadasar" size="20">
<input class="btnForm" type="submit" name="btnSubmitAdd" value="Submit"/>
</form>
<?php
if(isset($_POST['katadasar'])){
$teksAsli = $_POST['katadasar'];
//echo $teksAsli;
$length = strlen($teksAsli);
//echo $length;
$pattern = '[A-Za-z]';
$kata = '';
if(preg_match($pattern, $teksAsli)){
$kata = $teksAsli;
$stemming = NAZIEF($kata); //Memasukkan kata ke fungsi Algoritma Nazief
echo $stemming.'<br/>';
$kata = '';
}
}