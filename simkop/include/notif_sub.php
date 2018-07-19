<?php 
	if($_GET['s']=='sub_ins'){
      echo "<div class='alert alert-success alert-autoclose'><i class='notif img-yes'></i>&nbsp;&nbsp;
      <strong>Data Berhasil Disimpan.</strong> Data telah disimpan di Database</div>";           
    }elseif($_GET['s']=='sub_upd'){
      echo "<div class='alert alert-success alert-autoclose'><i class='notif img-yes'></i>&nbsp;&nbsp;
      <strong>Data Berhasil Diperbarui.</strong></div>";
    }elseif($_GET['s']=='err'){
    	echo "<div class='alert alert-success alert-autoclose'><i class='notif img-yes'></i>&nbsp;&nbsp;
      <strong>Maaf, Data Gagal Disimpan.</strong> Segera Anda menghubungi Administrator</div>";
    	
    }
 ?>