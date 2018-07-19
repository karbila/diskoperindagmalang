<p>Rumus Ratio Ekonomi = (Jumlah Anggaran Realisasi/Jumlah Anggaran Rencana) X 100</p>
                <p>Jumlah Anggaran Realisasi = Jumlah Anggaran Penyiapan + Jumlah Anggaran Pelaksanaan</p>
                <p class='text-info'>TABEL ACUAN RATIO EKONOMI</p>
                <table border='1'>
                  <thead><th>Ratio Ekonomi</th><th>Makna</th><th>Skor Ekonomi</th></thead>
                  <tbody>
                    <?php 
                      $y = mysql_query("SELECT * FROM tbl_evaluasi WHERE status = '1'");
                      while ($y2 = mysql_fetch_assoc($y)) {
                        echo "<tr>
                        <td>$y2[range]</td>
                        <td>$y2[makna]</td>
                        <td align='center'>$y2[skor]</td>
                        </tr>";
                      }
                     ?>
                  </tbody>
                </table>
                <br>
                <p>Selanjutkan, bila Anggaran diatas dimasukkan dalam Rumus maka:</p>
                <table>
                  <tbody>
                    <tr><td>Jumlah Anggaran Realisasi</td><td>= Rp. <?php echo "$uangtb2"; ?> + Rp. <?php echo "$uangtb3"; ?></td></tr>
                    <tr><td></td><td>= Rp. <?php echo "$uangtb4"; ?></td></tr>
                    <br>
                    <tr><td>Ratio Ekonomi</td><td>= (<?php echo "Rp. $uangtb4"; ?>/<?php echo "Rp. $uangtb1"; ?>) X 100%</td></tr>
                    <?php 
                      $ang2 = $tot_ren['anggaran_ren'];
                      $realisasi = $tot_penyi['jumpenyi']+$tot_pelak['jumpelak'];                      
                      $kon1 = ($realisasi/$ang2)*100;

                      if($kon1 < 90){
                        $ekon = "<b style='color:green;'>Sangat Ekonomis</b>";
                      }elseif($kon1 >=90 AND $kon1 <=94.99){
                        $ekon = "<b style='color:green;'>Ekonomis</b>";
                      }elseif($kon1 >=95 AND $kon1 <=100){
                        $ekon = "<b style='color:green;'>Cukup Ekonomis</b>";
                      }elseif($kon1 >=100.01 AND $kon1 <=105){
                        $ekon = "<b style='color:red;'>Kurang Ekonomis</b>";
                      }elseif($kon1 > 105){
                        $ekon = "<b style='color:red;'>Tidak Ekonomis</b>";
                      }
                     ?>
                    <tr><td></td><td>= <?php echo "$kon1 %"; ?></td></tr>
                    <tr><td colspan='2'>Telah dihasilkan Ratio Ekonomi sebesar <?php echo "$kon1 %"; ?>, Maka Ratio Ekonomi untuk Rencana <?php  echo "$tot_ren[nama_keg_ren]";?> adalah <?php echo "$ekon"; ?></td></tr>

                  </tbody>
                </table>