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
$pdf->SetTitle('Laporan Perencanaan');
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
$j = "SELECT r.kode_ren, r.nama_keg_ren, r.mulai_ren, r.selesai_ren, r.anggaran_ren, r.desk_ren, r.tempat_ren , p.nama_pegawai, d . * 
	FROM tbl_rencana r, pegawai p, dokumen d
	WHERE r.id_pegawai = p.id_pegawai
	AND d.id_dok = r.id_dok
	AND SUBSTRING( r.mulai_ren, 1, 4 ) =  '$t'
	AND SUBSTRING( r.mulai_ren, 6, 2 ) =  '$_GET[bl]'
	ORDER BY r.id_rencana DESC";
//$pdf->writeHTML($j, true, 0);

$q_ren = mysql_query($j);
$jum = mysql_num_rows($q_ren);

$coba = '<br><h2 style="text-align:center">Laporan Perencanaan Bulan '.$b.' Tahun '.$t.'</h2><br>
<table border="1" cellpadding="4">
              <thead>              	
              	<tr>
                <th style="text-align:center"; rowspan="2">Kode</th>
                <th style="text-align:center"; rowspan="2">Nama Kegiatan</th>
                <th colspan="2" align="center">Tanggal Pelaksanaan</th>
                <th style="text-align:center"; rowspan="2">Tempat</th>
                <th style="text-align:center"; rowspan="2">Penanggung Jawab</th>
                <th style="text-align:center"; rowspan="2">Anggaran</th>                
                <th style="text-align:center"; rowspan="2">Deskripsi Kegiatan</th>                
                </tr>                

                <tr>
                <th style="text-align:center";>Mulai</th>
                <th style="text-align:center";>Selesai</th>
                </tr>
              </thead>
              <tbody>';                
                //tampilkan data yang hanya belum diproses selanjutnya -> proses persiapan
                
                while ($d=mysql_fetch_array($q_ren)) {
                  $start = dbtoindo($d['mulai_ren']);
                  $finish = dbtoindo($d['selesai_ren']); 
                  $uang = number_format($d['anggaran_ren'],2,",",".");                 
                  $coba .="<tr>";
                  $coba .="<td>$d[kode_ren]</td><td>$d[nama_keg_ren]</td><td>$start</td><td>$finish</td><td>$d[tempat_ren]</td><td>$d[nama_pegawai]</td><td>Rp. $uang</td><td>$d[desk_ren]</td>";
                  $coba .="</tr>";
                }
                
                
              $coba .="</tbody></table>";


$pdf->writeHTML($coba, true, 0);
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



$info  = "<br><br><br><br><br><br><hr>Jumlah Data Perencanaan = ".$jum." Data<br>Dicetak Oleh = ".$_SESSION['namauser']." - ".$_SESSION['namajab']."<br>".$current_date;
$pdf->writeHTML($info, true, 0);
// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('Laporan Perencanaan.pdf', 'I');
//============================================================+
// END OF FILE
//============================================================+
