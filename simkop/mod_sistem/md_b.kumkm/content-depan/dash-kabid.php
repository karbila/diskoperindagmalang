<div class="row-fluid">	
	<div class="span12" >
		<div class="row-fluid">
			<div class="page-header">
				<h3>Halaman Dashboard <strong><?php echo "$_SESSION[namalengkap]"; ?></strong></h3>
				<small>Anda masuk sebagai <?php echo "$_SESSION[namajab]"; ?></small>
			</div>

			<div class="span12" style='margin-left:0px;'>
				<div class="alert">Untuk mengetahui kegiatan yang dilakukan di tiap seksi, Anda harus memilih Seksi terlebih dahulu.</div>
				<form class="form-inline">
				  Seksi:
				  <select name="seksi" class='span3' onchange="ganti_seksi_bid(this, '#kotak_info');">
				  	<option value="0">Pilih Seksi</option>
				  	<?php
				  		$idbid = "1";
				  		$g = mysql_query("SELECT s.id_seksi, s.nama_seksi FROM seksi s JOIN bidang b ON b.id_bidang=s.id_bidang WHERE b.id_bidang='$idbid'");					  		
				  		while ($data = mysql_fetch_assoc($g)) {
				  			echo "<option value='$data[id_seksi]'>$data[nama_seksi]</option>";
				  		}
				  	?>
				  </select>
				</form>				
			</div>
			<!-- isi -->
			<div class="span12" style='margin-left:0px;' id='kotak_info'></div>
		</div>
	</div>
</div>