
<?php  
	//error_reporting(0);
	session_start();
	include "../../../../konfigurasi/conf-db/dbautentikasi.php";
	$md = $_POST['h_idkeg'];

	switch ($_GET['ac']) {
		case 'add':
			$link = "?md=".$_POST['link'];
			$p = "INSERT INTO kop_modul (id_modul, nama_modul, nama_alias, link_modul, mod_status, id_sub) VALUES ('', '$_POST[tah]', '$_POST[altah]', '$link', '$_POST[radio_tah]', '$_POST[submenu]')";
			if(mysql_query($p)==true){
				header("location:../../../dashboard.php?md=$md&s=az");
			}else{
				echo "gagal".mysql_error();
			}
			break;

		case 'ed':
			$link = "?md=".$_POST['link'];
			if($_POST['link']==''){
				$u = "UPDATE  kop_modul SET  nama_modul =  '$_POST[tah]',
					nama_alias =  '$_POST[altah]',
					id_sub =  '$_POST[submenu]' WHERE  kop_modul.id_modul = '$_POST[idmod]'";	
			}else{
				$u = "UPDATE  kop_modul SET  nama_modul =  '$_POST[tah]',
					nama_alias =  '$_POST[altah]',
					link_modul =  '$link',					
					id_sub =  '$_POST[submenu]' WHERE  kop_modul.id_modul = '$_POST[idmod]'";
			}
			
			if(mysql_query($u)==true){
				header("location:../../../dashboard.php?md=$md&s=dp");
			}else{
				echo "gagal".mysql_error();	
			}

		break;

		case 'd':
			$kd = "DELETE FROM kop_modul WHERE id_modul = '$_GET[page]'";
			if(mysql_query($kd)==true){				
				header("location:../../../dashboard.php?md=$_GET[md]&s=ck#tabel_modul");
			}else{
				echo "gagal<br>".mysql_error();
			}
		break;

		case "a":
			$a = "UPDATE  kop_modul SET  mod_status =  'N' WHERE  kop_modul.id_modul = '$_GET[page]'";
			if(mysql_query($a)){header('location:../../../dashboard.php?md='.$_GET['md'].'&s=nonaktif#tabel_modul');}else{ echo "gagal<br>".mysql_error();}

		break;
		
		case "n":
			$a = "UPDATE  kop_modul SET  mod_status =  'Y' WHERE  kop_modul.id_modul = '$_GET[page]'";
			if(mysql_query($a)){header('location:../../../dashboard.php?md='.$_GET['md'].'&s=aktif#tabel_modul');}else{ echo "gagal<br>".mysql_error();}
		break;

		// UPDATE  koperasi.kop_modul SET  mod_status =  'Y' WHERE  kop_modul.id_modul =89;

		default:
			header("location:../../../dashboard.php");
			break;
	}

?>










