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

	$mulai = indotodb($_POST['s']);		
	$selesai = indotodb($_POST['f']);

	$uang = str_replace(",", "", $_POST['ang_penga']);

	switch ($_GET['ac']) {
		
		//PENGAWASAN
		case "awas_ins":		
			if(empty($nama)){
				//echo "anda tidak mengupload dokumen";
				$r = "INSERT INTO dokumen (id_dok, nama_dok, tanggal_upload, ukuran, tipe_file) VALUES ('', 'Tidak Ada Dokumen', '$tg', '-', '-')";
				mysql_query($r);
				//cari id dokumen
				$u = mysql_fetch_array(mysql_query("SELECT MAX(id_dok) as id_terakhir FROM dokumen"));			

				$r = "INSERT INTO tbl_pengawasan (id_pengawasan, kode_penga, nama_penga, tgl_awal_penga, tgl_akhir_penga, tempat_penga, detil_penga, ang_penga, hasil_penga, cat_penga, cat_penga2, id_dok, id_sub_pelak, id_pegawai, status_proses, status_kunci, owner) VALUES ('', '$_POST[no_penga]', '$_POST[nm_penga]', '$mulai', '$selesai', '$_POST[tp_penga]', '$_POST[des1]', '$uang', '$_POST[des2]', '$_POST[des3]','$_POST[des4]' , '$u[0]', '$_POST[nm_sub]', '$_POST[np]', '0', '0', '$_SESSION[iduser]')";
				
				if(mysql_query($r)){header("location:../../../dashboard.php?md=$md&s=az");}else{echo "gagal<br>".mysql_error();}

			}elseif($tipe_file!="text/plain" && $tipe_file!="application/pdf" && $tipe_file!="application/octet-stream" && $tipe_file!="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" && $tipe_file!="application/vnd.openxmlformats-officedocument.wordprocessingml.document" && $tipe_file!="application/vnd.openxmlformats-officedocument.presentationml.presentation" && $tipe_file!="application/msword" && $tipe_file!="application/vnd.openxmlformats-officedocument" && $tipe_file!="application/vnd.ms-excel" && $tipe_file!="application/octet-stream" && $tipe_file!="application/vnd.ms-powerpoint"){
				
				header("location:../../../dashboard.php?md=$md&s=st");

			}elseif(move_uploaded_file($lokasilm, "$lokasi$nmrand")){						
				$name_file= str_replace(array("/", "\\", ":", "*", "?", '"', "<", ">", "|", " "), "_", $nmrand);			
				rename($lokasi.$nmrand, $lokasi.$name_file);
				//echo "$lokasi$name_file";			
				$l = "INSERT INTO dokumen (id_dok, nama_dok, tanggal_upload, ukuran, tipe_file) VALUES ('', '$name_file', '$tg', '$ukuran', '$tipe_file')";
				mysql_query($l);
				//cari id dokumen
				$u = mysql_fetch_array(mysql_query("SELECT MAX(id_dok) as id_terakhir FROM dokumen"));

				$r = "INSERT INTO tbl_pengawasan (id_pengawasan, kode_penga, nama_penga, tgl_awal_penga, tgl_akhir_penga, tempat_penga, detil_penga, ang_penga, hasil_penga, cat_penga,cat_penga2, id_dok, id_sub_pelak, id_pegawai, status_proses, status_kunci, owner) VALUES ('', '$_POST[no_penga]', '$_POST[nm_penga]', '$mulai', '$selesai', '$_POST[tp_penga]', '$_POST[des1]', '$uang', '$_POST[des2]', '$_POST[des3]','$_POST[des4]', '$u[0]', '$_POST[nm_sub]', '$_POST[np]', '0', '0', '$_SESSION[iduser]')";
				//echo "$r";

				if(mysql_query($r)==true){header("location:../../../dashboard.php?md=$md&s=az");}else{echo "gagal<br>".mysql_error();}
			}
		break;

		case "awas_upd":		
				$o = mysql_fetch_array(mysql_query("SELECT d.id_dok, d.nama_dok FROM dokumen d, tbl_pengawasan l WHERE d.id_dok=l.id_dok AND l.id_pengawasan='$_POST[idpenga]'"));
				$lokasi = "../../../doc/";
				$namfilelama = $o['nama_dok'];
				$ll = $lokasi.$namfilelama;

				//jika user gak ngganti dokumen, maka dok gak usah diupdate
				if(empty($nama)){
					//untuk di tabel pelaksanaan id_dok tidak boleh diupdate...
					$p = "UPDATE tbl_pengawasan SET kode_penga= '$_POST[no_penga]',nama_penga='$_POST[nm_penga]',tgl_awal_penga='$mulai',tgl_akhir_penga='$selesai',tempat_penga='$_POST[tp_penga]',detil_penga='$_POST[des1]',ang_penga='$uang',hasil_penga='$_POST[des2]',cat_penga='$_POST[des3]', id_sub_pelak='$_POST[nm_sub]',id_pegawai='$_POST[np]', cat_penga2='$_POST[des4]' WHERE id_pengawasan='$_POST[idpenga]'";
						if(mysql_query($p)==true){
							header("location:../../../dashboard.php?md=$md&s=dp");
						}else{
							echo "gagal<br>".mysql_error();
						}					
				//jika user mengganti dokumennya
				}elseif(!empty($nama)){
					//cek data yang dokumennya kosong -> pada waktu insert awal user gak mengupload dokumen

					if($namfilelama=='Tidak Ada Dokumen'){
						// cek tipe
						if($tipe_file!="text/plain" && $tipe_file!="application/pdf" && $tipe_file!="application/octet-stream" && $tipe_file!="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" && $tipe_file!="application/vnd.openxmlformats-officedocument.wordprocessingml.document" && $tipe_file!="application/vnd.openxmlformats-officedocument.presentationml.presentation" && $tipe_file!="application/msword" && $tipe_file!="application/vnd.openxmlformats-officedocument" && $tipe_file!="application/vnd.ms-excel" && $tipe_file!="application/vnd.ms-powerpoint"){
							
							header("location:../../../dashboard.php?md=$md&s=st");

						//jika tipe lolos maka upload file
						}elseif(move_uploaded_file($lokasilm, "$lokasi$nmrand")){						
							$name_file= str_replace(array("/", "\\", ":", "*", "?", '"', "<", ">", "|","'" ," "), "_", $nmrand);
							rename($lokasi.$nmrand, $lokasi.$name_file);						
							// update dokumen 						
							$r = "UPDATE  dokumen SET  nama_dok =  '$name_file', tanggal_upload =  '$tg', ukuran =  '$ukuran', tipe_file =  '$tipe_file' WHERE  dokumen.id_dok = '$o[0]' ";
							if(mysql_query($r) == true){
								// tanpa update id_dok
								$p = "UPDATE tbl_pengawasan SET kode_penga= '$_POST[no_penga]',nama_penga='$_POST[nm_penga]',tgl_awal_penga='$mulai',tgl_akhir_penga='$selesai',tempat_penga='$_POST[tp_penga]',detil_penga='$_POST[des1]',ang_penga='$uang',hasil_penga='$_POST[des2]',cat_penga='$_POST[des3]', id_sub_pelak='$_POST[nm_sub]',id_pegawai='$_POST[np]', cat_penga2='$_POST[des4]' WHERE id_pengawasan='$_POST[idpenga]'";
								if(mysql_query($p)==true){
									header("location:../../../dashboard.php?md=$md&s=dp");
								}else{
									echo "gagal<br>".mysql_error();
								}
								
							}else{
								echo "gagal update dokumen<br>$p";
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
								$p = "UPDATE tbl_pengawasan SET kode_penga= '$_POST[no_penga]',nama_penga='$_POST[nm_penga]',tgl_awal_penga='$mulai',tgl_akhir_penga='$selesai',tempat_penga='$_POST[tp_penga]',detil_penga='$_POST[des1]',ang_penga='$uang',hasil_penga='$_POST[des2]',cat_penga='$_POST[des3]', id_sub_pelak='$_POST[nm_sub]',id_pegawai='$_POST[np]', cat_penga2='$_POST[des4]' WHERE id_pengawasan='$_POST[idpenga]'";
								if(mysql_query($p)==true){
									header("location:../../../dashboard.php?md=$md&s=dp");
								}else{
									echo "gagal<br>".mysql_error();
								}					
								
							}else{
								echo "gagal update dokumen<br>$p";
							}						
						}else{							
							echo "dokumen kamu hilang... :(";
						}
					}
	
				}
		break;

		case "awas_del":
		// DELETE FROM tbl_pengawasan WHERE 1
				$id = $_GET['page'];
				//cari dokumen				
				$o = mysql_fetch_array(mysql_query("SELECT d.id_dok, d.nama_dok FROM dokumen d, tbl_pengawasan l WHERE d.id_dok=l.id_dok AND l.id_pengawasan='$id'"));				
				$lokasi = "../../../doc/";
				$h = $lokasi.$o['nama_dok'];
				if($o[1]!="Tidak Ada Dokumen"){
					unlink($h);	
				}elseif($o[1]=="Tidak Ada Dokumen"){
					echo "";
				}
				
				$d = "DELETE FROM tbl_pengawasan WHERE id_pengawasan = '$id'"; //del dulu yang pake dokumennya...
				if(mysql_query($d)==true){
					mysql_query("DELETE FROM dokumen WHERE id_dok = '$o[0]'");
					header("location:../../../dashboard.php?md=$_GET[md]&s=ck#tbl_penga");
				}else{
					echo "gagal";
				}
		break;

		//SUB PENGAWASAN
		case "sub_ins":
		
			$t = mysql_fetch_array(mysql_query("SELECT id_pengawasan FROM tbl_pengawasan WHERE kode_penga='$_POST[kp]'"));
			$g = "INSERT INTO tbl_sub_pengawasan (id_sub_penga, kode_sub_penga, nama_sub_penga, tgl_mulai_penga_sub, tgl_akhir_penga_sub, deskripsi_sub_penga, id_pengawasan, status_proses, status_kunci, owner) VALUES ('', '$_POST[idsub]', '$_POST[nmsub]', '$mulai', '$selesai', '$_POST[dk]', '$t[0]', '0', '0', '$_SESSION[iduser]')";
			if(mysql_query($g)){header("location:../../../dashboard.php?md=$md&s=sub_ins");}else{echo "gagal<br>".mysql_error();}
		break;

		case "sub_upd":		
			$t = mysql_fetch_array(mysql_query("SELECT id_pengawasan FROM tbl_pengawasan WHERE kode_penga='$_POST[kp]'"));
			$f = "UPDATE tbl_sub_pengawasan SET kode_sub_penga='$_POST[idsub]',nama_sub_penga='$_POST[nmsub]',tgl_mulai_penga_sub='$mulai',tgl_akhir_penga_sub='$selesai',deskripsi_sub_penga='$_POST[dk]',id_pengawasan='$t[0]' WHERE id_sub_penga='$_POST[kdo]'";
			if(mysql_query($f)){header("location:../../../dashboard.php?md=$md&s=sub_upd");}else{echo "gagal<br>".mysql_error();}
		break;

		case "sub_rm":
		// DELETE FROM tbl_sub_pengawasan WHERE 1
			$d = "DELETE FROM tbl_sub_pengawasan WHERE id_sub_penga = '$_GET[page]'";
			if(mysql_query($d)){header("location:../../../dashboard.php?md=$_GET[md]&b=ck#tbl_sub_penga");}else{echo "gagal<br>".mysql_error();}
		break;

		//ON OFF

		case 'on':
			$p = "UPDATE tbl_pengawasan SET status_kunci='1' WHERE id_pengawasan='$_GET[page]'";
			//echo "$p";
			if(mysql_query($p)){header("location:../../../dashboard.php?md=$_GET[md]&s=on#tbl_penga");}else{echo "gagal<br>".mysql_error();}
		break;

		case 'off':
			$p = "UPDATE tbl_pengawasan SET status_kunci='0' WHERE id_pengawasan='$_GET[page]'";
			if(mysql_query($p)){header("location:../../../dashboard.php?md=$_GET[md]&s=off#tbl_penga");}else{echo "gagal<br>".mysql_error();}
		break;

		case 'on_sub':
			$p = "UPDATE tbl_sub_pengawasan SET status_kunci='1' WHERE id_sub_penga='$_GET[page]'";
			if(mysql_query($p)){header("location:../../../dashboard.php?md=$_GET[md]&b=on_sub#tbl_sub_penga");}else{echo "gagal<br>".mysql_error();}
		break;

		case 'off_sub':
			$p = "UPDATE tbl_sub_pengawasan SET status_kunci='0' WHERE id_sub_penga='$_GET[page]'";
			if(mysql_query($p)){header("location:../../../dashboard.php?md=$_GET[md]&b=off_sub#tbl_sub_penga");}else{echo "gagal<br>".mysql_error();}
		break;

		default:
			header("location:../../../dashboard.php");
			break;
	}	

?>