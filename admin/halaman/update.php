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
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	if (!empty($lokasi_file)){ 
	UploadFoto($nama_file) ;
  $updateSQL = sprintf("UPDATE halaman SET nama_halaman=%s, isi_halaman=%s, foto_halaman=%s, id_kat_halaman=%s WHERE id_halaman=%s",
                       GetSQLValueString($_POST['nama_halaman'], "text"),
                       GetSQLValueString($_POST['isi_halaman'], "text"),
                       GetSQLValueString($nama_file, "text"),
                       GetSQLValueString(1, "int"),
                       GetSQLValueString($_POST['id_halaman'], "int"));

  mysql_select_db($database_taperpus, $taperpus);
  $Result1 = mysql_query($updateSQL, $taperpus) or die(mysql_error());
} 
else {
	
	UploadFoto($nama_file) ;
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE halaman SET nama_halaman=%s, isi_halaman=%s, id_kat_halaman=%s WHERE id_halaman=%s",
                       GetSQLValueString($_POST['nama_halaman'], "text"),
                       GetSQLValueString($_POST['isi_halaman'], "text"), 
                       GetSQLValueString(1, "int"),
                       GetSQLValueString($_POST['id_halaman'], "int"));

  mysql_select_db($database_taperpus, $taperpus);
  $Result1 = mysql_query($updateSQL, $taperpus) or die(mysql_error());
  
}

  $updateGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
}

mysql_select_db($database_taperpus, $taperpus);
$query_kat_halaman = "SELECT * FROM kat_halaman";
$kat_halaman = mysql_query($query_kat_halaman, $taperpus) or die(mysql_error());
$row_kat_halaman = mysql_fetch_assoc($kat_halaman);
$totalRows_kat_halaman = mysql_num_rows($kat_halaman);

$colname_halaman = "-1";
if (isset($_GET['id_halaman'])) {
  $colname_halaman = $_GET['id_halaman'];
}
mysql_select_db($database_taperpus, $taperpus);
$query_halaman = sprintf("SELECT * FROM halaman WHERE id_halaman = %s", GetSQLValueString($colname_halaman, "int"));
$halaman = mysql_query($query_halaman, $taperpus) or die(mysql_error());
$row_halaman = mysql_fetch_assoc($halaman);
$totalRows_halaman = mysql_num_rows($halaman);
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
      <td nowrap="nowrap" align="right">Nama :</td>
      <td><input type="text" name="nama_halaman" value="<?php echo htmlentities($row_halaman['nama_halaman'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top">Isi :</td>
      <td><textarea name="isi_halaman" cols="50" rows="5"><?php echo htmlentities($row_halaman['isi_halaman'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Foto :</td>
      <td><input type="file" name="fupload" value="<?php echo htmlentities($row_halaman['foto_halaman'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr> 
    <tr> </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Update record" /></td>
    </tr>
  </table>
  <input type="hidden" name="id_halaman" value="<?php echo $row_halaman['id_halaman']; ?>" />
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id_halaman" value="<?php echo $row_halaman['id_halaman']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($kat_halaman);

mysql_free_result($halaman);
?>
