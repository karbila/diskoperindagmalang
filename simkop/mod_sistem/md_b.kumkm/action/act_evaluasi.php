<?php  
/*
KONDISI I
Dikatakan Ekonomis bila Scorenya 4


KONDISI II
Dikatakan Efektif (pas)
> Tanggal Akhir Perencanaan == tanggal Akhir Pelaksanaan
> Anggaran Perencanaan == Anggaran Penyiapan + Anggaran Pelaksanaan

Dikatakan Efisien (kurang)
0> Tanggal Akhir Perencanaan < tanggal akhir pelaksanaan
0> Anggaran perencanaan < tanggal akhir pelaksanaan

*/ 
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
$oke .="<td width=\"100\">Rp. $uang_real</td><td>$ekon & $e</td>";
?>

