<?php  
  $pelak = mysql_query("SELECT pl.nama_laksana, pl.id_pelaksanaan, pl.kode_laksana, pl.tgl_m_lak, pl.tgl_s_lak, j.nama_jab, p.nama_pegawai, pl.des_lak, pl.ang_lak, pl.tempat_lak, d.nama_dok, d.id_dok FROM tbl_pelaksanaan pl, jabatan j, pegawai p, dokumen d WHERE j.id_jab = p.id_jab AND d.id_dok = pl.id_dok AND p.id_pegawai = pl.id_pegawai AND pl.id_pelaksanaan =  '$_GET[kd]'");
  $ren = mysql_fetch_array($pelak);
  $penga = mysql_query("SELECT a.id_pengawasan, a.kode_penga, a.nama_penga, a.tgl_awal_penga, a.tgl_akhir_penga, a.tempat_penga, a.detil_penga, a.ang_penga, p.nama_pegawai, d.nama_dok, d.id_dok, j.nama_jab FROM tbl_pengawasan a, tbl_pelaksanaan pl, tbl_sub_pelaksanaan s, dokumen d, pegawai p, jabatan j WHERE j.id_jab=p.id_jab AND p.id_pegawai=a.id_pegawai AND d.id_dok=a.id_dok AND s.id_sub_pelak=a.id_sub_pelak AND pl.id_pelaksanaan=s.id_pelaksanaan AND pl.id_pelaksanaan='$_GET[kd]'");

  $mulai = $ren['tgl_m_lak'];
  $m = tgl_indo($mulai);
  $selesai = $ren['tgl_s_lak'];
  $s = tgl_indo($selesai);

  $uang_pelak = number_format($ren['ang_lak'],2,",",".");
?>
<div class="row-fluid">  
  <div class="span12">
    <div class="page-header">
      <h3><span class='label labelform label-info'>Detail </span>Kegiatan Pelaksanaan <?php echo "$ren[nama_laksana]"; ?></h3>
    </div>
    <div class="span12" style='margin-left:0px;'> 
      <div class="span12 box_info">
        <div class="page-header">
          <h4>Detail Informasi Pelaksanaan <?php echo "$ren[nama_laksana]"; ?></h4>
        </div>
        <div class="span12">
          <ul>
            <li>Nama Pelaksanaan: <span class='isi'><?php echo "$ren[nama_laksana]"; ?></span></li>
            <li>Mulai dilaksanakan pada tanggal: <span class='isi'><?php echo "$m"; ?></span></li>
            <li>Target Selesai pada Tanggal: <span class='isi'><?php echo "$s"; ?></span></li>
            <li>Tempat: <span class='isi'><?php echo "$ren[tempat_lak]"; ?></span></li>
            <li>Anggaran Pelaksanaan: <span class='isi'>Rp. <?php echo "$uang_pelak"; ?></span></li>
            <li>Penanggung Jawab (PJ): <span class='isi'><?php echo "$ren[nama_pegawai]"; ?></span></li>
            <li>Jabatan PJ: <span class='isi'><?php echo "$ren[nama_jab]"; ?></span></li>
            <li>Deskripsi Pelaksanaan: <span class='isi'><?php echo "$ren[des_lak]"; ?></span></li>
            <li>Dokumen: <span class='isi'><?php echo "<a href=''>$ren[nama_dok]</a>"; ?></span></li>
            <li>Sub Kegiatan Pelaksanaan <?php echo "$ren[nama_laksana]"; ?>
              <ol>
                <?php  
                $i=mysql_query("SELECT s. * FROM tbl_sub_pelaksanaan s, tbl_pelaksanaan l WHERE l.id_pelaksanaan = s.id_pelaksanaan AND l.id_pelaksanaan='$ren[id_pelaksanaan]'");

                while ($l=mysql_fetch_array($i)) {
                  $y=tgl_indo($l['pelak_sub_mulai']); 
                  $z=tgl_indo($l['pelak_sub_akhir']);
                  echo "<li>$l[pelak_sub_nama] ($ren[kode_laksana].$l[pelak_sub_kode], $y, $z)</li>
                  ";
                }

                ?>
              </ol>

            </li>
          </ul>
        </div>
      </div>       
      <div class="span12 box_info" style='margin-left:0px;'>
          <div class="page-header">
            <h4>Detail Informasi Pengawasan pada Kegiatan Pelaksanaan <?php echo "$ren[nama_laksana]"; ?></h4>
          </div>
          <div class="span12" style='margin-left:0px;'>
            <table border='1'>
            <thead>
              <tr>
                <th rowspan='2'>Kode</th>
                <th rowspan='2'>Nama Pengawasan</th>
                <th colspan='2'>Waktu</th>
                <th rowspan='2'>Detail Sub Pengawasan</th>
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
              while ($e=mysql_fetch_array($penga)) {
                $m1 = $e['tgl_awal_penga'];
                $m2 = tgl_indo($m1);
                $s1 = $e['tgl_akhir_penga'];
                $s2 = tgl_indo($s1);
                $uang_was = number_format($e['ang_penga'],2,",",".");
                echo "<tr>
                <td>$e[kode_penga]</td>
                <td>$e[nama_penga]</td>
                <td>$m2</td>
                <td>$s2</td>";
                $f = mysql_query("SELECT s.kode_sub_penga, s.nama_sub_penga, s.tgl_mulai_penga_sub, s.tgl_akhir_penga_sub FROM tbl_sub_pengawasan s, tbl_pengawasan py WHERE py.id_pengawasan=s.id_pengawasan AND py.id_pengawasan = '$e[id_pengawasan]'");
                echo "<td>";
                $t = mysql_num_rows($f);
                if($t==0){
                    echo "Tidak ada Sub Pelaksanaan";      
                  }else{
                    while ($k=mysql_fetch_array($f)) {
                    echo "<ul>
                    <li>$k[nama_sub_penga] ($e[kode_penga].$k[kode_sub_penga], $k[tgl_mulai_penga_sub], $k[tgl_akhir_penga_sub])</li>
                  </ul>";
                    }
                  }
                
                echo "</td>";
                echo "<td>$e[tempat_penga]</td>
                <td>Rp. $uang_was</td>
                <td>$e[nama_pegawai]</td>
                <td>$e[nama_jab]</td>
                <td>$e[detil_penga]</td>
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