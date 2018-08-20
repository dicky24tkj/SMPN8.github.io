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
  $updateSQL = sprintf("UPDATE denda SET jumlah_denda=%s WHERE id_denda=%s",
                       GetSQLValueString($_POST['jumlah_denda'], "int"),
                       GetSQLValueString($_POST['id_denda'], "int"));

  mysql_select_db($database_taperpus, $taperpus);
  $Result1 = mysql_query($updateSQL, $taperpus) or die(mysql_error());
}

mysql_select_db($database_taperpus, $taperpus);
$query_update = "SELECT * FROM denda";
$update = mysql_query($query_update, $taperpus) or die(mysql_error());
$row_update = mysql_fetch_assoc($update);
$totalRows_update = mysql_num_rows($update);
?>
  <div class="panel panel-primary">
  <div class="panel-heading"> Biaya Denda Perhari </div>
  <div class="panel-body">
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
     
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Jumlah denda:</td>
      <td><input type="text" name="jumlah_denda" value="<?php echo htmlentities($row_update['jumlah_denda'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Update record" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id_denda" value="<?php echo $row_update['id_denda']; ?>" />
</form></div></div>
<?php
mysql_free_result($update);
?>
