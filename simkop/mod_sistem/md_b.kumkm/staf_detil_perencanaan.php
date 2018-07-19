<?php  
  $ren = mysql_fetch_array(mysql_query("SELECT r.id_rencana, r.kode_ren, r.nama_keg_ren, r.mulai_ren, r.selesai_ren, r.tempat_ren, r.anggaran_ren, r.desk_ren, p.id_pegawai, p.nama_pegawai, p.nomor_induk, j.nama_jab, d.nama_dok, d.id_dok FROM tbl_rencana r, pegawai p, jabatan j, dokumen d WHERE j.id_jab=p.id_jab AND p.id_pegawai=r.id_pegawai AND d.id_dok=r.id_dok AND r.id_rencana = '$_GET[r]'"));
  $penyi = mysql_query("SELECT  p.id_rencana, py.kode_penyi, py.nama_kegiatan_penyi, py.id_penyiapan, py.tgl_mulai_penyi1, py.tgl_selesai_penyi1, py.tempat_penyi, j.nama_jab, py.anggaran, py.deskripsi_penyi, py.status_kunci, py.owner, pg.nama_pegawai FROM tbl_rencana p, tbl_penyiapan py, jabatan j, pegawai pg WHERE p.id_rencana = py.id_rencana AND j.id_jab = pg.id_jab AND pg.id_pegawai = py.id_pegawai AND p.id_rencana =  '$_GET[r]'");
  $pelak = mysql_query("SELECT r.id_rencana, pl.nama_laksana, pl.id_pelaksanaan, pl.kode_laksana, pl.tgl_m_lak,pl.tgl_s_lak, j.nama_jab, p.nama_pegawai, pl.des_lak, pl.ang_lak, pl.tempat_lak FROM tbl_rencana r, tbl_penyiapan py, tbl_sub_penyiapan sp, tbl_pelaksanaan pl, jabatan j, pegawai p WHERE r.id_rencana = py.id_rencana AND py.id_penyiapan = sp.id_penyiapan AND sp.id_sub_penyi = pl.id_sub_penyi AND j.id_jab = p.id_jab AND r.id_pegawai = p.id_pegawai AND r.id_rencana = '$_GET[r]'");

  $mulai = $ren['mulai_ren'];
  $m = tgl_indo($mulai);
  $selesai = $ren['selesai_ren'];
  $s = tgl_indo($selesai);

  $uang_ren = number_format($ren['anggaran_ren'],2,",",".");
?>
<div class="row-fluid">  
  <div class="span12">
    <div class="page-header">
      <h3><span class='label labelform label-info'>Detail/Tracking</span> Rencana <?php echo "$ren[nama_keg_ren]"; ?></h3>
    </div>
    <div class="span12" style='margin-left:0px;'>
      <div class="span12 box_info">
        <div class="page-header">
          <h4>Detail Informasi Perencanaan <?php echo "$ren[nama_keg_ren]"; ?></h4>
        </div>
        <div class="span12">
          <ul>
            <li>Nama Rencana: <span class='isi'><?php echo "$ren[nama_keg_ren]"; ?></span></li>
            <li>Mulai direncanakan pada Tanggal: <span class='isi'><?php echo "$m"; ?></span></li>
            <li>Target Selesai pada Tanggal: <span class='isi'><?php echo "$s"; ?></span></li>
            <li>Tempat: <span class='isi'><?php echo "$ren[tempat_ren]"; ?></span></li>
            <li>Rencana Anggaran: <span class='isi'>Rp. <?php echo "$uang_ren"; ?></span></li>
            <li>Penanggung Jawab (PJ): <span class='isi'><?php echo "$ren[nama_pegawai]"; ?></span></li>
            <li>Jabatan PJ: <span class='isi'><?php echo "$ren[nama_jab]"; ?></span></li>
            <li>Deskripsi Rencana: <span class='isi'><?php echo "$ren[desk_ren]"; ?></span></li>
            <li>Dokumen Perencanaan: <span class='isi'><?php echo "<a href=''>$ren[nama_dok]</a>"; ?></span></li>
          </ul>
        </div>
      </div>
      <div class="span12 box_info" style='margin-left:0px;'>
        <div class="page-header">
          <h4>Detail Informasi Kegiatan Persiapan Rencana <?php echo "$ren[nama_keg_ren]"; ?></h4>
        </div>
        <div class="span12" style='margin-left:0px;'>
          <table border='1'>
            <thead>
              <tr>
                <th rowspan='2'>Kode</th>
                <th rowspan='2'>Nama Penyiapan</th>
                <th colspan='2'>Waktu</th>
                <th rowspan='2'>Detail Sub Penyiapan</th>
                <th rowspan='2'>Tempat</th>
                <th rowspan='2'>Anggaran</th>
                <th rowspan='2'>Nama PJ</th>
                <th rowspan='2'>Jabatan PJ</th>
                <th rowspan='2'>Deskripsi</th>
              </tr>
              <tr><th>Mulai</th><th>Selesai</th></tr>
            </thead>
            <tbody>
              <?php 
              while ($e=mysql_fetch_array($penyi)) {
                $m1 = $e['tgl_mulai_penyi1'];
                $m2 = tgl_indo($m1);
                $s1 = $e['tgl_selesai_penyi1'];
                $s2 = tgl_indo($s1);
                $uang_penyi = number_format($e['anggaran'],2,",",".");
                echo "<tr>
                <td>$e[kode_penyi]</td>
                <td>$e[nama_kegiatan_penyi]</td>
                <td>$m2</td>
                <td>$s2</td>";
                $f = mysql_query("SELECT s.penyi_sub_kode, s.penyi_sub_nama, s.penyi_sub_selesai, s.penyi_sub_mulai FROM tbl_sub_penyiapan s, tbl_penyiapan py WHERE py.id_penyiapan=s.id_penyiapan AND py.id_penyiapan = '$e[id_penyiapan]'");
                echo "<td>";
                while ($k=mysql_fetch_array($f)) {
                  echo "<ul>
                    <li>$k[penyi_sub_nama] ($e[kode_penyi].$k[penyi_sub_kode], $k[penyi_sub_mulai], $k[penyi_sub_selesai])</li>
                  </ul>";
                }
                echo "</td>";
                
                echo "<td>$e[tempat_penyi]</td>
                <td>Rp. $uang_penyi</td>
                <td>$e[nama_pegawai]</td>
                <td>$e[nama_jab]</td>
                <td>$e[deskripsi_penyi]</td>
                </tr>";
              }
               ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="span12 box_info" style='margin-left:0px;'>
        <div class="page-header">
          <h4>Detail Informasi Kegiatan Pelaksanaan Rencana <?php echo "$ren[nama_keg_ren]"; ?></h4>
        </div>
        <div class="span12" style='margin-left:0px;'>
          <table border='1'>
            <thead>
              <tr>
                <th rowspan='2'>Kode</th>
                <th rowspan='2'>Nama Pelaksanaan</th>
                <th colspan='2'>Waktu</th>
                <th rowspan='2'>Detail Sub Pelaksanaan</th>
                <th rowspan='2'>Tempat</th>
                <th rowspan='2'>Anggaran</th>
                <th rowspan='2'>Nama PJ</th>
                <th rowspan='2'>Jabatan PJ</th>
                <th rowspan='2'>Deskripsi</th>
              </tr>
              <tr><th>Mulai</th><th>Selesai</th></tr>
            </thead>
            <tbody>
              <?php 
              while ($e2=mysql_fetch_array($pelak)) {
                $m3 = $e2['tgl_m_lak'];
                $m4 = tgl_indo($m3);
                $s3 = $e2['tgl_s_lak'];
                $s4 = tgl_indo($s3);
                $uang_pelak = number_format($e2['ang_lak'],2,",",".");


                echo "<tr>
                <td>$e2[kode_laksana]</td>
                <td>$e2[nama_laksana]</td>
                <td>$m4</td>
                <td>$s4</td>";
                $f = mysql_query("SELECT s.pelak_sub_kode, s.pelak_sub_nama, s.pelak_sub_akhir, s.pelak_sub_mulai FROM tbl_sub_pelaksanaan s, tbl_pelaksanaan py WHERE py.id_pelaksanaan=s.id_pelaksanaan AND py.id_pelaksanaan = '$e2[id_pelaksanaan]'");
                echo "<td>";
                while ($k=mysql_fetch_array($f)) {
                  echo "<ul>
                    <li>$k[pelak_sub_nama] ($e2[kode_laksana].$k[pelak_sub_kode], $k[pelak_sub_mulai], $k[pelak_sub_akhir])</li>
                  </ul>";
                }
                echo "</td>";
                
                echo "<td>$e2[tempat_lak]</td>
                <td>Rp. $uang_pelak</td>
                <td>$e2[nama_pegawai]</td>
                <td>$e2[nama_jab]</td>
                <td>$e2[des_lak]</td>
                </tr>";
              }
               ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- akhir rowfluid -->