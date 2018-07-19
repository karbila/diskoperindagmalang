<?php  
	//error_reporting(0);
	session_start();
	include "../../../../konfigurasi/conf-db/dbautentikasi.php";
	$md = $_POST['h_idkeg'];

	switch ($_GET['ac']) {
		case 'add':
			$j = "INSERT INTO submenu_utama (id_sub, nama_sub, id_menu, link_menu) VALUES (NULL, '$_POST[m]', '$_POST[mu]', '$_POST[linksub]')";
			if(mysql_query($j)){
				header("location:../../../dashboard.php?md=$md&s=az");
			}else{
				echo "gagal".mysql_error();
			}
			// echo "$j";
			break;

		case 'ed':
			$u = "UPDATE submenu_utama SET nama_sub = '$_POST[m]', id_menu = '$_POST[mu]', link_menu = '$_POST[linksub]' WHERE submenu_utama.id_sub = '$_POST[id_sub]'";
			// echo "$u";
			if(mysql_query($u)){
				header("location:../../../dashboard.php?md=$md&s=dp");
			}else{
				echo "gagal".mysql_error();
			}
			break;

		case 'off':
			$d = "UPDATE submenu_utama SET status = '0' WHERE submenu_utama.id_sub = '$_GET[f]' ";
			// echo "$d";
			if(mysql_query($d)){
				header("location:../../../dashboard.php?md=$_GET[md]&s=ck");
			}else{
				echo "gagal".mysql_error();
			}
			break;

		case 'on':
			$d = "UPDATE submenu_utama SET status = '1' WHERE submenu_utama.id_sub = '$_GET[f]' ";
			// echo "$d";
			if(mysql_query($d)){
				header("location:../../../dashboard.php?md=$_GET[md]&s=ck");
			}else{
				echo "gagal".mysql_error();
			}
			break;
		
		default:
			header("location:../../../dashboard.php");
			break;
	}

?>