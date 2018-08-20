<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$lokasi_file = $_FILES['fupload']['tmp_name'];
$nama_file   = $_FILES['fupload']['name'];
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	if (!empty($lokasi_file)){ 
	UploadFoto($nama_file) ;
  $insertSQL = sprintf("INSERT INTO halaman (nama_halaman, isi_halaman, foto_halaman, id_kat_halaman) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['nama_halaman'], "text"),
                       GetSQLValueString($_POST['isi_halaman'], "text"),
                       GetSQLValueString($nama_file, "text"),
                       GetSQLValueString(2, "int"));

  mysql_select_db($database_taperpus, $taperpus);
  $Result1 = mysql_query($insertSQL, $taperpus) or die(mysql_error());
} 

  $insertGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_taperpus, $taperpus);
$query_kat_halaman = "SELECT * FROM kat_halaman";
$kat_halaman = mysql_query($query_kat_halaman, $taperpus) or die(mysql_error());
$row_kat_halaman = mysql_fetch_assoc($kat_halaman);
$totalRows_kat_halaman = mysql_num_rows($kat_halaman);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" enctype="multipart/form-data">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nama Galeri:</td>
      <td><input type="text" name="nama_halaman" value="" required="required" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top">Isi :</td>
      <td><textarea name="isi_halaman" cols="50" rows="5" required="required"></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Foto Galeri:</td>
      <td><input type="file" name="fupload" required="required" value="" size="32" /></td>
    </tr> 
    <tr> </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Insert record" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($kat_halaman);
?>
