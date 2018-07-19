<?php  
	$tahap = $_POST['tahap'];
	$tahun = $_POST['tahun'];
	$bulan = $_POST['bln'];

	if($tahap=='1'){//1
		header("location:../pdf/examples/perencanaan.php?th=$tahun&bl=$bulan");
	}elseif($tahap=='2'){		
		header("location:../pdf/examples/penyiapan.php?th=$tahun&bl=$bulan");	
	}elseif($tahap=='3'){
		header("location:../pdf/examples/pelaksanaan.php?th=$tahun&bl=$bulan");
	}elseif($tahap=='4'){
		header("location:../pdf/examples/pengawasan.php?th=$tahun&bl=$bulan");
	}elseif($tahap=='5'){
		header("location:../pdf/examples/evaluasi.php?th=$tahun&bl=$bulan");
	}

	//echo "select pada tabel $tbl pada bulan $bulan dan tahun $tahun";
?>