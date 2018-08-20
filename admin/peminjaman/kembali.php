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
  $updateSQL = sprintf("UPDATE peminjaman SET kode_buku=%s, nis=%s, tanggal_peminjaman=%s, tanggal_pengembalian=%s, tgl_dikembalikan=%s,denda=%s,status=%s WHERE id_peminjaman=%s",
                       GetSQLValueString($_POST['kode_buku'], "text"),
                       GetSQLValueString($_POST['nis'], "int"),
                       GetSQLValueString($_POST['tanggal_peminjaman'], "date"),
                       GetSQLValueString($_POST['tanggal_pengembalian'], "date"),
                       GetSQLValueString($_POST['tgl_dikembalikan'], "date"),
                       GetSQLValueString($_POST['denda'], "text"),
                       GetSQLValueString(1, "int"),
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
$query_update = sprintf("SELECT * FROM peminjaman,siswa WHERE id_peminjaman = %s AND peminjaman.nis=siswa.nis", GetSQLValueString($colname_update, "int"));
$update = mysql_query($query_update, $taperpus) or die(mysql_error());
$row_update = mysql_fetch_assoc($update);
$totalRows_update = mysql_num_rows($update);

mysql_select_db($database_taperpus, $taperpus);
$query_denda = "SELECT * FROM denda";
$denda = mysql_query($query_denda, $taperpus) or die(mysql_error());
$row_denda = mysql_fetch_assoc($denda);
$totalRows_denda = mysql_num_rows($denda);

$tgl_dateline     = $row_update['tanggal_pengembalian'];
$tgl_kembali     =  $tgl_sekarang;

$tgl_dateline_pcs = explode ("-", $tgl_dateline);
$tgl_dateline_pcs = $tgl_dateline_pcs[2]."-".$tgl_dateline_pcs[1]."-".$tgl_dateline_pcs[0];

$tgl_kembali_pcs = explode ("-", $tgl_kembali);
$tgl_kembali_pcs = $tgl_kembali_pcs[2]."-".$tgl_kembali_pcs[1]."-".$tgl_kembali_pcs[0];

$selisih = strtotime ($tgl_kembali_pcs) - strtotime ($tgl_dateline_pcs);

$selisih = $selisih / 86400;
$denda = $row_denda['jumlah_denda'];
$bayar = $selisih * $denda;  
?>
<div class="panel panel-primary">
  <div class="panel-heading"> Proses Pengembalian buku oleh <label class="label label-primary"><?php echo $row_update['nama_siswa']; ?></label> </div>
  <div class="panel-body">

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Id peminjaman:</td>
      <td><?php echo $row_update['id_peminjaman']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Kode buku:</td>
      <td><input type="text" name="kode_buku" value="<?php echo htmlentities($row_update['kode_buku'], ENT_COMPAT, 'utf-8'); ?>" size="32" readonly  class="form-control" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nis:</td>
      <td><input type="text" name="nis" value="<?php echo htmlentities($row_update['nis'], ENT_COMPAT, 'utf-8'); ?>" size="32" readonly  class="form-control" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Tanggal peminjaman:</td>
      <td><input type="text" name="tanggal_peminjaman"  value="<?php echo htmlentities($row_update['tanggal_peminjaman'], ENT_COMPAT, 'utf-8'); ?>" size="32" readonly  class="form-control" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Tempo:</td>
      <td><input type="text" name="tanggal_pengembalian"  value="<?php echo htmlentities($row_update['tanggal_pengembalian'], ENT_COMPAT, 'utf-8'); ?>" size="32" readonly class="form-control" /></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" nowrap="nowrap" class="panel panel-primary"><strong class="panel-heading">Hitung Denda</strong></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">Keterlambatan</td>
      <td >  <?php echo "".floor ($selisih)." hari";?>
      </td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">Tanggal Dikembalikan</td>
      <td align="right" nowrap="nowrap"><input type="text" name="tgl_dikembalikan"  class="form-control" value="<?php echo date('Y-m-d'); ?>" size="32" readonly />
      <label class="label label-default">Tanggal otomatis hari ini</label>
      </td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap">Denda</td>
      <td align="right" nowrap="nowrap"><input type="text" name="denda" value="<?php 
echo floor($bayar); ?>" size="32" class="form-control" readonly  />
      <label class="label label-default">Denda Otomatis dihitung ,Atur denda perhari <a class="btn btn-primary btn-xs" href="index.php?page=denda&process=index" target="_blank">Disini</a></label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Proses" class="btn btn-primary" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id_peminjaman" value="<?php echo $row_update['id_peminjaman']; ?>" />
</form>
<p>&nbsp;</p>
  </div>
 </div>
</div>
<?php
mysql_free_result($update);

mysql_free_result($denda);
?>
