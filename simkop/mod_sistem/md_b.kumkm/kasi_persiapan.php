<div class="row-fluid">
   <?php 
     switch ($_GET['p']) {
       case 'update':
                ?>       
                  <!-- form 1 -->         
                  <div class="span6">
                      <div class="page-header">
                        <?php 
                        $t = mysql_fetch_array(mysql_query("SELECT * FROM  submenu_utama WHERE link_menu LIKE  '%$_GET[md]%'"));
                        echo "<h3>Form <span class='label labelform label-warning'>Edit</span> Data $t[nama_sub]</h3>";
                        $u=mysql_query("SELECT p.id_rencana, p.nama_keg_ren, py.kode_penyi, py.nama_kegiatan_penyi, py.id_penyiapan, py.tgl_mulai_penyi1, py.tgl_selesai_penyi1, py.tempat_penyi, j.nama_jab, p.anggaran_ren, py.anggaran, py.deskripsi_penyi, py.status_kunci, py.owner, pg.id_pegawai, j.id_jab
                          FROM tbl_rencana p, tbl_penyiapan py, jabatan j, pegawai pg
                          WHERE p.id_rencana = py.id_rencana
                          AND j.id_jab = pg.id_jab
                          AND pg.id_pegawai = py.id_pegawai
                          AND py.id_penyiapan = '$_GET[kode]'");
                        $dtpe = mysql_fetch_array($u);

                        $awal1 = dbtoindo($dtpe['tgl_mulai_penyi1']);
                        $akhir1 = dbtoindo($dtpe['tgl_selesai_penyi1']);  
                        $uangedit = number_format($dtpe['anggaran'],0,"",",");                      
                        include 'include/notif.php';
                        ?>
                      </div>

                      <form action="mod_sistem/md_b.kumkm/action/act_siap.php?md=<?php echo "$_GET[md]";?>&amp;ac=siap_upd" method='POST' class='form-horizontal'>                                                  
                            <div class="control-group">
                              <label for="" class="control-label">Perencanaan</label>
                              <div class="controls">
                              <select name="nama_peren" id='nama_peren'>
                                <option value="0">Pilih Rencana</option>
                                <?php 
                                  $i = mysql_query("SELECT id_rencana, nama_keg_ren FROM tbl_rencana ORDER BY nama_keg_ren ASC");                                  
                                  while ($u=mysql_fetch_array($i)){
                                    if($dtpe[0]==$u[0]){
                                      echo "<option value='$u[0]' selected>$u[1]</option>";
                                    }else{
                                      echo "<option value='$u[0]'>$u[1]</option>";
                                    }                                    
                                  }
                                 ?>
                              </select>                              
                              </div>
                            </div>                            

                            <div class="control-group">
                            <label class="control-label">Nomor</label>
                            <div class="controls">                    
                              <input type="text" name='no_siap' readonly value='<?php echo "$dtpe[kode_penyi]"; ?>'>
                            </div>                            

                            </div>

                            <div class="control-group">
                            <label class="control-label">Nama Persiapan</label>
                            <div class="controls">                    
                              <input type="text" name='nper' value='<?php echo "$dtpe[nama_kegiatan_penyi]"; ?>'>
                            </div>
                            </div>

                            <div class="alert alert-error" id="alert" style='display:none;'>
                            <strong>&nbsp;</strong>
                            </div>
                            <div class="control-group">
                              <label class='control-label'>Mulai</label>
                              <div class="controls">
                                <div class="input-append date" id='datemulai' data-date='<?php echo date("d-m-Y"); ?>' data-date-format='dd-mm-yyyy'>
                                  <input class="span12" size="16" type="text" readonly name='s' value='<?php echo "$awal1"; ?>'>
                                  <span class="add-on"><i class="icon-calendar"></i></span>
                                </div>
                              </div>
                            </div>

                            <div class="control-group">
                              <label class='control-label'>Selesai</label>
                              <div class="controls">
                                <div class="input-append date" id='dateselesai' data-date='<?php echo date("d-m-Y"); ?>' data-date-format='dd-mm-yyyy'>
                                  <input class="span12" size="16" type="text" readonly name='f' value='<?php echo "$akhir1"; ?>'>
                                  <span class="add-on"><i class="icon-calendar"></i></span>
                                </div>
                              </div>
                            </div>

                            <div class="control-group">
                              <label class="control-label">Tempat</label>
                              <div class="controls">
                                <input type="text" name='tp' value='<?php echo "$dtpe[tempat_penyi]"; ?>'>
                              </div>
                            </div>

                            <div class="control-group">
                              <label class='control-label'>Penanggungjawab</label>
                              <div class="controls">
                                <select name="pj" id='jab-ren'>
                                  <option value="0">Pilih Pelaksana</option>
                                  <?php  
                                  $j = mysql_query("SELECT id_jab, nama_jab FROM jabatan WHERE id_jab!='14' ORDER BY nama_jab ASC");
                                  while ($dj=mysql_fetch_array($j)) {
                                    if($dtpe['id_jab']==$dj[0]){
                                      echo "<option value='$dj[0]' selected>$dj[1]</option>";
                                    }else{
                                      echo "<option value='$dj[0]'>$dj[1]</option>";
                                    }
                                    
                                  }
                                  ?>
                                </select>
                              </div>
                              </div>

                              <div class="control-group">
                              <label class='control-label'>Pegawai</label>
                              <div class="controls">
                                <select name="np" id='peg'>
                                  <option value="0">Pilih Pegawai</option>
                                  <?php 
                                    if(empty($_GET['jb_pj'])){
                                      $i = mysql_query("SELECT p.id_pegawai, p.nama_pegawai, p.nomor_induk FROM pegawai p, jabatan j WHERE p.id_jab=j.id_jab AND j.id_jab='$dtpe[id_jab]'");
                                      while ($dd=mysql_fetch_array($i)) {
                                        if($dtpe['id_pegawai']==$dd[0]){
                                          echo "<option value='$dd[0]' selected>$dd[nomor_induk] - $dd[nama_pegawai]</option>";
                                        }else{
                                          echo "<option value='$dd[0]'>$dd[nomor_induk] - $dd[nama_pegawai]</option>";
                                        }                          
                                      } 

                                    }else{
                                      echo "<option value=\"0\">Pilih dulu Jabatannya</option>";    
                                    }
                                   ?>
                                  
                                </select>
                              </div>
                            </div>
                              

                              <div class="control-group">
                                <label class='control-label'>Anggaran</label>
                                <div class="controls">
                                  <input type="text" name='ang' id='ang' value='<?php echo "$uangedit"; ?>'>
                                </div>
                              </div> 

                                                    
                               <div class="control-group">
                                  <label class='control-label'>Deskripsi Persiapan</label>
                                  <div class="controls">
                                    <textarea name="dper" id="" cols="30" rows="5"><?php echo "$dtpe[deskripsi_penyi]"; ?></textarea>
                                  </div>
                                </div>                                                            
                                <div class="control-group">                
                                <div class="controls pull-left">
                                  <input type="submit" value='Perbarui' class='btn btn-warning'>
                                  <input type="reset" value='Reset' class='btn btn-inverse'>
                                  <input type="hidden" name='kode' value='<?php echo "$dtpe[id_penyiapan]"; ?>'>
                                  <input type="hidden" name='idrenc' value='<?php echo "$dtpe[id_rencana]"; ?>'>
                                </div>
                                </div>                      
                      </form>
                  </div>
                  <!-- form informasi perencanaan -->
                  <div class="span5">
                    <div class="page-header">
                      <h3>&nbsp;</h3>
                    </div>
                    <div id='info_peren'></div>                    
                  </div>
       <?php  
       break;
       
       case "update_sub":
       ?>
                  <!-- form 2 -->
                  <div class="span6">
                      <div class="page-header">
                        <?php 
                        $t = mysql_fetch_array(mysql_query("SELECT * FROM  submenu_utama WHERE link_menu LIKE  '%$_GET[md]%'"));
                        $qe = mysql_fetch_array(mysql_query("SELECT s . * , py.id_penyiapan, py.nama_kegiatan_penyi, py.kode_penyi
                              FROM tbl_sub_penyiapan s, tbl_penyiapan py
                              WHERE py.id_penyiapan = s.id_penyiapan                              
                              AND s.id_sub_penyi =  '$_GET[kode_sub]'"));
                        
                        echo "<h3>Form <span class='label labelform label-warning'>Edit</span> Data Sub $t[nama_sub]</h3>";
                        
                        include 'include/notif.php';

                        //koversi tanggal dari db ke indo
                        $start = dbtoindo($qe['penyi_sub_mulai']);
                        $finish = dbtoindo($qe['penyi_sub_selesai']);
                         ?>
                      </div>
                      <form action="mod_sistem/md_b.kumkm/action/act_siap.php?md=<?php echo "$_GET[md]";?>&amp;ac=sub_upd" method='POST' class='form-horizontal'>
                        <input type="hidden" name='kdo' value='<?php echo "$qe[id_sub_penyi]"; ?>'>
                        <div class="control-group">
                            <label class="control-label">Pilih Kegiatan Penyiapan</label>
                            <div class="controls">
                              <select name="kp" id='kp'>
                                <option value="0">Pilih Penyiapan</option>
                                <?php 
                                  $i = mysql_query("SELECT id_penyiapan, kode_penyi, nama_kegiatan_penyi FROM tbl_penyiapan ORDER by nama_kegiatan_penyi ASC");
                                  while ($u=mysql_fetch_array($i)) {
                                    if($qe['id_penyiapan']==$u[0]){
                                      echo "<option value='$u[1]' selected>$u[2]</option>";
                                    }else{
                                      echo "<option value='$u[1]'>$u[2]</option>";  
                                    }                                    
                                  }
                                 ?>
                              </select>
                            </div>
                          </div>

                          <div class="control-group">
                            <label class="control-label">Kode Sub Perencanaan</label>
                            <div class="controls">
                              <input type="text" class='input-small' id='idren' name='idren' readonly placeholder='pilih rencana' value='<?php echo "$qe[kode_penyi]"; ?>'>&nbsp;-&nbsp;
                              <input type="text" class='input-small'name='idsub' readonly value='<?php echo "$qe[penyi_sub_kode]"; ?>'>
                            </div>
                          </div>

                          <div class="control-group">
                            <label class="control-label">Nama Sub Perencanaan</label>
                            <div class="controls">                    
                              <input type="text" name='nmsub' value='<?php echo "$qe[penyi_sub_nama]"; ?>'>
                            </div>
                          </div>

                          <div class="alert alert-error" id="alert" style='display:none;'>
                          <strong>&nbsp;</strong>
                          </div>
                          <div class="control-group">
                            <label class='control-label'>Mulai</label>
                            <div class="controls">
                              <div class="input-append date" id='datemulai' data-date='<?php echo date("d-m-Y"); ?>' data-date-format='dd-mm-yyyy'>
                                <input class="span12" size="16" type="text" readonly name='s' value='<?php echo $start; ?>'>
                                <span class="add-on"><i class="icon-calendar"></i></span>
                              </div>
                            </div>
                          </div>

                          <div class="control-group">
                            <label class='control-label'>Selesai</label>
                            <div class="controls">
                              <div class="input-append date" id='dateselesai' data-date='<?php echo date("d-m-Y"); ?>' data-date-format='dd-mm-yyyy'>
                                <input class="span12" size="16" type="text" readonly name='f' value='<?php echo $finish; ?>'>
                                <span class="add-on"><i class="icon-calendar"></i></span>
                              </div>
                            </div>
                          </div>

                          <div class="control-group">
                          <label class='control-label'>Deskripsi Kegiatan</label>
                          <div class="controls">
                            <textarea name="dk" cols="30" rows="5"><?php echo "$qe[penyi_sub_deskripsi]"; ?></textarea>
                          </div>

                          </div>
                          <div class="control-group">                
                            <div class="controls pull-left">
                              <input type="submit" value='Simpan' class='btn btn-warning'>
                              <input type="reset" value='Reset' class='btn btn-inverse'>
                              <input type="hidden" name="h_idkeg" value="<?php echo "$_GET[md]"; ?>">
                            </div>
                          </div> 
                      </form>
                  </div> 
       <?php              
       break;

       default:
              ?>
              <!-- form 1 -->           
                  <div class="span6 span-border-kanan blue">
                     <div class="page-header">
                      <?php 
                      $t = mysql_fetch_array(mysql_query("SELECT * FROM  submenu_utama WHERE link_menu LIKE  '%$_GET[md]%'"));
                      $o = mysql_fetch_array(mysql_query("SELECT MAX(kode_penyi) FROM tbl_penyiapan"));
                      $ro = $o[0]+1;
                      echo "<h3>Form <span class='label labelform label-info'>Input</span> Data $t[nama_sub]</h3>";
                      include 'include/notif.php';

                       $qe = mysql_fetch_array(mysql_query("SELECT r.nama_keg_ren, r.kode_ren, r.mulai_ren, r.selesai_ren, r.tempat_ren, r.desk_ren, r.anggaran_ren, j.id_jab, p.id_pegawai
                          FROM tbl_rencana r, jabatan j, pegawai p
                          WHERE r.id_rencana =  '$_GET[a]'
                          AND j.id_jab = p.id_jab
                          AND p.id_pegawai = r.id_pegawai"));
                       $start = dbtoindo($qe['mulai_ren']);
                       $finish = dbtoindo($qe['selesai_ren']);
                      ?>
                      </div>
                      <div id='info_peren'></div>

                      <form action="mod_sistem/md_b.kumkm/action/act_siap.php?md=<?php echo "$_GET[md]";?>&amp;ac=siap_ins" method='POST' class='form-horizontal'>
                            <div class="control-group">
                              <label for="" class="control-label">Perencanaan</label>
                              <div class="controls">
                              <select name="nama_peren" id='nama_peren'>
                                <option value="0">Pilih Rencana</option>
                                <?php 
                                  $i = mysql_query("SELECT id_rencana, nama_keg_ren FROM tbl_rencana ORDER BY nama_keg_ren ASC");
                                  while ($u=mysql_fetch_array($i)) {
                                    echo "<option value='$u[0]'>$u[1]</option>";
                                  }
                                 ?>
                              </select>                              
                              </div>
                            </div>                            

                            <div class="control-group">
                            <label class="control-label">Nomor</label>
                            <div class="controls">                    
                              <input type="text" name='no_siap' id='kdpenyi1' value='<?php echo "00$ro"; ?>'>
                            </div>
                            <div id="kdpenyi2"></div>
                            </div>


                            <div class="control-group">
                            <label class="control-label">Nama Persiapan</label>
                            <div class="controls">                    
                              <input type="text" name='nper' value=''>
                            </div>
                            </div>

                            <div class="alert alert-error" id="alert" style='display:none;'>
                            <strong>&nbsp;</strong>
                            </div>

                            <div class="control-group">
                              <label class='control-label'>Mulai</label>
                              <div class="controls">
                                <div class="input-append date" id='datemulai' data-date='<?php echo date("d-m-Y"); ?>' data-date-format='dd-mm-yyyy'>
                                  <input class="span12" size="16" type="text" readonly name='s' value=''>
                                  <span class="add-on"><i class="icon-calendar"></i></span>
                                </div>
                              </div>
                            </div>

                            <div class="control-group">
                              <label class='control-label'>Selesai</label>
                              <div class="controls">
                                <div class="input-append date" id='dateselesai' data-date='<?php echo date("d-m-Y"); ?>' data-date-format='dd-mm-yyyy'>
                                  <input class="span12" size="16" type="text" readonly name='f' value=''>
                                  <span class="add-on"><i class="icon-calendar"></i></span>
                                </div>
                              </div>
                            </div>

                            <div class="control-group">
                              <label class="control-label">Tempat</label>
                              <div class="controls">
                                <input type="text" name='tp' value=''>
                              </div>
                            </div>

                            <div class="control-group">
                            <label class='control-label'>Penanggungjawab</label>
                            <div class="controls">
                              <select name="pj" id='jab-ren'>
                                <option value="0">Pilih PJ</option>
                                <?php  
                                $j = mysql_query("SELECT * FROM jabatan WHERE id_jab!='14' ORDER BY nama_jab ASC");
                                while ($dj=mysql_fetch_array($j)) {                      
                                  echo "<option value='$dj[0]'>$dj[1]</option>";
                                }
                                ?>
                              </select>
                            </div>
                            </div>
                          <div class="control-group">
                            <label class='control-label'>Pegawai</label>
                            <div class="controls">
                              <select name="np" id='peg'>
                                <option value="0">Pilih Pegawai</option>
                                <option value="0">Pilih dulu Jabatannya</option>
                            </select>
                            </div>
                          </div>
                              

                              <div class="control-group">
                                <label class='control-label'>Anggaran</label>
                                <div class="controls">
                                  <input type="text" name='ang' id='ang' value=''>
                                </div>
                              </div> 

                              <div class="control-group">
                                <label class='control-label'>Deskripsi Persiapan</label>
                                <div class="controls">
                                  <textarea name="dper" id="" cols="30" rows="5"></textarea>
                                </div>
                              </div>                                                          
                              <div class="control-group">                
                              <div class="controls pull-left">
                                <input type="submit" value='Simpan' class='btn btn-info'>
                                <input type="reset" value='Reset' class='btn btn-inverse'>
                                <input type="hidden" name="h_idkeg" value="<?php echo "$_GET[md]"; ?>">
                              </div>
                              </div>                        
                        </form>
                  </div>
              <!-- form2 -->
                  <div class="span6">
                      <div class="page-header">
                        <?php                               
                        $i = mysql_fetch_array(mysql_query("SELECT MAX(penyi_sub_kode) FROM tbl_sub_penyiapan"));
                        $dl = $i[0]+1;
                        echo "<h3>Form <span class='label labelform label-info'>Input</span> Data Sub $t[nama_sub]</h3>";
                        include 'include/notif_sub.php';
                        ?>
                      </div>
                      <form action="mod_sistem/md_b.kumkm/action/act_siap.php?ac=sub_ins" method="POST" class='form-horizontal'> 
                                    <div class="control-group">
                                      <label class="control-label">Pilih Kegiatan Penyiapan</label>
                                      <div class="controls">
                                        <select name="kp" id='kp'>
                                          <option value="0">Pilih Penyiapan</option>
                                          <?php 
                                            $i = mysql_query("SELECT kode_penyi, nama_kegiatan_penyi FROM tbl_penyiapan ORDER BY nama_kegiatan_penyi ASC");
                                            while ($u=mysql_fetch_array($i)) {                          
                                              echo "<option value='$u[0]'>$u[1]</option>";                          
                                            }
                                           ?>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="control-group">
                                      <label class="control-label">Kode</label>
                                      <div class="controls">
                                        <input type="text" class='input-small' id='idren' name='idren' readonly placeholder='pilih rencana'>&nbsp;-&nbsp;
                                        <!-- alasan mengapa sub -> input pake readonly kok gak pas update saja dikarenakan kode ini gabungan ntr sama kodenya penyi -->
                                        <input type="text" class='input-small' readonly name='idsub' value='<?php echo "$dl"; ?>'>
                                      </div>
                                    </div>

                                    <div class="control-group">
                                      <label class="control-label">Nama Sub Penyiapan</label>
                                      <div class="controls">                    
                                        <input type="text" name='nmsub'>
                                      </div>
                                    </div>

                                    <div class="alert alert-error" id="alerterror" style='display:none;'>
                                    <strong>&nbsp;</strong>
                                    </div>
                                    <div class="control-group">
                                      <label class='control-label'>Mulai</label>
                                      <div class="controls">
                                        <div class="input-append date" id='tglmulai' data-date='<?php echo date("d-m-Y"); ?>' data-date-format='dd-mm-yyyy'>
                                          <input class="span12" size="16" type="text" readonly name='s'>
                                          <span class="add-on"><i class="icon-calendar"></i></span>
                                        </div>
                                      </div>
                                    </div>

                                    <div class="control-group">
                                      <label class='control-label'>Selesai</label>
                                      <div class="controls">
                                        <div class="input-append date" id='tglselesai' data-date='<?php echo date("d-m-Y"); ?>' data-date-format='dd-mm-yyyy'>
                                          <input class="span12" size="16" type="text" readonly name='f'>
                                          <span class="add-on"><i class="icon-calendar"></i></span>
                                        </div>
                                      </div>
                                    </div>

                                    <div class="control-group">
                                    <label class='control-label'>Deskripsi</label>
                                    <div class="controls">
                                      <textarea name="dk" cols="30" rows="5"></textarea>
                                    </div>
                                    </div>
                                    <div class="control-group">                
                                      <div class="controls pull-left">
                                        <input type="submit" value='Simpan' class='btn btn-info'>
                                        <input type="reset" value='Reset' class='btn btn-inverse'>
                                        <input type="hidden" name="h_idkeg" value="<?php echo "$_GET[md]"; ?>">
                                      </div>
                                    </div>  
                      </form>
                  </div>
       <?php
       break;
   }
   ?>
   <!-- tabel 1 -->
   <div class="span12" id='tbl_penyi' style='margin-left: 0px;margin-bottom:50px;'>
                    <div class='page-header'>
                        <?php 
                          $t = mysql_fetch_array(mysql_query("SELECT * FROM  submenu_utama WHERE link_menu LIKE  '%$_GET[md]%'"));
                          $jumrow = mysql_num_rows(mysql_query("SELECT py.id_penyiapan
                                FROM tbl_rencana r
                                JOIN tbl_penyiapan py ON r.id_rencana = py.id_rencana
                                JOIN tbl_sub_penyiapan spy ON py.id_penyiapan = spy.id_penyiapan
                                JOIN tbl_pelaksanaan pl ON spy.id_sub_penyi = pl.id_sub_penyi
                                GROUP BY r.id_rencana"));
                          echo "<h3>Tabel $t[nama_sub]</h3>
                          <p>Ada <span class='badge badge-warning'><a href='?md=penyinotin' target='_blank'>$jumrow</a></span> Penyiapan yang sudah dilakukan Pelaksanaan</p>
                          ";
                          
                         ?>
                        </div> 
                        <?php include "include/notif_tabel.php"; ?>
                       <table class='table table-bordered table-striped table-hover' id="table_id">
                        <thead>
                          <tr>                      
                            <th rowspan='2'>Setting</th>
                            <th rowspan='2'>Status Data</th>
                            <th rowspan='2'>Kode</th>
                            <th rowspan='2'>Perencanaan</th>
                            <th rowspan='2'>Persiapan</th>
                            <th colspan='2'>Tanggal Persiapan</th>
                            <th rowspan='2'>Anggaran Perencanaan</th>
                            <th rowspan='2'>Anggaran Persiapan</th>
                            <th rowspan='2'>Tempat</th>
                            <th rowspan='2'>Deskripsi Persiapan</th>                            

                          </tr>
                          <tr>
                            <th>Mulai</th><th>Selesai</th>
                          </tr>
                        </thead>                        
                        <tbody>
                          <?php                            
                            $u=mysql_query("SELECT py.id_penyiapan, py.nama_kegiatan_penyi, py.status_kunci, py.tgl_mulai_penyi1, py.tgl_selesai_penyi1, py.kode_penyi, r.nama_keg_ren, r.anggaran_ren, py.anggaran, py.tempat_penyi, py.deskripsi_penyi, py.owner
                              FROM tbl_rencana r
                              JOIN tbl_penyiapan py ON r.id_rencana=py.id_rencana
                              WHERE py.id_penyiapan NOT IN (
                                SELECT py.id_penyiapan
                                FROM tbl_rencana r
                                JOIN tbl_penyiapan py ON r.id_rencana = py.id_rencana
                                JOIN tbl_sub_penyiapan spy ON py.id_penyiapan = spy.id_penyiapan
                                JOIN tbl_pelaksanaan pl ON spy.id_sub_penyi = pl.id_sub_penyi
                                GROUP BY r.id_rencana
                              )");
                            while ($dt = mysql_fetch_array($u)) {
                              $awal1 = dbtoindo($dt['tgl_mulai_penyi1']);
                              $akhir1 = dbtoindo($dt['tgl_selesai_penyi1']);                              
                              $ra = rand(00,55);
                              $ruwet=md5($dt['kode_penyi']).$ra."$dt[kode_penyi]";
                              $uangtb1 = number_format($dt['anggaran_ren'],2,",",".");
                              $uangtb2 = number_format($dt['anggaran'],2,",",".");

                              echo "<tr>
                              <td>";
                              if($dt['owner']==$_SESSION['iduser']){
                                ?>
                                <div class="btn-group">
                                  <a class="btn btn-success" href="#"><i class="icon-cog"></i></a>
                                  <a class="btn btn-success dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                                  <ul class="dropdown-menu">
                                    <li><a href="?md=<?php echo "$_GET[md]"; ?>&amp;p=update&amp;kode=<?php echo "$dt[id_penyiapan]"; ?>"><i class="icon-edit"></i> Edit</a></li>
                                    <li><a href='mod_sistem/md_b.kumkm/action/act_siap.php?md=<?php echo "$_GET[md]";?>&amp;ac=siap_del&amp;page=<?php echo "$dt[id_penyiapan]"; ?>&amp;id=<?php echo "$ruwet"; ?>' onclick="return confirm('Anda yakin ingin mengahapus data ini ?');"><i class="icon-trash"></i> Hapus</a></li>                    
                                    <?php  
                                    # filter lagi dropdown buka / kunci data
                                    echo "<li class='divider'></li>";
                                    if($dt['status_kunci']=='0'){
                                      echo "<li><a href='mod_sistem/md_b.kumkm/action/act_siap.php?md=$_GET[md]&amp;ac=on&amp;page=$dt[id_penyiapan]&amp;id=$ruwet' class='doc' rel='popover' data-content='Bila Anda membuka kunci Akses maka data ini akan bisa diakses oleh pengguna lain. Akses meliputi Edit dan Hapus' data-original-title='Informasi_Perbolehkan_Akses_Data' data-trigger='hover'><i class='icon-unlock'></i> Perbolehkan Akses</a></li>";
                                    }elseif($dt['status_kunci']=='1'){
                                      echo "<li><a href='mod_sistem/md_b.kumkm/action/act_siap.php?md=$_GET[md]&amp;ac=off&amp;page=$dt[id_penyiapan]&amp;id=$ruwet class='doc' rel='popover' data-content='Bila Anda menutup kunci Akses maka data ini akan tidak bisa lagi diakses oleh pengguna lain. Tutup Akses meliputi Edit dan Hapus' data-original-title='Informasi_Kunci_Akses_Data' data-trigger='hover'><i class='icon-lock'></i> Tutup Akses</a></li>"; 
                                    }

                                    ?>
                                  </ul>
                                </div>

                                <?php
                              }elseif($dt['owner']!=$_SESSION['iduser'] && $dt['status_kunci']=='1'){
                                ?>
                                <div class="btn-group">
                                  <a class="btn btn-success" href="#"><i class="icon-cog"></i></a>
                                  <a class="btn btn-success dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                                  <ul class="dropdown-menu">
                                    <li><a href="?md=<?php echo "$_GET[md]"; ?>&amp;p=update&amp;kode=<?php echo "$dt[id_penyiapan]"; ?>"><i class="icon-edit"></i> Edit</a></li>
                                    <li><a href='mod_sistem/md_b.kumkm/action/act_siap.php?md=<?php echo "$_GET[md]";?>&amp;ac=siap_del&amp;page=<?php echo "$dt[id_penyiapan]"; ?>&amp;id=<?php echo "$ruwet"; ?>' onclick="return confirm('Anda yakin ingin mengahapus data ini ?');"><i class="icon-trash"></i> Hapus</a></li>
                                  </ul>
                                </div>

                                <?php
                              }elseif($dt['owner']!=$_SESSION['iduser']){
                                #data terkunci gak tampil apa2.
                              }

                              if($dt['status_kunci']=='0'){
                                echo "<td><center><i class='icon-lock doc' rel='popover' data-content='Data ini Terkunci'  data-trigger='hover'></i></center></td>";
                              }else{
                                echo "<td><center><i class='icon-unlock doc' rel='popover' data-content='Data ini Terbuka'  data-trigger='hover'></i></center></td>";
                              }

                              echo "                              
                              <td>$dt[kode_penyi]</td>
                              <td>$dt[nama_keg_ren]</td>
                              <td>$dt[nama_kegiatan_penyi]</td>
                              <td>$awal1</td>
                              <td>$akhir1</td>
                              <td>Rp. $uangtb1</td>
                              <td>Rp. $uangtb2</td>
                              <td>$dt[tempat_penyi]</td>
                              <td>$dt[deskripsi_penyi]</td>                              
                              </tr>";
                            }
                          ?>
                          </tbody>
                          </table>
   </div>
   <!-- tabel 2 -->
   <div class="span12" id='tbl_sub_penyi' style='margin-left: 0px;margin-bottom:50px;'>
              <div class='page-header'>
                <?php 
                  $t = mysql_fetch_array(mysql_query("SELECT * FROM  submenu_utama WHERE link_menu LIKE  '%$_GET[md]%'"));
                  echo "<h3>Tabel Sub $t[nama_sub]</h3>"; 
                 ?>
              </div> 
              <?php include "include/notif_tabel_sub.php"; ?>
              <table class='table table-bordered table-striped table-hover' id="table_id_scroll">
                <thead>
                  <tr>
                    
                    <th>Setting</th>
                    <th>Status Data</th>
                    <th>Kode</th>
                    <th>Penyiapan</th>
                    <th>Nama Sub</th>
                    <th>Mulai</th>
                    <th>Selesai</th>
                    <th>Deskripsi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $u=mysql_query("SELECT s.*, py.nama_kegiatan_penyi, py.kode_penyi FROM tbl_sub_penyiapan s, tbl_penyiapan py WHERE py.id_penyiapan=s.id_penyiapan AND s.status_proses='0' ORDER BY s.id_sub_penyi DESC");
                    while ($dt = mysql_fetch_array($u)) {
                      $start = dbtoindo($dt['penyi_sub_mulai']);
                      $finish = dbtoindo($dt['penyi_sub_selesai']);
                      $ruwet=md5($dt['penyi_sub_kode']);
                      echo "<tr>
                      <td>";
                      if($dt['owner']==$_SESSION['iduser']){
                        ?>
                        <div class="btn-group">
                          <a class="btn btn-success" href="#"><i class="icon-cog"></i></a>
                          <a class="btn btn-success dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                          <ul class="dropdown-menu">
                            <li><a href="?md=<?php echo "$_GET[md]"; ?>&amp;p=update_sub&amp;kode_sub=<?php echo "$dt[id_sub_penyi]"; ?>"><i class="icon-edit"></i> Edit</a></li>
                            <li><a href='mod_sistem/md_b.kumkm/action/act_siap.php?md=<?php echo "$_GET[md]";?>&amp;ac=sub_rm&amp;page=<?php echo "$dt[id_sub_penyi]"; ?>&amp;id=<?php echo "$ruwet"; ?>' onclick="return confirm('Anda yakin ingin mengahapus data ini ?');"><i class="icon-trash"></i> Hapus</a></li>
                            <li class='divider'></li>
                            <?php  
                            if($dt['status_kunci']=='0'){
                              echo "<li><a href='mod_sistem/md_b.kumkm/action/act_siap.php?md=$_GET[md]&amp;ac=on_sub&amp;page=$dt[id_sub_penyi]&amp;id=$ruwet' class='doc' rel='popover' data-content='Bila Anda membuka kunci Akses maka data ini akan bisa diakses oleh pengguna lain. Akses meliputi Edit dan Hapus' data-original-title='Informasi_Perbolehkan_Akses_Data' data-trigger='hover'><i class='icon-unlock'></i> Perbolehkan Akses</a></li>";
                            }else{
                              echo "<li><a href='mod_sistem/md_b.kumkm/action/act_siap.php?md=$_GET[md]&amp;ac=off_sub&amp;page=$dt[id_sub_penyi]&amp;id=$ruwet class='doc' rel='popover' data-content='Bila Anda menutup kunci Akses maka data ini akan tidak bisa lagi diakses oleh pengguna lain. Tutup Akses meliputi Edit dan Hapus' data-original-title='Informasi_Kunci_Akses_Data' data-trigger='hover'><i class='icon-lock'></i> Tutup Akses</a></li>";
                            }

                            ?>                    
                          </ul>
                        </div>
                        <?php
                      }elseif($dt['owner']!=$_SESSION['iduser'] && $dt['status_kunci']=='1'){
                        ?>
                        <div class="btn-group">
                          <a class="btn btn-success" href="#"><i class="icon-cog"></i></a>
                          <a class="btn btn-success dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                          <ul class="dropdown-menu">
                            <li><a href="?md=<?php echo "$_GET[md]"; ?>&amp;p=update_sub&amp;kode_sub=<?php echo "$dt[id_sub_penyi]"; ?>"><i class="icon-edit"></i> Edit</a></li>
                            <li><a href='mod_sistem/md_b.kumkm/action/act_siap.php?md=<?php echo "$_GET[md]";?>&amp;ac=sub_rm&amp;page=<?php echo "$dt[id_sub_penyi]"; ?>&amp;id=<?php echo "$ruwet"; ?>' onclick="return confirm('Anda yakin ingin mengahapus data ini ?');"><i class="icon-trash"></i> Hapus</a></li>                    
                          </ul>
                        </div>

                        <?php
                      }elseif($dt['owner']!=$_SESSION['iduser']){
                        #gak ada
                      }

                      echo "</td>";
                      if($dt['status_kunci']=='0'){
                         echo "<td><center><i class='icon-lock doc' rel='popover' data-content='Data ini Terkunci'  data-trigger='hover'></i></center></td>";
                       }else{
                         echo "<td><center><i class='icon-unlock doc' rel='popover' data-content='Data ini Terbuka'  data-trigger='hover'></i></center></td>";
                       }                      
                      echo"<td>$dt[kode_penyi].$dt[penyi_sub_kode]</td>
                      <td>$dt[nama_kegiatan_penyi]</td>
                      <td>$dt[penyi_sub_nama]</td>
                      <td>$start</td>
                      <td>$finish</td>
                      <td>$dt[penyi_sub_deskripsi]</td>
                      </tr>";
                    }
                  ?>
                </tbody>
              </table>
   </div>
</div>
