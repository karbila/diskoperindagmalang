<?php
	error_reporting(0);
	session_start();
	include "../../../../konfigurasi/conf-db/dbautentikasi.php";

	$dok = mysql_query("SELECT * FROM dokumen WHERE id_dok='$_GET[page]'");
	$datadok = mysql_fetch_array($dok);	
	$direktori = "../../../doc/";
	$filename = "$datadok[nama_dok]";

	if(file_exists($direktori.$filename)){		
		$file_extension = strtolower(substr(strrchr($filename,"."),1));
		switch($file_extension){
		  case "pdf": $ctype="application/pdf"; break;		  
		  case "doc": $ctype="application/msword"; break;
		  case "xls": $ctype="application/vnd.ms-excel"; break;
		  case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
		  case "docx" : $ctype="application/vnd.openxmlformats-officedocument"; break;
		  case "pptx" : $ctype="application/vnd.openxmlformats-officedocument"; break;
		  case "xlsx" : $ctype="application/vnd.openxmlformats-officedocument"; break;		  
		  default: $ctype="application/proses";
		}

		if ($file_extension=='php'){
		  echo "<h1>Access forbidden!</h1>
				<p>Maaf, file yang Anda download sudah tidak tersedia atau filenya (direktorinya) telah diproteksi. <br />
				Silahkan hubungi Administrator Sistem.</p>";
		  exit;
		}
		else{		  
		  header("Content-Type: octet/stream");
		  header("Pragma: private"); 
		  header("Expires: 0");
		  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		  header("Cache-Control: private",false); 
		  header("Content-Type: $ctype");
		  header("Content-Disposition: attachment; filename=\"".basename($filename)."\";" );
		  header("Content-Transfer-Encoding: binary");
		  header("Content-Length: ".filesize($direktori.$filename));
		  readfile("$direktori$filename");
		  exit();   
		}
	}else{	  
		//echo "file hilang...<br>$direktori$filename";
		header("location:../../../dashboard.php?md=$_GET[md]&s=dd");
		exit;
	}

?>

