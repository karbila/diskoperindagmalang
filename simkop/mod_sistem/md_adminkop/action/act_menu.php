<?php  
	//error_reporting(0);
	session_start();
	include "../../../../konfigurasi/conf-db/dbautentikasi.php";
	$md = $_POST['h_idkeg'];

	switch ($_GET['ac']) {
		case 'add':
			$j = "INSERT INTO menu_utama (id_menu, nama_menu, id_jab, status) VALUES (NULL, '$_POST[m]', '$_POST[l]', '1')";
			if(mysql_query($j)){
				header("location:../../../dashboard.php?md=$md&s=az");
			}else{
				echo "gagal".mysql_error();
			}
			// echo "$j";
			break;

		case 'ed':
			$u = "UPDATE menu_utama SET nama_menu = '$_POST[m]', id_jab = '$_POST[l]' WHERE id_menu = '$_POST[id_menu]'";
			// echo "$u";
			if(mysql_query($u)){
				header("location:../../../dashboard.php?md=$md&s=dp");
			}else{
				echo "gagal".mysql_error();
			}
			break;

		case 'off':
			$d = "UPDATE menu_utama SET status = '0' WHERE id_menu = '$_GET[f]'";
			// echo "$d";
			if(mysql_query($d)){
				header("location:../../../dashboard.php?md=$_GET[md]&s=ck");
			}else{
				echo "gagal".mysql_error();
			}
			break;

		case 'on':
			$d = "UPDATE menu_utama SET status = '1' WHERE id_menu = '$_GET[f]'";
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