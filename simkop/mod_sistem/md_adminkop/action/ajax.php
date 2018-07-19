<?php 
	
	//error_reporting(0);
	session_start();
	include "../../../../konfigurasi/conf-db/dbautentikasi.php";
	if($_GET['idjab']){
		$l = "SELECT s.id_sub, s.nama_sub
			FROM submenu_utama s, menu_utama m, jabatan j
			WHERE j.id_jab = m.id_jab
			AND m.id_menu = s.id_menu
			AND j.id_jab =  '$_GET[idjab]'";	
		$k = mysql_query($l);
		echo "<option>Pilih Sekarang...</option>";
		if(mysql_num_rows($k)==0){
			echo "<option>0</option>";
		}else{
			while ($ll=mysql_fetch_array($k)) {
			echo "<option value='$ll[0]'>$ll[1]</option>";
			}	
		}
	}elseif($_GET['j']){
		$l = "SELECT m.id_menu, m.nama_menu
			FROM menu_utama m, jabatan j
			WHERE j.id_jab = m.id_jab			
			AND j.id_jab =  '$_GET[j]'";
		$k = mysql_query($l);
		echo "<option>Pilih Sekarang...</option>";
		if(mysql_num_rows($k)==0){
			echo "<option>0</option>";
		}else{
			while ($ll=mysql_fetch_array($k)) {
			echo "<option value='$ll[0]'>$ll[1]</option>";
			}	
		}		
	}
	
	

?>