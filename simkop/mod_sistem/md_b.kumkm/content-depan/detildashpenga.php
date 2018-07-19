<?php 
  $bb = date('n');      
  $t = date('Y');
  $bulansek = date("m");
  $b = getBulan($bb);     
      
  $j = mysql_query("SELECT pl.id_pelaksanaan, pl.kode_laksana, pl.nama_laksana, pl.tgl_m_lak, pl.tgl_s_lak, pl.tempat_lak, pl.des_lak, pl.ang_lak, d.id_dok, d.ukuran, d.tanggal_upload, d.tipe_file, d.nama_dok, p.nama_pegawai
  FROM tbl_pelaksanaan pl
  JOIN tbl_sub_pelaksanaan spl ON spl.id_pelaksanaan = pl.id_pelaksanaan
  JOIN tbl_pengawasan pg ON pg.id_sub_pelak=spl.id_sub_pelak
  JOIN pegawai p ON p.id_pegawai=pg.id_pegawai
  JOIN jabatan j ON j.id_jab=p.id_jab
  JOIN dokumen d ON pl.id_dok = d.id_dok  
  GROUP BY pl.id_pelaksanaan");


$jum_pelaks = mysql_num_rows($j);
 ?>
<div class="row-fluid">
  <!-- tabel 1 -->
  <div class="span12" id='tbl_pelak' style='margin-left: 0px;margin-bottom:20px;'>
                    <div class='page-header'>
                        <h3>Data Kegiatan Pelaksanaan (Assigment) - <?php echo "<span class='badge badge-info'>$jum_pelaks</span>"; ?> Data yang belum dilakukan Pengawasan</h3>
                        </div>                        
                       <table class='table table-bordered table-striped table-hover' id="table_id">
                        <thead>
                          <tr>
                            <th rowspan='2'>Setting</th>                            
                            <th rowspan='2'>Kode</th>                            
                            <th rowspan='2'>Nama Pelaksanaan</th>
                            <th colspan='2'>Tanggal Pelaksanaan</th>
                            <th rowspan='2'>Penanggungjawab</th>                            
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
                            

                            while ($dt = mysql_fetch_array($j)) {
                              $awal1 = dbtoindo($dt['tgl_m_lak']);
                              $akhir1 = dbtoindo($dt['tgl_s_lak']);                              
                              $ra = rand(00,55);
                              $ruwet=md5($dt['kode_laksana']).$ra."$dt[kode_laksana]";
                              $uangtb1 = number_format($dt['ang_lak'],2,",",".");                              
                              echo "<tr>
                              <td>";
                              ?>
                              <div class="btn-group">
                              <a class="btn btn-success" href="#"><i class="icon-cog"></i></a>
                              <a class="btn btn-success dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                              <ul class="dropdown-menu">
                                <?php 
                                if($dt['nama_dok']=='Tidak Ada Dokumen'){
                                  echo "<li><a href='#'>Tidak Ada Dokumen</a></li>";
                                }else{
                                  ?>                                  
                                  <li><a href="mod_sistem/md_b.kumkm/action/unduh.php?md=<?php echo "$_GET[md]";?>&amp;page=<?php echo "$dt[id_dok]"; ?>&amp;idfile=<?php echo "$dt[ukuran]$dt[tanggal_upload]$dt[id_dok]$ruwet"; ?>" class='doc' rel='popover' data-content='<?php echo "$dt[nama_dok]\n$dt[tipe_file]"; ?>' data-trigger='hover'><i class='icon-download'></i> Download Dokumen</a></li>
                                
                                <li><a href="mod_sistem/md_b.kumkm/action/view.php?md=<?php echo "$_GET[md]";?>&amp;page=<?php echo "$dt[id_dok]"; ?>&amp;idfile=<?php echo "$dt[ukuran]$dt[id_dok]$ruwet$dt[tanggal_upload]=="; ?>"><i class='icon-eye-open'></i> View Dokumen</a></li>

                                <?php
                                } //else
                                ?>
                              </ul>
                            </div>
                              <?
                              echo "</td>";
                              echo "
                              <td>$dt[kode_laksana]</td>                              
                              <td>$dt[nama_laksana]</td>
                              <td>$awal1</td>
                              <td>$akhir1</td>
                              <td>$dt[nama_pegawai]</td>
                              <td>Rp. $uangtb1</td>                              
                              <td>$dt[tempat_lak]</td>
                              <td>$dt[des_lak]</td>                              
                              </tr>";
                            }
                          ?>
                          </tbody>
                          </table>
  </div>

</div>