<?php 
	session_start();
	include "../../../konfigurasi/conf-db/dbautentikasi.php";

	if(!empty($_POST['mdlink'])){		
		$o = mysql_query("SELECT id_modul FROM kop_modul WHERE link_modul = '?md=".$_POST['mdlink']."'");
		$x = mysql_num_rows($o);
		echo "$x";
	}


 ?>