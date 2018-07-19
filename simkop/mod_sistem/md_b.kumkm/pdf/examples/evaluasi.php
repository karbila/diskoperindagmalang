<?php
// Include the main TCPDF library (search for installation path).

session_start();

require_once('tcpdf_include.php');
include "../../../../../konfigurasi/conf-db/dbautentikasi.php";
include "../../../../../konfigurasi/function/fungsi_indotgl.php";
date_default_timezone_set('asia/Jakarta'); // CDT

$current_date = date('d-m-Y, H:i:s');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Dinas Koperasi Pasuruan');
$pdf->SetTitle('Laporan Pengawasan');
// $pdf->SetSubject('TCPDF Tutorial');
// $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
// $pdf->SetFont('dejavusans', '', 10);
$pdf->SetFont('times', '', 10);
$pdf->setHeaderFont(array('times', '', 10));

// add a page
$pdf->AddPage();

$t = $_GET['th'];
$b = getBulan($_GET['bl']);
$j= "SELECT r.id_rencana, r.kode_ren, r.nama_keg_ren, r.mulai_ren, r.selesai_ren, r.tempat_ren, r.anggaran_ren, r.desk_ren, p.id_pegawai, p.nama_pegawai, p.nomor_induk, j.nama_jab, d.nama_dok, d.id_dok
                  FROM tbl_pelaksanaan pl
                  JOIN tbl_sub_penyiapan sp ON sp.id_sub_penyi = pl.id_sub_penyi
                  JOIN tbl_penyiapan py ON py.id_penyiapan = sp.id_penyiapan
                  JOIN tbl_rencana r ON r.id_rencana = py.id_rencana
                  JOIN dokumen d ON d.id_dok = r.id_dok
                  JOIN pegawai p ON r.id_pegawai = p.id_pegawai
                  JOIN jabatan j ON j.id_jab = p.id_jab
                  WHERE MONTH( r.mulai_ren ) =  '$_GET[bl]'
                  AND YEAR( r.mulai_ren ) =  '$t'
                  GROUP BY r.id_rencana";
// $pdf->writeHTML($j, true, 0);
$q_ren = mysql_query($j);
$jum = mysql_num_rows($q_ren);

$oke = '<br><h2 style="text-align:center">Laporan Evaluasi dan Monitoring Kegiatan Perencanaan <br>Bulan '.$b.' Tahun '.$t.'</h2><br>
<table border="1" cellpadding="4">
              <thead>               
                <tr>                
                <th width="50" style="text-align:center"; rowspan="2">Kode</th>
                <th style="text-align:center"; rowspan="2">Nama Rencana</th>
                      <th style="text-align:center"; colspan="2">Perencanaan</th>                      
                      <th style="text-align:center"; rowspan="2">PJ</th>
                      <th style="text-align:center"; colspan="2" width="200">Anggaran</th>                 
                      <th style="text-align:center"; rowspan="2" width="70">Kondisi Rencana</th>                      
                      </tr>
                      <tr>
                      <th style="text-align:center";>Mulai</th>
                      <th style="text-align:center";>Selesai</th>
                      <th style="text-align:center"; width="100">Rencana</th>
                      <th style="text-align:center"; width="100">Realisasi</th>
                      </tr>
              </thead>
              <tbody>';                
               
                if($jum==0){
                  $oke .= '<tr><td colspan="8">Tidak ada data Rencana di Bulan '.$b.' Tahun '.$t.'</td></tr>';
                }else{
                  while ($dt = mysql_fetch_assoc($q_ren)) {
                  $tg1 = dbtoindo($dt['mulai_ren']);
                  $tg2 = dbtoindo($dt['selesai_ren']);      
                  $uang_ren = number_format($dt['anggaran_ren'],2,",",".");
                  $oke .="<tr><td width=\"50\">$dt[kode_ren]</td>
                        <td>$dt[nama_keg_ren]</td>
                        <td>$tg1</td>
                        <td>$tg2</td>                        
                        <td>$dt[nama_pegawai]</td>
                        <td width=\"100\">Rp. $uang_ren</td>
                        ";
                        $anggaran_ren = $dt["anggaran_ren"];
                        $id_ren = $dt["id_rencana"];
                        $tot_penyi = mysql_fetch_assoc(mysql_query("SELECT SUM(py.anggaran) as jumpenyi FROM tbl_rencana p, tbl_penyiapan py, jabatan j, pegawai pg WHERE p.id_rencana = py.id_rencana AND j.id_jab = pg.id_jab AND pg.id_pegawai = py.id_pegawai AND p.id_rencana =  '$id_ren'"));
                        $tot_pelak = mysql_fetch_assoc(mysql_query("SELECT SUM(pl.ang_lak) as jumpelak FROM tbl_rencana r, tbl_penyiapan py, tbl_sub_penyiapan sp, tbl_pelaksanaan pl, jabatan j, pegawai p WHERE r.id_rencana = py.id_rencana AND py.id_penyiapan = sp.id_penyiapan AND sp.id_sub_penyi = pl.id_sub_penyi AND j.id_jab = p.id_jab AND r.id_pegawai = p.id_pegawai AND r.id_rencana = '$id_ren'"));

                        //KONDISI 1
                        $realisasi = $tot_penyi['jumpenyi']+$tot_pelak['jumpelak'];
                        $kon1 = ($realisasi/$anggaran_ren)*100;

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

                        // jika nilai anggaran realisasi = anggaran rencana --> efektif
                        if($realisasi == $anggaran_ren){
                          $rasio_c1 = ($realisasi/$anggaran_ren)*100;
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
                          $nilai_c3 = 4 * 4;
                          $nilai_c4 = ($nilai_c2/$nilai_c3)*100;
                          
                          if($nilai_c4 >=80 AND $nilai_c4 <=100){
                            $e = "<b style='color:green;'>Sangat Efektif</b>";
                          }elseif($nilai_c4 >=70 AND $nilai_c4 <=79){
                            $e = "<b style='color:green;'>Efektif</b>";
                          }elseif($nilai_c4 >=60 AND $nilai_c4 <=69){
                            $e = "<b style='color:green;'>Cukup Efektif</b>";
                          }elseif($nilai_c4 >=50 AND $nilai_c4 <=59){
                            $e = "<b style='color:red;'>Kurang Efektif</b>";
                          }elseif($nilai_c4 < 50){
                            $e = "<b style='color:red;'>Tidak Efektif</b>";
                          }else{
                            $e = "<b style='color:red;'>Undefined:Efektif :(</b>";
                          }
                        // jika nilai anggaran realisasi < || > anggaran rencana --> efisien
                        }elseif($realisasi < $anggaran_ren  || $realisasi > $anggaran_ren){ 
                          $rasio_b1 =  ($anggaran_ren/$anggaran_ren)*100;
                          $rasio_b2 = ($realisasi/$realisasi)*100;

                          $rasio_b3 = ($rasio_b2/$rasio_b1)*100;
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
                          $nilai_b5 = 4 * 4;
                          $efisien_b6 = ($nilai_b4/$nilai_b5)*100;
                          if($efisien_b6 >=80 AND $efisien_b6 <=100){
                            $e = "<b style='color:green;'>Sangat Efisien</b>";
                          }elseif($efisien_b6 >=70 AND $efisien_b6 <=79){
                            $e = "<b style='color:green;'>Efisien</b>";
                          }elseif($efisien_b6 >=60 AND $efisien_b6 <=69){
                            $e = "<b style='color:green;'>Cukup Efisien</b>";
                          }elseif($efisien_b6 >=50 AND $efisien_b6 <=59){
                            $e = "<b style='color:red;'>Kurang Efisien</b>";
                          }elseif($efisien_b6 < 50){
                            $e = "<b style='color:red;'>Tidak Efisien</b>";
                          }else{
                            $e = "<b style='color:red;'>Undifined:Efisien :(</b>";
                          }
                        }else{
                          $e = "Belum Diketahui";
                        }

                        $uang_real = number_format($realisasi,2,",",".");
                        $oke .="<td width=\"100\">Rp. $uang_real</td><td width=\"70\">$ekon & $e</td>";
                        $oke .="</tr>";                        
                }
                }
                
                
                
                
              $oke .="</tbody></table>";



$pdf->writeHTML($oke, true, 0);
$now = date('Y-m-d');
$tg = tgl_indo($now);
$i = mysql_fetch_array(mysql_query("SELECT p.*, j.nama_jab FROM pegawai p JOIN jabatan j ON j.id_jab=p.id_jab WHERE id_pegawai = '4'"));
$tdd = "<table>
		<tr>
		<td></td>
		<td></td>
		<td>Pasuruan, ".$tg."<br><strong>".$i['nama_jab']."</strong><br><br><br><br><br><br><br><strong><u>".strtoupper($i['nama_pegawai'])."</u></strong><br>NIP. ".strtoupper($i['nomor_induk'])."</td>
		</tr>
		</table>";
$pdf->writeHTML($tdd);



$info  = "<br><br><br><br><br><br><hr>Jumlah Data Pengawasan = ".$jum." Data<br>Dicetak Oleh = ".$_SESSION['namauser']." - ".$_SESSION['namajab']."<br>".$current_date;
$pdf->writeHTML($info, true, 0);
// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('Laporan Evaluasi dan Monitoring.pdf', 'I');
//============================================================+
// END OF FILE
//============================================================+
