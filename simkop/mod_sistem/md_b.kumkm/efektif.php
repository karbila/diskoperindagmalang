<?php 
                echo "Dari perbandingan nilai diatas diketahui bahwa Nilai Realisasi Anggaran (Rp. $uangtb4) <strong>sama dengan</strong> Nilai Rencana Anggaran (Rp. $uangtb1) maka Rencana $tot_ren[nama_keg_ren] termasuk katagori <strong>EFEKTIF</strong>";
                echo "<br>";
                echo "<p class='text-warning'>PERHITUNGAN EFEKTIF</p>";
                
                

                
                
                
 ?>
              <p><strong>Tahap 1: Mencari Peringkat Skor Ratio Efektif</strong></p>
                <p>Rumus Skor Ratio Efektif <strong>(C1)</strong> = (Nilai Anggaran (Output) Realisasi/Nilai Anggaran Rencana) X 100%</p>
                
                <p>Dari rumus diatas maka:</p>
                <?php 
                 $rasio_c1 = ($realisasi/$anggaran_ren)*100;
                 ?>
                <table>
                  <tbody>
                    <tr><td><strong>C1</strong></td><td>= (<?php echo "Rp. $uangtb4"; ?>/<?php echo "Rp. $uangtb1"; ?>) X 100%</td></tr>
                    <tr><td></td><td>= <?php echo "$rasio_c1"; ?></td></tr>
                  </tbody>
                </table>
                <br>
                <p class='text-info'>TABEL PERINGKAT SKOR RATIO EFEKTIFITAS</p>
                <table border='1'>
                  <thead><th>Ratio Efektif</th><th>Skor</th></thead>
                  <tbody>
                    <?php 
                      $y = mysql_query("SELECT * FROM tbl_evaluasi WHERE status = '4'");
                      while ($y2 = mysql_fetch_assoc($y)) {
                        echo "<tr>
                        <td>$y2[range]</td>";
                        if($y2['skor']=='4'){
                          echo "<td align='center'><span class='badge badge-info'>4</span></td>";
                        }else{
                          echo "<td align='center'>$y2[skor]</td>";
                        }
                        echo "</tr>";
                      }

                      if($rasio_c1 < 90){
                        $c1 = 1;
                      }elseif($rasio_c1 >=90 AND $rasio_c1 <=94.99){
                        $c1 = 2;
                      }elseif($rasio_c1 >=95 AND $rasio_c1 <=100){
                        $c1 = 3;
                      }elseif($rasio_c1 > 100){
                        $c1 = 4;
                      }

                      $nilai_c2 = $c1 * 4;
                     ?>
                  </tbody>
                </table>
                <p>Karena Nilai C1 adalah <?php echo "$rasio_c1"; ?> maka dari acuan tabel diatas Skor Ratio Efektifitas ini adalah <?php echo "<strong>$c1</strong>"; ?></p>
                <br>
                <p><strong>Tahap 2: Penentuan Nilai Efektifitas (C2)</strong></p>                
                <p><strong>Rumus C2</strong> = Skor Ratio Efektifitas X Bobot; Dimana Bobot adalah 4 (Angka Paten)</p>
                <p>Telah diketahui diatas bahwa Skor Ratio Efisiensi adalah <?php echo "<strong>$c1</strong>"; ?>, maka</p>
                <table>
                  <tbody>
                    <tr><td>C2 </td><td>= <?php echo "$c1"; ?> x 4</td></tr>
                    <tr><td></td><td>= <?php  echo "$nilai_c2";?></td></tr>
                  </tbody>
                </table>
                <br>
                <p><strong>Tahap 3: Penentuan Nilai Maksimum (C3)</strong></p>                
                <p><strong>Rumus C3</strong> = Skor Maksimum X Bobot; Dimana Bobot adalah 4 (Angka Paten)</p>
                <p>Untuk nilai Skor Maksimum bisa Anda lihat di <strong>Tabel Peringkat Skor Efektifitas</strong> nilai Skor maksimal adalah <strong>4</strong> maka itulah nilai Skor Maksimalnya.</p>
                <table>
                  <tbody>
                    <?php
                      $i = mysql_fetch_assoc(mysql_query("SELECT MAX(skor) as max FROM tbl_evaluasi WHERE status = '4'"));
                      $nilai_c3 = $i['max'] * 4;
                    ?>
                    <tr><td>Nilai Maksimum (C3) </td><td>= <?php echo "$i[max]"; ?> x 4</td></tr>
                    <tr><td></td><td>= <?php  echo "$nilai_c3";?></td></tr>
                  </tbody>
                </table>
                <br>
                <p><strong>Tahap 4: Pencapaian Kinerja Efektifitas (C4)</strong></p>                
                <p>Rumus C4 = (Nilai Efektifitas (C2) / Nilai Maksimum (C3)) X 100%</p>                
                <?php 

                $nilai_c4 = ($nilai_c2/$nilai_c3)*100;
                
                if($nilai_c4 >=80 AND $nilai_c4 <=100){
                  $f = "Range 80 - 100";
                  $e = "<b style='color:green;'>Sangat Efektif</b>";
                }elseif($nilai_c4 >=70 AND $nilai_c4 <=79){
                  $f = "Range 70 - 79";
                  $e = "<b style='color:green;'>Efektif</b>";
                }elseif($nilai_c4 >=60 AND $nilai_c4 <=69){
                  $f = "Range 60 - 69";
                  $e = "<b style='color:green;'>Cukup Efektif</b>";
                }elseif($nilai_c4 >=50 AND $nilai_c4 <=59){
                  $f = "Range 50 - 59";
                  $e = "<b style='color:red;'>Kurang Efektif</b>";
                }elseif($nilai_c4 < 50){
                  $f = "Range < 50";
                  $e = "<b style='color:red;'>Tidak Efektif</b>";
                }else{
                  $e = "<b style='color:red;'>Undefined:Efektif :(</b>";
                }                

                 ?>
                <table>
                  <tbody>
                    <tr><td><strong>C4</strong></td><td>= (<?php echo "$nilai_c2"; ?> / <?php echo "$nilai_c3"; ?>) X 100%</td></tr>
                    <tr><td></td><td>= <?php echo "$nilai_c4 %"; ?></td></tr>
                  </tbody>
                </table>
                <p>Untuk mengetahui Skor <?php echo "$nilai_c4"; ?> termasuk dalam kondisi apa maka ada tabel Acuan Kinerja Efektifitas</p>
                <p class='text-info' style='text-transform:uppercase;'>Acuan Kinerja Efektifitas</p>
                <table border='1'>
                  <thead><th>Range</th><th>Makna</th><th>Skor</th></thead>
                  <tbody>
                    <?php                    
                      $i = mysql_query("SELECT * FROM tbl_evaluasi WHERE status = '5'");
                      while ($k = mysql_fetch_assoc($i)) {
                        echo "<tr><td>$k[range]</td><td>$k[makna]</td><td align='center'>$k[skor]</td></tr>";
                      }
                    ?>                    
                  </tbody>
                </table>
                <p>Dari tabel diatas maka bisa dilihat bahwa nilai <?php echo "$nilai_c4"; ?> masuk dalam range <?php echo "$f"; ?> yang berarti bahwa rencana ini bersifat <?php echo "$e."; ?></p>