<?php 

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
        <li><a href="index.php">Home</a></li> <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Profil <span class="caret"></span></a>
          <ul class="dropdown-menu">
         <?php do {
			  ?>
            <li><a href="detail_halaman.php?recordID=<?php echo $row_profil['id_halaman']; ?>"><?php echo $row_profil['nama_halaman']?></a></li>
            <?php } while($row_profil = mysql_fetch_assoc($profil))?>
          </ul>
        </li>
        <li><a href="detail_galeri.php?id_kat_halaman=2">Galeri</a></li>
        <li><a href="buku.php">Cari Buku</a></li>
        <li><a href="tanya.php">Tanya Jawab</a></li>
        <li><a href="../index.php">Keluar</a></li>
       </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>