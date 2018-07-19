<?php  
	error_reporting(0);
	session_start();
	include "konfigurasi/conf-db/dbautentikasi.php";
?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" type="image/x-icon" href="../global/icon/_share.png">
    <link rel="stylesheet" href="./global/css/bootstrap.css" />
    <link rel="stylesheet" href="./global/css/font-awesome/css/font-awesome.css" />
    <link rel="stylesheet" href="./global/css/docs.css" />
    <link rel="stylesheet" href="./global/css/global.css" media='all'/>
    <link rel="stylesheet" href="./global/css/demo_table.css" />
    <link rel="stylesheet" href="./global/js/jquery.bxslider/jquery.bxslider.css">        
    <link rel="stylesheet" href="./global/css/bootstrap-responsive.css">
    <style>    	
		body .box-utama{width:850px;}
		img.logokop {width: initial;height: 100px;padding-left: 10px;}
		h3.dis{font-weight: bold;font-size: 20px;}
		h3.sis{margin-bottom: 0px;}
		h3.upper{text-transform: uppercase;font-weight: bolder;margin-bottom: 0px;}
		.box-info{padding:15px; min-height: 250px;}
		.boks{margin-top: 10px;}
		ul.listnomor{list-style: decimal;}
		table td{vertical-align:baseline;}
		table{width: 100%;}
		div.box-info .alert-costum{padding-right: 10px;border: none;background-color: white;}
		.border-kiri{border-left:5px solid orange;}
		.header-boks{padding-bottom: 14px;border-bottom: 1px solid #DBDBDB;}
		.foot{padding-top: 18px;border-top: 1px #CCC dashed;}

    </style>


	<script type='text/javascript'>            
            msg = ".::Selamat Datang di";
            msg = " Website SIM Koperasi Kota Pasuruan ::. " + msg;pos = 100;
            function s() {
                document.title = msg.substring(pos, msg.length) + msg.substring(0, pos); pos++;
                if (pos > msg.length) pos = 0
                window.setTimeout("s()",200);
            }
            s();
    </script>
</head>
	<div class="container box-utama">
    

		<div class="row-fluid">
			<!-- header -->
			<div class="span12 header-boks">
				<div class="row-fluid">
					<div class="span2">
						<img src="./global/img/logokop.png" alt="" class='logokop'>
					</div>
					<div class="span10 rapatkan">
						<div class="row-fluid">
							<div class="span12">
								<h3 class='sis upper'>sistem manajemen informasi</h3>
								<h3 class='dis upper'>DINAS KOPERASI, PERINDUSTRIAN DAN PERDAGANGAN KOTA PASURUAN</h3>
							</div>							
							<div class="span12 rapatkan"><h5>Jalan Pahlawan No. 28 Pasuruan</h5> </div>
						</div>
					</div>
				</div>
			</div>
			
			<!-- content -->
			<div class="span12 rapatkan boks">
				<div class="row-fluid">
					<div class="span8 box-info">
						<div class="alert alert-info">
							Selamat Datang di Website Sistem Informasi Manajemen <br>
							Dinas Koperasi, Perindustrian dan Perdagangan Kota Pasuruan	
						</div>
						<div class="alert">
							Sistem Manajemen Koperasi mencakup:
							<ul class='listnomor'>
								<li>Manajemen Data Perencanaan</li>
								<li>Manajemen Data Persiapan</li>
								<li>Manajemen Data Pelaksanaan</li>
								<li>Manajemen Data Pengawasan</li>
								<li>Rekap/Laporan Kegiatan</li>
								<li>Sistem Evaluasi dan Monitoring <i>(E-Monev)</i></li>
							</ul>
						</div>
					</div>
					<div class="span4 box-info border-kiri">
						<div class="alert alert-costum">
							<h3><strong>Form Login</strong></h3>
						</div>
						<?php  
						    // JANGAN DITARUH DALAM ROW-FLUID
						        if($_GET['a']=='g2l'){
						              ?>
						              <div class="alert alert-danger" style='margin-top:15px;'>
						                <button type="button" class="close" data-dismiss="alert">&times;</button>
						                <strong>Maaf, Login Salah</strong><br>Isi Username dan Password Anda dengan Benar.
						              </div>
						              <?php
						        }
						      ?>
						<div class="alert alert-costum">
							<form method='POST' action='konfigurasi/conf-db/validasi-login.php'>
								<table>
									<tbody>
										<tr><td>Username</td><td>: <input type="text" name="username" class='span10'></td></tr>
										<tr><td>Password</td><td>: <input type="password" name='password' class='span10'></td></tr>
										<tr><td colspan='2'><input type="submit" value='Login' class='btn btn-small btn-warning'></td></tr>
									</tbody>
								</table>
							</form>
						</div>
						
					</div>
				</div>
			</div>
			<!-- footer -->
			<div class="span12 rapatkan foot">
		          <footer>
		          <center><a href="<?php echo "$_SERVER[PHP_SELF]"; ?>">&copy; Dinas Koperasi, Perindustrian dan Perdagangan Kota Pasuruan</a></center>  
	        	</footer>   
	      	</div>
		</div>
	</div>

<body>

	<!-- javascript -->
	<script src="./global/js/jquery-1.9.1.js"></script>
    <script src="./global/js/bootstrap.js"></script>
    <script src='./global/js/twitter-bootstrap-hover-dropdown.js'></script>      
    <script src='./global/js/fileupload/bootstrap-fileupload.js'></script>
    <script src='./global/js/datepicker/js/bootstrap-datepicker.js'></script>
    <script src="./global/js/jquery.dataTables.js"></script>    
    <script src="./global/js/bootstrap-timepicker.min.js"></script>    
    <script src="./global/js/bootstrap.file-input.js"></script>    
    <script src="./global/js/clock.js" type="text/javascript"></script>    
    <script src='./global/js/holder.js'></script>
    <script src='./global/js/jquery.bxslider/jquery.bxslider.js'></script>
    
    <!-- costum js -->
    <script src='./global/js/kop-manual.js'></script>

    <!-- js khusus untuk this -->
	<script>
		$().ready(function(){
			$("#bxslider").bxSlider({
				  mode: 'horizontal',
		          minSlides: 1,          
		          auto: true,
		          captions: true, 
		          controls: false,
		          speed: 1000
			});

			$("#boxlogin").click(function(e) {
           e.stopPropagation();
        });
		});
	</script>
</body>
</html>