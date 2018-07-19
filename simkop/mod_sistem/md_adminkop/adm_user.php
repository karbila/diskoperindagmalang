<div class="row-fluid">
	<div class="span12">
		<?php  
			switch ($_GET['p']) {
				case 'e':									
				echo "<div class='page-header'>
				<h3>Form <span class='label labelform label-warning'>Edit</span> User</h3>";
					include 'include/notif.php';
				echo "</div>";

				$data = mysql_fetch_array(mysql_query("SELECT u.* FROM users u, jabatan j, seksi s WHERE j.id_jab=u.id_jab AND s.id_seksi=u.id_seksi AND u.id_user='$_GET[i]'"));
				?>
				<form class="form-horizontal" method='POST' action='mod_sistem/md_adminkop/action/act_user.php?ac=ed' enctype=''>
					<div class="control-group">
		                 <label class="control-label">Username</label>
		                 <div class="controls">                     
		                   <input type="text" name='u' value='<?php echo "$data[username]"; ?>'>
		                 </div>
	            	</div>

	            	<div class="control-group">
		                 <label class="control-label">Password</label>
		                 <div class="controls">                     
		                   <input type="text" name='p' value='' placeholder='kosongi bila tidak dirubah'>
		                 </div>
	            	</div>

	            	<div class="control-group">
		                 <label class="control-label">Nama Lengkap</label>
		                 <div class="controls">                     
		                   <input type="text" name='nl' value='<?php echo "$data[nama_lengkap]"; ?>'>
		                 </div>
	            	</div>


	            	<div class="control-group">
		                 <label class="control-label">Email</label>
		                 <div class="controls">                     
		                   <!-- <input type="text" name='e' value='' > -->
		                   <input type="email" pattern="[^ @]*@[^ @]*" name='e' value='<?php echo "$data[email]"; ?>'>
		                 </div>
	            	</div>

	            	<div class="control-group">
		                 <label class="control-label">No. Telp</label>
		                 <div class="controls">                     
		                   <input type="text" name='nt' value='<?php echo "$data[no_telp]"; ?>' >
		                 </div>
	            	</div>

	            	<div class="control-group">
		                 <label class="control-label">Blokir</label>
		                 <div class="controls">                     
		                    <span class='radio_b'><input type="radio" name="radio_tah" id="" value='Y' class='ra' <?php if($data['blokir']=='Y')echo "checked"; ?>>Ya</span>
	                     	<span class='radio_b'><input type="radio" name="radio_tah" id="" value='N' class='ra' <?php if($data['blokir']=='N')echo "checked"; ?>>Tidak</span>
		                 </div>
	            	</div>

	            	<div class="control-group">
	                  <label class="control-label">Seksi</label>
	                  <div class="controls">
	                    <select name="sek">
	                      <option value="0">Pilih Seksi</option>
	                      <?php  
	                      	$r = mysql_query("SELECT * FROM seksi ORDER BY nama_seksi ASC");
	                      	$sek = mysql_fetch_array(mysql_query("SELECT s.id_seksi FROM seksi s, users u WHERE s.id_seksi=u.id_seksi AND u.id_user='$_GET[i]'"));
	                      	while ($k=mysql_fetch_array($r)){
	                      		if($sek['id_seksi']==$k['id_seksi']){
	                      			echo "<option value='$k[id_seksi]' selected>$k[nama_seksi]</option>";	
	                      		}else{
	                      			echo "<option value='$k[id_seksi]'>$k[nama_seksi]</option>";
	                      		}
	                      		
	                      	}
	                      ?>
	                    </select>
	                  </div>
	            	</div>

		            <div class="control-group">
		                  <label class="control-label">Jabatan</label>
		                  <div class="controls">
		                    <select name="jab">
		                      <option value="0">Pilih Jabatan</option> 
		                      <?php  
		                      $q = mysql_query("SELECT * FROM jabatan ORDER BY nama_jab ASC");
		                      $jb = mysql_fetch_array(mysql_query("SELECT j.id_jab FROM jabatan j, users u WHERE j.id_jab=u.id_jab AND u.id_user = '$_GET[i]'"));
		                      while ($l=mysql_fetch_array($q)) {
		                      	if($jb[0]==$l[0]){
		                      		echo "<option value='$l[id_jab]' selected>$l[nama_jab]</option>";	
		                      	}else{
		                      		echo "<option value='$l[id_jab]'>$l[nama_jab]</option>";
		                      	}
		                      }

		                      ?>                      
		                    </select>
		                  </div>
		            </div>

		            <div class="control-group pull-left">
	                  <div class="controls" style="text-align:center;">  
	                    <input type="hidden" name="h_idkeg" value="<?php echo "$_GET[md]"; ?>">
	                    <input type="hidden" name="id_u" value="<?php echo "$_GET[i]"; ?>">
	                    <button type="submit" class="btn btn-success">Simpan</button>
	                    <button type="button" class="btn" onclick='self.history.back()'>Batal</button>
	                  </div>
	           		</div>
				</form>

	
				<?php
				break;
				
				default:
					
				echo "<div class='page-header'>
				<h3>Form <span class='label labelform label-info'>Input</span> User Baru</h3>";
					include 'include/notif.php';
				echo "</div>";
				?>
				<form class="form-horizontal" method='POST' action='mod_sistem/md_adminkop/action/act_user.php?ac=add' enctype=''>
				<div class="control-group">
	                 <label class="control-label">Username</label>
	                 <div class="controls">                     
	                   <input type="text" name='u' value=''>
	                 </div>
            	</div>

            	<div class="control-group">
	                 <label class="control-label">Password</label>
	                 <div class="controls">                     
	                   <input type="text" name='p' value='' >
	                 </div>
            	</div>

            	<div class="control-group">
	                 <label class="control-label">Nama Lengkap</label>
	                 <div class="controls">                     
	                   <input type="text" name='nl' value='' >
	                 </div>
            	</div>


            	<div class="control-group">
	                 <label class="control-label">Email</label>
	                 <div class="controls">                     
	                   <!-- <input type="text" name='e' value='' > -->
	                   <input type="email" pattern="[^ @]*@[^ @]*" value="" name='e'>
	                 </div>
            	</div>

            	<div class="control-group">
	                 <label class="control-label">No. Telp</label>
	                 <div class="controls">                     
	                   <input type="text" name='nt' value='' >
	                 </div>
            	</div>

            	<div class="control-group">
	                 <label class="control-label">Blokir</label>
	                 <div class="controls">                     
	                    <span class='radio_b'><input type="radio" name="radio_tah" class='ra' id="" value='Y'>Ya</span>
                     	<span class='radio_b'><input type="radio" name="radio_tah" class='ra' id="" value='N'>Tidak</span>
	                 </div>
            	</div>

            	<div class="control-group">
                  <label class="control-label">Seksi</label>
                  <div class="controls">
                    <select name="sek">
                      <option value="0">Pilih Seksi</option>
                      <?php  
                      	$r = mysql_query("SELECT * FROM seksi ORDER BY nama_seksi ASC");
                      	while ($k=mysql_fetch_array($r)) {
                      		echo "<option value='$k[id_seksi]'>$k[nama_seksi]</option>";
                      	}
                      ?>
                    </select>
                  </div>
            	</div>

	            <div class="control-group">
	                  <label class="control-label">Jabatan</label>
	                  <div class="controls">
	                    <select name="jab">
	                      <option value="0">Pilih Jabatan</option>   
	                      <?php  
	                      $q = mysql_query("SELECT * FROM jabatan WHERE id_jab!='14' ORDER BY nama_jab ASC");
	                      while ($l=mysql_fetch_array($q)) {
	                      	echo "<option value='$l[id_jab]'>$l[nama_jab]</option>";
	                      }

	                      ?>                   
	                    </select>
	                  </div>
	            </div>

	            <div class="control-group pull-left">
                  <div class="controls" style="text-align:center;">  
                    <input type="hidden" name="h_idkeg" value="<?php echo "$_GET[md]"; ?>">            
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <button type="button" class="btn" onclick='self.history.back()'>Batal</button>
                  </div>
           		</div>

				</form>
					<?php	
					break;
			}
		?>
	</div>
	<!-- tabel user-->
	<div class='span12 rapatkan' id='box-tabel'>
		<?php 
		$u = mysql_query("SELECT u.*, s.nama_seksi, j.nama_jab FROM users u, jabatan j, seksi s WHERE j.id_jab=u.id_jab AND s.id_seksi=u.id_seksi ORDER BY u.id_user DESC");
                $jumuser = mysql_num_rows($u);
		 ?>
		<div class='page-header'>
            <h3>Tabel User - <span class='badge badge-info'><?php echo "$jumuser"; ?> </span> Data</h3>
            <?php  
                if($_GET['s']=='ck'){
                  echo "<div class='alert alert-success alert-autoclose'>            
                  <strong>Data user berhasil diupdate</strong></div>";
                  }
            ?>
        </div>

        <table class='table table-bordered table-striped table-hover' id="table_id_scroll">
        	<thead>
                <th>Aksi</th>
                <th>No.</th>
                <th>Nama Lengkap</th>
                <th>Username</th>
                <th>E-mail</th>
                <th>No. Telp</th>                
                <th>Seksi</th>
                <th>Jabatan</th> 
                <th>Status</th>               
            </thead>
            <tbody>

            <?php  
                
                $no=1;
                while ($p=mysql_fetch_array($u)) {
                    echo "
                    <tr>
                    <td>";
                    ?>
                    <div class="btn-group btn-small">
                       <a class="btn btn-success btn-small" href="#"><i class="icon-cog"></i></a>
                       <a class="btn btn-success btn-small dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                       <ul class="dropdown-menu">
                         <li><a href='?md=<?php echo "$_GET[md]"; ?>&amp;p=e&amp;i=<?php echo "$p[id_user]"; ?>'><i class='icon-edit'></i> Edit User</a></li>
                         <li class='divider'></li>
                         <?php  
                         if($p['blokir']=='N'){
                            ?>                            
                            <li><a href='mod_sistem/md_adminkop/action/act_user.php?ac=off&amp;md=<?php echo "$_GET[md]"; ?>&amp;f=<?php echo "$p[id_user]"; ?>'><i class="icon-minus-sign"></i> Non Aktifkan</a></li>
                            <?php
                         }else{
                            ?>
                            <li><a href='mod_sistem/md_adminkop/action/act_user.php?ac=on&amp;md=<?php echo "$_GET[md]"; ?>&amp;f=<?php echo "$p[id_user]"; ?>'><i class="icon-ok-sign"></i> Aktifkan</a></li>
                            <?php

                         }
                         ?>
                       </ul>
                    </div>

                    <?php

                    echo "</td>
                    <td>$no</td>
                    <td>$p[nama_lengkap]</td>
                    <td>$p[username]</td>
                    <td>$p[email]</td>
                    <td>$p[no_telp]</td>                    
                    <td>$p[nama_seksi]</td>
                    <td>$p[nama_jab]</td>
                    <td style='text-align:center;'>";
                    if($p['blokir']=='Y'){
                    	echo "<i class='icon-warning-sign'></i>";
                    }else{
                    	echo "<i class='icon-thumbs-up'></i>";
                    }
                    "</td>
                    </tr>
                    ";
                $no++;
                }
            ?>
        </tbody>
        </table>		
	</div>
</div>