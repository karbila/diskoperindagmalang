<?php  
    error_reporting(0);
    session_start();    
    include "../konfigurasi/conf-db/dbautentikasi.php";
    include "../konfigurasi/function/fungsi_indotgl.php";    
?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anda tidak mempunyai hak akses... :(</title>
    <link rel="shortcut icon" type="image/x-icon" href="global/icon/_share.png">
    <link rel="stylesheet" href="global/css/bootstrap.css" />    
    <link rel="stylesheet" href="global/css/font-awesome/css/font-awesome.css" />
    <link rel="stylesheet" href="global/css/docs.css" />
    <link rel="stylesheet" href="global/css/global.css" media='all'/>
    
    <link rel="stylesheet" href="global/css/bootstrap-responsive.css">

    <style>
      .container div.nakal{ padding-left: 250px; padding-right: 250px; text-align: center;}
      div.nakalg{padding-bottom: 10px;}      
      h1{ text-transform: uppercase; font-weight: bold;}
      body div.utama{padding-bottom: 0;}
      span{font-family: sans-serif;}
    </style>
  </head>
  <!-- onload="startclock()" -->
  <body>
    
        <?php           
        echo "<div class='container utama'>";
        echo "<div class='alert alert-danger nakal'><i class='icon-warning-sign icon-5x'></i>
          <a href=\"./homepage.php\" title=\"Kembali ke Halaman Homepage\"><h1>Forbidden Act</h1></a>
        </div>";
        echo "<div class='nakal nakalg'><i class='icon-smile'> <span>Limited By Abe3 `n Azm4</span></i></div>";
        echo "</div>";
        
         ?>

    <script src="global/js/jquery-1.9.1.js"></script>
    <script src="global/js/bootstrap.js"></script>    
  </body>
</html>
