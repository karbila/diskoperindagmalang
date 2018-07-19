              <?php 
              if($realisasi > $anggaran_ren){
                  echo "Dari perbandingan nilai diatas diketahui bahwa Nilai Realisasi Anggaran (Rp. $uangtb4) <strong>lebih besar dari </strong> Nilai Rencana Anggaran (Rp. $uangtb1) maka Rencana $tot_ren[nama_keg_ren] termasuk katagori <strong>EFISIEN</strong>";  
                }elseif($realisasi < $anggaran_ren){
                  echo "Dari perbandingan nilai diatas diketahui bahwa Nilai Realisasi Anggaran (Rp. $uangtb4) <strong>lebih kecil dari </strong> Nilai Rencana Anggaran (Rp. $uangtb1) maka Rencana $tot_ren[nama_keg_ren] termasuk katagori <strong>EFISIEN</strong>";  
                }
                echo "<br><br>";
                echo "<p class='text-warning'>PERHITUNGAN EFISIEN</p>";
               ?>
              <p><strong>Tahap 1: Mencari Peringkat Skor Ratio Efisien</strong></p>
                <ul>
                  <li>Rumus Ratio Efiensi Rencana <strong>(B1)</strong> = (Nilai Anggaran (Input) yang direncanakan/Nilai Anggaran (Output) yang direncanakan) X 100%</li>
                  <li>Rumus Ratio Efiensi Realisasi <strong>(B2)</strong> = (Nilai Anggaran (Input) Realisasi Belanja/Nilai Anggaran (Output) Realisasi) X 100%</li>
                  <li>Rumus Ratio Efiensi <strong>(B3)</strong> = (B2/B1) X 100%</li>
                </ul>
                
                <p>Dari rumus diatas maka:</p>
                <?php 
                 $rasio_b1 =  ($anggaran_ren/$anggaran_ren)*100;
                 $rasio_b2 = ($realisasi/$realisasi)*100;
                 $rasio_b3 = ($rasio_b2/$rasio_b1)*100;
                 ?>
                <table>
                  <tbody>
                    <tr><td><strong>B1</strong></td><td>= <?php echo "( Rp. $uangtb1"; ?> / <?php echo "Rp. $uangtb1 )"; ?> X 100%</td></tr>
                    <tr><td></td><td>= <?php echo "$rasio_b1 %"; ?></td></tr>
                    <tr><td><strong>B2</strong></td><td>= <?php echo "( Rp. $uangtb4"; ?> / <?php echo "Rp. $uangtb4 )"; ?> X 100%</td></tr>
                    <tr><td></td><td>= <?php echo "$rasio_b2 %"; ?></td></tr>
                    <tr><td><strong>B3</strong></td><td>= <?php echo "( $rasio_b2%"; ?> / <?php echo "$rasio_b1% )"; ?> X 100%</td></tr>
                    <tr><td></td><td>= <?php echo "$rasio_b3 %"; ?></td></tr>
                  </tbody>
                </table>
                <br>
                <p class='text-info'>TABEL PERINGKAT SKOR RATIO EFISIEN</p>
                <table border='1'>
                  <thead><th>Ratio Efisien</th><th>Skor</th></thead>
                  <tbody>
                    <?php 
                      $y = mysql_query("SELECT * FROM tbl_evaluasi WHERE status = '2'");
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

                      if($rasio_b3 > 105){
                        $b3 = 1;
                      }elseif($rasio_b3 >=101 AND $rasio_b3 <=105){
                        $b3 = 2;
                      }elseif($rasio_b3 >=96 AND $rasio_b3 <=100){
                        $b3 = 3;
                      }elseif($rasio_b3 < 96){
                        $b3 = 4;
                      }

                      $nilai_b4 = $b3 * 4;
                     ?>
                  </tbody>
                </table>
                <p>Karena Nilai B3 adalah <?php echo "$rasio_b3"; ?> maka dari acuan tabel diatas Skor Rencana ini adalah <?php echo "$b3"; ?></p>
                <br>
                <p><strong>Tahap 2: Penentuan Nilai Efisiensi (B4)</strong></p>                
                <p>Rumus B4 = Skor Ratio Efisiensi X Bobot; Dimana Bobot adalah 4 (Angka Paten)</p>
                <p>Telah diketahui diatas bahwa Skor Ratio Efisiensi adalah <?php echo "$b3"; ?>, maka</p>
                <table>
                  <tbody>
                    <tr><td>Nilai Efisiensi (B4) </td><td>= <?php echo "$b3"; ?> x 4</td></tr>
                    <tr><td></td><td>= <?php  echo "$nilai_b4";?></td></tr>
                  </tbody>
                </table>
                <br>
                <p><strong>Tahap 3: Penentuan Nilai Maksimum (B5)</strong></p>                
                <p>Rumus B5 = Skor Maksimum X Bobot; Dimana Bobot adalah 4 (Angka Paten)</p>
                <p>Untuk nilai Skor Maksimum bisa Anda lihat di <strong>Tabel Peringkat Skor Efisien</strong> nilai Skor maksimal adalah <strong>4</strong> maka itulah nilai Skor Maksimalnya.</p>
                <table>
                  <tbody>
                    <?php
                      $i = mysql_fetch_assoc(mysql_query("SELECT MAX(skor) as max FROM tbl_evaluasi WHERE status = '2'"));
                      $nilai_b5 = $i['max'] * 4;
                    ?>
                    <tr><td>Nilai Maksimum (B5) </td><td>= <?php echo "$i[max]"; ?> x 4</td></tr>
                    <tr><td></td><td>= <?php  echo "$nilai_b5";?></td></tr>
                  </tbody>
                </table>
                <br>
                <p><strong>Tahap 4: Pencapaian Kinerja Efisien (B6)</strong></p>                
                <p>Rumus B6 = (Nilai Efisien (B4) / Nilai Maksimum (B5)) X 100%</p>                
                <?php 

                $efisien_b6 = ($nilai_b4/$nilai_b5)*100;
                if($efisien_b6 >=80 AND $efisien_b6 <=100){
                  $f = "Range 80 - 100";
                  $e = "<b style='color:green;'>Sangat Efisien</b>";
                }elseif($efisien_b6 >=70 AND $efisien_b6 <=79){
                  $f = "Range 70 - 79";
                  $e = "<b style='color:green;'>Efisien</b>";
                }elseif($efisien_b6 >=60 AND $efisien_b6 <=69){
                  $f = "Range 60 - 69";
                  $e = "<b style='color:green;'>Cukup Efisien</b>";
                }elseif($efisien_b6 >=50 AND $efisien_b6 <=59){
                  $f = "Range 50 - 59";
                  $e = "<b style='color:red;'>Kurang Efisien</b>";
                }elseif($efisien_b6 < 50){
                  $f = "Range < 50";
                  $e = "<b style='color:red;'>Tidak Efisien</b>";
                }else{
                  $e = "<b style='color:red;'>Undifined:Efisien :(</b>";
                }

                 ?>
                <table>
                  <tr><td>B6</td><td>= (<?php echo "$nilai_b4"; ?> / <?php echo "$nilai_b5"; ?>) X 100%</td></tr>
                  <tr><td></td><td>= <?php echo "$efisien_b6"; ?></td></tr>
                </table>
                <p>Untuk mengetahui Skor <?php echo "$efisien_b6"; ?> termasuk dalam kondisi apa maka ada tabel Acuan Kinerja Efisiensi Teknis/Alokasi</p>
                <p class='text-info' style='text-transform:uppercase;'>Acuan Kinerja Efisiensi Teknis/Alokasi</p>
                <table border='1'>
                  <thead><th>Range</th><th>Makna</th><th>Skor</th></thead>
                  <tbody>
                    <?php                    
                      $i = mysql_query("SELECT * FROM tbl_evaluasi WHERE status = '3'");
                      while ($k = mysql_fetch_assoc($i)) {
                        echo "<tr><td>$k[range]</td><td>$k[makna]</td><td align='center'>$k[skor]</td></tr>";
                      }
                    ?>                    
                  </tbody>
                </table>
                <p>Dari tabel diatas maka bisa dilihat bahwa nilai <?php echo "$efisien_b6"; ?> masuk dalam range <?php echo "$f"; ?> yang berarti bahwa rencana ini bersifat <?php echo "$e."; ?></p>