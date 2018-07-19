
<?php  	
	include "../../../konfigurasi/conf-db/dbautentikasi.php";
	include "../../../konfigurasi/function/fungsi_indotgl.php";	

	if(!empty($_GET['jb_pj'])){
		$y=mysql_query("SELECT p.id_pegawai, p.nama_pegawai, p.nomor_induk, j.id_jab, j.nama_jab FROM pegawai p, jabatan j WHERE p.id_jab=j.id_jab AND j.id_jab='$_GET[jb_pj]'");
		$jum=mysql_num_rows($y);
		if($jum==0){
		echo "<option value='0'>belum ada data</option>";	
		}else{			
			while ($ff=mysql_fetch_array($y)) {
				if($jum==1){
					echo "<option value='$ff[0]' selected>$ff[2] - $ff[1]</option>";
				}else{					
					echo "<option value='$ff[0]'>$ff[2] - $ff[1]</option>";
				}
			}	
		}
		
	}	
	elseif(!empty($_GET['siap'])){
		$o=mysql_query("SELECT s.id_sub_penyi, s.penyi_sub_nama FROM tbl_sub_penyiapan s, tbl_penyiapan py WHERE py.id_penyiapan=s.id_penyiapan AND py.id_penyiapan='$_GET[siap]'");
		$jum=mysql_num_rows($o);
		if($jum==0){
		echo "<option value='0'>belum ada sub</option>";
		}else{			
			while ($ff=mysql_fetch_array($o)) {
				if($jum==1){
					echo "<option value='$ff[0]' selected>$ff[1]</option>";
				}else{
					echo "<option value='$ff[0]'>$ff[1]</option>";
				}
			}	
		}
	}
	elseif(!empty($_GET['pelak'])){
		$o=mysql_query("SELECT s.id_sub_pelak, s.pelak_sub_nama FROM tbl_sub_pelaksanaan s, tbl_pelaksanaan l WHERE l.id_pelaksanaan = s.id_pelaksanaan AND l.id_pelaksanaan =  '$_GET[pelak]'");
		$jum=mysql_num_rows($o);
		if($jum==0){
		echo "<option value='0'>belum ada sub</option>";
		}else{			
			while ($ff=mysql_fetch_array($o)) {
				if($jum==1){
					echo "<option value='$ff[0]' selected>$ff[1]</option>";
				}else{
					echo "<option value='$ff[0]'>$ff[1]</option>";
				}
			}	
		}
	}


	//
	elseif(!empty($_GET['a'])){
		$ul = mysql_query("SELECT r.id_rencana, r.nama_keg_ren, pl.id_pelaksanaan, pl.nama_laksana, pl.tgl_m_lak, pl.tgl_s_lak, j.nama_jab, p.nama_pegawai
			FROM tbl_pelaksanaan pl
			JOIN tbl_sub_penyiapan sp ON sp.id_sub_penyi = pl.id_sub_penyi
			JOIN tbl_penyiapan py ON py.id_penyiapan = sp.id_penyiapan
			JOIN tbl_rencana r ON r.id_rencana = py.id_rencana
			JOIN pegawai p ON r.id_pegawai = p.id_pegawai
			JOIN jabatan j ON j.id_jab = p.id_jab
			WHERE MONTH( r.mulai_ren ) =  '$_GET[a]'
			AND YEAR( r.mulai_ren ) =  '$_GET[b]'
			GROUP BY r.id_rencana");		
		$no=1;
		$data='';
		$r = mysql_num_rows($ul);
		if($r==0){
			$data = "<tr><td colspan='5'>Tidak Ada Data</td></tr>";
		}else{
			while ($o = mysql_fetch_array($ul)) {
			$tg1 = dbtoindo($o['tgl_m_lak']);
			$tg2 = dbtoindo($o['tgl_s_lak']);
			
			$data .= "<tr>
			<td>$no</td>
			<td><a href='?md=detil&r=$o[id_rencana]' target='_blank'>$o[nama_keg_ren]</a></td>
			<td>$o[nama_laksana]</td>
			<td>Mulai:$tg1<br>Selesai:$tg2</td>
			<td>$o[nama_jab]</td></tr>";

			$no++;
			}		
		}
		
		echo json_encode($data);
		//print_r($data);die();
	}
	

	elseif(!empty($_GET['th'])){
		$t = mysql_query("SELECT b.id_bulan, b.nama_bulan
			FROM tbl_rencana r
			LEFT JOIN bulan b ON b.id_bulan = MONTH( r.mulai_ren ) 
			WHERE YEAR( r.mulai_ren ) =  '$_GET[th]'
			GROUP BY MONTH( r.mulai_ren ) ");
		$f = "<option value='0'>Pilih Bulan</option>";
		while ($r = mysql_fetch_array($t)) {
			$f .= "<option value='$r[0]'>$r[1]</option>";
		}
		echo json_encode($f);
	}

	///////////////////////////

	elseif(!empty($_GET['keg'])){
		//perencanaan atau emonev
		if($_GET['keg']==1 || $_GET['keg']==5){
			$tt = "SELECT b.id_bulan, b.nama_bulan
			FROM tbl_rencana r
			LEFT JOIN bulan b ON b.id_bulan = MONTH( r.mulai_ren ) 			
			GROUP BY MONTH( r.mulai_ren )";
			$t = mysql_query($tt);
			$f = "<option value='0'>Sekarang Pilih Bulan...</option>";
			while ($r = mysql_fetch_array($t)) {
				$f .= "<option value='$r[0]'>$r[1]</option>";
			}
			echo json_encode($f);			
		}elseif($_GET['keg']==2){
			$t = mysql_query("SELECT b.id_bulan, b.nama_bulan
			FROM tbl_penyiapan r
			LEFT JOIN bulan b ON b.id_bulan = MONTH( r.tgl_mulai_penyi1 ) 			
			GROUP BY MONTH( r.tgl_mulai_penyi1 )");
			$f = "<option value='0'>Sekarang Pilih Bulan...</option>";
			while ($r = mysql_fetch_array($t)) {
				$f .= "<option value='$r[0]'>$r[1]</option>";
			}
			echo json_encode($f);

		}elseif($_GET['keg']==3){
			$t = mysql_query("SELECT b.id_bulan, b.nama_bulan
			FROM tbl_pelaksanaan r
			LEFT JOIN bulan b ON b.id_bulan = MONTH( r.tgl_m_lak ) 			
			GROUP BY MONTH( r.tgl_m_lak )");
			$f = "<option value='0'>Sekarang Pilih Bulan...</option>";
			while ($r = mysql_fetch_array($t)) {
				$f .= "<option value='$r[0]'>$r[1]</option>";
			}
			echo json_encode($f);

		}elseif($_GET['keg']==4){
			$t = mysql_query("SELECT b.id_bulan, b.nama_bulan
			FROM tbl_pengawasan r
			LEFT JOIN bulan b ON b.id_bulan = MONTH( r.tgl_awal_penga ) 			
			GROUP BY MONTH( r.tgl_awal_penga )");
			$f = "<option value='0'>Sekarang Pilih Bulan...</option>";
			while ($r = mysql_fetch_array($t)) {
				$f .= "<option value='$r[0]'>$r[1]</option>";
			}
			echo json_encode($f);

		}
	}elseif(!empty($_GET['idbul']) && !empty($_GET['idkeg'])){		
		if($_GET['idkeg']==1 || $_GET['idkeg']==5){
			$t = mysql_query("SELECT YEAR( r.mulai_ren )
			FROM tbl_rencana r			
			GROUP BY YEAR( r.mulai_ren )");
			$f = "<option value='0'>Sekarang Pilih Tahun...</option>";
			while ($r = mysql_fetch_array($t)) {
				$f .= "<option value='$r[0]'>$r[0]</option>";
			}
			echo json_encode($f);
		}elseif($_GET['idkeg']==2){
			$t = mysql_query("SELECT YEAR( r.tgl_mulai_penyi1 )
			FROM tbl_penyiapan r			
			GROUP BY YEAR( r.tgl_mulai_penyi1 )");
			$f = "<option value='0'>Sekarang Pilih Tahun...</option>";
			while ($r = mysql_fetch_array($t)) {
				$f .= "<option value='$r[0]'>$r[0]</option>";
			}
			echo json_encode($f);

		}elseif($_GET['idkeg']==3){
			$t = mysql_query("SELECT YEAR( r.tgl_m_lak )
			FROM tbl_pelaksanaan r			
			GROUP BY YEAR( r.tgl_m_lak )");
			$f = "<option value='0'>Sekarang Pilih Tahun...</option>";
			while ($r = mysql_fetch_array($t)) {
				$f .= "<option value='$r[0]'>$r[0]</option>";
			}
			echo json_encode($f);

		}elseif($_GET['idkeg']==4){
			$t = mysql_query("SELECT YEAR( r.tgl_awal_penga )
			FROM tbl_pengawasan r			
			GROUP BY YEAR( r.tgl_awal_penga )");
			$f = "<option value='0'>Sekarang Pilih Tahun...</option>";
			while ($r = mysql_fetch_array($t)) {
				$f .= "<option value='$r[0]'>$r[0]</option>";
			}
			echo json_encode($f);

		}
	}






	elseif(!empty($_GET['h'])){
		$t = mysql_query("SELECT b.id_bulan, b.nama_bulan
			FROM tbl_pelaksanaan r
			LEFT JOIN bulan b ON b.id_bulan = MONTH( r.tgl_m_lak ) 
			WHERE YEAR( r.tgl_m_lak ) =  '$_GET[h]'
			GROUP BY MONTH( r.tgl_m_lak ) ");
		$f = "<option value='0'>Pilih Bulan</option>";
		while ($r = mysql_fetch_array($t)) {
			$f .= "<option value='$r[0]'>$r[1]</option>";
		}
		echo json_encode($f);
	}
	elseif(!empty($_GET['bulan'])){
		$ul = mysql_query("SELECT pl.id_pelaksanaan, pl.nama_laksana, j.nama_jab, pg.tgl_awal_penga, pg.tgl_akhir_penga	
		    FROM tbl_pelaksanaan pl
		    JOIN tbl_sub_pelaksanaan spl ON spl.id_pelaksanaan = pl.id_pelaksanaan
		    JOIN tbl_pengawasan pg ON pg.id_sub_pelak=spl.id_sub_pelak
		    JOIN pegawai p ON p.id_pegawai=pg.id_pegawai
		    JOIN jabatan j ON j.id_jab=p.id_jab
		    WHERE MONTH( pl.tgl_m_lak )='$_GET[bulan]'
			AND YEAR( pl.tgl_m_lak )='$_GET[tahun]'
			GROUP BY pl.id_pelaksanaan");

		$r = mysql_num_rows($ul);
		if($r==0){
			$uu = "<tr><td colspan='4'>Tidak Ada Data</td></tr>";
		}else{
			$no = 1;		
			$uu = '';
			while ($o = mysql_fetch_array($ul)) {
			$tg1 = dbtoindo($o['tgl_awal_penga']);
			$tg2 = dbtoindo($o['tgl_akhir_penga']);
			
			$uu .= "<tr>
			<td>$no</td>
			<td><a href='?md=det_lak&kd=$o[0]' target='_blank' class='hitam' title='klik untuk melihat detail'>$o[nama_laksana]</a></td>
			<td>Mulai:$tg1<br>Selesai:$tg2</td>
			<td>$o[nama_jab]</td>
			</tr>";

			$no++;
			}
		}
		echo json_encode($uu);
	}


	elseif(!empty($_GET['x'])){
		$i = mysql_query("SELECT r.id_rencana, r.kode_ren, r.nama_keg_ren, r.mulai_ren, r.selesai_ren, r.tempat_ren, r.anggaran_ren, r.desk_ren, p.id_pegawai, p.nama_pegawai, p.nomor_induk, j.nama_jab, d.nama_dok, d.id_dok
			FROM tbl_pelaksanaan pl
			JOIN tbl_sub_penyiapan sp ON sp.id_sub_penyi = pl.id_sub_penyi
			JOIN tbl_penyiapan py ON py.id_penyiapan = sp.id_penyiapan
			JOIN tbl_rencana r ON r.id_rencana = py.id_rencana
			JOIN dokumen d ON d.id_dok = r.id_dok
			JOIN pegawai p ON r.id_pegawai = p.id_pegawai
			JOIN jabatan j ON j.id_jab = p.id_jab
			WHERE MONTH( r.mulai_ren ) =  '$_GET[x]'
			AND YEAR( r.mulai_ren ) =  '$_GET[y]'
			GROUP BY r.id_rencana");
		$no = 1;
		$oke = '';
		while ($dt = mysql_fetch_assoc($i)) {
			$tg1 = dbtoindo($dt['mulai_ren']);
			$tg2 = dbtoindo($dt['selesai_ren']);			
			$uang_ren = number_format($dt['anggaran_ren'],2,",",".");
			$oke .="<tr><td>$no</td>
						<td>$dt[kode_ren]</td>
						<td><a href='?md=detil&r=$dt[id_rencana]' target='_blank'>$dt[nama_keg_ren]</a></td>
            			<td>$tg1</td>
            			<td>$tg2</td>
            			<td>$dt[tempat_ren]</td>            			
            			<td>$dt[nama_pegawai]</td>
            			<td>Rp. $uang_ren</td>
            			";
            			include 'action/act_evaluasi.php';
            			
            			$oke .="            			
            			<td><a href='?md=detilhitung&r=$dt[id_rencana]' target='_blank'>Detail Perhitungan</a></td>
            			</tr>";
            $no++;
		}

		echo json_encode($oke);			
	}
	elseif(!empty($_GET['bid'])){
		//cari seksi yang sinc dengan bidang
		$l = mysql_query("SELECT s.id_seksi, s.nama_seksi FROM seksi s JOIN bidang b ON b.id_bidang=s.id_bidang WHERE b.id_bidang='$_GET[bid]'");		
		$isi ="<option value='0'>Pilih seksi sekarang...</option>";
		while ($data = mysql_fetch_assoc($l)) {
			$isi .= "<option value='$data[id_seksi]'>$data[nama_seksi]</option>";
		}
		echo json_encode($isi);
	}
	elseif(!empty($_GET['ids']) && !empty($_GET['idb'])){
		$d1 = mysql_fetch_array(mysql_query("SELECT s.id_seksi, s.nama_seksi FROM seksi s WHERE s.id_seksi='$_GET[ids]'"));
		$d2 = mysql_fetch_array(mysql_query("SELECT nama_bidang FROM bidang WHERE id_bidang='$_GET[idb]'"));
		$bb = date('n');			
		$t = date('Y');
		$bulansek = date("m");
		$b = getBulan($bb);	
		//jumlah perencanaan yang sudah direalasi pada bulan ini tahun ini
			$var1 = "SELECT r.id_rencana
					FROM tbl_pelaksanaan pl
					JOIN tbl_sub_penyiapan sp ON sp.id_sub_penyi = pl.id_sub_penyi
					JOIN tbl_penyiapan py ON py.id_penyiapan = sp.id_penyiapan
					JOIN tbl_rencana r ON r.id_rencana = py.id_rencana
					JOIN pegawai p ON r.id_pegawai = p.id_pegawai
					JOIN jabatan j ON j.id_jab = p.id_jab
					WHERE MONTH( r.mulai_ren ) !=  '$bulansek'
					AND YEAR( r.mulai_ren ) !=  '$t'
					GROUP BY r.id_rencana";

			$var2 = "SELECT id_rencana
					FROM tbl_rencana
					WHERE id_rencana NOT 
					IN ($var1)";	

			$k1 = mysql_num_rows(mysql_query($var1)); 
			$k2 = mysql_num_rows(mysql_query($var2));

			//jumlah pelaksanaan yang masih diawasi pada bulan ini dan tahun ini
			$j = mysql_num_rows(mysql_query("SELECT pl.id_pelaksanaan
		    FROM tbl_pelaksanaan pl
		    JOIN tbl_sub_pelaksanaan spl ON spl.id_pelaksanaan = pl.id_pelaksanaan
		    JOIN tbl_pengawasan pg ON pg.id_sub_pelak=spl.id_sub_pelak
		    JOIN pegawai p ON p.id_pegawai=pg.id_pegawai
		    JOIN jabatan j ON j.id_jab=p.id_jab
		    WHERE MONTH( pg.tgl_awal_penga )='$bulansek'
			AND YEAR( pg.tgl_awal_penga )='$t'
			GROUP BY pl.id_pelaksanaan"));

			$ul = mysql_query("SELECT id_rencana
					FROM  tbl_rencana 
					WHERE id_rencana NOT 
					IN (
					SELECT r.id_rencana
					FROM tbl_rencana r, tbl_penyiapan py, tbl_sub_penyiapan sp, tbl_pelaksanaan pl, jabatan j, pegawai p
					WHERE r.id_rencana = py.id_rencana
					AND py.id_penyiapan = sp.id_penyiapan
					AND sp.id_sub_penyi = pl.id_sub_penyi
					AND j.id_jab = p.id_jab
					AND r.id_pegawai = p.id_pegawai
					GROUP BY r.id_rencana
					)");
			$jum = mysql_num_rows($ul);

			$telo = mysql_query("SELECT id_pelaksanaan
							FROM tbl_pelaksanaan
							WHERE id_pelaksanaan NOT 
							IN (
								SELECT pl.id_pelaksanaan
								FROM tbl_pelaksanaan pl
								JOIN tbl_sub_pelaksanaan spl ON pl.id_pelaksanaan = spl.id_pelaksanaan
								JOIN tbl_pengawasan pg ON pg.id_sub_pelak = spl.id_sub_pelak
								GROUP BY pl.id_pelaksanaan
							)");
			$jum_pelak = mysql_num_rows($telo);

		if($_GET['ids']=='2' && $_GET['idb']=='1'){
			$hai = "<div class='box_info'>";
			$hai .= "<div class=\"page-header\">
			          <h4>Detail Informasi Kegiatan Perencanaan dan Pelaksanaan $d1[nama_seksi]</h4>
			        </div>
					<ul>
						<li>Rencana yang <b>sudah</b> terealisasi sampai Bulan $b Tahun $t sebanyak <b class='jum_info'><span class='badge badge-success'><a href=\"?md=detildashperensu\" target='_blank'>$k1</a></span></b> Rencana</li>
						<li>Rencana yang <b>belum</b> terealisasi sampai Bulan $b Tahun $t sebanyak <b class='jum_info'><span class='badge badge-important'><a href=\"?md=detildashperenbel\" target='_blank'>$k2</a></span></b> Rencana</li>	
						<li>Pelaksanaan yang masih dalam tahap pengawasan sampai saat ini sebanyak <b class='jum_info'><span class='badge badge-success'><a href=\"?md=detildashpelak\" target='_blank'>$j</a></span></b> Pelaksanaan</li>
					</ul>";			
			$hai .="</div>";
			$hai .= "<div class=\"span6\" style='margin-left:0px;'>";
			$hai .= "<div class=\"page-header\">
					<h4>Realisasi Perencanaan 
						<span class='labels label-warning pull-right'><a href='?md=detildashreal' title='Ada $jum Perencanaan yang belum direalisasi' style='color:white;'>$jum rencana</a></span>
					</h4>
					</div>";
			$hai .= "<form class=\"form-inline\">				  
				  Tahun:
				  <select name=\"th-dash\" id=\"th-dash\" class='span4' onchange=\"ganti_th(this,'#bl-dash');\">
				  	<option value='0'>Pilih Tahun</option>";
				  	
				  		$oo = mysql_query("SELECT YEAR(mulai_ren) FROM tbl_rencana GROUP BY YEAR(mulai_ren)");
				  		while ($l = mysql_fetch_array($oo)) {
				  			$hai .="<option value='$l[0]'>$l[0]</option>";
				  		}
				  	
				  $hai .= "</select>
				  Bulan:
				  <select name=\"bl-dash\" id=\"bl-dash\" class='span6' onchange=\"ganti_bulan(this,'#th-dash' ,'#tbl_rencana');\" disabled>
				  	<option value=\"0\">Pilih Bulan</option>				  
				  </select>
				  </form>";
			$hai .= "<table class='table table-bordered table-striped table-hover' id='tbl_rencana'>
					<thead>
						<tr><th>No.</th><th>Perencanaan</th><th>Nama Pelaks.</th><th>Tgl.Realisasi</th><th>PJ</th></tr>
					</thead>
					<tbody>
						<tr><td colspan='5'>Pilih Dulu Tahun dan Bulan</td></tr>
					</tbody>
					</table>";

			$hai .= "</div>";
			// akhir tabel kiri
			$hai .= "<div class=\"span6\">";
			$hai .= "<div class=\"page-header\">
					<h4>Kegiatan Pelaksanaan dalam Tahap Pengawasan
						<span class='labels label-info pull-right'><a href='?md=detildashpenga' title='Ada $jum_pelak Pelaksanaan yang belum diawasi' style='color:white;'>$jum_pelak Pelaksanaan</a></span>
					</h4>
					</div>";
			$hai .= "<form class=\"form-inline\">				  
				  Tahun:
				  <select name=\"th_dash\" id=\"th_dash\" class='span4' onchange=\"ganti_th_pelak(this, '#bl_dash2');\">
				  	<option value='0'>Pilih Tahun</option>";
				  	
				  		$oo = mysql_query("SELECT YEAR(tgl_m_lak) FROM tbl_pelaksanaan GROUP BY YEAR(tgl_m_lak)");
				  		while ($l = mysql_fetch_array($oo)) {
				  			$hai .= "<option value='$l[0]'>$l[0]</option>";
				  		}
				  	
				  $hai .= "</select>
				  Bulan:
				  <select name=\"bl_dash\" id=\"bl_dash2\" class='span6' onchange=\"ganti_bl_pelak(this, '#th_dash','#tbl_pelak');\" disabled>
				  	<option value=\"0\">Pilih Bulan</option>				  
				  </select>
				  </form>";
			$hai .= "<table class='table table-bordered table-striped table-hover' id='tbl_pelak'>
					<thead>
						<tr><th>No.</th><th>Kegiatan</th><th>Tgl.Pengawasan</th><th>PJ</th></tr>
					</thead>
					<tbody>
						<tr><td colspan='4'>Pilih Dulu Tahun dan Bulan</td></tr>
					</tbody>
					</table>";

			$hai .= "</div>";
			echo json_encode($hai);
		}else{
			$hai = "<div class='alert alert-danger'>Maaf, Data <strong>$d1[nama_seksi]</strong> tidak ditemukan :(. Silahkan Anda pilih Seksi yang lain.</div>";
			echo json_encode($hai);
		}
		
	}elseif(!empty($_GET['idseks'])){
		$d1 = mysql_fetch_array(mysql_query("SELECT s.id_seksi, s.nama_seksi FROM seksi s WHERE s.id_seksi='$_GET[idseks]'"));
		$bb = date('n');			
		$t = date('Y');
		$bulansek = date("m");
		$b = getBulan($bb);	
		//jumlah perencanaan yang sudah direalasi pada bulan ini tahun ini
			$var1 = "SELECT r.id_rencana
					FROM tbl_pelaksanaan pl
					JOIN tbl_sub_penyiapan sp ON sp.id_sub_penyi = pl.id_sub_penyi
					JOIN tbl_penyiapan py ON py.id_penyiapan = sp.id_penyiapan
					JOIN tbl_rencana r ON r.id_rencana = py.id_rencana
					JOIN pegawai p ON r.id_pegawai = p.id_pegawai
					JOIN jabatan j ON j.id_jab = p.id_jab
					WHERE MONTH( r.mulai_ren ) !=  '$bulansek'
					AND YEAR( r.mulai_ren ) !=  '$t'
					GROUP BY r.id_rencana";

			$var2 = "SELECT id_rencana
					FROM tbl_rencana
					WHERE id_rencana NOT 
					IN ($var1)";	

			$k1 = mysql_num_rows(mysql_query($var1)); 
			$k2 = mysql_num_rows(mysql_query($var2));

			//jumlah pelaksanaan yang masih diawasi pada bulan ini dan tahun ini
			$j = mysql_num_rows(mysql_query("SELECT pl.id_pelaksanaan
		    FROM tbl_pelaksanaan pl
		    JOIN tbl_sub_pelaksanaan spl ON spl.id_pelaksanaan = pl.id_pelaksanaan
		    JOIN tbl_pengawasan pg ON pg.id_sub_pelak=spl.id_sub_pelak
		    JOIN pegawai p ON p.id_pegawai=pg.id_pegawai
		    JOIN jabatan j ON j.id_jab=p.id_jab
		    WHERE MONTH( pg.tgl_awal_penga )='$bulansek'
			AND YEAR( pg.tgl_awal_penga )='$t'
			GROUP BY pl.id_pelaksanaan"));
			$ul = mysql_query("SELECT id_rencana
					FROM  tbl_rencana 
					WHERE id_rencana NOT 
					IN (
					SELECT r.id_rencana
					FROM tbl_rencana r, tbl_penyiapan py, tbl_sub_penyiapan sp, tbl_pelaksanaan pl, jabatan j, pegawai p
					WHERE r.id_rencana = py.id_rencana
					AND py.id_penyiapan = sp.id_penyiapan
					AND sp.id_sub_penyi = pl.id_sub_penyi
					AND j.id_jab = p.id_jab
					AND r.id_pegawai = p.id_pegawai
					GROUP BY r.id_rencana
					)");
			$jum = mysql_num_rows($ul);

			$telo = mysql_query("SELECT id_pelaksanaan
							FROM tbl_pelaksanaan
							WHERE id_pelaksanaan NOT 
							IN (
								SELECT pl.id_pelaksanaan
								FROM tbl_pelaksanaan pl
								JOIN tbl_sub_pelaksanaan spl ON pl.id_pelaksanaan = spl.id_pelaksanaan
								JOIN tbl_pengawasan pg ON pg.id_sub_pelak = spl.id_sub_pelak
								GROUP BY pl.id_pelaksanaan
							)");
			$jum_pelak = mysql_num_rows($telo);

		if($_GET['idseks']=='2'){
			$hai = "<div class='box_info'>";
			$hai .= "<div class=\"page-header\">
			          <h4>Detail Informasi Kegiatan Perencanaan dan Pelaksanaan $d1[nama_seksi]</h4>
			        </div>
					<ul>
						<li>Rencana yang <b>sudah</b> terealisasi sampai Bulan $b Tahun $t sebanyak <b class='jum_info'><span class='badge badge-success'><a href=\"?md=detildashperensu\" target='_blank'>$k1</a></span></b> Rencana</li>
						<li>Rencana yang <b>belum</b> terealisasi sampai Bulan $b Tahun $t sebanyak <b class='jum_info'><span class='badge badge-important'><a href=\"?md=detildashperenbel\" target='_blank'>$k2</a></span></b> Rencana</li>	
						<li>Pelaksanaan yang masih dalam tahap pengawasan sampai saat ini sebanyak <b class='jum_info'><span class='badge badge-success'><a href=\"?md=detildashpelak\" target='_blank'>$j</a></span></b> Pelaksanaan</li>
					</ul>";			
			$hai .="</div>";
			$hai .= "<div class=\"span6\" style='margin-left:0px;'>";
			$hai .= "<div class=\"page-header\">
					<h4>Realisasi Perencanaan 
						<span class='labels label-warning pull-right'><a href='?md=detildashreal' title='Ada $jum Perencanaan yang belum direalisasi' style='color:white;'>$jum rencana</a></span>
					</h4>
					</div>";
			$hai .= "<form class=\"form-inline\">				  
				  Tahun:
				  <select name=\"th-dash\" id=\"th-dash\" class='span4' onchange=\"ganti_th(this,'#bl-dash');\">
				  	<option value='0'>Pilih Tahun</option>";
				  	
				  		$oo = mysql_query("SELECT YEAR(mulai_ren) FROM tbl_rencana GROUP BY YEAR(mulai_ren)");
				  		while ($l = mysql_fetch_array($oo)) {
				  			$hai .="<option value='$l[0]'>$l[0]</option>";
				  		}
				  	
				  $hai .= "</select>
				  Bulan:
				  <select name=\"bl-dash\" id=\"bl-dash\" class='span6' onchange=\"ganti_bulan(this,'#th-dash' ,'#tbl_rencana');\" disabled>
				  	<option value=\"0\">Pilih Bulan</option>				  
				  </select>
				  </form>";
			$hai .= "<table class='table table-bordered table-striped table-hover' id='tbl_rencana'>
					<thead>
						<tr><th>No.</th><th>Perencanaan</th><th>Nama Pelaks.</th><th>Tgl.Realisasi</th><th>PJ</th></tr>
					</thead>
					<tbody>
						<tr><td colspan='5'>Pilih Dulu Tahun dan Bulan</td></tr>
					</tbody>
					</table>";

			$hai .= "</div>";
			// akhir tabel kiri
			$hai .= "<div class=\"span6\">";
			$hai .= "<div class=\"page-header\">
					<h4>Kegiatan Pelaksanaan dalam Tahap Pengawasan
						<span class='labels label-info pull-right'><a href='?md=detildashpenga' title='Ada $jum_pelak Pelaksanaan yang belum diawasi' style='color:white;'>$jum_pelak Pelaksanaan</a></span>
					</h4>
					</div>";
			$hai .= "<form class=\"form-inline\">				  
				  Tahun:
				  <select name=\"th_dash\" id=\"th_dash\" class='span4' onchange=\"ganti_th_pelak(this, '#bl_dash2');\">
				  	<option value='0'>Pilih Tahun</option>";
				  	
				  		$oo = mysql_query("SELECT YEAR(tgl_m_lak) FROM tbl_pelaksanaan GROUP BY YEAR(tgl_m_lak)");
				  		while ($l = mysql_fetch_array($oo)) {
				  			$hai .= "<option value='$l[0]'>$l[0]</option>";
				  		}
				  	
				  $hai .= "</select>
				  Bulan:
				  <select name=\"bl_dash\" id=\"bl_dash2\" class='span6' onchange=\"ganti_bl_pelak(this, '#th_dash','#tbl_pelak');\" disabled>
				  	<option value=\"0\">Pilih Bulan</option>				  
				  </select>
				  </form>";
			$hai .= "<table class='table table-bordered table-striped table-hover' id='tbl_pelak'>
					<thead>
						<tr><th>No.</th><th>Kegiatan</th><th>Tgl.Pengawasan</th><th>PJ</th></tr>
					</thead>
					<tbody>
						<tr><td colspan='4'>Pilih Dulu Tahun dan Bulan</td></tr>
					</tbody>
					</table>";

			$hai .= "</div>";
			echo json_encode($hai);
		}else{
			$hai = "<div class='alert alert-danger'>Maaf, Data <strong>$d1[nama_seksi]</strong> tidak ditemukan :(. Silahkan Anda pilih Seksi yang lain.</div>";
			echo json_encode($hai);
		}
	
	}
?>