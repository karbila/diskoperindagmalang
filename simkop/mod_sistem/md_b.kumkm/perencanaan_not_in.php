<!-- awal tabel -->
  <div class="span12" id='tbl_rencana' style='margin-left:0px'>
      <div class='page-header'>
          <?php 
          $q_ren = mysql_query("SELECT r.*, d.*, p.nama_pegawai
                          FROM tbl_rencana r JOIN pegawai p ON p.id_pegawai=r.id_pegawai JOIN jabatan j ON j.id_jab=p.id_jab JOIN dokumen d ON d.id_dok=r.id_dok
                          WHERE r.id_rencana 
                          IN (
                          SELECT r.id_rencana
                          FROM tbl_rencana r
                          JOIN tbl_penyiapan py ON r.id_rencana = py.id_rencana
                          )");
          $jumrenn = mysql_num_rows($q_ren);
           ?>
          <h3>Tabel Perencanaan (Planning) - <span class='badge badge-info'><?php echo "$jumrenn"; ?></span> Data</h3>
        </div>        
          <table class='table table-bordered table-striped table-hover' id="table_id">
              <thead>
                <tr>
                <th rowspan='2'>Setting</th>                
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
                  ?>                  
                    <div class="btn-group">
                          <a href="#" class='btn btn-success'><i class='icon-cog'></i></a>
                          <a href="#" class='btn  btn-success dropdown-toggle' data-toggle='dropdown'><span class='caret'></span></a>
                          <ul class="dropdown-menu">
                            <?php                         
                              if($d['nama_dok']=='Tidak Ada Dokumen'){
                                echo "<li><a href='#'>Tidak Ada Dokumen</a></li>";
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
                  echo "</td>";
                  echo "<td>$d[kode_ren]</td><td>$d[nama_keg_ren]</td><td>$start</td><td>$finish</td><td>$d[tempat_ren]</td><td>$d[nama_pegawai]</td><td>Rp $uangtb</td><td>$d[desk_ren]</td>
                  </tr>                  
                  ";
                }
                
                ?>
              </tbody>
          </table>
  </div>
  <!-- akhir tabel -->