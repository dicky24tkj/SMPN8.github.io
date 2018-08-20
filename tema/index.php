 <?php 
if (!isset($_SESSION)) {
  session_start();
}
 	require_once('Connections/taperpus.php');  
 	ini_set('display_errors','Off'); 
	include "tema/head.php";
	include "tema/logo.php";
	include "tema/menu.php";
	$a=isset($_GET['page'])? $_GET['page'] : null;
	$b=isset($_GET['process'])? $_GET['process'] : null;
	$c=isset($_GET['home'])? $_GET['home'] : null; 
	if (!empty ($a)or !empty ($b)) {
	include "admin/".$a."/".$b.".php";
	}
	elseif(!empty ($c)){
		include"tema/".$c.".php";
		}
	else{
	include "tema/informasi-berita.php";
	}
	include "tema/sidebar.php";
	include "tema/footer.php";
 ?>