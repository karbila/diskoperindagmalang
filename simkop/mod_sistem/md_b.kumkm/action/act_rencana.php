<?php  
	//error_reporting(0);
	session_start();
	include "../../../../konfigurasi/conf-db/dbautentikasi.php";
	include "../../../../konfigurasi/function/fungsi_indotgl.php";
	$md = $_POST['h_idkeg'];
	$nama = $_FILES['up_detail']['name'];
	$ukuran = $_FILES['up_detail']['size'];
	$tipe_file = $_FILES['up_detail']['type'];
	$lokasilm = $_FILES['up_detail']['tmp_name'];
	$rand = rand(0000,9999);
	$lokasi = "../../../doc/";
	$nmrand = "$_POST[h_idkeg]_".$rand."_".$nama;
	$tg = date('Y-m-d');
	$uang = str_replace(",", "", $_POST['ang']);

	switch ($_GET['ac']) {
		//kabid kumkm
		case 'ins':	
			$mulai = indotodb($_POST['s']);		
			$selesai = indotodb($_POST['f']);
			

			if(empty($nama)){
				//echo "anda tidak mengupload dokumen";
				$r = "INSERT INTO dokumen (id_dok, nama_dok, tanggal_upload, ukuran, tipe_file) VALUES ('', 'Tidak Ada Dokumen', '$tg', '-', '-')";
				mysql_query($r);
				//cari id dokumen
				$u = mysql_fetch_array(mysql_query("SELECT MAX(id_dok) as id_terakhir FROM dokumen"));			

				$r = "INSERT INTO tbl_rencana (id_rencana, kode_ren, nama_keg_ren, mulai_ren, selesai_ren, tempat_ren, anggaran_ren, desk_ren, id_pegawai, id_dok, status_proses, status_kunci, owner) VALUES ('', '$_POST[no]', '$_POST[nm]', '$mulai', '$selesai', '$_POST[tp]', '$uang', '$_POST[dk]', '$_POST[np]', '$u[id_terakhir]', '0', '0', '$_SESSION[iduser]')";
				
				if(mysql_query($r)==true){					
					header("location:../../../dashboard.php?md=$md&s=az");
				}else{
					echo "gagal<br>".mysql_error();
				}

			}elseif($tipe_file!="text/plain" && $tipe_file!="application/pdf" && $tipe_file!="application/octet-stream" && $tipe_file!="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" && $tipe_file!="application/vnd.openxmlformats-officedocument.wordprocessingml.document" && $tipe_file!="application/vnd.openxmlformats-officedocument.presentationml.presentation" && $tipe_file!="application/msword" && $tipe_file!="application/vnd.openxmlformats-officedocument" && $tipe_file!="application/vnd.ms-excel" && $tipe_file!="application/octet-stream" && $tipe_file!="application/vnd.ms-powerpoint"){
				
				header("location:../../../dashboard.php?md=$md&s=st");

			}elseif(move_uploaded_file($lokasilm, "$lokasi$nmrand")){						
				$name_file= str_replace(array("/", "\\", ":", "*", "?", '"', "<", ">", "|", " "), "_", $nmrand);			
				rename($lokasi.$nmrand, $lokasi.$name_file);
				//echo "$lokasi$name_file";			
				$r = "INSERT INTO dokumen (id_dok, nama_dok, tanggal_upload, ukuran, tipe_file) VALUES ('', '$name_file', '$tg', '$ukuran', '$tipe_file')";
				mysql_query($r);
				//cari id dokumen
				$u = mysql_fetch_array(mysql_query("SELECT MAX(id_dok) as id_terakhir FROM dokumen"));

				$r = "INSERT INTO tbl_rencana (id_rencana, kode_ren, nama_keg_ren, mulai_ren, selesai_ren, tempat_ren, anggaran_ren, desk_ren, id_pegawai, id_dok, status_proses, status_kunci, owner) VALUES ('', '$_POST[no]', '$_POST[nm]', '$mulai', '$selesai', '$_POST[tp]', '$uang', '$_POST[dk]', '$_POST[np]', '$u[id_terakhir]', '0', '0', '$_SESSION[iduser]')";				
				if(mysql_query($r)==true){
					//echo "oke";
					header("location:../../../dashboard.php?md=$md&s=az");
				}else{
					echo "gagal<br>".mysql_error();
				}
			}
		break;

		case 'upd':
			$mulai = indotodb($_POST['s']);		
			$selesai = indotodb($_POST['f']);
			//cari dokumen dari tabel tbl_rencana
				$o = mysql_fetch_array(mysql_query("SELECT d.id_dok, d.nama_dok FROM dokumen d, tbl_rencana r WHERE d.id_dok=r.id_dok AND r.id_rencana='$_POST[id_ren]'"));
				$lokasi = "../../../doc/";
				$namfilelama = $o['nama_dok'];
				$ll = $lokasi.$namfilelama;

				//jika user gak ngganti dokumen, maka dok gak usah diupdate
				if(empty($nama)){					
					$p = "UPDATE tbl_rencana SET kode_ren = '$_POST[no]', nama_keg_ren = '$_POST[nm]', mulai_ren = '$mulai', selesai_ren = '$selesai', tempat_ren = '$_POST[tp]', anggaran_ren = '$uang', desk_ren = '$_POST[dk]', id_pegawai = '$_POST[np]' WHERE tbl_rencana.id_rencana = '$_POST[id_ren]' ";
						if(mysql_query($p)==true){
							header("location:../../../dashboard.php?md=$md&s=dp");
						}else{
							echo "gagal<br>".mysql_error();
						}
				//jika user mengganti dokumennya
				}elseif(!empty($nama)){
					//cek data yang dokumennya kosong -> pada waktu insert awal user gak mengupload dokumen

					if($namfilelama=='Tidak Ada Dokumen'){
						//aksi update dokumen hanya mode db dan update data
						if($tipe_file!="text/plain" && $tipe_file!="application/pdf" && $tipe_file!="application/octet-stream" && $tipe_file!="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" && $tipe_file!="application/vnd.openxmlformats-officedocument.wordprocessingml.document" && $tipe_file!="application/vnd.openxmlformats-officedocument.presentationml.presentation" && $tipe_file!="application/msword" && $tipe_file!="application/vnd.openxmlformats-officedocument" && $tipe_file!="application/vnd.ms-excel" && $tipe_file!="application/vnd.ms-powerpoint"){
							
							header("location:../../../dashboard.php?md=$md&s=st");

						}elseif(move_uploaded_file($lokasilm, "$lokasi$nmrand")){						
							$name_file= str_replace(array("/", "\\", ":", "*", "?", '"', "<", ">", "|","'" ," "), "_", $nmrand);
							rename($lokasi.$nmrand, $lokasi.$name_file);						
							// update dokumen 						
							$r = "UPDATE  dokumen SET  nama_dok =  '$name_file', tanggal_upload =  '$tg', ukuran =  '$ukuran', tipe_file =  '$tipe_file' WHERE  dokumen.id_dok = '$o[0]' ";
							if(mysql_query($r) == true){
								//update data tanpa merubah id_doknya => karena id tetap di tabel rencana, yang diupdate itu yang di tabel dokumennya.						
								$p = "UPDATE tbl_rencana SET kode_ren = '$_POST[no]', nama_keg_ren = '$_POST[nm]', mulai_ren = '$mulai', selesai_ren = '$selesai', tempat_ren = '$_POST[tp]', anggaran_ren = '$uang', desk_ren = '$_POST[dk]', id_pegawai = '$_POST[np]' WHERE tbl_rencana.id_rencana = '$_POST[id_ren]' ";
									if(mysql_query($p)==true){
										header("location:../../../dashboard.php?md=$md&s=dp");
									}else{
										echo "gagal<br>".mysql_error();
									}
							}else{
								echo "gagal update dokumen<br>$r";
							}						
						}
					// bila dokumennya sudah ada dulu
					}else{
						// namun bila user telah sudah mengupload dokumen sebelumnya maka
						if($tipe_file!="text/plain" && $tipe_file!="application/pdf" && $tipe_file!="application/octet-stream" && $tipe_file!="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" && $tipe_file!="application/vnd.openxmlformats-officedocument.wordprocessingml.document" && $tipe_file!="application/vnd.openxmlformats-officedocument.presentationml.presentation" && $tipe_file!="application/msword" && $tipe_file!="application/vnd.openxmlformats-officedocument" && $tipe_file!="application/vnd.ms-excel" && $tipe_file!="application/vnd.ms-powerpoint"){
						
						header("location:../../../dashboard.php?md=$md&s=st");

						//cek apakah masih ada nih dokumen yang dulu di server, ntr tiba2 gak ada karena kena virus lagi.... :(
						}elseif(file_exists($ll)){
							//kalo Y, maka del...
							unlink($ll);						
							// upload dokumen 
							move_uploaded_file($lokasilm, "$lokasi$nmrand");
							$name_file= str_replace(array("/", "\\", ":", "*", "?", '"', "<", ">", "|","'" ," "), "_", $nmrand);
							rename($lokasi.$nmrand, $lokasi.$name_file);						
							// update dokumen 						
							$r = "UPDATE  dokumen SET  nama_dok =  '$name_file', tanggal_upload =  '$tg', ukuran =  '$ukuran', tipe_file =  '$tipe_file' WHERE  dokumen.id_dok = '$o[0]' ";
							if(mysql_query($r) == true){
								//update data						
								$p = "UPDATE tbl_rencana SET kode_ren = '$_POST[no]', nama_keg_ren = '$_POST[nm]', mulai_ren = '$mulai', selesai_ren = '$selesai', tempat_ren = '$_POST[tp]', anggaran_ren = '$uang', desk_ren = '$_POST[dk]', id_pegawai = '$_POST[np]' WHERE tbl_rencana.id_rencana = '$_POST[id_ren]' ";
									if(mysql_query($p)==true){
										header("location:../../../dashboard.php?md=$md&s=dp");
									}else{
										echo "gagal<br>".mysql_error();
									}
							}else{
								echo "gagal update dokumen<br>$r";
							}						
						}else{							
							echo "dokumen kamu hilang... :(";
						}
					}
	
				}		
		break;

		case 'dl':
				$id = $_GET['kd'];
				//cari dokumen
				$o = mysql_fetch_array(mysql_query("SELECT d.id_dok, d.nama_dok FROM dokumen d, tbl_rencana r WHERE d.id_dok=r.id_dok AND r.id_rencana='$id'"));
				$r = mysql_fetch_array(mysql_query("SELECT nama_dok FROM dokumen WHERE id_dok = '$o[0]'"));
				$lokasi = "../../../doc/";
				$h = $lokasi.$r[0];
				if($r[0]!="Tidak Ada Dokumen"){
					unlink($h);	
				}elseif($r[0]=="Tidak Ada Dokumen"){
					echo "";
				}
				
				$d = "DELETE FROM tbl_rencana WHERE id_rencana = '$id'"; //del dulu yang pake dokumennya...
				if(mysql_query($d)==true){
					mysql_query("DELETE FROM dokumen WHERE id_dok = '$o[0]'");
					header("location:../../../dashboard.php?md=$_GET[md]&s=ck#tbl_rencana");
				}else{
					echo "gagal";
				}
		break;

		case 'on':
			$p = "UPDATE tbl_rencana SET status_kunci='1' WHERE id_rencana='$_GET[page]'";
			if(mysql_query($p)){header("location:../../../dashboard.php?md=$_GET[md]&s=on#tbl_rencana");}else{echo "gagal<br>".mysql_error();}
		break;

		case 'off':
			$p = "UPDATE tbl_rencana SET status_kunci='0' WHERE id_rencana='$_GET[page]'";
			if(mysql_query($p)){header("location:../../../dashboard.php?md=$_GET[md]&s=on#tbl_rencana");}else{echo "gagal<br>".mysql_error();}
		break;

		

		default:
			header("location:../../../dashboard.php");
			break;
	}




?>