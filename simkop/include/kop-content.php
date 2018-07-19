<?php
	$alert = "<div class='alert alert-warning'><strong>Maaf, Modul Belum Ada --> $_GET[md]</strong></div>"; 

	// GET UTAMA
	$koperasi = "$_GET[md]";
	
	// yang sudah bisa diakses adalah id 1(admin), 3(kadin), 4(kabidkumkm), 8(kasikop), 13(stafkop)
	// namun setelah dipikir-pikir yang jadi acuan bukan id user namun id jab
	/*
	1 = admin
	2 = kadin
	3 = kabidkumkm
	7 = kasikop
	11 = stafkop
	*/
	switch ($_SESSION['idjab']) {
		case 1: //admin
			switch ($koperasi) {
				case "modul": include 'mod_sistem/md_adminkop/adm_modul.php'; break; 
				case "user": include 'mod_sistem/md_adminkop/adm_user.php'; break;
				case "men1": include 'mod_sistem/md_adminkop/adm_menuut.php'; break;
				case "men2": include 'mod_sistem/md_adminkop/adm_submenu.php'; break;
				case "news": include 'mod_sistem/md_adminkop/adm_berita.php'; break;
				case "katnews": include 'mod_sistem/md_adminkop/adm_katagori.php'; break;	

				//baru
				case "aktif": include 'mod_sistem/md_adminkop/action/act_user_status.php';

				default:
					?>
						<div class="hero-unit">
			            <h2>Selamat Datang <?php echo "<span style='color:#FF1010;'><strong>$_SESSION[namalengkap]</strong></span> &raquo; $_SESSION[iduser]<br>Anda Masuk sebagai <strong>$_SESSION[namajab] ($_SESSION[idjab])</strong>"; ?></h2>
			            <p>Anda mendapatkan hak akses:
			            	<ol>
			            		<li><a href="?md=men1">Setting Menu Utama</a></li>
			            		<li><a href="?md=men2">Setting Sub Menu (level 1)</a></li>
			            		<li><a href="?md=modul">Setting Modul (level 2)</a></li>
			            		<li><a href="?md=user">Manajemen User</a></li>
			            	</ol>
			            </p>
			         	</div>

					<?php
				break;
			}
		break;
		
		case 2: //kadin
			switch ($koperasi) {
				case "peren4": include "mod_sistem/md_b.kumkm/kadin_perencanaan.php"; break; //ok			
				case "penyi4": include "mod_sistem/md_b.kumkm/kadin_persiapan.php"; break;
				case "pelak4": include "mod_sistem/md_b.kumkm/kadin_pelaksanaan.php"; break; 
				case "penga4": include "mod_sistem/md_b.kumkm/kadin_pengawasan.php"; break;

				case "eval4": include "mod_sistem/md_b.kumkm/kadin_evaluasi.php"; break;
				case "lapor4": include "mod_sistem/md_b.kumkm/kadin_lap.php"; break;
				// untuk semua akses
				case "detil": include "mod_sistem/md_b.kumkm/staf_detil_perencanaan.php"; break;
				case "det_lak": include "mod_sistem/md_b.kumkm/staf_detil_pelaksanaan.php"; break;
				case "detilhitung": include "mod_sistem/md_b.kumkm/detil_hitung.php"; break;
				// not in
				case "perennotin": include 'mod_sistem/md_b.kumkm/perencanaan_not_in.php'; break;
				case "penyinotin": include 'mod_sistem/md_b.kumkm/penyiapan_not_in.php'; break;
				case "pelaknotin": include 'mod_sistem/md_b.kumkm/pelaksanaan_not_in.php'; break;

				// detil dashboard
				case "detildashperensu": include 'mod_sistem/md_b.kumkm/content-depan/detildashperensu.php'; break;
				case "detildashperenbel": include 'mod_sistem/md_b.kumkm/content-depan/detildashperenbel.php'; break;
				case "detildashpelak": include 'mod_sistem/md_b.kumkm/content-depan/detildashpelak.php'; break;
				case "detildashreal": include 'mod_sistem/md_b.kumkm/content-depan/detildashreal.php'; break;
				case "detildashpenga": include 'mod_sistem/md_b.kumkm/content-depan/detildashpenga.php'; break;								
				default: include 'mod_sistem/md_b.kumkm/content-depan/dash-kadin.php';break;
			}
		break;

		case 3: //kabidkumkm
			switch ($koperasi) {
				case "peren1": include "mod_sistem/md_b.kumkm/kabid_perencanaan.php"; break; 			
				case "penyi1": include "mod_sistem/md_b.kumkm/kabid_persiapan.php"; break; 
				case "pelak1": include "mod_sistem/md_b.kumkm/kabid_pelaksanaan.php"; break; 
				case "penga1": include "mod_sistem/md_b.kumkm/kabid_pengawasan.php"; break;
				case "eval1": include "mod_sistem/md_b.kumkm/kabid_evaluasi.php"; break;
				case "lapor1": include "mod_sistem/md_b.kumkm/kabid_monitoring.php"; break;
				// untuk semua akses
				case "detil": include "mod_sistem/md_b.kumkm/staf_detil_perencanaan.php"; break;
				case "det_lak": include "mod_sistem/md_b.kumkm/staf_detil_pelaksanaan.php"; break;
				case "detilhitung": include "mod_sistem/md_b.kumkm/detil_hitung.php"; break;
				// not in
				case "perennotin": include 'mod_sistem/md_b.kumkm/perencanaan_not_in.php'; break;
				case "penyinotin": include 'mod_sistem/md_b.kumkm/penyiapan_not_in.php'; break;
				case "pelaknotin": include 'mod_sistem/md_b.kumkm/pelaksanaan_not_in.php'; break;

				// detil dashboard
				case "detildashperensu": include 'mod_sistem/md_b.kumkm/content-depan/detildashperensu.php'; break;
				case "detildashperenbel": include 'mod_sistem/md_b.kumkm/content-depan/detildashperenbel.php'; break;
				case "detildashpelak": include 'mod_sistem/md_b.kumkm/content-depan/detildashpelak.php'; break;
				case "detildashreal": include 'mod_sistem/md_b.kumkm/content-depan/detildashreal.php'; break;
				case "detildashpenga": include 'mod_sistem/md_b.kumkm/content-depan/detildashpenga.php'; break;
				
				default: include 'mod_sistem/md_b.kumkm/content-depan/dash-kabid.php';
			}
		break;

		case 7: //kasikop
			switch ($koperasi) {
				case "peren2": include "mod_sistem/md_b.kumkm/kasi_perencanaan.php"; break; 			
				case "penyi2": include "mod_sistem/md_b.kumkm/kasi_persiapan.php"; break;
				case "pelak2": include "mod_sistem/md_b.kumkm/kasi_pelaksanaan.php"; break; 
				case "penga2": include "mod_sistem/md_b.kumkm/kasi_pengawasan.php"; break;
				case "eval2": include "mod_sistem/md_b.kumkm/kasi_evaluasi.php"; break;
				case "lapor2": include "mod_sistem/md_b.kumkm/kasi_monitoring.php"; break;
				// untuk semua akses
				case "detil": include "mod_sistem/md_b.kumkm/staf_detil_perencanaan.php"; break;
				case "det_lak": include "mod_sistem/md_b.kumkm/staf_detil_pelaksanaan.php"; break;
				case "detilhitung": include "mod_sistem/md_b.kumkm/detil_hitung.php"; break;
				// not in
				case "perennotin": include 'mod_sistem/md_b.kumkm/perencanaan_not_in.php'; break;
				case "penyinotin": include 'mod_sistem/md_b.kumkm/penyiapan_not_in.php'; break;
				case "pelaknotin": include 'mod_sistem/md_b.kumkm/pelaksanaan_not_in.php'; break;

				// detil dashboard
				case "detildashperensu": include 'mod_sistem/md_b.kumkm/content-depan/detildashperensu.php'; break;
				case "detildashperenbel": include 'mod_sistem/md_b.kumkm/content-depan/detildashperenbel.php'; break;
				case "detildashpelak": include 'mod_sistem/md_b.kumkm/content-depan/detildashpelak.php'; break;
				case "detildashreal": include 'mod_sistem/md_b.kumkm/content-depan/detildashreal.php'; break;
				case "detildashpenga": include 'mod_sistem/md_b.kumkm/content-depan/detildashpenga.php'; break;
				
				default: include 'mod_sistem/md_b.kumkm/content-depan/dash-stafkop.php'; break;
			}
		break;

		case 11: //stafkop
			switch ($koperasi) {
				case "peren3": include "mod_sistem/md_b.kumkm/staf_perencanaan.php"; break; 			
				case "penyi3": include "mod_sistem/md_b.kumkm/staf_persiapan.php"; break;
				case "pelak3": include "mod_sistem/md_b.kumkm/staf_pelaksanaan.php"; break; 
				case "penga3": include "mod_sistem/md_b.kumkm/staf_pengawasan.php"; break;
				case "eval3": include "mod_sistem/md_b.kumkm/staf_evaluasi.php"; break;
				case "lapor3": include "mod_sistem/md_b.kumkm/staf_laporan.php"; break;				
				case "detil": include "mod_sistem/md_b.kumkm/staf_detil_perencanaan.php"; break;
				case "det_lak": include "mod_sistem/md_b.kumkm/staf_detil_pelaksanaan.php"; break;
				case "detilhitung": include "mod_sistem/md_b.kumkm/detil_hitung.php"; break;				
				case "perennotin": include 'mod_sistem/md_b.kumkm/perencanaan_not_in.php'; break;
				case "penyinotin": include 'mod_sistem/md_b.kumkm/penyiapan_not_in.php'; break;
				case "pelaknotin": include 'mod_sistem/md_b.kumkm/pelaksanaan_not_in.php'; break;
				// detil dashboard
				case "detildashperensu": include 'mod_sistem/md_b.kumkm/content-depan/detildashperensu.php'; break;
				case "detildashperenbel": include 'mod_sistem/md_b.kumkm/content-depan/detildashperenbel.php'; break;
				case "detildashpelak": include 'mod_sistem/md_b.kumkm/content-depan/detildashpelak.php'; break;
				case "detildashreal": include 'mod_sistem/md_b.kumkm/content-depan/detildashreal.php'; break;
				case "detildashpenga": include 'mod_sistem/md_b.kumkm/content-depan/detildashpenga.php'; break;
				default: include 'mod_sistem/md_b.kumkm/content-depan/dash-stafkop.php'; break;
			}
		break;
		
		default:
			echo ":) Anda Siapa ?";
			break;
	}

?>