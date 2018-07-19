<?php  
	error_reporting(0);
	session_start();
	include "../../../konfigurasi/conf-db/dbautentikasi.php";
	include "../../../konfigurasi/function/fungsi_indotgl.php";	
	
	if(!empty($_POST['id'])){
		$u = mysql_query("SELECT id_rencana FROM tbl_rencana WHERE kode_ren = '$_POST[id]'");
		$jum = mysql_num_rows($u);
		echo "$jum";
		
	}elseif(!empty($_POST['kdpenyi'])){
		$u = mysql_query("SELECT id_penyiapan FROM tbl_penyiapan WHERE kode_penyi ='$_POST[kdpenyi]'");
		$jum = mysql_num_rows($u);
		echo "$jum";

	//cek nomor pelaksanaan
	}elseif(!empty($_POST['kdlaksana'])){
		$u = mysql_query("SELECT id_pelaksanaan FROM tbl_pelaksanaan WHERE kode_laksana ='$_POST[kdlaksana]'");
		$jum = mysql_num_rows($u);
		echo "$jum";

	
	//cek nomor pengawasan
	}elseif(!empty($_POST['kdpenga'])){
		$u = mysql_query("SELECT id_pengawasan FROM tbl_pengawasan WHERE kode_penga ='$_POST[kdpenga]'");
		$jum = mysql_num_rows($u);
		echo "$jum";

	}

	elseif(!empty($_POST['idperen'])){
		$e = mysql_fetch_array(mysql_query("SELECT r.mulai_ren, r.selesai_ren, r.anggaran_ren, r.nama_keg_ren, j.nama_jab, r.tempat_ren FROM tbl_rencana r, jabatan j, pegawai p WHERE p.id_pegawai=r.id_pegawai AND p.id_jab=j.id_jab AND id_rencana='$_POST[idperen]'"));
		$p1 = dbtoindo($e['mulai_ren']);
		$p2 = dbtoindo($e['selesai_ren']);
		$uang = number_format($e[2],2,",",".");
		echo "<div class='alert alert-info'><strong>Informasi Data Perencanaan <b style='color:#000;'>$e[3]</b></strong>
		<ol>
		<li>Tanggal Mulai Perencanaan = <strong>$p1</strong></li>
		<li>Tanggal Selesai Perencanaan = <strong>$p2</strong></li>
		<li>Anggaran Perencanaan = <strong>Rp. $uang</strong></li>
		<li>PJ Perencanaan = <strong>$e[4]</strong></li>
		<li>Tempat Perencanaan = <strong>$e[5]</strong></li>
		</ol>
		<div>";
		
	}
	elseif(!empty($_POST['idpenyi'])){
		$bb = "Penyiapan";
		$e = mysql_fetch_array(mysql_query("SELECT r.tgl_mulai_penyi1, r.tgl_selesai_penyi1, r.anggaran, r.nama_kegiatan_penyi, j.nama_jab, r.tempat_penyi FROM tbl_penyiapan r, jabatan j, tbl_rencana y, pegawai p WHERE y.id_rencana=r.id_rencana AND j.id_jab=p.id_jab AND p.id_pegawai=r.id_pegawai AND r.id_penyiapan='$_POST[idpenyi]'"));
		$p1 = dbtoindo($e['tgl_mulai_penyi1']);
		$p2 = dbtoindo($e['tgl_selesai_penyi1']);
		$uang = number_format($e[2],2,",",".");
		echo "<div class='alert alert-info'><strong>Informasi Data $bb <b style='color:#000;'>$e[3]</b></strong>
		<ol>
		<li>Tanggal Mulai $bb = <strong>$p1</strong></li>
		<li>Tanggal Selesai $bb = <strong>$p2</strong></li>
		<li>Anggaran $bb = <strong>Rp. $uang</strong></li>
		<li>PJ $bb = <strong>$e[4]</strong></li>
		<li>Tempat $bb = <strong>$e[5]</strong></li>
		</ol>
		<div>";
		
	}
	
	elseif(!empty($_POST['idpelak'])){
		$bb = "Pelaksanaan";
		$e = mysql_fetch_array(mysql_query("SELECT l.nama_laksana, l.tgl_m_lak, l.tgl_s_lak, l.ang_lak, j.nama_jab, l.tempat_lak
                              FROM tbl_pelaksanaan l, tbl_penyiapan py, tbl_sub_penyiapan s, dokumen d, jabatan j, pegawai p
                              WHERE l.id_dok = d.id_dok
                              AND l.id_sub_penyi = s.id_sub_penyi
                              AND j.id_jab = p.id_jab
                              AND p.id_pegawai = l.id_pegawai
                              AND s.id_penyiapan = py.id_penyiapan AND l.id_pelaksanaan = '$_POST[idpelak]'"));
		$p1 = dbtoindo($e['tgl_m_lak']);
		$p2 = dbtoindo($e['tgl_s_lak']);
		$uang = number_format($e['ang_lak'],2,",",".");
		echo "<div class='alert alert-info'><strong>Informasi Data $bb <b style='color:#000;'>$e[nama_laksana]</b></strong>
		<ol>
		<li>Tanggal Mulai $bb = <strong>$p1</strong></li>
		<li>Tanggal Selesai $bb = <strong>$p2</strong></li>
		<li>Anggaran $bb = <strong>Rp. $uang</strong></li>
		<li>PJ $bb = <strong>$e[nama_jab]</strong></li>
		<li>Tempat $bb = <strong>$e[tempat_lak]</strong></li>
		</ol>
		<div>";
		
	}


?>