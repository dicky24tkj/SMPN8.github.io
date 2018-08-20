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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO peminjaman (kode_buku, nis, tanggal_peminjaman, tanggal_pengembalian,status) VALUES (%s,%s, %s, %s, %s)",
                       GetSQLValueString($_POST['kode_buku'], "text"),
                       GetSQLValueString($_POST['nis'], "int"),
                       GetSQLValueString($_POST['tanggal_peminjaman'], "date"),
                       GetSQLValueString($_POST['tanggal_pengembalian'], "date"),
                       GetSQLValueString(0, "int"));

  mysql_select_db($database_taperpus, $taperpus);
  $Result1 = mysql_query($insertSQL, $taperpus) or die(mysql_error());

  $insertGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_taperpus, $taperpus);
$query_buku = "SELECT * FROM buku";
$buku = mysql_query($query_buku, $taperpus) or die(mysql_error());
$row_buku = mysql_fetch_assoc($buku);
$totalRows_buku = mysql_num_rows($buku);

mysql_select_db($database_taperpus, $taperpus);
$query_siswa = "SELECT * FROM siswa";
$siswa = mysql_query($query_siswa, $taperpus) or die(mysql_error());
$row_siswa = mysql_fetch_assoc($siswa);
$totalRows_siswa = mysql_num_rows($siswa);

mysql_select_db($database_taperpus, $taperpus);
$query_cek_nis = "SELECT * FROM peminjaman";
$cek_nis = mysql_query($query_cek_nis, $taperpus) or die(mysql_error());
$row_cek_nis = mysql_fetch_assoc($cek_nis);
$totalRows_cek_nis = mysql_num_rows($cek_nis);
?>
<div class="panel panel-primary">
  <div class="panel-heading"> Input Peminjaman Buku </div>
  <div class="panel-body">

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Kode_buku:</td>
      <td><select class="form-control" name="kode_buku">
        <?php 
do {  
?>
        <option value="<?php echo $row_buku['kode_buku']?>" ><?php echo $row_buku['kode_buku']?> (<?php echo $row_buku['judul_buku']?>)</option>
        <?php
} while ($row_buku = mysql_fetch_assoc($buku));
?>
      </select></td>
    </tr>
    <tr> </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nis:</td>
      <td><select class="form-control" name="nis">
        <?php 
do {  
?>
        <option value="<?php 
		 echo $row_siswa['nis']?>" ><?php echo $row_siswa['nis']?> (<?php echo $row_siswa['nama_siswa']?>)</option>
        <?php
} while ($row_siswa = mysql_fetch_assoc($siswa));
?>
      </select></td>
    </tr>
    <tr> </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Tanggal peminjaman:</td>
      <td><input class="form-control" type="text" name="tanggal_peminjaman"  id="datepicker" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Tanggal pengembalian:</td>
      <td><input class="form-control" type="text" name="tanggal_pengembalian" id="datepicker2" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Proses" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
  </div>
 </div>
 
<?php
mysql_free_result($buku);

mysql_free_result($siswa);

mysql_free_result($cek_nis);
?>
