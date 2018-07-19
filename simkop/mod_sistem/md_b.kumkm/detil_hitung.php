<?php  
  // $ren = mysql_fetch_array(mysql_query("SELECT r.id_rencana, r.kode_ren, r.nama_keg_ren, r.mulai_ren, r.selesai_ren, r.tempat_ren, r.anggaran_ren, r.desk_ren, p.id_pegawai, p.nama_pegawai, p.nomor_induk, j.nama_jab, d.nama_dok, d.id_dok FROM tbl_rencana r, pegawai p, jabatan j, dokumen d WHERE j.id_jab=p.id_jab AND p.id_pegawai=r.id_pegawai AND d.id_dok=r.id_dok AND r.id_rencana = '$_GET[r]'"));
  // $penyi = mysql_query("SELECT  p.id_rencana, py.kode_penyi, py.nama_kegiatan_penyi, py.id_penyiapan, py.tgl_mulai_penyi1, py.tgl_selesai_penyi1, py.tempat_penyi, j.nama_jab, py.anggaran, py.deskripsi_penyi, py.status_kunci, py.owner, pg.nama_pegawai FROM tbl_rencana p, tbl_penyiapan py, jabatan j, pegawai pg WHERE p.id_rencana = py.id_rencana AND j.id_jab = pg.id_jab AND pg.id_pegawai = py.id_pegawai AND p.id_rencana =  '$_GET[r]'");
  // $pelak = mysql_query("SELECT r.id_rencana, pl.nama_laksana, pl.id_pelaksanaan, pl.kode_laksana, pl.tgl_m_lak,pl.tgl_s_lak, j.nama_jab, p.nama_pegawai, pl.des_lak, pl.ang_lak, pl.tempat_lak FROM tbl_rencana r, tbl_penyiapan py, tbl_sub_penyiapan sp, tbl_pelaksanaan pl, jabatan j, pegawai p WHERE r.id_rencana = py.id_rencana AND py.id_penyiapan = sp.id_penyiapan AND sp.id_sub_penyi = pl.id_sub_penyi AND j.id_jab = p.id_jab AND r.id_pegawai = p.id_pegawai AND r.id_rencana = '$_GET[r]'");

  $mulai = $ren['mulai_ren'];
  $m = tgl_indo($mulai);
  $selesai = $ren['selesai_ren'];
  $s = tgl_indo($selesai);

  $uang_ren = number_format($ren['anggaran_ren'],2,",",".");


  $tot_penyi = mysql_fetch_assoc(mysql_query("SELECT SUM(py.anggaran) as jumpenyi, py.tgl_mulai_penyi1, py.tgl_selesai_penyi1 FROM tbl_rencana p, tbl_penyiapan py, jabatan j, pegawai pg WHERE p.id_rencana = py.id_rencana AND j.id_jab = pg.id_jab AND pg.id_pegawai = py.id_pegawai AND p.id_rencana =  '$_GET[r]'"));
  $tot_pelak = mysql_fetch_assoc(mysql_query("SELECT SUM(pl.ang_lak) as jumpelak, pl.tgl_m_lak, pl.tgl_s_lak FROM tbl_rencana r, tbl_penyiapan py, tbl_sub_penyiapan sp, tbl_pelaksanaan pl, jabatan j, pegawai p WHERE r.id_rencana = py.id_rencana AND py.id_penyiapan = sp.id_penyiapan AND sp.id_sub_penyi = pl.id_sub_penyi AND j.id_jab = p.id_jab AND r.id_pegawai = p.id_pegawai AND r.id_rencana = '$_GET[r]'"));
  $tot_ren = mysql_fetch_assoc(mysql_query("SELECT r.mulai_ren, r.selesai_ren, r.anggaran_ren, r.nama_keg_ren FROM tbl_rencana r WHERE r.id_rencana='$_GET[r]'"));        
  $all = mysql_query("SELECT pl.nama_laksana, pl.id_pelaksanaan
                    FROM tbl_rencana r
                    JOIN tbl_penyiapan py ON r.id_rencana = py.id_rencana
                    JOIN tbl_sub_penyiapan spy ON py.id_penyiapan = spy.id_penyiapan
                    JOIN tbl_pelaksanaan pl ON spy.id_sub_penyi = pl.id_sub_penyi
                    WHERE r.id_rencana = '$_GET[r]'");      
  $total = $tot_penyi['jumpenyi']+$tot_pelak['jumpelak'];
  
  $uangtb1 = number_format($tot_ren['anggaran_ren'],2,",",".");
  $uangtb2 = number_format($tot_penyi['jumpenyi'],2,",",".");
  $uangtb3 = number_format($tot_pelak['jumpelak'],2,",",".");
  $uangtb4 = number_format($total,2,",",".");
              
  $mulai1 = dbtoindo($tot_ren['mulai_ren']);
  $selesai1 = dbtoindo($tot_ren['selesai_ren']);

  $mulai2 = dbtoindo($tot_penyi['tgl_mulai_penyi1']);
  $selesai2 = dbtoindo($tot_penyi['tgl_selesai_penyi1']);

  $mulai3 = dbtoindo($tot_pelak['tgl_m_lak']);
  $selesai3 = dbtoindo($tot_pelak['tgl_s_lak']);
?>
<div class="row-fluid">  
  <div class="span12">
    <div class="page-header">
      <h3><span class='label labelform label-info'>Perhitungan</span> Kondisi Rencana <?php echo "$ren[nama_keg_ren]";?> Berdasarkan <i>Model Value For Money (3E)</i></h3>
    </div>
    <div class="span12" style='margin-left:0px;'>
      <div class="span12 box_info">
        <div class="page-header">
          <h4>Detail Informasi Perencanaan <?php echo "$ren[nama_keg_ren]"; ?> <i class='icon-arrow-right'></i> Penyiapan <i class='icon-arrow-right'></i> Pelaksanaan</h4>
        </div>
        <div class="span12" style='margin-left:0px;'>
          <table border='1'>
            <!-- class='table table-bordered table-striped table-hover' id='tbl_rencana' -->
          <thead>
          <tr>
            <th rowspan='3'>Kode</th>
            <th rowspan='3'>Rencana</th>
            <th rowspan='3'>Penyiapan</th>
            <th rowspan='3'>Pelaksanaan</th>
            <th colspan='4'>Anggaran</th>            
            <th colspan='3'>Manajemen Waktu</th>
          </tr>
          <tr>
            <th rowspan='2'>Rencana</th>
            <th colspan='3'>Realisasi</th>
            <th rowspan='2'>Rencana</th>
            <th colspan='2'>Realisasi</th>
          </tr>
          <tr>
            <th>Penyiapan</th>
            <th>Pelaksanaan</th>
            <th>Total</th>
            <th>Penyiapan</th>
            <th>Pelaksanaan</th>
          </tr>
          </thead>
          <?php  

            $r = mysql_query("SELECT r.nama_keg_ren, r.id_rencana, r.anggaran_ren, r.kode_ren FROM tbl_rencana r WHERE r.id_rencana='$_GET[r]'");            
            while ($dtr = mysql_fetch_assoc($r)) {
              echo "<tr>
              <td>$dtr[kode_ren]</td>
              <td>$dtr[nama_keg_ren]</td>
              <td>";
              $p = mysql_query("SELECT py.id_penyiapan, py.nama_kegiatan_penyi FROM tbl_penyiapan py JOIN tbl_rencana r ON r.id_rencana = py.id_rencana WHERE r.id_rencana = '$dtr[id_rencana]'");
              while ($dtp = mysql_fetch_assoc($p)) {
                echo "
                <ul>
                <li>$dtp[nama_kegiatan_penyi]";
                  $sp = mysql_query("SELECT spy.id_sub_penyi, spy.penyi_sub_nama FROM tbl_sub_penyiapan spy JOIN tbl_penyiapan py ON py.id_penyiapan=spy.id_penyiapan WHERE py.id_penyiapan = '$dtp[id_penyiapan]'");
                    while ($dtsp = mysql_fetch_assoc($sp)) {
                      echo "<ul>
                            <li>$dtsp[penyi_sub_nama]</li>
                            </ul>";
                    }
                echo "</li>
                </ul>
                ";
              }
              echo "</td><td><ul>";
              
              while ($dtpl = mysql_fetch_assoc($all)) {
                echo "                
                  <li>$dtpl[nama_laksana]
                  <ul>";
                  $m = mysql_query("SELECT spl.pelak_sub_nama FROM tbl_sub_pelaksanaan spl JOIN tbl_pelaksanaan pl ON pl.id_pelaksanaan=spl.id_pelaksanaan WHERE pl.id_pelaksanaan='$dtpl[id_pelaksanaan]'");
                  while ($m2 = mysql_fetch_assoc($m)) {
                    echo "<li>$m2[pelak_sub_nama]</li>";
                  }
                  echo "</ul>
                  </li>
                ";
              }
              echo "</ul>
                </td>";
              echo "
              <td>Rp. $uangtb1</td>
              <td>Rp. $uangtb2</td>
              <td>Rp. $uangtb3</td>
              <td>Rp. $uangtb4</td>
              <td> $mulai1 s.d $selesai1</td>
              <td> $mulai2 s.d $selesai2</td>
              <td> $mulai3 s.d $selesai3</td>
              </tr>";
            }
          ?>
          <tbody>           
          </tbody>
        </table>
        </div>
        <?php  

        $jumpenyi = mysql_num_rows(mysql_query("SELECT py.id_penyiapan, py.nama_kegiatan_penyi FROM tbl_penyiapan py JOIN tbl_rencana r ON r.id_rencana = py.id_rencana WHERE r.id_rencana = '$_GET[r]'"));
        $jumpelak = mysql_num_rows($all);


        ?>
        <div class="span12" style='margin:20px 0px;'>
          <p>Dari tabel diatas bisa diambil data Anggaran:
            <ul>
              <li>Anggaran Rencana = Rp. <?php echo "$uangtb1"; ?></li>
              <li>Anggaran Kegiatan Penyiapan yang berjumlah <span class='badge badge-info'><?php echo "$jumpenyi"; ?></span> Penyiapan = Rp. <?php echo "$uangtb2"; ?></li>
              <li>Anggaran Kegiatan Pelaksanaan yang berjumlah <span class='badge badge-info'><?php echo "$jumpelak"; ?></span> Pelaksanaan = Rp. <?php echo "$uangtb3"; ?></li>
            </ul>
          </p>
          <div class="row-fluid">
            <div class="span6">
              <div class="page-header">
                <h4>Rumus Penentuan Kondisi Rencana ini dari sudut pandang Ekonomi</h4>
              </div>
              <div class="span12" style='margin-left:0px;'>
                <?php 
                include 'mod_sistem/md_b.kumkm/ekonomi.php';
                 ?>
              </div>  
            </div>

            <div class="span6">
              <div class="page-header">
                <h4>Rumus Penentuan Kondisi Rencana ini termasuk Efektif atau Efisien</h4>
              </div>
              <div class="span12" style='margin-left:0px;'>
                <p>Dalam Penentuan ini Sistem akan menentukan terlebih dahulu, apakah Rencana <?php echo "$tot_ren[nama_keg_ren]"; ?> termasuk katagori Efektif atau Efisien. Setelah itu maka Sistem akan menilai Rencana ini pada kondisi seperti apa.</p>
                <p class='text-info'>ACUAN PENENTUAN EFEKTIF ATAU EFISIEN</p>
                <ul>
                  <li>Bila Nilai Anggaran Rencana <strong>sama dengan (pas)</strong> Nilai Anggaran Realisasi maka Rencana tersebut dikatakan termasuk <strong>Katagori Efektif</strong>.</li>
                  <li>Bila Nilai Anggaran Rencana <strong>kurang dari atau lebih dari</strong> Nilai Anggaran Realisasi atau sebaliknya maka Rencana tersebut dikatakan termasuk <strong>Katagori Efisien</strong>.</li>
                </ul>
                <p>Nilai Anggaran Realisasi = Jumlah Anggaran Penyiapan + Jumlah Anggaran Pelaksanaan</p>
                <table>
                  <tbody>
                    <tr><td>Nilai Anggaran Realisasi</td><td>= Rp. <?php echo "$uangtb2"; ?> + Rp. <?php echo "$uangtb3"; ?></td></tr>
                    <tr><td></td><td>= Rp. <?php echo "$uangtb4"; ?></td></tr>
                    <tr><td>Nilai Anggaran Rencana</td><td>= Rp. <?php echo "$uangtb1"; ?></td></tr>                    
                  </tbody>
                </table>
                <br>
                <?php 
                $realisasi = $total;
                $anggaran_ren = $tot_ren['anggaran_ren'];

                  if($realisasi == $anggaran_ren){
                  include 'mod_sistem/md_b.kumkm/efektif.php';
                  // jika nilai anggaran realisasi < || > anggaran rencana --> efisien
                  }elseif($realisasi < $anggaran_ren  || $realisasi > $anggaran_ren){ 
                    include 'mod_sistem/md_b.kumkm/efisien.php';
                    }// akhir dari elsenya efisien atau efektif
                     ?>

              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
<!-- akhir rowfluid -->