<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "login.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
	 echo "<div class='alert alert-success alert-dismissible fade in'>Berhasil Logout, silahkan <a href='#'onclick='history.go(-2);return false;' class='btn btn-primary' > Login </a> kembali</div>"; 
    exit;
  }
}
?>
<?php
mysql_select_db($database_taperpus, $taperpus);
$query_kategori_buku = "SELECT * FROM katagori_buku";
$kategori_buku = mysql_query($query_kategori_buku, $taperpus) or die(mysql_error());
$row_kategori_buku = mysql_fetch_assoc($kategori_buku);
$totalRows_kategori_buku = mysql_num_rows($kategori_buku);
 
mysql_select_db($database_taperpus, $taperpus);
$query_profil = sprintf("SELECT * FROM halaman WHERE id_kat_halaman = 1");
$profil = mysql_query($query_profil, $taperpus) or die(mysql_error());
$row_profil = mysql_fetch_assoc($profil);
$totalRows_profil = mysql_num_rows($profil);
 
mysql_select_db($database_taperpus, $taperpus);
$query_galeri = sprintf("SELECT * FROM halaman WHERE id_kat_halaman =2");
$galeri = mysql_query($query_galeri, $taperpus) or die(mysql_error());
$row_galeri = mysql_fetch_assoc($galeri);
$totalRows_galeri = mysql_num_rows($galeri);
?>
<!--untuk menu-->
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="index.php">Home</a></li>
        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Profil <span class="caret"></span></a>
          <ul class="dropdown-menu">
         <?php do {
			  ?>
            <li><a href="index.php?page=halaman&process=detail&recordID=<?php echo $row_profil['id_halaman']; ?>"><?php echo $row_profil['nama_halaman']?></a></li>
            <?php } while($row_profil = mysql_fetch_assoc($profil))?>
          </ul>
        </li>
        <li><a href="index.php?page=halaman&process=index&id_kat_halaman=2">Galeri</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Katagori Buku <span class="caret"></span></a>
          <ul class="dropdown-menu">
          <?php do {
			  ?>
            <li><a href="index.php?page=buku&process=kategori-buku&id_katagori_buku=<?php echo $row_kategori_buku['id_katagori_buku']?>"><?php echo $row_kategori_buku['nama_katagori']?></a></li>
            <?php } while($row_kategori_buku = mysql_fetch_assoc($kategori_buku))?>
           
          </ul>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Akun <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo $logoutAction ?>">Log Out</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<!--untuk menu-->
<?php
mysql_free_result($kategori_buku);

mysql_free_result($profil);

mysql_free_result($galeri);
?>
