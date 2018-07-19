<div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>      
          <div class="nav-collapse">
            <ul class="nav">
              <li class="active">
                <a href="<?php echo "$_SERVER[PHP_SELF]"; ?>"><i class="icon-home icon-white"></i> Home</a>
              </li>
              <?php                
                $topmenu = mysql_query("SELECT m.* FROM menu_utama m, jabatan j WHERE j.id_jab=m.id_jab AND j.id_jab= '$_SESSION[idjab]' AND m.status = '1'");
                while ($d1 = mysql_fetch_array($topmenu)) {
                  if(mysql_num_rows($topmenu)==0){
                    echo "<li><a href='#'>Belum Ada Menu Utama</a></li>";  
                  }else{
                    echo "<li class='dropdown'><a href='#' class='dropdown-toggle' data-toggle='dropdown' data-hover='dropdown'>$d1[nama_menu] <b class='caret'></b></a>";
                  }
                                    
                  $submenu = mysql_query("SELECT sm.* FROM submenu_utama sm, menu_utama m WHERE m.id_menu=sm.id_menu AND m.id_menu = '$d1[id_menu]' AND sm.status='1'");
                  $jumsub = mysql_num_rows($submenu);
                  echo "<ul class='dropdown-menu'>";
                    if($jumsub>0){
                      while ($d2 = mysql_fetch_array($submenu)) {                    
                      $submenu2 = mysql_query("SELECT m.* FROM kop_modul m, submenu_utama sm WHERE sm.id_sub=m.id_sub AND sm.id_sub='$d2[id_sub]' AND m.mod_status='Y' ");                      
                            $jumsub2 = mysql_num_rows($submenu2);
                            if($jumsub2>0){
                              //jika dropdwon level 3 ada maka                        
                              echo "<li class='dropdown-submenu'><a href='$d2[link_menu]'>$d2[nama_sub]</a>";
                              echo "<ul class='dropdown-menu'>";
                              while ($d3 = mysql_fetch_array($submenu2)) {
                                echo "<li><a href='$d3[link_modul]'>$d3[nama_modul]</a></li>";
                              }
                              echo "</ul>";                            
                              echo "</li>";
                              //jika tidak ada sub level 3 maka tampilkan tanpa submenu level 3
                            }elseif($jumsub2==0){
                              echo "<li><a href='$d2[link_menu]'>$d2[nama_sub]</a></li>";
                            }
                      }
                    }elseif($jumsub==0){
                      echo "<li><a href='#'>Belum ada Sub Menu</a></li>";
                    }
                  echo "</ul></li>";
                }

                ?>
            </ul>

            <ul class="nav pull-right">
              <li class='dropdown'>
                <a href="./logout.php"><i class='icon icon-signout icon-1x'></i> Keluar dari SIM</a>
              </li>
            </ul>
          </div>

    </div><!-- /.container -->
  </div><!-- /navbar-inner -->
</div><!-- /navbar --> 

      
<!-- /.nav-collapse -->
 