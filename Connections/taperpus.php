<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_taperpus = "localhost";
$database_taperpus = "mtsmuhme_localhost";
$username_taperpus = "mtsmuhme_db";
$password_taperpus = "masuk123321";
$taperpus = mysql_pconnect($hostname_taperpus, $username_taperpus, $password_taperpus) or trigger_error(mysql_error(),E_USER_ERROR);
setlocale(LC_TIME, 'id_ID', 'Indonesian_indonesia', 'Indonesian');
date_default_timezone_set('Asia/Jakarta');

function dateID($str) {
$date = strftime( "%A, %d %B %Y", strtotime($str));
return $date;
}
$tgl_sekarang = date('Y-m-d'); 

function UploadFoto($fupload_name){
   //direktori untuk foto galeri
  $vdir_upload = "foto/";
  $vfile_upload = $vdir_upload . $fupload_name;

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);
}
?>