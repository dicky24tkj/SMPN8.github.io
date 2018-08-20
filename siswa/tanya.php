<?php require_once('../Connections/taperpus.php'); ?>
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

$currentPage = $_SERVER["PHP_SELF"];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO tanya_jawab (nama_siswa, isi, tangga_posting) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['nama_siswa'], "text"),
                       GetSQLValueString($_POST['isi'], "text"),
                       GetSQLValueString($_POST['tangga_posting'], "date"));

  mysql_select_db($database_taperpus, $taperpus);
  $Result1 = mysql_query($insertSQL, $taperpus) or die(mysql_error());

  $insertGoTo = "tanya.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$maxRows_index = 10;
$pageNum_index = 0;
if (isset($_GET['pageNum_index'])) {
  $pageNum_index = $_GET['pageNum_index'];
}
$startRow_index = $pageNum_index * $maxRows_index;

mysql_select_db($database_taperpus, $taperpus);
$query_index = "SELECT * FROM tanya_jawab";
$query_limit_index = sprintf("%s LIMIT %d, %d", $query_index, $startRow_index, $maxRows_index);
$index = mysql_query($query_limit_index, $taperpus) or die(mysql_error());
$row_index = mysql_fetch_assoc($index);

if (isset($_GET['totalRows_index'])) {
  $totalRows_index = $_GET['totalRows_index'];
} else {
  $all_index = mysql_query($query_index);
  $totalRows_index = mysql_num_rows($all_index);
}
$totalPages_index = ceil($totalRows_index/$maxRows_index)-1;


$queryString_index = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_index") == false && 
        stristr($param, "totalRows_index") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_index = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_index = sprintf("&totalRows_index=%d%s", $totalRows_index, $queryString_index);
	include "head.php"; 
	include "menu.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<div class="row">
	<div class="col-md-12">
    <div class="col-md-4">
<div class="panel panel-primary"><div class="panel-heading">Tulis Pertanyaan</div>
<div class="panel-body">
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  
      <input type="text" name="nama_siswa" value="" class="form-control" placeholder="Nama" size="32" required="required" /> 
      <textarea name="isi" cols="50" rows="5" placeholder="Isi Pertanyaan" required="required" class="form-control"></textarea></td>
   <input type="submit" value="Kirim Pertanyaan" class="btn btn-xs btn-primary" /> 
  <input type="hidden" name="tangga_posting" value="<?php echo date('Y-m-d');?>" />
  <input type="hidden" name="MM_insert" value="form1" />
</form>

    </div>
    </div></div>
    	<div class="col-md-8">
<body>
<div class="panel panel-primary"><div class="panel-heading">List Pertanyaan</div>
<div class="panel-body">
<table  class="table">
  <tr>
    <td>Nama</td>
    <td>Pertanyaan</td>
    <td>Tanggal</td>
  </tr>
  <?php do { 
  $id= $row_index['id_tanya'];
mysql_select_db($database_taperpus, $taperpus);
$query_jawaban = "SELECT * FROM jawab_tanya WHERE id_tanya = $id";
$jawaban = mysql_query($query_jawaban, $taperpus) or die(mysql_error());
$row_jawaban = mysql_fetch_assoc($jawaban);
$totalRows_jawaban = mysql_num_rows($jawaban);
  ?>
    <tr>
      <td> <?php echo $row_index['nama_siswa']; ?> </td>
      <td><?php echo $row_index['isi']; ?> <br />Jawaban :
<br /><?php $no=1; do { ?>
<label class="label label-primary"><?php echo $no;?>. <?php echo $row_jawaban['jawaban']?></label><br /><br />


<?php $no++; } while ($row_jawaban = mysql_fetch_assoc($jawaban))?><br /></td>
      <td><?php echo $row_index['tangga_posting']; ?>&nbsp; </td>
    </tr>
    <?php } while ($row_index = mysql_fetch_assoc($index)); ?>
</table>
<br />
<table border="0">
  <tr>
    <td><?php if ($pageNum_index > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_index=%d%s", $currentPage, 0, $queryString_index); ?>">First</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_index > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_index=%d%s", $currentPage, max(0, $pageNum_index - 1), $queryString_index); ?>">Previous</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_index < $totalPages_index) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_index=%d%s", $currentPage, min($totalPages_index, $pageNum_index + 1), $queryString_index); ?>">Next</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_index < $totalPages_index) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_index=%d%s", $currentPage, $totalPages_index, $queryString_index); ?>">Last</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
Records <?php echo ($startRow_index + 1) ?> to <?php echo min($startRow_index + $maxRows_index, $totalRows_index) ?> of <?php echo $totalRows_index ?>
</div></div>
 
</body></div></div>
</body>
</html>
<?php
include "footer.php";
mysql_free_result($index);
?>
<?php
mysql_free_result($jawaban);
?>
