<?php  
			
			if($_GET['b']=='ck'){
            echo "<div class='alert alert-success alert-autoclose'>            
            <strong>Data Berhasil dihapus.</strong> Data telah berhasil dihapus di Database</div>";
            }
			elseif($_GET['b']=='on_sub'){
              echo "<div class='alert alert-success alert-autoclose'>
            <strong>Akses Data Berhasil diupdate menjadi ON</strong><br>Sekarang data Anda telah dapat diakses oleh pengguna lain. Akses data meliputi Edit dan Hapus.</div>";
            }
            elseif($_GET['b']=='off_sub'){
              echo "<div class='alert alert-success alert-autoclose'>
            <strong>Akses Data Berhasil diupdate menjadi OFF</strong><br>Sekarang data Anda telah tertutup oleh akses pengguna lain. Tutup Akses data meliputi Edit dan Hapus.</div>";
            }

?>