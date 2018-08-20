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
  $updateSQL = sprintf("UPDATE buku SET id_katagori_buku=%s, judul_buku=%s, kode_buku=%s, abstrak=%s, penulis=%s, Tahaun_terbit=%s, penerbit=%s, pengarang=%s WHERE id_buku=%s",
                       GetSQLValueString($_POST['id_katagori_buku'], "int"),
                       GetSQLValueString($_POST['judul_buku'], "text"),
                       GetSQLValueString($_POST['kode_buku'], "text"),
                       GetSQLValueString($_POST['abstrak'], "text"),
                       GetSQLValueString($_POST['penulis'], "text"),
                       GetSQLValueString($_POST['Tahaun_terbit'], "int"),
                       GetSQLValueString($_POST['penerbit'], "text"),
                       GetSQLValueString($_POST['pengarang'], "text"),
                       GetSQLValueString($_POST['id_buku'], "int"));

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
if (isset($_GET['id_buku'])) {
  $colname_update = $_GET['id_buku'];
}
mysql_select_db($database_taperpus, $taperpus);
$query_update = sprintf("SELECT * FROM buku WHERE id_buku = %s", GetSQLValueString($colname_update, "int"));
$update = mysql_query($query_update, $taperpus) or die(mysql_error());
$row_update = mysql_fetch_assoc($update);
$totalRows_update = mysql_num_rows($update);
?>
<div class="panel panel-primary">
<div class="panel-heading"> Update Data Buku </div>
  <div class="panel-body">

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Id_buku:</td>
      <td><?php echo $row_update['id_buku']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Id_katagori_buku:</td>
      <td><input type="text" name="id_katagori_buku" value="<?php echo htmlentities($row_update['id_katagori_buku'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Judul_buku:</td>
      <td><input type="text" name="judul_buku" value="<?php echo htmlentities($row_update['judul_buku'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Kode_buku:</td>
      <td><input type="text" name="kode_buku" value="<?php echo htmlentities($row_update['kode_buku'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Abstrak:</td>
      <td><input type="text" name="abstrak" value="<?php echo htmlentities($row_update['abstrak'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Penulis:</td>
      <td><input type="text" name="penulis" value="<?php echo htmlentities($row_update['penulis'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Tahaun_terbit:</td>
      <td><input type="text" name="Tahaun_terbit" value="<?php echo htmlentities($row_update['Tahaun_terbit'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Penerbit:</td>
      <td><input type="text" name="penerbit" value="<?php echo htmlentities($row_update['penerbit'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Pengarang:</td>
      <td><input type="text" name="pengarang" value="<?php echo htmlentities($row_update['pengarang'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Update record" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id_buku" value="<?php echo $row_update['id_buku']; ?>" />
</form>
<p>&nbsp;</p>
  </div>
 
<?php
mysql_free_result($update);
?>
