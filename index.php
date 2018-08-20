<?php 
include "sessi.php";
require_once('Connections/taperpus.php');  
 	ini_set('display_errors','Off'); 
	include "tema/head.php";
	include "tema/logo.php";
	include "tema/menu.php";
	include "tema/sidebar.php";
	$a=isset($_GET['page'])? $_GET['page'] : null;
	$b=isset($_GET['process'])? $_GET['process'] : null;
	$c=isset($_GET['home'])? $_GET['home'] : null; 
	$d=isset($_GET['siswa'])? $_GET['siswa'] : null; 
	if (!empty ($a)or !empty ($b)) {
		echo "<div class='col-md-9'> ";
	include "admin/".$a."/".$b.".php";
	echo "</div>";
	}
	elseif(!empty ($c)){
		echo "<div class='col-md-9'> ";
		include"tema/".$c.".php";
	echo "</div>";
		}
		elseif (!empty ($d)) {
		echo "<div class='col-md-9'> ";
	include "siswa/".$d.".php";
	echo "</div>";
	}
	else{
	include "tema/konten.php";
	}
	include "tema/footer.php";
 ?>