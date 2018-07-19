<div class="row-fluid">
	<!-- tabel 1 -->
  <div class="span12" id='tbl_penga' style='margin-left: 0px;margin-bottom:20px;'>
                    <div class='page-header'>
                        <?php 
                          $t = mysql_fetch_array(mysql_query("SELECT * FROM  kop_modul WHERE link_modul LIKE  '%$_GET[md]%'"));
                          echo "<h3>Tabel $t[nama_modul]</h3>";
                         ?>
                        </div> 
                        <?php include "include/notif_tabel.php"; ?> 
                       <table id="tabelscroll_x" class='table-bordered'>
                        <thead>
                          <tr>
                            <th rowspan='2'>Setting</th>                            
                            <th rowspan='2'>Kode</th>
                            <th rowspan='2'>Nama Pelaksanaan</th>
                            <th rowspan='2'>Nama Pengawasan</th>
                            <th colspan='2'>Tanggal Pengawasan</th>
                            <th rowspan='2'>Penanggungjawab</th>
                            <th rowspan='2'>Anggaran Pelaksanaan</th>
                            <th rowspan='2'>Anggaran Pengawasan</th>
                            <th rowspan='2'>Tempat</th>
                            <th rowspan='2'>Deskripsi Pengawasan</th>
                            <th rowspan='2'>Hasil Pengawasan</th>
                            <th rowspan='2'>Catatan Kabid</th>
                            <th rowspan='2'>Catatan Kasi</th>
                          </tr>
                          <tr>
                            <th>Mulai</th><th>Selesai</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $u=mysql_query("SELECT a.*, d.nama_dok, d.id_dok, d.ukuran, d.tipe_file, d.tanggal_upload, l.id_pelaksanaan, l.nama_laksana,l.ang_lak, j.id_jab, j.nama_jab FROM tbl_pengawasan a, dokumen d, tbl_sub_pelaksanaan s, tbl_pelaksanaan l, jabatan j, pegawai p WHERE d.id_dok=a.id_dok AND s.id_sub_pelak=a.id_sub_pelak AND j.id_jab = p.id_jab AND p.id_pegawai=a.id_pegawai AND l.id_pelaksanaan=s.id_pelaksanaan ORDER BY a.id_pengawasan DESC");

                            while ($dt = mysql_fetch_array($u)) {
                              $awal1 = dbtoindo($dt['tgl_awal_penga']);
                              $akhir1 = dbtoindo($dt['tgl_akhir_penga']);
                              $ra = rand(00,55);
                              $ruwet=md5($dt['kode_penga']).$ra."$dt[kode_penga]";
                              $uangtb1 = number_format($dt['ang_penga'],2,",",".");
                              $uangtb2 = number_format($dt['ang_lak'],2,",",".");



                              echo "<tr>
                              <td>";
                              ?>
                              <div class="btn-group">
                                  <a class="btn btn-success" href="#"><i class="icon-cog"></i></a>
                                  <a class="btn btn-success dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                                  <ul class="dropdown-menu">                                    
                                    <?php 
                                    if($dt['nama_dok']=='Tidak Ada Dokumen'){
                                      echo "<li><a href=\"#\">Tidak Ada Dokumen</a></li>";
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
                              echo "</td>";
                              echo "
                              <td>$dt[kode_penga]</td>
                              <td>$dt[nama_laksana]</td>
                              <td>$dt[nama_penga]</td>
                              <td>$awal1</td>
                              <td>$akhir1</td>
                              <td>$dt[nama_jab]</td>
                              <td>Rp. $uangtb2</td>
                              <td>Rp. $uangtb1</td>
                              <td>$dt[tempat_penga]</td>
                              <td>$dt[detil_penga]</td>
                              <td>$dt[hasil_penga]</td>
                              <td>$dt[cat_penga]</td>
                              <td>$dt[cat_penga2]</td>
                              </tr>";
                            }
                          ?>
                          </tbody>
                          </table>
  </div>

  <!-- tabel sub -->
  <div class="span12" id='tbl_sub_penga' style='margin-left: 0px;margin-bottom:20px;'>
                    <div class='page-header'>
                      <?php 
                        $t = mysql_fetch_array(mysql_query("SELECT * FROM  kop_modul WHERE link_modul LIKE  '%$_GET[md]%'"));
                        echo "<h3>Tabel Sub $t[nama_modul]</h3>";                        
                       ?>
                    </div> 
                    <?php include "include/notif_tabel_sub.php"; ?> 
                    <table class='table table-bordered table-striped table-hover' id="table_id_scroll">
                      <thead>
                        <tr>                          
                          <th>Kode</th>
                          <th>Pengawasan</th>
                          <th>Nama Sub</th>
                          <th>Mulai</th>
                          <th>Selesai</th>
                          <th>Deskripsi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $u=mysql_query("SELECT s.*, a.id_pengawasan, a.nama_penga, a.kode_penga FROM tbl_sub_pengawasan s, tbl_pengawasan a WHERE a.id_pengawasan=s.id_pengawasan AND s.status_proses='0' ORDER BY s.id_sub_penga DESC");

                          while ($dt = mysql_fetch_array($u)) {
                            $start = dbtoindo($dt['tgl_mulai_penga_sub']);
                            $finish = dbtoindo($dt['tgl_akhir_penga_sub']);
                            $ruwet=md5($dt['kode_sub_penga']);
                            echo "<tr>
                            <td>$dt[kode_penga].$dt[kode_sub_penga]</td>
                            <td>$dt[nama_penga]</td>
                            <td>$dt[nama_sub_penga]</td>
                            <td>$start</td>
                            <td>$finish</td>
                            <td>$dt[deskripsi_sub_penga]</td>
                            </tr>";
                          }
                        ?>
                      </tbody>
                    </table>
  </div>
</div>