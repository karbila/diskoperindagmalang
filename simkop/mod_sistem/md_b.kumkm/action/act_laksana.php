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
	$uang = str_replace(",", "", $_POST['ang_lak']);


	$mulai = indotodb($_POST['s']);		
	$selesai = indotodb($_POST['f']);

	switch ($_GET['ac']) {
		// AKSI PELAKSANAAN
		case "laksana_ins":
			$mulai = indotodb($_POST['s']);		
			$selesai = indotodb($_POST['f']);			

			if(empty($nama)){
				//echo "anda tidak mengupload dokumen";
				$r = "INSERT INTO dokumen (id_dok, nama_dok, tanggal_upload, ukuran, tipe_file) VALUES ('', 'Tidak Ada Dokumen', '$tg', '-', '-')";
				mysql_query($r);
				//cari id dokumen
				$u = mysql_fetch_array(mysql_query("SELECT MAX(id_dok) as id_terakhir FROM dokumen"));			

				$r = "INSERT INTO tbl_pelaksanaan (id_pelaksanaan, kode_laksana, nama_laksana, tgl_m_lak, tgl_s_lak, tempat_lak, des_lak, id_dok, ang_lak, id_pegawai, id_sub_penyi, status_proses, status_kunci, owner) VALUES ('', '$_POST[no_laksana]', '$_POST[nm_pelak]', '$mulai', '$selesai', '$_POST[tp_lak]', '$_POST[des_lak]', '$u[0]', '$uang', '$_POST[np]', '$_POST[nm_sub]', '0', '0', '$_SESSION[iduser]')";
				
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

				$r = "INSERT INTO tbl_pelaksanaan (id_pelaksanaan, kode_laksana, nama_laksana, tgl_m_lak, tgl_s_lak, tempat_lak, des_lak, id_dok, ang_lak, id_pegawai, id_sub_penyi, status_proses, status_kunci, owner) VALUES ('', '$_POST[no_laksana]', '$_POST[nm_pelak]', '$mulai', '$selesai', '$_POST[tp_lak]', '$_POST[des_lak]', '$u[0]', '$uang', '$_POST[np]', '$_POST[nm_sub]', '0', '0', '$_SESSION[iduser]')";
				if(mysql_query($r)==true){
					//echo "oke";
					header("location:../../../dashboard.php?md=$md&s=az");
				}else{
					echo "gagal<br>".mysql_error();
				}
			}
		break;

		case "laksana_upd":
			$mulai = indotodb($_POST['s']);	
			$selesai = indotodb($_POST['f']);
			//cari dokumen dari tabel tbl_pelaksanaan
				$o = mysql_fetch_array(mysql_query("SELECT d.id_dok, d.nama_dok FROM dokumen d, tbl_pelaksanaan l WHERE d.id_dok=l.id_dok AND l.id_pelaksanaan='$_POST[kode_pelak]'"));
				$lokasi = "../../../doc/";
				$namfilelama = $o['nama_dok'];
				$ll = $lokasi.$namfilelama;

				//jika user gak ngganti dokumen, maka dok gak usah diupdate
				if(empty($nama)){
					//untuk di tabel pelaksanaan id_dok tidak boleh diupdate...
					$p = "UPDATE tbl_pelaksanaan SET kode_laksana='$_POST[no_laksana]', nama_laksana= '$_POST[nm_pelak]',tgl_m_lak='$mulai',tgl_s_lak='$selesai',tempat_lak='$_POST[tp_lak]',des_lak='$_POST[des_lak]', ang_lak='$uang',id_pegawai= '$_POST[np]', id_sub_penyi='$_POST[nm_sub]' WHERE id_pelaksanaan='$_POST[kode_pelak]'";
					// echo "$p";
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
								$p = "UPDATE tbl_pelaksanaan SET kode_laksana='$_POST[no_laksana]', nama_laksana= '$_POST[nm_pelak]',tgl_m_lak='$mulai',tgl_s_lak='$selesai',tempat_lak='$_POST[tp_lak]',des_lak='$_POST[des_lak]', ang_lak='$uang',id_pegawai= '$_POST[np]',id_sub_penyi='$_POST[nm_sub]' WHERE id_pelaksanaan='$_POST[kode_pelak]'";
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
								$p = "UPDATE tbl_pelaksanaan SET kode_laksana='$_POST[no_laksana]', nama_laksana= '$_POST[nm_pelak]',tgl_m_lak='$mulai',tgl_s_lak='$selesai',tempat_lak='$_POST[tp_lak]',des_lak='$_POST[des_lak]', ang_lak='$uang', id_pegawai= '$_POST[np]',id_sub_penyi='$_POST[nm_sub]' WHERE id_pelaksanaan='$_POST[kode_pelak]'";
								if(mysql_query($p)==true){
									header("location:../../../dashboard.php?md=$md&s=dp");
								}else{
									echo "gagal<br>".mysql_error();
								}					
								
							}else{
								echo "gagal update dokumen<br>$p";
							}						
						}else{							
							echo "dokumen kamu hilang... :..(";
						}
					}
	
				}
		
		break;

		case "laksana_del":
				$id = $_GET['page'];
				//cari dokumen				
				$o = mysql_fetch_array(mysql_query("SELECT d.id_dok, d.nama_dok FROM dokumen d, tbl_pelaksanaan l WHERE d.id_dok=l.id_dok AND l.id_pelaksanaan='$id'"));				
				$lokasi = "../../../doc/";
				$h = $lokasi.$o['nama_dok'];
				if($o[1]!="Tidak Ada Dokumen"){
					unlink($h);	
				}elseif($o[1]=="Tidak Ada Dokumen"){
					echo "";
				}
				
				$d = "DELETE FROM tbl_pelaksanaan WHERE id_pelaksanaan = '$id'"; //del dulu yang pake dokumennya...
				if(mysql_query($d)==true){
					mysql_query("DELETE FROM dokumen WHERE id_dok = '$o[0]'");
					header("location:../../../dashboard.php?md=$_GET[md]&s=ck#tbl_pelak");
				}else{
					echo "gagal";
				}
		break;


		// AKSI SUB PELAKSANAAN
		case "sub_ins":
			$h = mysql_fetch_array(mysql_query("SELECT id_pelaksanaan FROM tbl_pelaksanaan WHERE kode_laksana='$_POST[kp]'"));
			$g = "INSERT INTO tbl_sub_pelaksanaan (id_sub_pelak, pelak_sub_nama, pelak_sub_mulai, pelak_sub_akhir, pelak_sub_kode, pelak_deskripsi, id_pelaksanaan, status_proses, status_kunci, owner) VALUES ('', '$_POST[nmsub]', '$mulai', '$selesai', '$_POST[idsub]', '$_POST[dk]', '$h[0]', '0', '0', '$_SESSION[iduser]')";
			if(mysql_query($g)){header("location:../../../dashboard.php?md=$md&s=sub_ins");}else{echo "gagal<br>".mysql_error();}
		break;

		case "sub_upd":
			$h = mysql_fetch_array(mysql_query("SELECT id_pelaksanaan FROM tbl_pelaksanaan WHERE kode_laksana='$_POST[kp]'"));
			$f = "UPDATE tbl_sub_pelaksanaan SET pelak_sub_nama='$_POST[nmsub]',pelak_sub_mulai='$mulai',pelak_sub_akhir='$selesai',pelak_sub_kode='$_POST[idsub]',pelak_deskripsi='$_POST[dk]',id_pelaksanaan='$h[0]' WHERE id_sub_pelak='$_POST[kdo]'";
			if(mysql_query($f)){header("location:../../../dashboard.php?md=$md&s=sub_upd");}else{echo "gagal<br>".mysql_error();}
		break;


		case "sub_rm":
			$d = "DELETE FROM tbl_sub_pelaksanaan WHERE id_sub_pelak = '$_GET[page]'";
			if(mysql_query($d)){header("location:../../../dashboard.php?md=$_GET[md]&b=ck#tbl_sub_pelak");}else{echo "gagal<br>".mysql_error();}
		break;



		//ON OFF

		case 'on':
			$p = "UPDATE tbl_pelaksanaan SET status_kunci='1' WHERE id_pelaksanaan='$_GET[page]'";
			//echo "$p";
			if(mysql_query($p)){header("location:../../../dashboard.php?md=$_GET[md]&s=on#tbl_pelak");}else{echo "gagal<br>".mysql_error();}
		break;

		case 'off':
			$p = "UPDATE tbl_pelaksanaan SET status_kunci='0' WHERE id_pelaksanaan='$_GET[page]'";
			if(mysql_query($p)){header("location:../../../dashboard.php?md=$_GET[md]&s=off#tbl_pelak");}else{echo "gagal<br>".mysql_error();}
		break;

		case 'on_sub':
			$p = "UPDATE tbl_sub_pelaksanaan SET status_kunci='1' WHERE id_sub_pelak='$_GET[page]'";
			if(mysql_query($p)){header("location:../../../dashboard.php?md=$_GET[md]&b=on_sub#tbl_sub_pelak");}else{echo "gagal<br>".mysql_error();}
		break;

		case 'off_sub':
			$p = "UPDATE tbl_sub_pelaksanaan SET status_kunci='0' WHERE id_sub_pelak='$_GET[page]'";
			if(mysql_query($p)){header("location:../../../dashboard.php?md=$_GET[md]&b=off_sub#tbl_sub_pelak");}else{echo "gagal<br>".mysql_error();}
		break;

		
		default:
			header("location:../../../dashboard.php");
			break;


	} //switch


	
?>