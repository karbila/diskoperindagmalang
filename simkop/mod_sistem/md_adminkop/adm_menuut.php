<div class="row-fluid">
	<div class="span5">

		<?php  
			switch ($_GET[p]) {
				case 'e':
					?>
					<div class='page-header'>
			            <h3>Form <span class='label labelform label-warning'>Edit</span> Menu Utama</h3>
			            <?php include 'include/notif.php'; 
			            $dat = mysql_fetch_array(mysql_query("SELECT m.*, j.id_jab, j.nama_jab FROM menu_utama m, jabatan j WHERE j.id_jab=m.id_jab AND m.id_menu='$_GET[i]'"));

			            ?>
			        </div>

			        <form class="form-horizontal" method='POST' action='mod_sistem/md_adminkop/action/act_menu.php?ac=ed'>	
			            <div class="control-group">
			                  <label class="control-label">Nama Menu</label>
			                  <div class="controls">                     
			                    <input type="text" name='m' value='<?php echo "$dat[nama_menu]"; ?>'>
			                  </div>
			            </div>
			            <div class="control-group">
			                <label for="" class="control-label">Level Akses</label>
			                <div class="controls">
			                    <select name="l">
			                        <option value="0">Pilih Level Akses</option>
			                        <?php  
			                        $b = mysql_query("SELECT * FROM jabatan ORDER BY nama_jab ASC");
			                        while ($h=mysql_fetch_array($b)) {			                        	
			                        	if($dat['id_jab']==$h[0]){
			                        		echo "<option value='$h[0]' selected>$h[1]</option>";	
			                        	}else{
			                        		echo "<option value='$h[0]'>$h[1]</option>";
			                        	}
			                        }
			                        ?>
			                    </select>
			                </div>
			            </div>

			            <div class="control-group">
		                  <div class="controls" style="text-align:center;">  
		                    <input type="hidden" name="h_idkeg" value="<?php echo "$_GET[md]"; ?>">
		                    <input type="hidden" name="id_menu" value="<?php echo "$_GET[i]"; ?>">
		                    <button type="submit" class="btn btn-inverse">Simpan</button>
		                    <button type="button" class="btn" onclick='self.history.back()'>Batal</button>
		                  </div>
		            	</div>
			        </form>

					<?php
					break;
				
				default:
					?>
					<div class='page-header'>
			            <h3>Form <span class='label labelform label-info'>Input</span> Menu Utama</h3>
			            <?php include 'include/notif.php'; ?>
			        </div>

			        <form class="form-horizontal" method='POST' action='mod_sistem/md_adminkop/action/act_menu.php?ac=add'>	
			            <div class="control-group">
			                  <label class="control-label">Nama Menu</label>
			                  <div class="controls">                     
			                    <input type="text" name='m' value=''>
			                  </div>
			            </div>
			            <div class="control-group">
			                <label for="" class="control-label">Level Akses</label>
			                <div class="controls">
			                    <select name="l">
			                        <option value="0">Pilih Level Akses</option>
			                        <?php  
			                        $b = mysql_query("SELECT * FROM jabatan ORDER BY nama_jab ASC");
			                        while ($h=mysql_fetch_array($b)) {
			                        	echo "<option value='$h[0]'>$h[1]</option>";
			                        }
			                        ?>
			                    </select>
			                </div>
			            </div>

			            <div class="control-group">
		                  <div class="controls" style="text-align:center;">  
		                    <input type="hidden" name="h_idkeg" value="<?php echo "$_GET[md]"; ?>">            
		                    <button type="submit" class="btn btn-inverse">Simpan</button>
		                    <button type="button" class="btn" onclick='self.history.back()'>Batal</button>
		                  </div>
		            	</div>
			        </form>

					<?php
					break;
			}

		?>
		

        


	</div>

	<div class="span7">
		<div class='page-header'>
            <h3><span class='label labelform label-info'>Tabel</span> Menu Utama</h3>
            <?php  
                if($_GET['s']=='ck'){
                  echo "<div class='alert alert-success alert-autoclose'>            
                  <strong>Data telah berhasil diupdate</strong></div>";
                  }
            ?>
        </div>
        <table class='table table-bordered table-striped table-hover' id="table_id_scroll">
        	<thead>
        		<th>Aksi</th>
        		<th>No.</th>
        		<th>Status</th>
        		<th>Nama Menu</th>
        		<th>Level Akses</th>        		
        	</thead>

        	<tbody>
        		<?php  
        			$i = mysql_query("SELECT m.*, j.nama_jab FROM menu_utama m, jabatan j WHERE j.id_jab=m.id_jab ORDER BY id_menu DESC");
        			$no=1;
        			while ($o=mysql_fetch_array($i)) {
        				echo "<tr>        				
        				<td>";
        				?>
        				<div class="btn-group btn-small">
		                       <a class="btn btn-success btn-small" href="#"><i class="icon-cog"></i></a>
		                       <a class="btn btn-success btn-small dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
		                       <ul class="dropdown-menu">
		                         <li><a href='?md=<?php echo "$_GET[md]"; ?>&amp;p=e&amp;i=<?php echo "$o[id_menu]"; ?>'><i class='icon-edit'></i> Edit</a></li>
		                         <li class='divider'></li>
		                         <?php  
		                         if($o['status']=='1'){
		                            ?>                            
		                            <li><a href='mod_sistem/md_adminkop/action/act_menu.php?ac=off&amp;md=<?php echo "$_GET[md]"; ?>&amp;f=<?php echo "$o[id_menu]"; ?>'><i class="icon-minus-sign"></i> Sembunyikan</a></li>
		                            <?php
		                         }else{
		                            ?>
		                            <li><a href='mod_sistem/md_adminkop/action/act_menu.php?ac=on&amp;md=<?php echo "$_GET[md]"; ?>&amp;f=<?php echo "$o[id_menu]"; ?>'><i class="icon-ok-sign"></i> Tampilkan</a></li>
		                            <?php

		                         }
		                         ?>        
		                       </ul>
		                    </div>
        				<?php
        				echo "</td>
        				<td>$no</td>
        				<td>";
        				if($o['status']=='1'){
        					echo "tampil";
        				}else{echo "sembunyi";}
        				echo "</td>
        				<td>$o[nama_menu]</td>
        				<td>$o[nama_jab]</td>
        				</tr>";
        			$no++;
        			}
        		?>
        	</tbody>

        </table>



	</div>
</div>