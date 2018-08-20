
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
  $insertSQL = sprintf("INSERT INTO buku (id_katagori_buku, judul_buku, kode_buku, abstrak, penulis, Tahaun_terbit, penerbit, pengarang) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_katagori_buku'], "int"),
                       GetSQLValueString($_POST['judul_buku'], "text"),
                       GetSQLValueString($_POST['kode_buku'], "text"),
                       GetSQLValueString($_POST['abstrak'], "text"),
                       GetSQLValueString($_POST['penulis'], "text"),
                       GetSQLValueString($_POST['Tahaun_terbit'], "int"),
                       GetSQLValueString($_POST['penerbit'], "text"),
                       GetSQLValueString($_POST['pengarang'], "text"));

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
$query_katagori_buku = "SELECT * FROM katagori_buku";
$katagori_buku = mysql_query($query_katagori_buku, $taperpus) or die(mysql_error());
$row_katagori_buku = mysql_fetch_assoc($katagori_buku);
$totalRows_katagori_buku = mysql_num_rows($katagori_buku);
?>
 
  <div class="panel panel-primary">
  <div class="panel-heading"> List Buku</div>
  <div class="panel-body">

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Id_katagori_buku:</td>
      <td><select name="id_katagori_buku">
        <?php 
do {  
?>
        <option value="<?php echo $row_katagori_buku['id_katagori_buku']?>" ><?php echo $row_katagori_buku['nama_katagori']?></option>
        <?php
} while ($row_katagori_buku = mysql_fetch_assoc($katagori_buku));
?>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Judul_buku:</td>
      <td><input type="text" name="judul_buku" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Kode_buku:</td>
      <td><input type="text" name="kode_buku" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top">Abstrak:</td>
      <td><textarea name="abstrak" cols="50" rows="5"></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Penulis:</td>
      <td><input type="text" name="penulis" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Tahaun_terbit:</td>
      <td><input type="text" name="Tahaun_terbit" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Penerbit:</td>
      <td><input type="text" name="penerbit" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Pengarang:</td>
      <td><input type="text" name="pengarang" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Insert record" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
  </div>
 </div>
 
<?php
mysql_free_result($katagori_buku);
?>
