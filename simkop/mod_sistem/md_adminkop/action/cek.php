<?php  
	error_reporting(0);
	session_start();
	include "../../../../konfigurasi/conf-db/dbautentikasi.php";
	// $i = "?md=perens";
	$link = mysql_real_escape_string("$_POST[linksub]");
	$u = "SELECT * FROM kop_modul WHERE link_modul =  '$link'";
	$result = mysql_query($u);
	// echo "$u<br>";
	if(mysql_num_rows($result)>0){		
		// echo "0"." link tidak bisa dipakai";
		echo 0;
	}else{
		// echo "1"." link bisa dipakai";
		echo 1;
	}
?>