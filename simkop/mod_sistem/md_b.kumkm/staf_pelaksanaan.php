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
                        
                        $u=mysql_query("SELECT l.id_pelaksanaan, l.kode_laksana, l.nama_laksana, l.tgl_m_lak, l.tgl_s_lak, l.tempat_lak, l.des_lak, l.ang_lak, py.nama_kegiatan_penyi, py.anggaran, d.id_dok, d.ukuran, d.tanggal_upload, d.tipe_file, d.nama_dok, p.nama_pegawai,p.id_pegawai, j.nama_jab,j.id_jab, s.id_sub_penyi, s.penyi_sub_kode, l.status_kunci, l.status_proses, l.owner, py.id_penyiapan, s.id_sub_penyi
                              FROM tbl_pelaksanaan l, tbl_penyiapan py, tbl_sub_penyiapan s, dokumen d, pegawai p, jabatan j
                              WHERE l.id_dok = d.id_dok
                              AND l.id_sub_penyi = s.id_sub_penyi
                              AND j.id_jab = p.id_jab AND l.id_pegawai = p.id_pegawai
                              AND s.id_penyiapan = py.id_penyiapan
                              AND l.id_pelaksanaan = '$_GET[kode]'");

                        $dtpe = mysql_fetch_array($u);

                        $awal = dbtoindo($dtpe['tgl_m_lak']);
                        $akhir = dbtoindo($dtpe['tgl_s_lak']); 
                        $uangedit = number_format($dtpe['ang_lak'],0,"",",");  

                        include 'include/notif.php';
                        ?>
                      </div>
                      <form action="mod_sistem/md_b.kumkm/action/act_laksana.php?md=<?php echo "$_GET[md]";?>&amp;ac=laksana_upd" method='POST' class='form-horizontal' enctype='multipart/form-data'>                        
                            <div class="control-group">
                              <label for="" class="control-label">Persiapan</label>
                              <div class="controls">
                              <select name="id_siap" id='id_siap'>
                                <option value="0">Pilih Persiapan</option>
                                <?php 
                                  $i = mysql_query("SELECT id_penyiapan, nama_kegiatan_penyi FROM tbl_penyiapan ORDER BY nama_kegiatan_penyi ASC");
                                  while ($u=mysql_fetch_array($i)) {
                                    if($dtpe['id_penyiapan']==$u[0]){
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
                              <label class="control-label">Sub Persiapan</label>
                              <div class="controls">
                                <select name="nm_sub" id='nm_sub'>
                                  <option value="0">Pilih Sub Persiapan</option>
                                  <?php 
                                    // cara supaya combo ajax tidak mati saat diedit // IDE TERBARU :)
                                    if(empty($_GET['siap'])){
                                      $m = mysql_query("SELECT s.id_sub_penyi, s.penyi_sub_nama FROM tbl_sub_penyiapan s, tbl_penyiapan py WHERE py.id_penyiapan=s.id_penyiapan AND py.id_penyiapan='$dtpe[id_penyiapan]'");

                                      while ($hh = mysql_fetch_array($m)) {
                                        if($dtpe['id_sub_penyi']==$hh[0]){
                                          echo "<option value='$hh[0]' selected>$hh[1]</option>";
                                        }else{
                                          echo "<option value='$hh[0]'>$hh[1]</option>";
                                        }
                                      }
                                    }else{
                                      echo "<option value='0'>Pilih Persiapan dulu...</option>";
                                    }

                                   ?>
                                  
                                </select>
                              </div>
                            </div>

                            <div class="control-group">
                            <label class="control-label">Nomor</label>
                            <div class="controls">                    
                              <input type="text" name='no_laksana' readonly value='<?php echo "$dtpe[kode_laksana]"; ?>'>
                            </div>
                            </div>

                            <div class="control-group">
                            <label class="control-label">Nama Pelaksanaan</label>
                            <div class="controls">                    
                              <input type="text" name='nm_pelak' value='<?php echo "$dtpe[nama_laksana]"; ?>'>
                            </div>
                            </div>

                            <div class="alert alert-error" id="alert" style='display:none;'>
                            <strong>&nbsp;</strong>
                            </div>
                            <div class="control-group">
                              <label class='control-label'>Mulai</label>
                              <div class="controls">
                                <div class="input-append date" id='datemulai' data-date='<?=date("d-m-Y"); ?>' data-date-format='dd-mm-yyyy'>
                                  <input class="span12" size="16" type="text" readonly name='s' value='<?php echo "$awal"; ?>'>
                                  <span class="add-on"><i class="icon-calendar"></i></span>
                                </div>
                              </div>
                            </div>

                            <div class="control-group">
                              <label class='control-label'>Selesai</label>
                              <div class="controls">
                                <div class="input-append date" id='dateselesai' data-date='<?=date("d-m-Y"); ?>' data-date-format='dd-mm-yyyy'>
                                  <input class="span12" size="16" type="text" readonly name='f' value='<?php echo "$akhir"; ?>'>
                                  <span class="add-on"><i class="icon-calendar"></i></span>
                                </div>
                              </div>
                            </div>

                            <div class="control-group">
                              <label class="control-label">Tempat</label>
                              <div class="controls">
                                <input type="text" name='tp_lak' value='<?php echo "$dtpe[tempat_lak]"; ?>'>
                              </div>
                            </div>

                            <div class="control-group">
                            <label class='control-label'>Penanggungjawab</label>
                            <div class="controls">
                              <select name="pj" id='jab-ren'>
                                <option value="0">Pilih Pelaksana</option>
                                <?php  
                                $j = mysql_query("SELECT * FROM jabatan WHERE id_jab!='14' ORDER BY nama_jab ASC");
                                while ($dj=mysql_fetch_array($j)) {   
                                  if($dtpe['id_jab']==$dj[0]){echo "<option value='$dj[0]' selected>$dj[1]</option>";}else{echo "<option value='$dj[0]'>$dj[1]</option>";}
                                  
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
                                  <input type="text" name='ang_lak' id='ang' value='<?php echo "$uangedit"; ?>'>
                                </div>
                              </div>      
                                               
                            <div class="control-group">
                              <label class="control-label">File Lama</label>
                              <div class="controls">
                                <strong><?php echo "$dtpe[nama_dok]"; ?></strong>
                              </div>
                              <div class="controls">
                                <label class='checkbox'>
                                  <input type="checkbox" name="jadi" value="upload_cek" id='upload_cek' onclick='tampilkan_cek()'>Upload File Baru ? 
                                </label>
                              </div>
                            </div>
                              <div class="control-group" id='upload'>
                                <label class="control-label">Dokumen Pelaksanaan</label>
                                <div class="controls">
                                  <input type="file" name='up_detail'>
                                </div>
                              </div>            

                              <div class="control-group" id='info_upload'>              
                                <label class="control-label">Informasi Upload File</label>
                                <div class="controls">
                                  <a href="#" class='btn btn-success doc' role="button"  data-content="Sistem hanya mendukung file bertipe .doc/.docx, .ppt/.pptx, .xls,.xlsx, .pdf dan .txt. Anda diperbolehkan menyertakan dokumen perencananan atau tidak menyertakannya dalam proses input pelaksanaan." data-trigger='hover' data-original-title="Informasi Upload"><i class='icon-question'></i></a>
                                </div>
                              </div>
                             <div class="control-group">
                                <label class='control-label'>Deskripsi Pelaksanaan</label>
                                <div class="controls">
                                  <textarea name="des_lak" id="" cols="30" rows="5"><?php echo "$dtpe[des_lak]"; ?></textarea>
                                </div>
                              </div>   

                              <div class="control-group">                
                              <div class="controls pull-left">
                                <input type="submit" value='Simpan' class='btn btn-success'>
                                <input type="reset" value='Reset' class='btn btn-inverse'>
                                <input type="hidden" name='h_idkeg' value='<?php echo "$_GET[md]"; ?>'>
                                <input type="hidden" name='kode_pelak' value='<?php echo "$dtpe[id_pelaksanaan]"; ?>'>
                              </div>
                              </div>                        
                      </form>
                  </div>  

                  <!-- form informasi penyiapan -->
                  <div class="span5">
                    <div class="page-header">
                      <h3>&nbsp;</h3>
                    </div>
                    <div id='info_penyi'></div>                    
                  </div>                
                  
                <?php                              
            break;
            case "update_sub":
              ?>
                <div class="span6">
                  <div class="page-header">
                    <?php 
                        $t = mysql_fetch_array(mysql_query("SELECT * FROM  submenu_utama WHERE link_menu LIKE  '%$_GET[md]%'"));
                        $qe = mysql_fetch_array(mysql_query("SELECT s. * , l.id_pelaksanaan, l.nama_laksana, l.kode_laksana FROM tbl_sub_pelaksanaan s, tbl_pelaksanaan l WHERE l.id_pelaksanaan = s.id_pelaksanaan AND s.id_sub_pelak =  '$_GET[kode_sub]'"));
                        
                        echo "<h3>Form <span class='label labelform label-warning'>Edit</span> Data Sub $t[nama_sub]</h3>";
                        $start = dbtoindo($qe['pelak_sub_mulai']);
                        $finish = dbtoindo($qe['pelak_sub_akhir']);
                        include 'include/notif.php';
                     ?>
                  </div>

                    <form action="mod_sistem/md_b.kumkm/action/act_laksana.php?md=<?php echo "$_GET[md]";?>&amp;ac=sub_upd" method='POST' class='form-horizontal'>
                          <input type="hidden" name='kdo' value='<?php echo "$qe[id_sub_pelak]"; ?>'>
                          <div class="control-group">
                              <label class="control-label">Kegiatan Pelaksanaan</label>
                              <div class="controls">
                                <select name="kp" id='kp'>
                                  <option value="0">Pilih Kegiatan</option>
                                  <?php 
                                    $i = mysql_query("SELECT id_pelaksanaan, kode_laksana, nama_laksana FROM tbl_pelaksanaan ORDER by nama_laksana ASC");
                                    while ($u=mysql_fetch_array($i)) {
                                      if($qe['id_pelaksanaan']==$u[0]){
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
                              <label class="control-label">Kode</label>
                              <div class="controls">
                                <input type="text" class='input-small' id='idren' name='idren' readonly placeholder='pilih pelaksanaan' value='<?php echo "$qe[kode_laksana]"; ?>'>&nbsp;-&nbsp;
                                <input type="text" class='input-small'name='idsub' readonly value='<?php echo "$qe[pelak_sub_kode]"; ?>'>
                              </div>
                            </div>

                            <div class="control-group">
                              <label class="control-label">Nama Sub Pelaksanaan</label>
                              <div class="controls">                    
                                <input type="text" name='nmsub'value='<?php echo "$qe[pelak_sub_nama]"; ?>'>
                              </div>
                            </div>

                            <div class="alert alert-error" id="alert" style='display:none;'>
                            <strong>&nbsp;</strong>
                            </div>
                            <div class="control-group">
                              <label class='control-label'>Mulai</label>
                              <div class="controls">
                                <div class="input-append date" id='datemulai' data-date='<?=date("d-m-Y"); ?>' data-date-format='dd-mm-yyyy'>
                                  <input class="span12" size="16" type="text" readonly name='s' value='<?php echo $start; ?>'>
                                  <span class="add-on"><i class="icon-calendar"></i></span>
                                </div>
                              </div>
                            </div>

                            <div class="control-group">
                              <label class='control-label'>Selesai</label>
                              <div class="controls">
                                <div class="input-append date" id='dateselesai' data-date='<?=date("d-m-Y"); ?>' data-date-format='dd-mm-yyyy'>
                                  <input class="span12" size="16" type="text" readonly name='f' value='<?php echo $finish; ?>'>
                                  <span class="add-on"><i class="icon-calendar"></i></span>
                                </div>
                              </div>
                            </div>

                            <div class="control-group">
                            <label class='control-label'>Deskripsi Kegiatan</label>
                            <div class="controls">
                              <textarea name="dk" cols="30" rows="5"><?php echo "$qe[pelak_deskripsi]"; ?></textarea>
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
                        $o = mysql_fetch_array(mysql_query("SELECT MAX(kode_laksana) FROM tbl_pelaksanaan"));
                        $ro = $o[0]+1;
                        echo "<h3>Form <span class='label labelform label-info'>Input</span> Data $t[nama_sub]</h3>";
                        include 'include/notif.php';
                        ?>
                      </div>
                      <div id='info_penyi'></div>

                      <form action="mod_sistem/md_b.kumkm/action/act_laksana.php?md=<?php echo "$_GET[md]";?>&amp;ac=laksana_ins" method='POST' class='form-horizontal' enctype='multipart/form-data'>
                            <div class="control-group">
                              <label for="" class="control-label">Kegiatan Persiapan</label>
                              <div class="controls">
                              <select name="id_siap" id='id_siap'>
                                <option value="0">Pilih Persiapan</option>
                                <?php 
                                  $i = mysql_query("SELECT py.id_penyiapan, py.nama_kegiatan_penyi FROM tbl_penyiapan py ORDER by py.nama_kegiatan_penyi ASC");
                                  while ($u=mysql_fetch_array($i)) {
                                    echo "<option value='$u[0]'>$u[1]</option>";
                                  }
                                 ?>
                              </select>                              
                              </div>
                            </div>

                            <div class="control-group">
                              <label class="control-label">Sub Persiapan</label>
                              <div class="controls">
                                <select name="nm_sub" id='nm_sub'>
                                  <option value="0">Pilih Sub Persiapan</option>
                                  <option value="0">Pilih Persiapan dulu...</option>
                                </select>
                              </div>
                            </div>

                            <div class="control-group">
                            <label class="control-label">Nomor</label>
                            <div class="controls">                    
                              <input type="text" name='no_laksana' id='no_laksana' value='<?php echo "00$ro"; ?>'>
                            </div>
                            <div id="alert_laksana"></div>
                            </div>

                            <div class="control-group">
                            <label class="control-label">Nama Pelaksanaan</label>
                            <div class="controls">                    
                              <input type="text" name='nm_pelak'>
                            </div>
                            </div>

                            <div class="alert alert-error" id="alert" style='display:none;'>
                            <strong>&nbsp;</strong>
                            </div>
                            <div class="control-group">
                              <label class='control-label'>Mulai</label>
                              <div class="controls">
                                <div class="input-append date" id='datemulai' data-date='<?=date("d-m-Y"); ?>' data-date-format='dd-mm-yyyy'>
                                  <input class="span12" size="16" type="text" readonly name='s' value=''>
                                  <span class="add-on"><i class="icon-calendar"></i></span>
                                </div>
                              </div>
                            </div>

                            <div class="control-group">
                              <label class='control-label'>Selesai</label>
                              <div class="controls">
                                <div class="input-append date" id='dateselesai' data-date='<?=date("d-m-Y"); ?>' data-date-format='dd-mm-yyyy'>
                                  <input class="span12" size="16" type="text" readonly name='f' value=''>
                                  <span class="add-on"><i class="icon-calendar"></i></span>
                                </div>
                              </div>
                            </div>

                            <div class="control-group">
                              <label class="control-label">Tempat</label>
                              <div class="controls">
                                <input type="text" name='tp_lak' value=''>
                              </div>
                            </div>

                            <div class="control-group">
                            <label class='control-label'>Penanggungjawab</label>
                            <div class="controls">
                              <select name="pj" id='jab-ren'>
                                <option value="0">Pilih Pelaksana</option>
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
                                <input type="text" name='ang_lak' id='ang' value='' placeholder = 'tidak boleh Rp.0,-'>
                              </div>
                            </div>   

                            <div class="control-group">
                                <label class="control-label">Dokumen Pelaksanaan</label>
                                <div class="controls">
                                  <input type="file" name='up_detail'>
                                </div>
                              </div>            

                              <div class="control-group">              
                                <label class="control-label">Informasi Upload File</label>
                                <div class="controls">
                                  <a href="#" class='btn btn-success doc' role="button"  data-content="Sistem hanya mendukung file bertipe .doc/.docx, .ppt/.pptx, .xls,.xlsx, .pdf dan .txt. Anda diperbolehkan menyertakan dokumen perencananan atau tidak menyertakannya dalam proses input pelaksanaan." data-trigger='hover' data-original-title="Informasi Upload"><i class='icon-question'></i></a>
                                </div>
                              </div>

                             <div class="control-group">
                                <label class='control-label'>Deskripsi Pelaksanaan</label>
                                <div class="controls">
                                  <textarea name="des_lak" id="" cols="30" rows="5"></textarea>
                                </div>
                              </div>   

                              <div class="control-group">                
                              <div class="controls pull-left">
                                <input type="submit" value='Simpan' class='btn btn-success'>
                                <input type="reset" value='Reset' class='btn btn-inverse'>
                                <input type="hidden" name='h_idkeg' value='<?php echo "$_GET[md]"; ?>'>
                              </div>
                              </div>                        
                      </form>
                  </div>

                  <!-- form 2 -->
                  <div class="span6">
                    <div class="page-header">
                        <?php                               
                        $i = mysql_fetch_array(mysql_query("SELECT MAX(pelak_sub_kode) FROM tbl_sub_pelaksanaan"));
                        $dl = $i[0]+1;
                        echo "<h3>Form <span class='label labelform label-info'>Input</span> Data Sub $t[nama_sub]</h3>";
                        include 'include/notif_sub.php';
                        ?>
                      </div>
                      <form action="mod_sistem/md_b.kumkm/action/act_laksana.php?md=<?php echo "$_GET[md]";?>&amp;ac=sub_ins" method='POST' class='form-horizontal'>                          
                          <div class="control-group">
                              <label class="control-label">Kegiatan Pelaksanaan</label>
                              <div class="controls">
                                <select name="kp" id='kp'>
                                  <option value="0">Pilih Kegiatan</option>
                                  <?php 
                                    $i = mysql_query("SELECT kode_laksana, nama_laksana FROM tbl_pelaksanaan ORDER BY nama_laksana ASC ");
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
                                <input type="text" class='input-small' id='idren' name='idren' readonly placeholder='pilih pelaksanaan' value=''>&nbsp;-&nbsp;
                                <input type="text" class='input-small'name='idsub' readonly value='<?php echo "$dl"; ?>'>
                              </div>
                            </div>

                            <div class="control-group">
                              <label class="control-label">Nama Sub Pelaksanaan</label>
                              <div class="controls">                    
                                <input type="text" name='nmsub' value=''>
                              </div>
                            </div>

                            <div class="alert alert-error" id="alerterror" style='display:none;'>
                            <strong>&nbsp;</strong>
                            </div>
                            <div class="control-group">
                              <label class='control-label'>Mulai</label>
                              <div class="controls">
                                <div class="input-append date" id='tglmulai' data-date='<?=date("d-m-Y"); ?>' data-date-format='dd-mm-yyyy'>
                                  <input class="span12" size="16" type="text" readonly name='s' value=''>
                                  <span class="add-on"><i class="icon-calendar"></i></span>
                                </div>
                              </div>
                            </div>

                            <div class="control-group">
                              <label class='control-label'>Selesai</label>
                              <div class="controls">
                                <div class="input-append date" id='tglselesai' data-date='<?=date("d-m-Y"); ?>' data-date-format='dd-mm-yyyy'>
                                  <input class="span12" size="16" type="text" readonly name='f' value=''>
                                  <span class="add-on"><i class="icon-calendar"></i></span>
                                </div>
                              </div>
                            </div>

                            <div class="control-group">
                            <label class='control-label'>Deskripsi Kegiatan</label>
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

                  <div class="span12" id='tbl_pelak' style='margin-left: 0px;margin-bottom:20px;'>
                    <div class='page-header'>
                        <?php 
                          $t = mysql_fetch_array(mysql_query("SELECT * FROM  submenu_utama WHERE link_menu LIKE  '%$_GET[md]%'"));
                          $jumrow = mysql_num_rows(mysql_query("SELECT l.id_pelaksanaan
                                FROM tbl_pelaksanaan l
                                JOIN tbl_sub_pelaksanaan spy ON l.id_pelaksanaan=spy.id_pelaksanaan JOIN tbl_pengawasan a ON spy.id_sub_pelak=a.id_sub_pelak
                                GROUP BY l.id_pelaksanaan"));
                          echo "<h3>Tabel $t[nama_sub]</h3><p>Ada <span class='badge badge-warning'><a href=\"?md=pelaknotin\" target='_blank'>$jumrow</a></span> Pelaksanaan yang sudah dilakukan Pengawasan</p>";
                         ?>
                        </div>
                        <?php include "include/notif_tabel.php"; ?> 
                       <table class='table table-bordered table-striped table-hover' id="table_id">
                        <thead>
                          <tr>
                            <th rowspan='2'>Setting</th>
                            <th rowspan='2'>Status Data</th>
                            <th rowspan='2'>Kode</th>
                            <th rowspan='2'>Nama Persiapan</th>
                            <th rowspan='2'>Nama Pelaksanaan</th>
                            <th colspan='2'>Tanggal Pelaksanaan</th>
                            <th rowspan='2'>Penanggungjawab</th>
                            <th rowspan='2'>Anggaran Penyiapan</th>
                            <th rowspan='2'>Anggaran Pelaksanaan</th>
                            <th rowspan='2'>Tempat</th>
                            <th rowspan='2'>Deskripsi Pelaksanaan</th>                            
                          </tr>
                          <tr>
                            <th>Mulai</th><th>Selesai</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $u=mysql_query("SELECT l.id_pelaksanaan, l.kode_laksana, l.nama_laksana, l.tgl_m_lak, l.tgl_s_lak, l.tempat_lak, l.des_lak, l.ang_lak, py.nama_kegiatan_penyi, py.anggaran, d.id_dok, d.ukuran, d.tanggal_upload, d.tipe_file, d.nama_dok, p.nama_pegawai, j.nama_jab, s.id_sub_penyi, s.penyi_sub_kode, l.status_kunci, l.status_proses, l.owner
                              FROM tbl_pelaksanaan l
                              JOIN tbl_sub_penyiapan s ON s.id_sub_penyi=l.id_sub_penyi JOIN tbl_penyiapan py ON py.id_penyiapan=s.id_penyiapan JOIN tbl_rencana r ON r.id_rencana = py.id_rencana JOIN dokumen d ON d.id_dok=l.id_dok JOIN pegawai p ON p.id_pegawai=l.id_pegawai JOIN jabatan j ON j.id_jab=p.id_jab 
                              WHERE l.id_pelaksanaan NOT IN (
                                SELECT l.id_pelaksanaan
                                FROM tbl_pelaksanaan l
                                JOIN tbl_sub_pelaksanaan spy ON l.id_pelaksanaan=spy.id_pelaksanaan JOIN tbl_pengawasan a ON spy.id_sub_pelak=a.id_sub_pelak
                                GROUP BY l.id_pelaksanaan
                                )");

                            while ($dt = mysql_fetch_array($u)) {
                              $awal1 = dbtoindo($dt['tgl_m_lak']);
                              $akhir1 = dbtoindo($dt['tgl_s_lak']);                              
                              $ra = rand(00,55);
                              $ruwet=md5($dt['kode_laksana']).$ra."$dt[kode_laksana]";
                              $uangtb1 = number_format($dt['ang_lak'],2,",",".");
                              $uangtb2 = number_format($dt['anggaran'],2,",",".");



                              echo "<tr>
                              <td>";

                              if($dt['owner']==$_SESSION['iduser']){
                                ?>
                                <div class="btn-group">
                                  <a class="btn btn-success" href="#"><i class="icon-cog"></i></a>
                                  <a class="btn btn-success dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                                  <ul class="dropdown-menu">
                                    <li><a href="?md=<?php echo "$_GET[md]"; ?>&amp;p=update&amp;kode=<?php echo "$dt[id_pelaksanaan]"; ?>"><i class="icon-edit"></i> Edit</a></li>
                                    <li><a href='mod_sistem/md_b.kumkm/action/act_laksana.php?md=<?php echo "$_GET[md]";?>&amp;ac=laksana_del&amp;page=<?php echo "$dt[id_pelaksanaan]"; ?>&amp;id=<?php echo "$ruwet"; ?>' onclick="return confirm('Anda yakin ingin mengahapus data ini ?');"><i class="icon-trash"></i> Hapus</a></li>     
                                    
                                    
                                    <?php 
                                    if($dt['nama_dok']=='Tidak Ada Dokumen'){
                                      echo "";
                                    }else{
                                      ?>
                                      <li class='divider'></li>
                                      <li><a href="mod_sistem/md_b.kumkm/action/unduh.php?md=<?php echo "$_GET[md]";?>&amp;page=<?php echo "$dt[id_dok]"; ?>&amp;idfile=<?php echo "$dt[ukuran]$dt[tanggal_upload]$dt[id_dok]$ruwet"; ?>" class='doc' rel='popover' data-content='<?php echo "$dt[nama_dok]\n$dt[tipe_file]"; ?>' data-trigger='hover'><i class='icon-download'></i> Download Dokumen</a></li>
                                    
                                    <li><a href="mod_sistem/md_b.kumkm/action/view.php?md=<?php echo "$_GET[md]";?>&amp;page=<?php echo "$dt[id_dok]"; ?>&amp;idfile=<?php echo "$dt[ukuran]$dt[id_dok]$ruwet$dt[tanggal_upload]=="; ?>"><i class='icon-eye-open'></i> View Dokumen</a></li>

                                    <?php
                                    } //else
                                    ?>
                                    <li class='divider'></li>
                                    <?php  
                                    if($dt['status_kunci']=='0'){
                                      echo "<li><a href='mod_sistem/md_b.kumkm/action/act_laksana.php?md=$_GET[md]&amp;ac=on&amp;page=$dt[id_pelaksanaan]&amp;id=$ruwet' class='doc' rel='popover' data-content='Bila Anda membuka kunci Akses maka data ini akan bisa diakses oleh pengguna lain. Akses meliputi Edit dan Hapus' data-original-title='Informasi_Perbolehkan_Akses_Data' data-trigger='hover'><i class='icon-unlock'></i> Perbolehkan Akses</a></li>";
                                    }else{
                                      echo "<li><a href='mod_sistem/md_b.kumkm/action/act_laksana.php?md=$_GET[md]&amp;ac=off&amp;page=$dt[id_pelaksanaan]&amp;id=$ruwet class='doc' rel='popover' data-content='Bila Anda menutup kunci Akses maka data ini akan tidak bisa lagi diakses oleh pengguna lain. Tutup Akses meliputi Edit dan Hapus' data-original-title='Informasi_Kunci_Akses_Data' data-trigger='hover'><i class='icon-lock'></i> Tutup Akses</a></li>";
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
                                  <li><a href="?md=<?php echo "$_GET[md]"; ?>&amp;p=update&amp;kode=<?php echo "$dt[id_pelaksanaan]"; ?>"><i class="icon-edit"></i> Edit</a></li>
                                  
                                  <li><a href='mod_sistem/md_b.kumkm/action/act_laksana.php?md=<?php echo "$_GET[md]";?>&amp;ac=laksana_del&amp;page=<?php echo "$dt[id_pelaksanaan]"; ?>&amp;id=<?php echo "$ruwet"; ?>' onclick="return confirm('Anda yakin ingin mengahapus data ini ?');"><i class="icon-trash"></i> Hapus</a></li>     
                                  
                                  
                                  <?php 
                                  if($dt['nama_dok']=='Tidak Ada Dokumen'){
                                    echo "";
                                  }else{
                                    ?>
                                    <li class='divider'></li>
                                    <li><a href="mod_sistem/md_b.kumkm/action/unduh.php?md=<?php echo "$_GET[md]";?>&amp;page=<?php echo "$dt[id_dok]"; ?>&amp;idfile=<?php echo "$dt[ukuran]$dt[tanggal_upload]$dt[id_dok]$ruwet"; ?>" class='doc' rel='popover' data-content='<?php echo "$dt[nama_dok]\n$dt[tipe_file]"; ?>' data-trigger='hover'><i class='icon-download'></i> Download Dokumen</a></li>
                                  
                                  <li><a href="mod_sistem/md_b.kumkm/action/view.php?md=<?php echo "$_GET[md]";?>&amp;page=<?php echo "$dt[id_dok]"; ?>&amp;idfile=<?php echo "$dt[ukuran]$dt[id_dok]$ruwet$dt[tanggal_upload]=="; ?>"><i class='icon-eye-open'></i> View Dokumen</a></li>

                                  <?php
                                  } //else
                                  ?>
                                </ul>
                              </div>

                                <?php
                              }elseif($dt['owner']!=$_SESSION['iduser']){
                                ?>
                                <div class="btn-group">
                              <a class="btn btn-success" href="#"><i class="icon-cog"></i></a>
                              <a class="btn btn-success dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                              <ul class="dropdown-menu">
                                <?php 
                                if($dt['nama_dok']=='Tidak Ada Dokumen'){
                                  echo "";
                                }else{
                                  ?>                                  
                                  <li><a href="mod_sistem/md_b.kumkm/action/unduh.php?md=<?php echo "$_GET[md]";?>&amp;page=<?php echo "$dt[id_dok]"; ?>&amp;idfile=<?php echo "$dt[ukuran]$dt[tanggal_upload]$dt[id_dok]$ruwet"; ?>" class='doc' rel='popover' data-content='<?php echo "$dt[nama_dok]\n$dt[tipe_file]"; ?>' data-trigger='hover'><i class='icon-download'></i> Download Dokumen</a></li>
                                
                                <li><a href="mod_sistem/md_b.kumkm/action/view.php?md=<?php echo "$_GET[md]";?>&amp;page=<?php echo "$dt[id_dok]"; ?>&amp;idfile=<?php echo "$dt[ukuran]$dt[id_dok]$ruwet$dt[tanggal_upload]=="; ?>"><i class='icon-eye-open'></i> View Dokumen</a></li>

                                <?php
                                } //else
                                ?>
                              </ul>
                            </div>

                                <?php
                              }

                              echo "</td>";

                              if($dt['status_kunci']=='0'){
                                 echo "<td><center><i class='icon-lock doc' rel='popover' data-content='Data ini Terkunci'  data-trigger='hover'></i></center></td>";
                               }else{
                                 echo "<td><center><i class='icon-unlock doc' rel='popover' data-content='Data ini Terbuka'  data-trigger='hover'></i></center></td>";
                               } 

                              echo "
                              <td>$dt[kode_laksana]</td>
                              <td>$dt[nama_kegiatan_penyi]</td>
                              <td>$dt[nama_laksana]</td>
                              <td>$awal1</td>
                              <td>$akhir1</td>
                              <td>$dt[nama_jab]</td>
                              <td>Rp. $uangtb2</td>
                              <td>Rp. $uangtb1</td>
                              <td>$dt[tempat_lak]</td>
                              <td>$dt[des_lak]</td>                              
                              </tr>";
                            }
                          ?>
                          </tbody>
                          </table>
                  </div>

                  <!-- tabel sub -->
                  <div class="span12" id='tbl_sub_pelak' style='margin-left: 0px;margin-bottom:20px;'>
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
                          <th>Pelaksanaan</th>
                          <th>Nama Sub</th>
                          <th>Mulai</th>
                          <th>Selesai</th>
                          <th>Deskripsi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $u=mysql_query("SELECT s. * , l.id_pelaksanaan, l.nama_laksana, l.kode_laksana FROM tbl_sub_pelaksanaan s, tbl_pelaksanaan l WHERE l.id_pelaksanaan = s.id_pelaksanaan ORDER BY s.id_sub_pelak DESC ");

                          while ($dt = mysql_fetch_array($u)) {
                            $start = dbtoindo($dt['pelak_sub_mulai']);
                            $finish = dbtoindo($dt['pelak_sub_akhir']);
                            $ruwet=md5($dt['pelak_sub_kode']);
                            echo "<tr>
                            <td>";
                            if($dt['owner']==$_SESSION['iduser']){
                                ?>
                                <div class="btn-group">
                                  <a class="btn btn-success" href="#"><i class="icon-cog"></i></a>
                                  <a class="btn btn-success dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                      <li><a href="?md=<?php echo "$_GET[md]"; ?>&amp;p=update_sub&amp;kode_sub=<?php echo "$dt[id_sub_pelak]"; ?>"><i class="icon-edit"></i> Edit</a></li>
                                      
                                      <li><a href='mod_sistem/md_b.kumkm/action/act_laksana.php?md=<?php echo "$_GET[md]";?>&amp;ac=sub_rm&amp;page=<?php echo "$dt[id_sub_pelak]"; ?>&amp;id=<?php echo "$ruwet"; ?>' onclick="return confirm('Anda yakin ingin mengahapus data ini ?');"><i class="icon-trash"></i> Hapus</a></li>

                                      <li class='divider'></li>
                                    <?php  
                                    if($dt['status_kunci']=='0'){
                                      echo "<li><a href='mod_sistem/md_b.kumkm/action/act_laksana.php?md=$_GET[md]&amp;ac=on_sub&amp;page=$dt[id_sub_pelak]&amp;id=$ruwet' class='doc' rel='popover' data-content='Bila Anda membuka kunci Akses maka data ini akan bisa diakses oleh pengguna lain. Akses meliputi Edit dan Hapus' data-original-title='Informasi_Perbolehkan_Akses_Data' data-trigger='hover'><i class='icon-unlock'></i> Perbolehkan Akses</a></li>";
                                    }else{
                                      echo "<li><a href='mod_sistem/md_b.kumkm/action/act_laksana.php?md=$_GET[md]&amp;ac=off_sub&amp;page=$dt[id_sub_pelak]&amp;id=$ruwet class='doc' rel='popover' data-content='Bila Anda menutup kunci Akses maka data ini akan tidak bisa lagi diakses oleh pengguna lain. Tutup Akses meliputi Edit dan Hapus' data-original-title='Informasi_Kunci_Akses_Data' data-trigger='hover'><i class='icon-lock'></i> Tutup Akses</a></li>";
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
                                    <li><a href="?md=<?php echo "$_GET[md]"; ?>&amp;p=update_sub&amp;kode_sub=<?php echo "$dt[id_sub_pelak]"; ?>"><i class="icon-edit"></i> Edit</a></li>
                                    
                                    <li><a href='mod_sistem/md_b.kumkm/action/act_laksana.php?md=<?php echo "$_GET[md]";?>&amp;ac=sub_rm&amp;page=<?php echo "$dt[id_sub_pelak]"; ?>&amp;id=<?php echo "$ruwet"; ?>' onclick="return confirm('Anda yakin ingin mengahapus data ini ?');"><i class="icon-trash"></i> Hapus</a></li>
                                  </ul>
                              </div>

                                <?php
                              }elseif($dt['owner']!=$_SESSION['iduser']){
                                #gak dapat akses apa2...
                              }

                            echo "</td>";

                            if($dt['status_kunci']=='0'){
                               echo "<td><center><i class='icon-lock doc' rel='popover' data-content='Data ini Terkunci'  data-trigger='hover'></i></center></td>";
                             }else{
                               echo "<td><center><i class='icon-unlock doc' rel='popover' data-content='Data ini Terbuka'  data-trigger='hover'></i></center></td>";
                             }

                            echo "
                            <td>$dt[kode_laksana].$dt[pelak_sub_kode]</td>
                            <td>$dt[nama_laksana]</td>
                            <td>$dt[pelak_sub_nama]</td>
                            <td>$start</td>
                            <td>$finish</td>
                            <td>$dt[pelak_deskripsi]</td>
                            </tr>";
                          }
                        ?>
                      </tbody>
                    </table>
                  </div>

      </div>
