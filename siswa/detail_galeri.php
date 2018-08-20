<?php
require_once("../Connections/taperpus.php");
	include "head.php";
	include "menu.php";  ?>
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

mysql_select_db($database_taperpus, $taperpus);
$query_index = "SELECT * FROM halaman";
$index = mysql_query($query_index, $taperpus) or die(mysql_error());
$row_index = mysql_fetch_assoc($index);
$totalRows_index = mysql_num_rows($index);$colname_index = "-1";
if (isset($_GET['id_kat_halaman'])) {
  $colname_index = $_GET['id_kat_halaman'];
}
mysql_select_db($database_taperpus, $taperpus);
$query_index = sprintf("SELECT * FROM halaman WHERE id_kat_halaman = %s", GetSQLValueString($colname_index, "int"));
$index = mysql_query($query_index, $taperpus) or die(mysql_error());
$row_index = mysql_fetch_assoc($index);
$totalRows_index = mysql_num_rows($index);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<p><a href="index.php?page=halaman&amp;process=create"></a></p>
<div class="panel panel-primary">
	<div class="panel-heading">Halaman Profil Sekolah</div>
    <div class="panel-body">
  <?php do { ?>
  <div class="col-md-12">
<img style="margin:10px" src="../foto/<?php echo $row_index['foto_halaman']; ?>" width="200" class="img-thumbnail pull-left"  />
    	<h3><a href="detail_halaman.php?recordID=<?php echo $row_index['id_halaman']; ?>"> <?php echo $row_index['nama_halaman']; ?>&nbsp; </a></h3><br />
 
     <?php echo $row_index['isi_halaman']; ?>&nbsp;  <br /> 
     <div class="clearfix"></div>
     
   
     </div> 
    <?php } while ($row_index = mysql_fetch_assoc($index)); ?> 
    </div>
<br />
<?php echo $totalRows_index ?> Records Total
</body>
</html>
<?php
mysql_free_result($index);
?>
<?php
include "footer.php"; 
?>
