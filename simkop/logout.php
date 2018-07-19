<?php
  session_start();
  session_destroy();
  //echo "<script>alert('Anda telah keluar dari SIM'); window.location = '../index.php'</script>";
  header('location:../index.php');
?>