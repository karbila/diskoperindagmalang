<?php  

	//error_reporting(0);
	// session_start();
	include "../../../../konfigurasi/conf-db/dbautentikasi.php";
	$md = $_POST['h_idkeg'];

	switch ($_GET['ac']) {

		case 'add':
			$pp = md5($_POST['p']);
			$l = "INSERT INTO users (id_user, id_seksi, username, password, nama_lengkap, email, no_telp, blokir, id_jab) VALUES (NULL, '$_POST[sek]', '$_POST[u]', '$pp', '$_POST[nl]', '$_POST[e]', '$_POST[nt]', '$_POST[radio_tah]', '$_POST[jab]')";
			// echo "$l";
			if(mysql_query($l)){
				header("location:../../../dashboard.php?md=$md&s=az");
			}else{
				echo "gagal".mysql_error();
			}
			break;
			
		case 'ed':
			//jika pass gak diedit
			if(empty($_POST['p'])){
				$y = "UPDATE users SET id_seksi = '$_POST[sek]', username = '$_POST[u]', nama_lengkap = '$_POST[nl]', email = '$_POST[e]', no_telp = '$_POST[nt]', blokir = '$_POST[radio_tah]', id_jab = '$_POST[jab]' WHERE users.id_user = $_POST[id_u]";
				if(mysql_query($y)){
					header("location:../../../dashboard.php?md=$md&s=dp");
				}else{
					echo "gagal".mysql_error();
				}
			}else{
			//jika diedit
				$pp = md5($_POST['p']);
				$i = "UPDATE users SET id_seksi = '$_POST[sek]', username = '$_POST[u]', password='$pp', nama_lengkap = '$_POST[nl]', email = '$_POST[e]', no_telp = '$_POST[nt]', blokir = '$_POST[radio_tah]', id_jab = '$_POST[jab]' WHERE users.id_user = $_POST[id_u]";
				if(mysql_query($i)){
					header("location:../../../dashboard.php?md=$md&s=dp");
				}else{
					echo "gagal".mysql_error();
				}
			}
			
			break;
		
		case 'off':
			$u = mysql_query("UPDATE users SET blokir = 'Y' WHERE id_user = '$_GET[f]'");
			if($u==true){
				header("location:../../../dashboard.php?md=$_GET[md]&s=ck#box-tabel");
			}else{echo "gagal".mysql_error();}

		break;

		case 'on':
			$u = mysql_query("UPDATE users SET blokir = 'N' WHERE id_user = '$_GET[f]'");
			if($u==true){
				header("location:../../../dashboard.php?md=$_GET[md]&s=ck#box-tabel");
			}else{echo "gagal".mysql_error();}

		break;

				
		default:
			header("location:../../../dashboard.php");
			break;
	}
?>