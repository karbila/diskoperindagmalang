<?php
include "./dbautentikasi.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}

$username = anti_injection($_POST['username']);
$pass     = anti_injection(md5($_POST['password']));

// pastikan username dan password adalah berupa huruf atau angka.
if (!ctype_alnum($username) OR !ctype_alnum($pass)){
  echo "Sekarang loginnya tidak bisa di injeksi lho.";
}
else{
  $login=mysql_query("SELECT u.*, j.* FROM users u, jabatan j WHERE j.id_jab=u.id_jab AND u.username='$username' AND u.password='$pass' AND blokir='N'");
  $ketemu=mysql_num_rows($login);
  $r=mysql_fetch_array($login);

  // Apabila username dan password ditemukan
  if ($ketemu == 1){
    session_start();

    //mengingat identitas yang bisa dibawa ke halaman manapun setelah login
    $_SESSION['namauser']     = $r['username'];
    $_SESSION['namalengkap']  = $r['nama_lengkap'];
    $_SESSION['passuser']     = $r['password'];
    $_SESSION['sessid']       = $r['id_session'];
    $_SESSION['leveluser']    = $r['level'];
    $_SESSION['iduser']       = $r['id_user'];
    $_SESSION['idjab']        = $r['id_jab'];
    $_SESSION['namajab']      = $r['nama_jab'];

    //header('location:media.php?module=home');
    header('location:../../simkop/dashboard.php');
  }else{
    header("location:../../frontpage.php?a=g2l");
  }
}
?>
