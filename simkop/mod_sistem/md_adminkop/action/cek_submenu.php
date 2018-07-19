<?php  
	
	session_start();
	include "../../../../konfigurasi/conf-db/dbautentikasi.php";
	// ?md=lap_th	
	$link = mysql_real_escape_string("$_POST[linksub]");
	$o = "SELECT link_menu FROM submenu_utama WHERE link_menu =  '$link'";
	$result = mysql_query($o);
	if(mysql_num_rows($result)>0){
		//sudah ada linknya
		echo 0;
	}else{
		//berarti nilai < 0 alias gak ada ==> bisa dipakai tu link
		echo 1;
	}
?>