
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
$query_index = "SELECT * FROM katagori_buku";
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
  <div class="panel panel-primary">
  <div class="panel-heading"> katagori_buku </div>
  <div class="panel-body">


<body>
<p><a href="index.php?page=katagori_buku&process=create">tambah</a></p>
<table class="table table-bordered" id="example"> 
<thead>
  <tr>
    <th width="20">id</th>
    <th>nama_katagori</th>
    <th>pilihan</th>
  </tr>
</thead>
<tfoot>
  <tr>
    <th>id</th>
    <th>nama_katagori</th>
    <th>pilihan</th>
  </tr>
</tfoot>
<tbody>
  <?php do { ?>
    <tr>
      <td><a href="detail.php?recordID=<?php echo $row_index['id_katagori_buku']; ?>"> <?php echo $row_index['id_katagori_buku']; ?>&nbsp; </a></td>
      <td><?php echo $row_index['nama_katagori']; ?>&nbsp; </td>
      <td><a href="index.php?page=katagori_buku&process=update&id_katagori_buku=<?php echo $row_index['id_katagori_buku']; ?>">edit</a> / <a href="index.php?page=katagori_buku&process=delete&id_katagori_buku=<?php echo $row_index['id_katagori_buku']; ?>">hapus</a></td>
    </tr>
    <?php } while ($row_index = mysql_fetch_assoc($index)); ?>
    </tbody>
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
  </div>
 </div>
 
<?php
mysql_free_result($index);
?>
