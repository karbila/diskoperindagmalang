<?php  

            if($_GET['s']=='ck'){
            echo "<div class='alert alert-success alert-autoclose'>            
            <strong>Data Berhasil dihapus.</strong> Data telah berhasil dihapus di Database</div>";
            }            
            elseif($_GET['s']=='on'){
              echo "<div class='alert alert-success alert-autoclose'>
            <strong>Akses Data Berhasil diupdate menjadi ON</strong><br>Sekarang data Anda telah dapat diakses oleh pengguna lain. Akses data meliputi Edit dan Hapus.</div>";
            }
            elseif($_GET['s']=='off'){
              echo "<div class='alert alert-success alert-autoclose'>
            <strong>Akses Data Berhasil diupdate menjadi OFF</strong><br>Sekarang data Anda telah tertutup oleh akses pengguna lain. Tutup Akses data meliputi Edit dan Hapus.</div>";
            }
            elseif($_GET['s']=='aktif'){
              echo "<div class='alert alert-success alert-autoclose'>
            <strong>Sub Menu (level 2) Berhasil diupdate menjadi Aktif</strong><br>Sekarang Sub Menu (Level 2) telah Aktif kembali (tampil).</div>";
            }
            elseif($_GET['s']=='nonaktif'){
              echo "<div class='alert alert-success alert-autoclose'>
            <strong>Sub Menu (level 2) Berhasil diupdate menjadi Non-aktif</strong><br>Sekarang Sub Menu (Level 2) telah tidak Aktif (tidak terlihat).</div>";
            }

            else{
              echo "";
            }

?>