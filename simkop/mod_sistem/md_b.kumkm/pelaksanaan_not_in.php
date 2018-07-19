<?php 
$u=mysql_query("SELECT l.id_pelaksanaan, l.kode_laksana, l.nama_laksana, l.tgl_m_lak, l.tgl_s_lak, l.tempat_lak, l.des_lak, l.ang_lak, py.nama_kegiatan_penyi, py.anggaran, d.id_dok, d.ukuran, d.tanggal_upload, d.tipe_file, d.nama_dok, p.nama_pegawai, j.nama_jab, s.id_sub_penyi, s.penyi_sub_kode, l.status_kunci, l.status_proses, l.owner
                              FROM tbl_pelaksanaan l
                              JOIN tbl_sub_penyiapan s ON s.id_sub_penyi=l.id_sub_penyi JOIN tbl_penyiapan py ON py.id_penyiapan=s.id_penyiapan JOIN tbl_rencana r ON r.id_rencana = py.id_rencana JOIN dokumen d ON d.id_dok=l.id_dok JOIN pegawai p ON p.id_pegawai=l.id_pegawai JOIN jabatan j ON j.id_jab=p.id_jab 
                              WHERE l.id_pelaksanaan IN (
                                SELECT l.id_pelaksanaan
                                FROM tbl_pelaksanaan l
                                JOIN tbl_sub_pelaksanaan spy ON l.id_pelaksanaan=spy.id_pelaksanaan JOIN tbl_pengawasan a ON spy.id_sub_pelak=a.id_sub_pelak
                                GROUP BY l.id_pelaksanaan
                                )");
$jum_pelaks = mysql_num_rows($u);
 ?>
<div class="row-fluid">
  <!-- tabel 1 -->
  <div class="span12" id='tbl_pelak' style='margin-left: 0px;margin-bottom:20px;'>
                    <div class='page-header'>
                        <h3>Tabel Pelaksanaan (Assigment) - <?php echo "<span class='badge badge-info'>$jum_pelaks</span>"; ?> Data</h3>
                        </div>                        
                       <table class='table table-bordered table-striped table-hover' id="table_id">
                        <thead>
                          <tr>
                            <th rowspan='2'>Setting</th>                            
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
                            

                            while ($dt = mysql_fetch_array($u)) {
                              $awal1 = dbtoindo($dt['tgl_m_lak']);
                              $akhir1 = dbtoindo($dt['tgl_s_lak']);                              
                              $ra = rand(00,55);
                              $ruwet=md5($dt['kode_laksana']).$ra."$dt[kode_laksana]";
                              $uangtb1 = number_format($dt['ang_lak'],2,",",".");
                              $uangtb2 = number_format($dt['anggaran'],2,",",".");
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

</div>