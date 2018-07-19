<div class="row-fluid">	
	<div class="span12" >
		<div class="row-fluid">
			<div class="page-header">
				<h3>Halaman Dashboard <strong><?php echo "$_SESSION[namalengkap]"; ?></strong></h3>
				<small>Anda masuk sebagai <?php echo "$_SESSION[namajab]"; ?></small>
			</div>
			<?php
			$bb = date('n');			
			$t = date('Y');
			$bulansek = date("m");
			$b = getBulan($bb);			
			
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

			//jumlah perencanaan yang sudah direalasi pada bulan ini tahun ini
			$var1 = "SELECT r.id_rencana
					FROM tbl_pelaksanaan pl
					JOIN tbl_sub_penyiapan sp ON sp.id_sub_penyi = pl.id_sub_penyi
					JOIN tbl_penyiapan py ON py.id_penyiapan = sp.id_penyiapan
					JOIN tbl_rencana r ON r.id_rencana = py.id_rencana
					JOIN pegawai p ON r.id_pegawai = p.id_pegawai
					JOIN jabatan j ON j.id_jab = p.id_jab
					WHERE MONTH( pl.tgl_m_lak ) !=  '$bulansek' AND YEAR( pl.tgl_s_lak ) != '$t' 					
					GROUP BY r.id_rencana";
					//echo "$var1";

			$var2 = "SELECT id_rencana
					FROM tbl_rencana
					WHERE id_rencana NOT 
					IN ($var1)";
					// echo "$var2";

			//selain bulan sekarang dan tahun sekarang && tidak boleh lebih besar dari bulan sekarang dan tahun sekarang		

			$k1 = mysql_num_rows(mysql_query($var1)); 
			$k2 = mysql_num_rows(mysql_query($var2));

			?>
			<div class="span12" style='margin-left:0px;'>
				<div class="box_info">
					<div class="page-header">
			          <h4>Detail Informasi Kegiatan Perencanaan dan Pelaksanaan</h4>
			        </div>
					<ul>
						<li>Rencana yang <b>sudah</b> terealisasi sampai Bulan <?php echo "$b"; ?> Tahun <?php echo "$t"; ?> sebanyak <b class='jum_info'><?php echo "<span class='badge badge-success'><a href=\"?md=detildashperensu\" >$k1</a></span>"; ?></b> Rencana</li>
						<li>Rencana yang <b>belum</b> terealisasi sampai Bulan <?php echo "$b"; ?> Tahun <?php echo "$t"; ?> sebanyak <b class='jum_info'><?php echo "<span class='badge badge-important'><a href=\"?md=detildashperenbel\" >$k2</a></span>"; ?></b> Rencana</li>	
						<li>Pelaksanaan yang masih dalam tahap pengawasan sampai saat ini sebanyak <b class='jum_info'><?php echo "<span class='badge badge-success'><a href=\"?md=detildashpelak\" >$j</a></span>"; ?></b> Pelaksanaan</li>
					</ul>
				</div>
			</div>
			<?php  
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

			?>
			
			<div class="span6" style='margin-left:0px;'>
				<div class="page-header">
					<h4>Realisasi Perencanaan 
						<?php echo "<span class='labels label-warning pull-right'><a href='?md=detildashreal' data-content='Ada $jum Perencanaan yang belum direalisasi' class='tool' style='color:white;' data-placement='right' data-trigger='hover'>$jum rencana</a></span>"; ?>
					</h4>
				</div>
				<form class="form-inline">				  
				  Tahun:
				  <select name="th-dash" id="th-dash" class='span4' onchange="ganti_th(this,'#bl-dash');">
				  	<!--  -->
				  	<option value='0'>Pilih Tahun</option>
				  	<?php  
				  		$oo = mysql_query("SELECT YEAR(mulai_ren) FROM tbl_rencana GROUP BY YEAR(mulai_ren)");
				  		while ($l = mysql_fetch_array($oo)) {
				  			echo "<option value='$l[0]'>$l[0]</option>";
				  		}
				  	?>	
				  </select>
				  

				  Bulan:
				  <select name="bl-dash" id="bl-dash" class='span6' onchange="ganti_bulan(this,'#th-dash' ,'#tbl_rencana');" disabled>				  	
				  	<option value="0">Pilih Bulan</option>				  
				  </select>
				</form>
				<table class='table table-bordered table-striped table-hover' id='tbl_rencana'>
					<thead>
						<tr><th>No.</th>
							<th>Perencanaan</th>
							<th>Nama Pelaks.</th>
							<th>Tgl.Realisasi</th>
							<th>PJ</th>
						</tr>
					</thead>
					<tbody>
						<tr><td colspan='5'>Pilih Dulu Tahun dan Bulan</td></tr>
					</tbody>
					

				</table>
			</div>
			<div class="span6">
				<div class="page-header">
					<?php 
					$t = mysql_query("SELECT id_pelaksanaan
							FROM tbl_pelaksanaan
							WHERE id_pelaksanaan NOT 
							IN (
								SELECT pl.id_pelaksanaan
								FROM tbl_pelaksanaan pl
								JOIN tbl_sub_pelaksanaan spl ON pl.id_pelaksanaan = spl.id_pelaksanaan
								JOIN tbl_pengawasan pg ON pg.id_sub_pelak = spl.id_sub_pelak
								GROUP BY pl.id_pelaksanaan
							)");
					$jum_pelak = mysql_num_rows($t);
					 ?>
					<h4>Kegiatan Pelaksanaan dalam Tahap Pengawasan
						<?php echo "<span class='labels label-info pull-right'><a href='?md=detildashpenga' data-content='Ada $jum_pelak Pelaksanaan yang belum diawasi' class='tool' style='color:white;' data-placement='right' data-trigger='hover'>$jum_pelak Pelaksanaan</a></span>"; ?>
					</h4>
				</div>
				<form class="form-inline">
				  Tahun:
				  <select name="th_dash" id="th_dash" class='span4' onchange="ganti_th_pelak(this, '#bl_dash2');">
				  	<option value='0'>Pilih Tahun</option>
				  	<?php  
				  		$oo = mysql_query("SELECT YEAR(tgl_m_lak) FROM tbl_pelaksanaan GROUP BY YEAR(tgl_m_lak)");
				  		while ($l = mysql_fetch_array($oo)) {
				  			echo "<option value='$l[0]'>$l[0]</option>";
				  		}
				  	?>	
				  </select>

				  Bulan:
				  <select name="bl_dash" id="bl_dash2" class='span6' onchange="ganti_bl_pelak(this, '#th_dash','#tbl_pelak');" disabled>
				  	<option value='0'>Pilih Bulan</option>
				  </select>
				  
				</form>
				<table class='table table-bordered table-striped table-hover' id='tbl_pelak'>
					<thead>
						<tr><th>No.</th><th>Kegiatan</th><th>Tgl.Pengawasan</th><th>PJ</th></tr>
					</thead>
					<tbody>
						<tr><td colspan='4'>Pilih Dulu Tahun dan Bulan</td></tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>