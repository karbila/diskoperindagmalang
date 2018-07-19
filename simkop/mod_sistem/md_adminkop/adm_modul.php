<div class="row-fluid">

    <?php  
      switch ($_GET['p']) {
        case 'upd_mod':
          # edit modul
          ?>
        <div class='span12'>
          <div class='page-header'>
            <h3>Form <span class='label labelform label-warning'>Edit</span> Modul Tahapan Kegiatan</h3>
            <?php 

            $o = mysql_fetch_array(mysql_query("SELECT k.id_modul, k.nama_modul, k.nama_alias, k.link_modul, k.mod_status, s.id_sub, s.nama_sub, j.id_jab, j.nama_jab
                  FROM kop_modul k, submenu_utama s, menu_utama m, jabatan j
                  WHERE j.id_jab = m.id_jab
                  AND m.id_menu = s.id_menu
                  AND s.id_sub = k.id_sub
                  AND k.id_modul =  '$_GET[page]'"));
              ?>
          </div>
          <?php include 'include/notif.php'; ?> 
          <form class="form-horizontal" method='POST' action='mod_sistem/md_adminkop/action/act_modul.php?ac=ed'>

              <div class="control-group">
                    <label for="" class="control-label">Diakses Oleh</label>
                    <div class="controls">
                        <select name="jabatan" id="jab">
                            <option value="0">Pilih Jabatan</option>
                            <?php  
                                $l=mysql_query("SELECT id_jab, nama_jab FROM  jabatan ORDER BY nama_jab ASC");
                                while ($y=mysql_fetch_array($l)) { 
                                    if($o['id_jab']==$y[0]){
                                      echo "<option value='$y[0]' selected>$y[1]</option>";
                                    }else{
                                      echo "<option value='$y[0]'>$y[1]</option>";
                                    } 
                                    
                                }
                            ?>
                        </select>
                    </div>
                </div>


                <div class="control-group">
                    <label for="" class="control-label">Sub Menu</label>
                    <div class="controls">
                        <select name="submenu" id="submenu">
                            <option value="0">Pilih Sub Menu</option>
                            <?php 
                            // MANIPULASI AJAX BROW
                            if(empty($_GET['idjab'])){
                              $r = mysql_query("SELECT s.id_sub, s.nama_sub
                                    FROM submenu_utama s, menu_utama m, jabatan j
                                    WHERE j.id_jab = m.id_jab
                                    AND m.id_menu = s.id_menu
                                    AND  j.id_jab =  '$o[id_jab]'");
                              while ($ww = mysql_fetch_array($r)) {
                                if($o['id_sub']==$ww[0]){
                                  echo "<option value='$ww[0]' selected>$ww[1]</option>";
                                }else{
                                  echo "<option value='$ww[0]'>$ww[1]</option>";
                                }
                              }
                            }else{
                              echo "<option value='0'>Pilih dahulu Jabatan</option>";
                            }

                            ?>
                        </select>
                    </div>
                </div>
              <div class="control-group">
                      <label class="control-label">Nama Modul (Tahapan)</label>
                      <div class="controls">                     
                        <input type="text" name='tah' value='<?php echo "$o[nama_modul]"; ?>'>
                      </div>
                </div>

                <div class="control-group">
                      <label class="control-label">Nama Alias Tahapan</label>
                      <div class="controls">                     
                        <input type="text" name='altah' value='<?php echo "$o[nama_alias]"; ?>'>
                      </div>
                </div>

                

                <div class="control-group">
                      <label class="control-label">Link Lama Anda</label>
                      <div class="controls">                     
                        <div class="alert span3"><strong><?php echo "$o[link_modul]"; ?></strong></div> 
                      </div>
                      <br>
                      <br>
                      <br>
                      <div class="controls">
                          <label class='checkbox'>
                          <input type="checkbox" id='rubah' onclick='rubah_link()'> Rubah Link ? 
                          </label>
                      </div>                      
                </div>


                <div class="control-group" id='rubah1' style='display:none;'>
                      <label class="control-label">Link Modul</label>
                      <div class="controls">                     
                        <input type="text" class='span1' name='link' placeholder='?md=' disabled>
                        <input type="text" id='link' class='input-medium' name='link' placeholder='namamodul'>
                      </div>
                      <div id='alert_link'></div>
                </div>
                <div class="control-group" id='rubah2' style='display:none;'>              
                    <label class="control-label">Informasi URL Modul</label>
                    <div class="controls">
                      <a href="#" class='btn btn-success doc' role="button" data-content="Anda tulis namamodul di field yang disediakan dan nanti URL akan tercipta otomatis menjadi ?md=[namaUrlAnda]" data-original-title="Informasi Penulisan Link" data-trigger="hover"><i class='icon-question'></i></a>
                    </div>
                </div>                

                <div class="control-group pull-left both">
                      <div class="controls" style="text-align:center;">  
                        <input type="hidden" name="h_idkeg" value="<?php echo "$_GET[md]"; ?>">
                        <input type="hidden" name='idmod' value='<?php echo "$o[id_modul]"; ?>'>
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <button type="button" class="btn" onclick='self.history.back()'>Batal</button>
                      </div>
                </div>
          </form>
        </div>

          <?php
          break;
        
        default:
          # insert modul
          ?>
          <div class='span12'>
            <div class='page-header'>
              <h3>Form <span class='label labelform label-info'>Input</span> Tahapan Kegiatan / Modul (Dropdown Level 2)</h3>              
            </div>
            <?php include 'include/notif.php'; ?>
            <form class="form-horizontal" method='POST' action='mod_sistem/md_adminkop/action/act_modul.php?ac=add'>
                
                <div class="control-group">
                    <label for="" class="control-label">Diakses Oleh</label>
                    <div class="controls">
                        <select name="jabatan" id="jab">
                            <option value="0">Pilih Jabatan</option>
                            <?php  
                                $l=mysql_query("SELECT * FROM  jabatan");
                                while ($y=mysql_fetch_array($l)) {
                                    echo "<option value='$y[0]'>$y[1]</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>


                <div class="control-group">
                    <label for="" class="control-label">Sub Menu</label>
                    <div class="controls">
                        <select name="submenu" id="submenu">
                            <option value="0">Pilih Sub Menu</option>
                            <option value='0'>:( - Pilih dahulu Jabatan</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                      <label class="control-label">Nama Modul (Tahapan)</label>
                      <div class="controls">                     
                        <input type="text" name='tah' value='' id='tah'>
                      </div>
                </div>

                <div class="control-group">
                      <label class="control-label">Nama Alias Tahapan</label>
                      <div class="controls">                     
                        <input type="text" name='altah' id='alias'>
                      </div>
                </div>

                

                <div class="control-group">
                      <label class="control-label">Link Modul</label>
                      <div class="controls">                     
                        <input type="text" class='span1' name='link' placeholder='?md=' disabled>
                        <input type="text" id='link' class='input-medium' name='link' placeholder='namamodul'>
                      </div>
                      <div id='alert_link'></div>
                </div>
                <div class="control-group">              
                    <label class="control-label">Informasi URL Modul</label>
                    <div class="controls">
                      <a href="#" class='btn btn-success doc' role="button" data-content="Anda tulis namamodul di field yang disediakan dan nanti URL akan tercipta otomatis menjadi ?md=[namaUrlAnda]" data-original-title="Informasi Penulisan Link" data-trigger='hover'><i class='icon-question'></i></a>
                    </div>
                </div>

                <div class="control-group">
                      <label class="control-label">Status</label>
                      <div class="controls">                                         
                         <span class='radio_b'><input type="radio" class='ra' name="radio_tah" id="" value='Y'><i class='radio_text'>Aktif</i></span>
                         <span class='radio_b'><input type="radio" class='ra' name="radio_tah" id="" value='N'><i class='radio_text'>Tidak Aktif</i></span>
                      </div>
                </div>

                <div class="control-group pull-left">
                      <div class="controls" style="text-align:center;">  
                        <input type="hidden" name="h_idkeg" value="<?php echo "$_GET[md]"; ?>">            
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <button type="button" class="btn" onclick='self.history.back()'>Batal</button>
                      </div>
                </div>
            </form>
          </div>
          <?php
          break;
      }
    ?>
  <div class="span12 rapatkan" id='tabel_modul'>
    <!-- tabel -->
    <div class='page-header'><h3>Tabel Modul (Dropdown Level 2)</h3></div>
    <?php include 'include/notif_tabel.php'; ?>
    <table class='table table-bordered table-striped table-hover' id="table_id">
          <thead>
                <th>Aksi</th>
                <th>No.</th>
                <th>Nama Modul (Dropdown Level 2)</th>
                <th>Nama Sub Menu (Dropdown Level 1)</th>
                <th>Menu Utama</th>
                <th>Level Akses</th>
                <th width='20%'>Link</th>
                <th>Status</th>                
          </thead>
          <tbody>

            <?php  
                $u = mysql_query("SELECT k.*, s.id_sub, s.nama_sub, m.nama_menu, j.id_jab, j.nama_jab
                  FROM kop_modul k, submenu_utama s, menu_utama m, jabatan j
                  WHERE j.id_jab = m.id_jab
                  AND m.id_menu = s.id_menu
                  AND s.id_sub = k.id_sub
                  ORDER BY k.id_modul DESC");
                $no=1;
                while ($p=mysql_fetch_array($u)) {
                    if($p['mod_status']=='Y'){
                      $t = "<center><i class='icon-ok-sign doc'  data-content='Aktif' data-trigger='hover' data-placement='left'></i></center>";
                    }elseif($p['mod_status']=='N'){
                      $t = "<center><i class='icon-minus-sign icon-2x doc'  data-content=' Tidak Aktif' data-trigger='hover' data-placement='left'></i></center>";
                    }
                    $ruwet = md5($p['nama_sub']).md5($p['nama_alias']);

                    echo "
                    <tr><td>";
                    ?>
                    <div class="btn-group btn-small">
                       <a class="btn btn-success btn-small" href="#"><i class="icon-cog"></i></a>
                       <a class="btn btn-success btn-small dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                       <ul class="dropdown-menu">
                         <li><a href='?md=<?php echo "$_GET[md]"; ?>&amp;p=upd_mod&amp;page=<?php echo "$p[0]"; ?>'><i class='icon-edit'></i> Edit</a></li>
                         <li><a href='mod_sistem/md_adminkop/action/act_modul.php?md=<?php echo "$_GET[md]"; ?>&amp;ac=d&amp;page=<?php echo "$p[0]"; ?>&amp;id=<?php echo "$ruwet"; ?>' onclick="return confirm('Anda yakin ingin mengahapus data ini ?');"><i class="icon-trash"></i> Hapus</a></li>
                         <li class='divider'></li>
                         <?php  
                         if($p['mod_status']=='Y'){
                            ?>
                            <li><a href='mod_sistem/md_adminkop/action/act_modul.php?md=<?php echo "$_GET[md]"; ?>&amp;ac=a&amp;page=<?php echo "$p[0]"; ?>&amp;id=<?php echo "$ruwet"; ?>'><i class="icon-minus-sign"></i> Non Aktifkan</a></li>
                            <?php
                         }else{
                            ?>
                            <li><a href='mod_sistem/md_adminkop/action/act_modul.php?md=<?php echo "$_GET[md]"; ?>&amp;ac=n&amp;page=<?php echo "$p[0]"; ?>&amp;id=<?php echo "$ruwet"; ?>'><i class="icon-ok-sign"></i> Aktifkan</a></li>
                            <?php

                         }


                         ?>
                       </ul>
                    </div>

                    <?php

                    echo "</td><td>$no</td>
                    <td>$p[nama_modul]</td>
                    <td>$p[nama_sub]</td>
                    <td>$p[nama_menu]</td>
                    <td>$p[nama_jab]</td>
                    <td>$p[link_modul]</td>
                    <td>$t</td>";
                    echo "</tr>";
                $no++;
                }
            ?>
          </tbody>
    </table>
  </div>  
</div>