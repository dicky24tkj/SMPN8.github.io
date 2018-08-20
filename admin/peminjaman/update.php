
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE peminjaman SET kode_buku=%s, nis=%s, tanggal_peminjaman=%s, tanggal_pengembalian=%s WHERE id_peminjaman=%s",
                       GetSQLValueString($_POST['kode_buku'], "text"),
                       GetSQLValueString($_POST['nis'], "int"),
                       GetSQLValueString($_POST['tanggal_peminjaman'], "date"),
                       GetSQLValueString($_POST['tanggal_pengembalian'], "date"),
                       GetSQLValueString($_POST['id_peminjaman'], "int"));

  mysql_select_db($database_taperpus, $taperpus);
  $Result1 = mysql_query($updateSQL, $taperpus) or die(mysql_error());

  $updateGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_update = "-1";
if (isset($_GET['id_peminjaman'])) {
  $colname_update = $_GET['id_peminjaman'];
}
mysql_select_db($database_taperpus, $taperpus);
$query_update = sprintf("SELECT * FROM peminjaman WHERE id_peminjaman = %s", GetSQLValueString($colname_update, "int"));
$update = mysql_query($query_update, $taperpus) or die(mysql_error());
$row_update = mysql_fetch_assoc($update);
$totalRows_update = mysql_num_rows($update);
?> 
  <div class="panel panel-primary">
  <div class="panel-heading"> untuk konten </div>
  <div class="panel-body">

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Id_peminjaman:</td>
      <td><?php echo $row_update['id_peminjaman']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Kode_buku:</td>
      <td><input type="text" name="kode_buku" value="<?php echo htmlentities($row_update['kode_buku'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nis:</td>
      <td><input type="text" name="nis" value="<?php echo htmlentities($row_update['nis'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Tanggal_peminjaman:</td>
      <td><input type="text" name="tanggal_peminjaman" id="datepicker" value="<?php echo htmlentities($row_update['tanggal_peminjaman'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Tanggal_pengembalian:</td>
      <td><input type="text" name="tanggal_pengembalian" id="datepicker2" value="<?php echo htmlentities($row_update['tanggal_pengembalian'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Update record" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id_peminjaman" value="<?php echo $row_update['id_peminjaman']; ?>" />
</form>
<p>&nbsp;</p>
  </div>
 </div> 
<?php
mysql_free_result($update);
?>
