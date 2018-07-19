<div class="row-fluid">
  <div class="span12">
    <div class="page-header">
      <?php 
      $t = mysql_fetch_array(mysql_query("SELECT * FROM  submenu_utama WHERE link_menu LIKE  '%$_GET[md]%'"));
      $o = mysql_fetch_array(mysql_query("SELECT MAX(kode_penga) FROM tbl_pengawasan"));
      $ro = $o[0]+1;
      echo "<h3><span class='label labelform label-info'>Rekap</span> Data $t[nama_sub]</h3>";
      include 'include/notif.php';
      ?>
    </div>
    <!-- <form action="mod_sistem/md_b.kumkm/pdf/examples/perencanaan.php" method='POST' class='form-horizontal' target="_blank"> -->
    <form action="mod_sistem/md_b.kumkm/action/act_laporan.php" method='POST' class='form-horizontal' target="_blank">
      <div class="control-group">
           <label for="" class="control-label">Tahapan Kegiatan</label>
           <div class="controls">
           <select name="tahap" id='keg_lap' onchange="func_kegiatan(this, '#bulan_lap');">
             <option value="0">Pilih Tahapan</option>
             <?php 
               $i = mysql_query("SELECT id_modul, nama_modul FROM kop_modul ORDER BY id_modul ASC LIMIT 0 , 5");
               while ($u=mysql_fetch_array($i)) {
                 echo "<option value='$u[0]'>$u[1]</option>";
               }
              ?>
           </select>                              
           </div>
      </div>
      <div class="control-group">
           <label for="" class="control-label">Bulan</label>
           <div class="controls">
           <select name="bln" id='bulan_lap' onchange="func_bulan(this, '#keg_lap', '#th_lap');" disabled>
             <option value="0">Pilih Bulan</option>             
           </select>                              
           </div>
      </div>
      <div class="control-group">
           <label for="" class="control-label">Tahun</label>
           <div class="controls">
           <select name="tahun" id='th_lap' disabled>
             <option value="0">Pilih Tahun</option>             
           </select>                              
           </div>
      </div>

      <div class="control-group">                
         <div class="controls pull-left">
           <input type="submit" value='Preview dan Cetak' class='btn btn-success'>           
         </div>
      </div> 

    </form>

  </div>
</div>
