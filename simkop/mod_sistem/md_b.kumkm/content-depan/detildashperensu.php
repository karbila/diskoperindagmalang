<!-- awal tabel -->
  <div class="span12" id='tbl_rencana' style='margin-left:0px'>
      <div class='page-header'>
          <?php 
          $t = date('Y');
          $bulansek = date("m");
          $bb = date('n');
          $b = getBulan($bb); 
          $y = "SELECT r.id_rencana, r.kode_ren, r.nama_keg_ren, r.mulai_ren, r.selesai_ren, r.tempat_ren, p.nama_pegawai, r.anggaran_ren, r.desk_ren, d.*
                                FROM tbl_pelaksanaan pl
                                JOIN tbl_sub_penyiapan sp ON sp.id_sub_penyi = pl.id_sub_penyi
                                JOIN tbl_penyiapan py ON py.id_penyiapan = sp.id_penyiapan
                                JOIN tbl_rencana r ON r.id_rencana = py.id_rencana
                                JOIN pegawai p ON r.id_pegawai = p.id_pegawai
                                JOIN jabatan j ON j.id_jab = p.id_jab
                                JOIN dokumen d ON d.id_dok = pl.id_dok
                                WHERE MONTH( r.mulai_ren ) !=  '$bulansek'
                                AND YEAR( r.mulai_ren ) !=  '$t'
                                GROUP BY r.id_rencana";
                                //echo "$y";
          $q_ren = mysql_query($y);          
          $jumrenn = mysql_num_rows($q_ren);
           ?>
          <h3>Perencanaan (Planning) - <span class='badge badge-info'><?php echo "$jumrenn"; ?></span> Data yang sudah direalisasi sampai Bulan <?php echo "$b"; ?></h3>
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