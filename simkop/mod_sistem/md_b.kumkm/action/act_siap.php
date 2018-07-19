<?php  
	//error_reporting(0);
	session_start();
	include "../../../../konfigurasi/conf-db/dbautentikasi.php";
	include "../../../../konfigurasi/function/fungsi_indotgl.php";
	$md = $_POST['h_idkeg'];
	$mulai = indotodb($_POST['s']);		
	$selesai = indotodb($_POST['f']);
	$uang = str_replace(",", "", $_POST['ang']);

	switch ($_GET['ac']) {		
		case "siap_ins":		

		$f= "INSERT INTO tbl_penyiapan (id_penyiapan, kode_penyi, nama_kegiatan_penyi, tgl_mulai_penyi1, tgl_selesai_penyi1, tempat_penyi, deskripsi_penyi, id_rencana, anggaran, id_pegawai, status_proses, status_kunci, owner) VALUES ('', '$_POST[no_siap]', '$_POST[nper]', '$mulai', '$selesai', '$_POST[tp]', '$_POST[dper]', '$_POST[nama_peren]', '$uang', '$_POST[np]', '0', '0', '$_SESSION[iduser]')";
		echo "$f";
		if(mysql_query($f)){
			//mysql_query("UPDATE tbl_rencana SET status_proses = '1' WHERE id_rencana = '$_POST[nama_peren]'");
			header("location:../../../dashboard.php?md=$_GET[md]&s=az");
		}else{
			echo "gagal<br>".mysql_error();
		}
		break;

		case "siap_upd":
			$i = "UPDATE tbl_penyiapan SET kode_penyi= '$_POST[no_siap]',nama_kegiatan_penyi= '$_POST[nper]',tgl_mulai_penyi1= '$mulai',tgl_selesai_penyi1='$selesai',tempat_penyi='$_POST[tp]',deskripsi_penyi='$_POST[dper]', anggaran= '$uang', id_pegawai= '$_POST[np]',  id_rencana='$_POST[nama_peren]' WHERE id_penyiapan = '$_POST[kode]'";
			if(mysql_query($i)==true){
				header("location:../../../dashboard.php?md=$_GET[md]&s=dp");
			}else{
				echo "gagal<br>".mysql_error();
			}

		
		break;

		case "siap_del":
			$i = "$_GET[page]";
			$h = "DELETE FROM tbl_penyiapan WHERE id_penyiapan = '$i'";
			if(mysql_query($h)){
					header("location:../../../dashboard.php?md=$_GET[md]&s=ck#tbl_penyi");
				}else{
					echo "gagal<br>".mysql_error();
				}
		break;

		// SUB PENYIAPAN
		case 'sub_ins':
			$mulai = indotodb($_POST['s']);		
			$selesai = indotodb($_POST['f']);
			//karena didapatkan kode 001 yang mana ini adalah kode alias maka harus dicari id aslinya
			$i = mysql_fetch_array(mysql_query("SELECT id_penyiapan FROM tbl_penyiapan WHERE kode_penyi = '$_POST[kp]'"));
			$p = "INSERT INTO tbl_sub_penyiapan (id_sub_penyi, penyi_sub_kode, penyi_sub_nama, penyi_sub_mulai, penyi_sub_selesai, penyi_sub_deskripsi, id_penyiapan, status_proses, status_kunci, owner) VALUES ('', '$_POST[idsub]', '$_POST[nmsub]', '$mulai', '$selesai', '$_POST[dk]', '$i[0]', '0', '0', '$_SESSION[iduser]')";
			echo "$p";
			if(mysql_query($p)==true){
				header("location:../../../dashboard.php?md=$md&s=sub_ins");
			}else{
				echo "gagal<br>".mysql_error();
			}
		break;

		case "sub_upd":
			$mulai = indotodb($_POST['s']);		
			$selesai = indotodb($_POST['f']);
			//cari id penyiapan yang kodenya dari $_POST[kp]
			$i = mysql_fetch_array(mysql_query("SELECT id_penyiapan FROM tbl_penyiapan WHERE kode_penyi = '$_POST[kp]'"));
			$l = "UPDATE tbl_sub_penyiapan SET penyi_sub_kode='$_POST[idsub]',penyi_sub_nama='$_POST[nmsub]',penyi_sub_mulai='$mulai',penyi_sub_selesai='$selesai',penyi_sub_deskripsi='$_POST[dk]',id_penyiapan='$i[0]' WHERE id_sub_penyi='$_POST[kdo]'";
			// echo "$l";
			if(mysql_query($l)){header("location:../../../dashboard.php?md=$md&s=sub_upd");}else{echo "gagal<br>".mysql_error();}
			
		break;

		case "sub_rm":
			$id=$_GET['page'];
			$q="DELETE FROM tbl_sub_penyiapan WHERE id_sub_penyi='$id'";
			if(mysql_query($q)){header("location:../../../dashboard.php?md=$_GET[md]&b=ck#tbl_sub_penyi");}else{echo "gagal<br>".mysql_error();}
		break;

		case 'on':
			$p = "UPDATE tbl_penyiapan SET status_kunci='1' WHERE id_penyiapan='$_GET[page]'";
			//echo "$p";
			if(mysql_query($p)){header("location:../../../dashboard.php?md=$_GET[md]&s=on#tbl_penyi");}else{echo "gagal<br>".mysql_error();}
		break;

		case 'off':
			$p = "UPDATE tbl_penyiapan SET status_kunci='0' WHERE id_penyiapan='$_GET[page]'";
			if(mysql_query($p)){header("location:../../../dashboard.php?md=$_GET[md]&s=off#tbl_penyi");}else{echo "gagal<br>".mysql_error();}
		break;

		case 'on_sub':
			$p = "UPDATE tbl_sub_penyiapan SET status_kunci='1' WHERE id_sub_penyi='$_GET[page]'";
			if(mysql_query($p)){header("location:../../../dashboard.php?md=$_GET[md]&b=on_sub#tbl_sub_penyi");}else{echo "gagal<br>".mysql_error();}
		break;

		case 'off_sub':
			$p = "UPDATE tbl_sub_penyiapan SET status_kunci='0' WHERE id_sub_penyi='$_GET[page]'";
			if(mysql_query($p)){header("location:../../../dashboard.php?md=$_GET[md]&b=off_sub#tbl_sub_penyi");}else{echo "gagal<br>".mysql_error();}
		break;

		
		default:
			header("location:../../../dashboard.php");
			break;
	}

?>

