<div class="row-fluid">
	<div class="span12">
		<div class="page-header">
			<h3><span class='label labelform label-info'>Evaluasi dan Monitoring</span> Kegiatan Realisasi Perencanaan</h3>
		</div>
		<div class="span12" style='margin-left:0;'>
			<form class="form-inline">				  
				  Tahun:
				  <select name="th-dash" id="th-dash" class='span2' onchange="ganti_th(this,'#bl-dash');">			
				  	<option value='0'>Pilih Tahun</option>
				  	<?php  
				  		$oo = mysql_query("SELECT YEAR(mulai_ren) FROM tbl_rencana GROUP BY YEAR(mulai_ren)");
				  		while ($l = mysql_fetch_array($oo)) {
				  			echo "<option value='$l[0]'>$l[0]</option>";
				  		}
				  	?>	
				  </select>
				  
				  Bulan:
				  <select name="bl-dash" id="bl-dash" class='span2' onchange="ganti_bulan_eval(this,'#th-dash' ,'#tbl_rencana');" disabled>				  	
				  	<option value="0">Pilih Bulan</option>				  
				  </select>
				</form>
				<table class='table table-bordered table-striped table-hover' id='tbl_rencana' style='width:100%;'>
					<thead>
						<tr>
						<th rowspan='2'>No.</th>
						<th rowspan='2'>Kode</th>
						<th rowspan='2'>Nama Rencana</th>
            			<th colspan='2'>Perencanaan</th>            			
            			<th rowspan='2'>Tempat</th>
            			<th rowspan='2'>Penanggung Jawab (PJ)</th>
            			<th colspan='2'>Anggaran</th>            			
            			<th rowspan='2'>KONDISI</th>
            			<th rowspan='2'>Aksi</th>
            			</tr>
            			<tr>
            			<th>Mulai</th>
            			<th>Selesai</th>
            			<th>Rencana</th>
            			<th><a class='hitam' title='Jumlah Anggaran Penyiapan dan Pelaksanaan'>Realisasi</a></th>
            			</tr>
            			
					</thead>
					<tbody>
						<tr><td colspan='11'>Pilih Dulu Tahun dan Bulan</td></tr>
					</tbody>
				</table>
		</div>	
		
	</div>
</div>
































