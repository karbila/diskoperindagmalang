<?php  
	
		if($_GET['s']=='az'){
      echo "<div class='alert alert-success alert-autoclose'><i class='notif img-yes'></i>&nbsp;&nbsp;
      <strong>Data Berhasil Disimpan.</strong> Data telah disimpan di Database dan Server</div>";           
    }elseif($_GET['s']=='bf'){
      echo "<div class='alert alert-error alert-autoclose'><i class='notif img-no'></i>&nbsp;&nbsp;
      <strong>Proses Simpan Gagal.</strong> Terdapat Kesalahan dalam Sistem, Segera Anda menghubungi Administrator</div>";
    }elseif($_GET['s']=='dp'){
      echo "<div class='alert alert-success alert-autoclose'><i class='notif img-yes'></i>&nbsp;&nbsp;
      <strong>Data Berhasil Diperbarui.</strong> Data telah diperbarui di Database dan Server</div>";      
    }elseif ($_GET['s']=='pd') {
      echo "<div class='alert alert-success alert-autoclose'><i class='notif img-yes'></i>&nbsp;&nbsp;
      <strong>Data Berhasil Diperbarui.</strong> Data telah diperbarui di Database dan Server</div>";
      echo "<div class='alert alert-warning alert-autoclose'><i class='notif img-yes'></i>&nbsp;&nbsp;
      <strong>Data telah kembali ke proses sebelumnya</strong></div>";  
    }elseif($_GET['s']=='st'){
      echo "<div class='alert alert-error alert-autoclose'><i class='notif img-no'></i>&nbsp;&nbsp;
      <strong>Proses Input Data GAGAL dikarenakan dokumen yang Anda unggah tidak didukung oleh Sistem</strong><br>Baca kembali informasi Upload File di Form ini. Terima Kasih.</div>";
    }elseif($_GET['s']=='dd'){
      echo "<div class='alert alert-error alert-autoclose'><i class='notif img-no'></i>&nbsp;&nbsp;
      <strong>SISTEM ADA MASALAH...</strong></div>";
    }

?>