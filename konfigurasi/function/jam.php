<?php      
   	date_default_timezone_set("Asia/Jakarta");
   	//code untuk
   	$tgl = date("Y-m-d"); 
   	$waktu_indonesia = tgl_indo($tgl);
   	$jam = date("H:i:s");
   	$namahari =date("l");

      if ($namahari == "Sunday") $namahari = "Minggu";
   	else if ($namahari == "Monday") $namahari = "Senin";
   	else if ($namahari == "Tuesday") $namahari = "Selasa";
   	else if ($namahari == "Wednesday") $namahari = "Rabu";
   	else if ($namahari == "Thursday") $namahari = "Kamis";
   	else if ($namahari == "Friday") $namahari = "Jumat";
   	else if ($namahari == "Saturday") $namahari = "Sabtu";

   	echo "$namahari, $waktu_indonesia, $jam";
?>
