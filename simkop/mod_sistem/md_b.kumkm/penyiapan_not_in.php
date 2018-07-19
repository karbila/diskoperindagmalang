<?php  
$u=mysql_query("SELECT py.id_penyiapan, py.nama_kegiatan_penyi, py.status_kunci, py.tgl_mulai_penyi1, py.tgl_selesai_penyi1, py.kode_penyi, r.nama_keg_ren, r.anggaran_ren, py.anggaran, py.tempat_penyi, py.deskripsi_penyi, py.owner
                              FROM tbl_rencana r
                              JOIN tbl_penyiapan py ON r.id_rencana=py.id_rencana
                              WHERE py.id_penyiapan IN (
                                SELECT py.id_penyiapan
                                FROM tbl_rencana r
                                JOIN tbl_penyiapan py ON r.id_rencana = py.id_rencana
                                JOIN tbl_sub_penyiapan spy ON py.id_penyiapan = spy.id_penyiapan
                                JOIN tbl_pelaksanaan pl ON spy.id_sub_penyi = pl.id_sub_penyi
                                GROUP BY r.id_rencana
                              )");
$jum_penyi = mysql_num_rows($u);

?>
<div class="row-fluid">
  <!-- tabel 1 -->
   <div class="span12" id='tbl_penyi' style='margin-left: 0px;margin-bottom:50px;'>
                    <div class='page-header'>
                        <h3>Tabel Penyiapan (Preparing) - <?php echo "<span class='badge badge-info'>$jum_penyi</span>"; ?> Data</h3>
                        </div>                         
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
</div>