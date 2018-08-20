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
$query_index = "SELECT * FROM peminjaman, buku, siswa WHERE peminjaman.kode_buku=buku.kode_buku AND peminjaman.nis=siswa.nis AND peminjaman.status=0";
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
  <div class="panel-heading"> Data Peminjaman </div>
  <div class="panel-body">


<title> - DATA PEMINJAMAN</title>
<body>
<p><a class="btn btn-primary" href="index.php?page=peminjaman&process=create">Tambah</a></p>
<p><a class="btn btn-primary" href="http://mts-muhmetro.net/admin/peminjaman/laporan.php">Cetak Laporan</a></p>
<table class="table table-bordered" id="example"> 
<thead>
  <tr>
    <th>ID</th>
    <th>Nama Siswa</th>
    <th>Kode Buku</th>
    <th>Status</th> 
    <th>Tanggal peminjaman</th>
    <th>Batas Waktu</th>
    <th>pilihan</th>
  </tr>
  </thead>
  <tfoot>
  <tr>
    <th>ID</th>
    <th>Nama Siswa</th>
    <th>Kode Buku</th>
    <th>Status</th> 
    <th>Tanggal peminjaman</th>
    <th>Batas Waktu</th>
    <th>pilihan</th>
  </tr>
  </tfoot>
  <tbody>
  <?php do { ?>
    <tr>
      <td><a href="detail.php?recordID=<?php echo $row_index['id_peminjaman']; ?>"> <?php echo $row_index['id_peminjaman']; ?>&nbsp; </a></td>
      <td><?php echo $row_index['nama_siswa']; ?></td>
      <td><?php echo $row_index['kode_buku']; ?>&nbsp; </td>
      <td>  
    <?php 
	// fungsi denda
$tgl_dateline     = $row_index['tanggal_pengembalian'];
$tgl_kembali     =  $tgl_sekarang;

$tgl_dateline_pcs = explode ("-", $tgl_dateline);
$tgl_dateline_pcs = $tgl_dateline_pcs[2]."-".$tgl_dateline_pcs[1]."-".$tgl_dateline_pcs[0];

$tgl_kembali_pcs = explode ("-", $tgl_kembali);
$tgl_kembali_pcs = $tgl_kembali_pcs[2]."-".$tgl_kembali_pcs[1]."-".$tgl_kembali_pcs[0];

$selisih = strtotime ($tgl_kembali_pcs) - strtotime ($tgl_dateline_pcs);

$selisih = $selisih / 86400;
  
	
	// fungsi status 
	if($row_index['tanggal_pengembalian'] < $tgl_sekarang){
		$statusnya = "<label class='label label-danger'>Jatuh tempo</label>";
	}
	 else { $statusnya ="<label class='label label-primary'>Belum Jatuh tempo</label>"; }
	?>
   <?php echo $statusnya?> <br>
<br>

 
    </td> 
      <td><?php echo dateID($row_index['tanggal_peminjaman']); ?>&nbsp; </td>
      <td><?php echo dateID($row_index['tanggal_pengembalian']); ?>&nbsp; </td>
      <td><a class="btn btn-xs btn-info" href="index.php?page=peminjaman&process=update&id_peminjaman=<?php echo $row_index['id_peminjaman']; ?>">Edit</a> <a class="btn btn-xs btn-danger" href="index.php?page=peminjaman&process=delete&id_peminjaman=<?php echo $row_index['id_peminjaman']; ?>">Hapus</a>
      <a class="btn btn-xs btn-primary" href="index.php?page=peminjaman&process=kembali&id_peminjaman=<?php echo $row_index['id_peminjaman']; ?>">Pengembalian</a>
      </td>
    </tr>
   
  
  <?php } while ($row_index = mysql_fetch_assoc($index)); ?> </tbody>
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
