<div class="row-fluid">
  <!-- tabel 1 -->
   <div class="span12" id='tbl_penyi' style='margin-left: 0px;margin-bottom:50px;'>
                    <div class='page-header'>
                        <?php 
                          $t = mysql_fetch_array(mysql_query("SELECT * FROM submenu_utama WHERE link_menu LIKE  '%$_GET[md]%'"));
                          $jumrow = mysql_num_rows(mysql_query("SELECT py.id_penyiapan
                                FROM tbl_rencana r
                                JOIN tbl_penyiapan py ON r.id_rencana = py.id_rencana
                                JOIN tbl_sub_penyiapan spy ON py.id_penyiapan = spy.id_penyiapan
                                JOIN tbl_pelaksanaan pl ON spy.id_sub_penyi = pl.id_sub_penyi
                                GROUP BY r.id_rencana"));
                          echo "<h3>Tabel $t[nama_sub]</h3>
                          <p>Ada <span class='badge badge-warning'><a href=\"?md=penyinotin\" target=\"_blank\">$jumrow</a></span> Penyiapan yang sudah dilakukan Pelaksanaan</p>
                          ";
                          
                         ?>
                        </div> 
                        <?php include "include/notif_tabel.php"; ?>
                       <table class='table table-bordered table-striped table-hover' id="table_id">
                        <thead>
                          <tr>                                                  
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
                  $t = mysql_fetch_array(mysql_query("SELECT * FROM submenu_utama WHERE link_menu LIKE  '%$_GET[md]%'"));
                  echo "<h3>Tabel Sub $t[nama_sub]</h3>"; 
                 ?>
              </div> 
              <?php include "include/notif_tabel_sub.php"; ?>
              <table class='table table-bordered table-striped table-hover' id="table_id_scroll">
                <thead>
                  <tr>
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
                      echo "<tr><td>$dt[kode_penyi].$dt[penyi_sub_kode]</td>
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