<div class="row-fluid">  
  <?php  
    switch ($_GET['p']) {
          case 'e':
            ?>
          <!-- awal edit -->
          <div class="span12">
            <div class="page-header">
              <?php 
              $t = mysql_fetch_array(mysql_query("SELECT * FROM  submenu_utama WHERE link_menu LIKE  '%$_GET[md]%'"));
              $qe = mysql_fetch_array(mysql_query("SELECT r.id_rencana, r.kode_ren, r.nama_keg_ren, r.selesai_ren, r.mulai_ren, r.tempat_ren, r.anggaran_ren, r.desk_ren, p.id_pegawai, p.nama_pegawai, j.id_jab, j.nama_jab, d.nama_dok FROM tbl_rencana r, pegawai p, jabatan j, dokumen d WHERE r.id_pegawai=p.id_pegawai AND p.id_jab=j.id_jab AND d.id_dok=r.id_dok AND r.id_rencana='$_GET[kode]'"));

              echo "<h3>Form <span class='label labelform label-warning'>Edit</span> Data $t[nama_sub]</h3>";
              include 'include/notif.php';

              //koversi tanggal dari db ke indo
              $start = dbtoindo($qe['mulai_ren']);
              $finish = dbtoindo($qe['selesai_ren']);
              $r = $qe['anggaran_ren'];
              $uangedit = number_format($r,0,"",",");
              ?>
            </div>
            <form action="mod_sistem/md_b.kumkm/action/act_rencana.php?ac=upd&amp;kode=<?php echo "$qe[id_rencana]";?>" class='form-horizontal' method='POST' enctype='multipart/form-data'>
              <div class="control-group">
                <label class='control-label'>No. Kegiatan</label>
                <div class="controls">
                  <input type="text" name='no' value='<?php echo "$qe[kode_ren]"; ?>'>
                  <input type="hidden" name='id_ren' value='<?php echo "$qe[id_rencana]"; ?>'>
                </div>                
              </div>
              <div class="control-group">
                <label class='control-label'>Nama Kegiatan</label>
                <div class="controls">
                  <input type="text" name='nm' value='<?php echo "$qe[nama_keg_ren]"; ?>'>
                </div>
              </div>
              <div class="alert alert-error" id="alert" style='display:none;'>
              <strong>#</strong>
              </div>
              <div class="control-group">
                <label class='control-label'>Mulai</label>
                <div class="controls">
                  <div class="input-append date" id='datemulai' data-date='20-10-2013' data-date-format='dd-mm-yyyy'>                    
                    <input class="span12" size="16" type="text" readonly name='s' value='<?php echo $start; ?>'>
                    <span class="add-on"><i class="icon-calendar"></i></span>
                  </div>
                </div>
              </div>

              <div class="control-group">
                <label class='control-label'>Selesai</label>
                <div class="controls">
                  <div class="input-append date" id='dateselesai' data-date='25-10-2013' data-date-format='dd-mm-yyyy'>
                    <input class="span12" size="16" type="text" readonly name='f' value='<?php echo $finish; ?>'>
                    <span class="add-on"><i class="icon-calendar"></i></span>
                  </div>
                </div>
              </div>

              <div class="control-group">
                <label class='control-label'>Tempat</label>
                <div class="controls">
                  <input type="text" name='tp' value='<?php echo "$qe[tempat_ren]"; ?>'>
                </div>
              </div>

              <div class="control-group">
                <label class='control-label'>Penanggung Jawab (Jabatan)</label>
                <div class="controls">
                  <select name="pj" id='jab-ren'>
                    <option value="0">Pilih Jabatan</option>
                    <?php  
                    $j = mysql_query("SELECT id_jab, nama_jab FROM jabatan WHERE id_jab!='14' ORDER BY nama_jab ASC");
                    while ($dj=mysql_fetch_array($j)) {
                      if($qe['id_jab']==$dj[0]){
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
                <label class='control-label'>Nama Pegawai</label>
                <div class="controls">
                  <select name="np" id='peg'>
                    <option value="0">Pilih Pegawai</option>
                    <?php 
                      if(empty($_GET['jb_pj'])){
                        $i = mysql_query("SELECT p.id_pegawai, p.nama_pegawai FROM pegawai p, jabatan j WHERE p.id_jab=j.id_jab AND j.id_jab='$qe[id_jab]'");                        
                        while ($dd=mysql_fetch_array($i)) {
                          if($qe['id_pegawai']==$dd[0]){
                            echo "<option value='$dd[0]' selected>$dd[nama_pegawai]</option>";
                          }else{
                            echo "<option value='$dd[0]'>$dd[nama_pegawai]</option>";
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
                  <input type="text" name='ang' id='ang' placeholder='inputan hanya boleh angka' value='<?php echo "$uangedit"; ?>'>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label">File Lama</label>
                <div class="controls">
                  <strong><?php echo "$qe[nama_dok]"; ?></strong>
                </div>
                <div class="controls">
                  <label class='checkbox'>
                    <input type="checkbox" name="jadi" value="upload_cek" id='upload_cek' onclick='tampilkan_cek()'>Upload File Baru ? 
                  </label>
                </div>
              </div>

              <div class="control-group" id='upload'>
                <label class="control-label">Dokumen</label>
                <div class="controls">
                  <input type="file" name='up_detail'>
                </div>
              </div>

              <div class="control-group" id='info_upload'>              
                <label class="control-label">Informasi Upload File</label>
                <div class="controls">
                  <a href="#" class='btn btn-success doc' role="button"  data-content="Sistem hanya mendukung file bertipe .doc/.docx, .ppt/.pptx, .xls,.xlsx, .pdf dan .txt. Anda diperbolehkan menyertakan dokumen perencananan atau tidak menyertakannya dalam proses input perencanaan." data-trigger='hover' data-original-title="Informasi Upload"><i class='icon-question'></i></a>
                </div>
              </div>

              <div class="control-group">
                <label class='control-label'>Deskripsi Kegiatan</label>
                <div class="controls">
                  <textarea name="dk" id="" cols="30" rows="5"><?php echo "$qe[desk_ren]"; ?></textarea>
                </div>
              </div>

              <div class="control-group">                
                <div class="controls pull-left">
                  <input type="submit" value='Perbarui' class='btn btn-success'>
                  <input type="reset" value='Reset' class='btn btn-inverse'>
                  <input type="hidden" name="h_idkeg" value="<?php echo "$_GET[md]"; ?>">
                </div>
              </div>
            </form>
          </div>
          <!-- akhir edit -->
            <?php
            break;
            
            default:
            ?>
          <!-- awal insert -->
          <div class="span12">
            <div class="page-header">
              <?php 
              $t = mysql_fetch_array(mysql_query("SELECT * FROM  submenu_utama WHERE link_menu LIKE  '%$_GET[md]%'"));
              echo "<h3>Form <span class='label labelform label-info'>Input</span> Data $t[nama_sub]</h3>";
              include 'include/notif.php';
              $uu = mysql_fetch_array(mysql_query("SELECT MAX(kode_ren) FROM tbl_rencana"));
              $nn = $uu[0]+1;
              ?>
            </div>
            <form action="mod_sistem/md_b.kumkm/action/act_rencana.php?ac=ins" class='form-horizontal' method='POST' enctype='multipart/form-data' onsubmit="return validation(this, 'required');">
              <input type="hidden" name="h_idkeg" value="<?php echo "$_GET[md]"; ?>">
              <div class="control-group">
                <label class='control-label'>No. Kegiatan</label>
                <div class="controls">
                  <input type="text" name='no' id='lala1' value='<?php echo "00$nn"; ?>' class="required">
                </div>
                <div id='lala2'></div>
              </div>
              <div class="control-group">
                <label class='control-label'>Nama Kegiatan</label>
                <div class="controls">
                  <input type="text" name='nm' class="required" placeholder="Nama Kegiatan" onkeyup="cek_error(this);">
                </div>
              </div>
              <div class="alert alert-error" id="alert" style='display:none;'>
              <strong>#</strong>
              </div>
              <div class="control-group">
                <label class='control-label'>Mulai</label>
                <div class="controls">
                  <div class="input-append date" id='datemulai' data-date="<?=date('d-m-Y')?>" data-date-format='dd-mm-yyyy'>
                    <input class="span12 required" size="16" type="text" readonly name='s' placeholder="Tanggal Mulai">
                    <span class="add-on"><i class="icon-calendar"></i></span>
                  </div>
                </div>
              </div>

              <div class="control-group">
                <label class='control-label'>Selesai</label>
                <div class="controls">
                  <div class="input-append date" id='dateselesai' data-date="<?=date('d-m-Y')?>" data-date-format='dd-mm-yyyy'>
                    <input class="span12 required" size="16" type="text" readonly name='f'  placeholder="Tanggal Selesai">
                    <span class="add-on"><i class="icon-calendar"></i></span>
                  </div>
                </div>
              </div>

              <div class="control-group">
                <label class='control-label'>Tempat</label>
                <div class="controls">
                  <input type="text" name='tp' class="required" class="required" placeholder="Tempat Perencanaan" onkeyup="cek_error(this);">
                </div>
              </div>

              <div class="control-group">
                <label class='control-label'>Penanggung Jawab</label>
                <div class="controls">
                  <select name="pj" id='jab-ren' onkeyup="cek_error(this);">
                    <option value="0">Pilih Jabatan</option>
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
                <label class='control-label'>Nama Pegawai</label>
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
                  <input type="text" name='ang' id='ang' placeholder='Anggaran' class="required" onkeyup="cek_error(this);">
                </div>
              </div>

              <div class="control-group">
                <label class="control-label">Dokumen</label>
                <div class="controls">
                  <input type="file" name='up_detail'>
                </div>
              </div>            

              <div class="control-group">              
                <label class="control-label">Informasi Upload File</label>
                <div class="controls">
                  <a href="#" class='btn btn-success doc' role="button"  data-content="Sistem hanya mendukung file bertipe .doc/.docx, .ppt/.pptx, .xls,.xlsx, .pdf dan .txt. Anda diperbolehkan menyertakan dokumen perencananan atau tidak menyertakannya dalam proses input perencanaan." data-trigger='hover' data-original-title="Informasi Upload"><i class='icon-question'></i></a>
                </div>
              </div>
                <div class="control-group">
                  <label class='control-label'>Deskripsi Kegiatan</label>
                  <div class="controls">
                    <textarea name="dk" cols="30" rows="5" class="required" placeholder="Deskripsi Kegiatan" onkeyup="cek_error(this);"></textarea>
                  </div>
                </div>
                <div class="control-group">                
                  <div class="controls pull-left">
                    <input type="submit" value='Simpan' class='btn btn-success'>
                    <input type="reset" value='Reset' class='btn btn-inverse'>
                  </div>
                </div>              
            </form>
          </div>
          <!-- akhir insert -->
            <?php
            break;
          }
          ?>        
  <!-- awal tabel -->
  <div class="span12" id='tbl_rencana' style='margin-left:0px'>
      <div class='page-header'>
          <?php 
            $t = mysql_fetch_array(mysql_query("SELECT * FROM  submenu_utama WHERE link_menu LIKE  '%$_GET[md]%'"));
            $jumrow = mysql_num_rows(mysql_query("SELECT r.id_rencana
                          FROM tbl_rencana r
                          JOIN tbl_penyiapan py ON r.id_rencana = py.id_rencana GROUP BY r.id_rencana"));
            echo "<h3>Tabel $t[nama_sub]</h3><p>Ada <span class='badge badge-warning'><a href='?md=perennotin' target='_blank'>$jumrow</a></span> Perencanaan yang sudah dilakukan Persiapan</p>";
           ?>
        </div>
        <?php include "include/notif_tabel.php"; ?>  
          <table class='table table-bordered table-striped table-hover' id="table_id">
              <thead>
                <tr>
                <th rowspan='2'>Setting</th>
                <th rowspan='2'>Status Data</th>
                <th rowspan='2'>Kode</th>
                <th rowspan='2'>Nama Kegiatan</th>                
                <th colspan='2'>Tanggal Perencanaan</th>                
                <th rowspan='2'>Tempat</th>
                <th rowspan='2'>Penanggung Jawab</th>
                <th rowspan='2'>Anggaran</th>                
                <th rowspan='2'>Deskripsi Kegiatan</th>
                </tr>
                <tr>
                  <th>Mulai</th>
                  <th>Selesai</th>
                </tr>
              </thead>
              <tbody>
                <?php
                //tampilkan data yang hanya belum diproses selanjutnya -> proses persiapan
                $q_ren = mysql_query("SELECT r.*, d.id_dok, d.nama_dok, p.nama_pegawai
                          FROM tbl_rencana r JOIN pegawai p ON p.id_pegawai=r.id_pegawai JOIN jabatan j ON j.id_jab=p.id_jab JOIN dokumen d ON d.id_dok=r.id_dok
                          WHERE r.id_rencana NOT 
                          IN (
                          SELECT r.id_rencana
                          FROM tbl_rencana r
                          JOIN tbl_penyiapan py ON r.id_rencana = py.id_rencana
                          )");
                while ($d=mysql_fetch_array($q_ren)) {
                  $start = dbtoindo($d['mulai_ren']);
                  $finish = dbtoindo($d['selesai_ren']);
                  $ruwet = md5($d['id_rencana'])."==";
                  $r = $d['anggaran_ren'];
                  $uangtb = number_format($r,2,",",".");
                  echo "                  
                  <tr>
                  <td>";
                    //jika data ini miliknya sendiri (crud, down, view, lock, unlock)
                    if($d['owner']==$_SESSION['iduser']){
                      ?>
                      <div class="btn-group">
                        <a href="#" class='btn btn-success'><i class='icon-cog'></i></a>
                        <a href="#" class='btn  btn-success dropdown-toggle' data-toggle='dropdown'><span class='caret'></span></a>
                        <ul class="dropdown-menu">
                          <li><a href="?md=<?php echo "$_GET[md]"; ?>&amp;p=e&amp;kode=<?php echo $d['id_rencana']; ?>"><i class='icon-edit'></i> Edit</a></li>

                          <li><a href='mod_sistem/md_b.kumkm/action/act_rencana.php?md=<?php echo "$_GET[md]";?>&amp;ac=dl&amp;kd=<?php echo "$d[id_rencana]"; ?>' onclick="return confirm('Anda yakin ingin mengahapus data ini ?');"><i class='icon-trash'></i> Hapus</a></li>

                          <?php                         
                            if($d['nama_dok']=='Tidak Ada Dokumen'){
                              echo "";
                            }else{
                              ?>
                              <li class='divider'></li>
                              <li><a href="mod_sistem/md_b.kumkm/action/unduh.php?md=<?php echo "$_GET[md]";?>&amp;page=<?php echo "$d[id_dok]"; ?>&amp;idfile=<?php echo "$d[ukuran]$d[tanggal_upload]$d[id_dok]$ruwet"; ?>" class='doc' rel='popover' data-content='<?php echo "$d[nama_dok]\n$d[tipe_file]"; ?>' data-trigger='hover'><i class='icon-download'></i> Download Dokumen</a></li>
                              <li><a href="mod_sistem/md_b.kumkm/action/view.php?md=<?php echo "$_GET[md]";?>&amp;page=<?php echo "$d[id_dok]"; ?>&amp;idfile=<?php echo "$d[ukuran]$d[id_dok]$ruwet$d[tanggal_upload]=="; ?>"><i class='icon-eye-open'></i> View Dokumen</a></li>
      
                              <?php
                            }
                           ?>
                           <li class='divider'></li>
                           <?php  

                          if($d['status_kunci']=='0'){
                              echo "<li><a href='mod_sistem/md_b.kumkm/action/act_rencana.php?md=$_GET[md]&amp;ac=on&amp;page=$d[id_rencana]&amp;id=$ruwet' class='doc' rel='popover' data-content='Bila Anda membuka kunci Akses maka data ini akan bisa diakses oleh pengguna lain. Akses meliputi Edit dan Hapus' data-original-title='Informasi_Perbolehkan_Akses_Data' data-trigger='hover'><i class='icon-unlock'></i> Perbolehkan Akses</a></li>";
                          }elseif($d['status_kunci']=='1'){
                            echo "<li><a href='mod_sistem/md_b.kumkm/action/act_rencana.php?md=$_GET[md]&amp;ac=off&amp;page=$d[id_rencana]'&amp;id=$ruwet class='doc' rel='popover' data-content='Bila Anda menutup kunci Akses maka data ini akan tidak bisa lagi diakses oleh pengguna lain. Tutup Akses meliputi Edit dan Hapus' data-original-title='Informasi_Kunci_Akses_Data' data-trigger='hover'><i class='icon-lock'></i> Tutup Akses</a></li>"; 
                          }
                           ?>                      
                        </ul>
                      </div>
                      <?php
                    // jika data ini bukan miliknya namun telah diberikan aksesnya ke user ini
                    // (crud, down, view)
                    }elseif($d['owner']!=$_SESSION['iduser'] && $d['status_kunci']=='1'){
                      ?>
                      <div class="btn-group">
                          <a href="#" class='btn btn-success'><i class='icon-cog'></i></a>
                          <a href="#" class='btn  btn-success dropdown-toggle' data-toggle='dropdown'><span class='caret'></span></a>
                          <ul class="dropdown-menu">
                            <li><a href="?md=<?php echo "$_GET[md]"; ?>&amp;p=e&amp;kode=<?php echo $d['id_rencana']; ?>"><i class='icon-edit'></i> Edit</a></li>

                            <li><a href='mod_sistem/md_b.kumkm/action/act_rencana.php?md=<?php echo "$_GET[md]";?>&amp;ac=dl&amp;kd=<?php echo "$d[id_rencana]"; ?>' onclick="return confirm('Anda yakin ingin mengahapus data ini ?');"><i class='icon-trash'></i> Hapus</a></li>

                            <?php                         
                              if($d['nama_dok']=='Tidak Ada Dokumen'){
                                echo "";
                              }else{
                                ?>
                                <li class='divider'></li>
                                <li><a href="mod_sistem/md_b.kumkm/action/unduh.php?md=<?php echo "$_GET[md]";?>&amp;page=<?php echo "$d[id_dok]"; ?>&amp;idfile=<?php echo "$d[ukuran]$d[tanggal_upload]$d[id_dok]$ruwet"; ?>" class='doc' rel='popover' data-content='<?php echo "$d[nama_dok]\n$d[tipe_file]"; ?>' data-trigger='hover'><i class='icon-download'></i> Download Dokumen</a></li>
                                <li><a href="mod_sistem/md_b.kumkm/action/view.php?md=<?php echo "$_GET[md]";?>&amp;page=<?php echo "$d[id_dok]"; ?>&amp;idfile=<?php echo "$d[ukuran]$d[id_dok]$ruwet$d[tanggal_upload]=="; ?>"><i class='icon-eye-open'></i> View Dokumen</a></li>
        
                                <?php
                              }
                             ?>
                          </ul>
                      </div>
                      <?
                    // jika data bukan milik dan tidak diberikan aksesnya ke user ini
                    // (down, view)
                    }elseif($d['owner']!=$_SESSION['iduser']){
                      ?>
                      <div class="btn-group">
                          <a href="#" class='btn btn-success'><i class='icon-cog'></i></a>
                          <a href="#" class='btn  btn-success dropdown-toggle' data-toggle='dropdown'><span class='caret'></span></a>
                          <ul class="dropdown-menu">
                            <?php                         
                              if($d['nama_dok']=='Tidak Ada Dokumen'){
                                echo "<li>Tidak Ada Dokumen</li>";
                              }else{
                                ?>                                
                                <li><a href="mod_sistem/md_b.kumkm/action/unduh.php?md=<?php echo "$_GET[md]";?>&amp;page=<?php echo "$d[id_dok]"; ?>&amp;idfile=<?php echo "$d[ukuran]$d[tanggal_upload]$d[id_dok]$ruwet"; ?>" class='doc' rel='popover' data-content='<?php echo "$d[nama_dok]\n$d[tipe_file]"; ?>' data-trigger='hover'><i class='icon-download'></i> Download Dokumen</a></li>
                                <li><a href="mod_sistem/md_b.kumkm/action/view.php?md=<?php echo "$_GET[md]";?>&amp;page=<?php echo "$d[id_dok]"; ?>&amp;idfile=<?php echo "$d[ukuran]$d[id_dok]$ruwet$d[tanggal_upload]=="; ?>"><i class='icon-eye-open'></i> View Dokumen</a></li>
        
                                <?php
                              }
                             ?>
                          </ul>
                      </div>
                      <?php
                    }
                  
                  echo "</td>";
                  if($d['status_kunci']=='0'){
                    echo "<td><i class='icon-lock doc' rel='popover' data-content='Data ini Terkunci'  data-trigger='hover'></i></td>";
                  }else{
                    echo "<td><i class='icon-unlock doc' rel='popover' data-content='Data ini Terbuka'  data-trigger='hover'></i></td>";
                  }

                  //isi
                  echo "<td>$d[kode_ren]</td><td>$d[nama_keg_ren]</td><td>$start</td><td>$finish</td><td>$d[tempat_ren]</td><td>$d[nama_pegawai]</td><td>Rp $uangtb</td><td>$d[desk_ren]</td>
                  </tr>                  
                  ";
                }
                
                ?>
              </tbody>
          </table>
  </div>
  <!-- akhir tabel -->
</div>
<!-- akhir rowfluid -->