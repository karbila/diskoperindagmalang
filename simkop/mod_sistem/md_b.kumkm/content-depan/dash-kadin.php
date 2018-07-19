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
					WHERE MONTH( r.mulai_ren ) !=  '$bulansek'
					AND YEAR( r.mulai_ren ) !=  '$t'
					GROUP BY r.id_rencana";

			$var2 = "SELECT id_rencana
					FROM tbl_rencana
					WHERE id_rencana NOT 
					IN ($var1)";		

			$k1 = mysql_num_rows(mysql_query($var1)); 
			$k2 = mysql_num_rows(mysql_query($var2));

			?>
			<div class="span12" style='margin-left:0px;'>
				<div class="alert">Untuk mengetahui kegiatan yang dilakukan di tiap seksi, Anda harus memilih Bidang dan Seksi terlebih dahulu.</div>
				<form class="form-inline">				  
				  Bidang:
				  <select name="bidang" class='span3' id='bidang' onchange="ganti_bidang(this, '#seksi');">
				  	<option value='0'>Pilih Bidang</option>
				  	<?php  
				  		$oo = mysql_query("SELECT id_bidang, nama_bidang FROM bidang ORDER BY id_bidang");
				  		while ($l = mysql_fetch_array($oo)) {
				  			echo "<option value='$l[0]'>$l[1]</option>";
				  		}
				  	?>	
				  </select>				 
				  Seksi:
				  <select name="seksi" class='span3' id='seksi' onchange="ganti_seksi(this, '#bidang', '#kotak_info');" disabled >
				  	<option value="0">Pilih Seksi</option>				  				  	
				  </select>
				</form>				
			</div>
			<!-- isi -->
			<div class="span12" style='margin-left:0px;' id='kotak_info'>
				
			</div>
		</div>
	</div>
</div>