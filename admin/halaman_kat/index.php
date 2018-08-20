<?php require_once('../../Connections/taperpus.php'); ?>
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
$query_index = "SELECT * FROM kat_halaman";
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
<p><a href="create.php">Tambah</a></p>
<table border="1" align="center">
  <tr>
    <td>id_kat_halaman</td>
    <td>nama_kat_halaman</td>
    <td>Pilihan</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="detail.php?recordID=<?php echo $row_index['id_kat_halaman']; ?>"> <?php echo $row_index['id_kat_halaman']; ?>&nbsp; </a></td>
      <td><?php echo $row_index['nama_kat_halaman']; ?>&nbsp; </td>
      <td><a href="update.php?id_kat_halaman=<?php echo $row_index['id_kat_halaman']; ?>">Edit</a> /<a href="delete.php?id_kat_halaman=<?php echo $row_index['id_kat_halaman']; ?>?id_kat_halaman=<?php echo $row_index['id_kat_halaman']; ?>?id_kat_halaman=<?php echo $row_index['id_kat_halaman']; ?>?id_kat_halaman=<?php echo $row_index['id_kat_halaman']; ?>?id_kat_halaman=<?php echo $row_index['id_kat_halaman']; ?>?id_kat_halaman=<?php echo $row_index['id_kat_halaman']; ?>?id_kat_halaman=<?php echo $row_index['id_kat_halaman']; ?>?id_kat_halaman=<?php echo $row_index['id_kat_halaman']; ?>?id_kat_halaman=<?php echo $row_index['id_kat_halaman']; ?>"> Hapus</a></td>
    </tr>
    <?php } while ($row_index = mysql_fetch_assoc($index)); ?>
</table>
<br />
<?php echo $totalRows_index ?> Records Total
</body>
</html>
<?php
mysql_free_result($index);
?>
