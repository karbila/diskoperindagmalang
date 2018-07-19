<div class="row-fluid">
	<div class="span5">

		<?php  
			switch ($_GET[p]) {
				case 'e':
					?>
					<div class='page-header'>
			            <h3>Form <span class='label labelform label-warning'>Edit</span> Sub Menu</h3>
			            <?php include 'include/notif.php'; 
			            $a = mysql_query("SELECT s.*, m.id_menu, j.id_jab FROM submenu_utama s, menu_utama m, jabatan j WHERE j.id_jab=m.id_jab AND m.id_menu=s.id_menu AND s.id_sub='$_GET[i]'");
			            $dat = mysql_fetch_array($a);

			            ?>
			        </div>

			        <form class="form-horizontal" method='POST' action='mod_sistem/md_adminkop/action/act_submenu.php?ac=ed'>	
			            <div class="control-group">
			                  <label class="control-label">Level Akses/ Jabatan</label>
			                  <div class="controls">                     
			                    <select name="jabatan" id='jabatan'>
			                    	<option value="0">Pilih Level Akses</option>
			                    	<?php  
			                    		$h = mysql_query("SELECT * FROM jabatan ORDER BY nama_jab ASC");
			                    		while ($h2=mysql_fetch_array($h)) {
			                    			if($dat[id_jab]==$h2[0]){
			                    				echo "<option value='$h2[id_jab]' selected>$h2[nama_jab]</option>";	
			                    			}else{
			                    				echo "<option value='$h2[id_jab]'>$h2[nama_jab]</option>";
			                    			}
			                    			
			                    		}
			                    	?>
			                    </select>
			                  </div>
			            </div>

			            <div class="control-group">
			                  <label class="control-label">Menu Utama</label>
			                  <div class="controls">
			                    <select name="mu" id='menu'>
			                    	<?php
			                    		$a2 = mysql_fetch_array(mysql_query("SELECT m.id_menu, m.nama_menu  FROM menu_utama m, submenu_utama s WHERE m.id_menu=s.id_menu AND s.id_sub='$_GET[i]'"));
			                    		echo "<option value='$a2[0]'>$a2[1]</option>";
			                    	?>
			                    </select>
			                  </div>
			            </div>


			            <div class="control-group">
			                  <label class="control-label">Nama Menu</label>
			                  <div class="controls">                     
			                    <input type="text" name='m' value='<?php echo "$dat[nama_sub]"; ?>'>
			                  </div>
			            </div>

			            <div class="control-group">
			                  <label class="control-label">Link Sub Menu</label>
			                  <div class="controls">                     
			                    <input type="text" id="linksub" name='linksub' class='input-medium' placeholder='?md=namamodul' value='<?php echo "$dat[link_menu]"; ?>'>			
			                  </div>
			                  <label class="control-label" id='hasil2'></label>
			            </div>

			            <div class="control-group">
		                  <div class="controls" style="text-align:center;">  
		                    <input type="hidden" name="h_idkeg" value="<?php echo "$_GET[md]"; ?>"> 
		                    <input type="hidden" name="id_sub" value="<?php echo "$_GET[i]"; ?>">
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
			            <h3>Form <span class='label labelform label-info'>Input</span> Sub Menu</h3>
			            <?php include 'include/notif.php'; ?>
			        </div>

			        <form class="form-horizontal" method='POST' action='mod_sistem/md_adminkop/action/act_submenu.php?ac=add'>	
			            
			            <div class="control-group">
			                  <label class="control-label">Level Akses/ Jabatan</label>
			                  <div class="controls">                     
			                    <select name="jabatan" id='jabatan'>
			                    	<option value="0">Pilih Level Akses</option>
			                    	<?php  
			                    		$h = mysql_query("SELECT * FROM jabatan ORDER BY nama_jab ASC");
			                    		while ($h2=mysql_fetch_array($h)) {
			                    			echo "<option value='$h2[id_jab]'>$h2[nama_jab]</option>";
			                    		}
			                    	?>
			                    </select>
			                  </div>
			            </div>

			            <div class="control-group">
			                  <label class="control-label">Menu Utama</label>
			                  <div class="controls">
			                    <select name="mu" id='menu'>
			                    	<option value="0">Pilih Menu Utama</option>
			                    	<option value="0">Pilih Dulu Menu Utama :(</option>
			                    </select>
			                  </div>
			            </div>


			            <div class="control-group">
			                  <label class="control-label">Nama Sub Menu</label>
			                  <div class="controls">                     
			                    <input type="text" name='m' value=''>
			                  </div>
			            </div>

			            <div class="control-group">
			                  <label class="control-label">Link Sub Menu</label>
			                  <div class="controls">                     
			                    <input type="text" id="linksub" name='linksub' class='input-medium' placeholder='?md=namamodul'>
			                  </div>
			                  <label class="control-label" id='hasil2'></label>
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
            <h3><span class='label labelform label-info'>Tabel</span> Sub Menu (Dropdown Level 1)</h3>
            <?php  
                if($_GET['s']=='ck'){
                  echo "<div class='alert alert-success alert-autoclose'>            
                  <strong>Data berhasil diupdate</strong></div>";
                  }
            ?>
        </div>
        <table class='table table-bordered table-striped table-hover' id="table_id_scroll">
        	<thead>
        		<th>Aksi</th>
        		<th>No.</th>
        		<th>Status</th>
        		<th>Sub Menu</th>
        		<th>Menu Utama</th>
        		<th>Link Menu</th>
        		<th>Level Akses</th>
        		
        	</thead>

        	<tbody>
        		<?php  
        			$i = mysql_query("SELECT s.*, m.nama_menu, j.nama_jab FROM submenu_utama s, menu_utama m, jabatan j WHERE j.id_jab=m.id_jab AND m.id_menu=s.id_menu ORDER BY s.id_sub DESC");
        			$no=1;
        			while ($o=mysql_fetch_array($i)) {
        				if($o['status']=='1'){$r='tampil';}else{$r='tidak tampil';}
        				echo "<tr>
        				<td>";        				
        				?>
        				<div class="btn-group btn-small">
		                       <a class="btn btn-success btn-small" href="#"><i class="icon-cog"></i></a>
		                       <a class="btn btn-success btn-small dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
		                       <ul class="dropdown-menu">
		                         <li><a href='?md=<?php echo "$_GET[md]"; ?>&amp;p=e&amp;i=<?php echo "$o[0]"; ?>'><i class='icon-edit'></i> Edit</a></li>
		                         <li class='divider'></li>
		                         <?php  
		                         if($o['status']=='1'){
		                            ?>                            
		                            <li><a href='mod_sistem/md_adminkop/action/act_submenu.php?ac=off&amp;md=<?php echo "$_GET[md]"; ?>&amp;f=<?php echo "$o[id_sub]"; ?>'><i class="icon-minus-sign"></i> Sembunyikan</a></li>
		                            <?php
		                         }else{
		                            ?>
		                            <li><a href='mod_sistem/md_adminkop/action/act_submenu.php?ac=on&amp;md=<?php echo "$_GET[md]"; ?>&amp;f=<?php echo "$o[id_sub]"; ?>'><i class="icon-ok-sign"></i> Tampilkan</a></li>
		                            <?php

		                         }
		                         ?>        
		                       </ul>
		                    </div>
        				<?php
        				echo "</td>
        				<td>$no</td>
        				<td>$r</td>
        				<td>$o[nama_sub]</td><td>$o[nama_menu]</td><td>$o[link_menu]</td><td>$o[nama_jab]</td>
        				</tr>";
        			$no++;
        			}
        		?>
        	</tbody>

        </table>



	</div>
</div>