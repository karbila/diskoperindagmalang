<?php

	// penghitungan dimulai dari 0 misal 12345 berarti angka 1 adalah index ke-0


	function tgl_indo($tgl){
	//2013-10-01 --> 01 Oktober 2013
			$tanggal = substr($tgl,8,2);
			$bulan = getBulan(substr($tgl,5,2));
			$tahun = substr($tgl,0,4);
			return $tanggal.' '.$bulan.' '.$tahun;		 
	}
	//fungsi untuk merubah format 01-10-2013 menjadi 2013-10-01
	function indotodb($a){
		$tanggal = substr($a,0,2);
		$bln = substr($a,3,2);
		$th = substr($a,6,4);
		return $th."-".$bln."-".$tanggal;
	}

	//fungsi untuk merubah format db menjadi indonesia
	// 2013-10-01 ==> 01-10-2013
	function dbtoindo($b){
		$tanggal = substr($b,8,2);
		$bulan = substr($b,5,2);
		$tahun = substr($b,0,4);
		return $tanggal."-".$bulan."-".$tahun;
	}




	function getBulan($bln){
				switch ($bln){
					case 1: return "Januari";break;
					case 2: return "Februari"; break;
					case 3: return "Maret"; break;
					case 4: return "April"; break;
					case 5: return "Mei"; break;
					case 6: return "Juni"; break;
					case 7: return "Juli"; break;
					case 8: return "Agustus"; break;
					case 9: return "September"; break;
					case 10: return "Oktober"; break;
					case 11: return "November"; break;
					case 12: return "Desember"; break;
				}
	}

	// function val_ekonomi($ang_ren,$ang_realisasi){
	// 	switch ($ang_ren) {
	// 		case "< 90":
	// 			return "Sangat Ekonomis";
	// 			break;
			
	// 		default:
	// 			return "Undefined";
	// 			break;
	// 	}
	// } 
?>
