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

$maxRows_DetailRS1 = 10;
$pageNum_DetailRS1 = 0;
if (isset($_GET['pageNum_DetailRS1'])) {
  $pageNum_DetailRS1 = $_GET['pageNum_DetailRS1'];
}
$startRow_DetailRS1 = $pageNum_DetailRS1 * $maxRows_DetailRS1;

$colname_DetailRS1 = "-1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS1 = $_GET['recordID'];
}
mysql_select_db($database_taperpus, $taperpus);
$query_DetailRS1 = sprintf("SELECT * FROM buku WHERE id_buku = %s", GetSQLValueString($colname_DetailRS1, "int"));
$query_limit_DetailRS1 = sprintf("%s LIMIT %d, %d", $query_DetailRS1, $startRow_DetailRS1, $maxRows_DetailRS1);
$DetailRS1 = mysql_query($query_limit_DetailRS1, $taperpus) or die(mysql_error());
$row_DetailRS1 = mysql_fetch_assoc($DetailRS1);

if (isset($_GET['totalRows_DetailRS1'])) {
  $totalRows_DetailRS1 = $_GET['totalRows_DetailRS1'];
} else {
  $all_DetailRS1 = mysql_query($query_DetailRS1);
  $totalRows_DetailRS1 = mysql_num_rows($all_DetailRS1);
}
$totalPages_DetailRS1 = ceil($totalRows_DetailRS1/$maxRows_DetailRS1)-1;
?><div class="col-md-8"> 
  <div class="panel panel-primary">
  <div class="panel-heading"> untuk konten </div>
  <div class="panel-body">

<body>

<table border="1" align="center">
  <tr>
    <td>id_buku</td>
    <td><?php echo $row_DetailRS1['id_buku']; ?></td>
  </tr>
  <tr>
    <td>id_katagori_buku</td>
    <td><?php echo $row_DetailRS1['id_katagori_buku']; ?></td>
  </tr>
  <tr>
    <td>judul_buku</td>
    <td><?php echo $row_DetailRS1['judul_buku']; ?></td>
  </tr>
  <tr>
    <td>kode_buku</td>
    <td><?php echo $row_DetailRS1['kode_buku']; ?></td>
  </tr>
  <tr>
    <td>abstrak</td>
    <td><?php echo $row_DetailRS1['abstrak']; ?></td>
  </tr>
  <tr>
    <td>penulis</td>
    <td><?php echo $row_DetailRS1['penulis']; ?></td>
  </tr>
  <tr>
    <td>Tahaun_terbit</td>
    <td><?php echo $row_DetailRS1['Tahaun_terbit']; ?></td>
  </tr>
  <tr>
    <td>penerbit</td>
    <td><?php echo $row_DetailRS1['penerbit']; ?></td>
  </tr>
  <tr>
    <td>pengarang</td>
    <td><?php echo $row_DetailRS1['pengarang']; ?></td>
  </tr>
  <tr>
    <td>id_katagori_penerbit</td>
    <td><?php echo $row_DetailRS1['id_katagori_penerbit']; ?></td>
  </tr>
</table>
  </div>
 </div>
</div><?php
mysql_free_result($DetailRS1);
?>