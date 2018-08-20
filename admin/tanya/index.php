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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<table class="table">
  <tr>
    <td>nama_siswa</td>
    <td>isi</td>
    <td>tangga_posting</td>
    <td>Jawab</td>
    <td>Pilihan</td>
  </tr>
  <?php
  
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO jawab_tanya (jawaban, id_tanya) VALUES (%s, %s)",
                       GetSQLValueString($_POST['jawaban'], "text"),
                       GetSQLValueString($_POST['id_tanya'], "int"));

  mysql_select_db($database_taperpus, $taperpus);
  $Result1 = mysql_query($insertSQL, $taperpus) or die(mysql_error());
echo"Berhasil dijawab";
}
   do { ?>
    <tr>
      <td><?php echo $row_index['nama_siswa']; ?>&nbsp;</td>
      <td><?php echo $row_index['isi']; ?>&nbsp; </td>
      <td><?php echo $row_index['tangga_posting']; ?>&nbsp; </td>
      <td>
      <?php 
mysql_select_db($database_taperpus, $taperpus);
$query_jawaban = "SELECT * FROM jawab_tanya WHERE id_tanya = ".$row_index['id_tanya']."";
$jawaban = mysql_query($query_jawaban, $taperpus) or die(mysql_error());
$row_jawaban = mysql_fetch_assoc($jawaban);
$totalRows_jawaban = mysql_num_rows($jawaban);

?> 
<body> Jawaban: <br />

<?php $no=1; do { ?>
<label class="label label-primary"><?php echo $no;?>. <?php echo $row_jawaban['jawaban']?></label> <a href="index.php?page=tanya&process=hapus_jawaban&id_jawab=<?php echo $row_jawaban['id_jawab']; ?>">hapus</a><br /><br />


<?php $no++; } while ($row_jawaban = mysql_fetch_assoc($jawaban))?><br />

<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
   
      <input type="text" name="jawaban" size="32" class="form-control"/> 
       <input type="submit" value="Kirim" class="btn btn-xs btn-primary" /> 
  <input type="hidden" name="MM_insert" value="form1" />
      <input type="hidden" name="id_tanya" value="<?php echo $row_index['id_tanya']?>"/> 
</form>
      </td>
      <td><a href="index.php?page=tanya&process=delete&id_tanya=<?php echo $row_index['id_tanya']; ?>">Hapus</a>  </td>
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
</body>
</html>
<?php
mysql_free_result($index);

mysql_free_result($jawaban);
?>
