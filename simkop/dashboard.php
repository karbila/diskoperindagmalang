<?php  
    error_reporting(0);
    session_start();    
    include "../konfigurasi/conf-db/dbautentikasi.php";
    include "../konfigurasi/function/fungsi_indotgl.php";

    if(!isset($_SESSION['iduser'])){
      header('location:../404.php');
    }else{
?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - <?php echo "$_SESSION[namalengkap]"; ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="../global/icon/_share.png">
    <link rel="stylesheet" href="../global/css/bootstrap.css" />    
    <link rel="stylesheet" href="../global/css/font-awesome/css/font-awesome.css" />
    <link rel="stylesheet" href="../global/css/docs.css" />
    <link rel="stylesheet" href="../global/css/global.css" media='all'/>
    <link rel="stylesheet" href="../global/css/demo_table.css" />    
    <link rel="stylesheet" href="../global/css/bootstrap-timepicker.min.css" type="text/css"  />
    <link rel="stylesheet" href="../global/js/datepicker/css/datepicker.css" type='text/css'>
    <link rel="stylesheet" href="../global/css/bootstrap-fileupload.css" type='text/css'>
    <link rel="stylesheet" href="../global/css/bootstrap-responsive.css">

    <style>
      .table th {
    font-weight: bold;
    text-align: center;
    }
    .table td{
      text-align: left;
      line-height: 18px;
    }

    .table th, .table td {
    border-top: 1px solid #DDDDDD;    
    padding: 8px;    
    vertical-align: top;
    }

    .table thead th {
        vertical-align: middle;
        text-align: center;
        line-height: 15px;
    }
    span.badge a{
      color:#FFF;
    }
    </style>
  </head>
  <!-- onload="startclock()" -->
  <body >
    
        <?php 
          include "include/menu-sistem.php";
        echo "<div class='container utama'>";
          include "include/kop-content.php";
        echo "</div>";
        
         ?>

    <script src="../global/js/jquery-1.9.1.js"></script>
    <script src="../global/js/bootstrap.js"></script>
    <script src='../global/js/twitter-bootstrap-hover-dropdown.js'></script>      
    <script src='../global/js/fileupload/bootstrap-fileupload.js'></script>
    <script src='../global/js/datepicker/js/bootstrap-datepicker.js'></script>
    <script src="../global/js/jquery.dataTables.js"></script>    
    <script src="../global/js/bootstrap-timepicker.min.js"></script>    
    <script src="../global/js/bootstrap.file-input.js"></script>    
    <script src="../global/js/clock.js" type="text/javascript"></script>
    <script src='../global/js/ckeditor/ckeditor.js'></script>
    <!-- costum js -->
    <script src='../global/js/kop-manual.js'></script>
  </body>
</html>

<?php  
  }
?>