<?
use App\Models\Pelamar;
use App\Models\Jabatan;
use App\Models\Visitor;
use App\Models\PelamarLowongan;
use App\Models\Lowongan;

$menu = request()->menu;

$reqMode = request()->reqMode;
$reqUser = request()->reqUser;
$reqPasswd = request()->reqPasswd;
$reqId = request()->reqId;

if($auth->userPelamarId)
{
	$pelamar = new Pelamar();
	$tempIsPernyataan = $pelamar->getFieldById("PAKTA_INTEGRITAS", $auth->userPelamarId);
}

$jabatan = new Jabatan();
$jabatan->selectByParamsJumlah(array("KELOMPOK" => 'O'));

$visitor = new Visitor();
$ip = _ip(); 
$timestamp = time();

$getStats = $visitor->getOnline($time, $ip);
if($getStats == 0)
{
	$visitor->setField("IP", $ip);
	$visitor->setField("TANGGAL", $time);	
	$visitor->setField("HITS", 1);	
	$visitor->setField("STATUS", $timestamp);
	$visitor->insertData();				
}


if($_SERVER['HTTPS']!="on") {
$redirect= "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
header("Location:".$redirect);  
}


?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title><?=config("app.nama_aplikasi")?> | <?=config("app.nama_perusahaan")?></title>
    <base href="{{ asset('/') }}">
    <link rel="shortcut icon" href="favicon.png" type="image/png">

    <!-- Bootstrap Core CSS -->
    <link href="libraries/startbootstrap-blog-post-1.0.4/css/bootstrap.css" rel="stylesheet">
    <link href="libraries/startbootstrap-freelancer-1.0.3/font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="libraries/startbootstrap-blog-post-1.0.4/css/blog-post.css" rel="stylesheet">

    <link href="css/gaya-rekrutmen.css" rel="stylesheet">
    <link href="css/rekrutmen.css" rel="stylesheet">
    <link href="css/halaman.css" rel="stylesheet" type="text/css">
    
    <!-- jQuery -->
    <script src="libraries/startbootstrap-blog-post-1.0.4/js/jquery.js"></script>

    
    <!-- Bootstrap Core JavaScript -->
    <script src="libraries/startbootstrap-blog-post-1.0.4/js/bootstrap.min.js"></script>
    
    <!-- FIXED MENU -->
    <script type='text/javascript'>//<![CDATA[
	    $(window).load(function(){
		    $(document).ready(function() {

            
          $(window).scroll(function () {
            //nav bar to stick.  
            if ($(window).scrollTop() < 79) {
              $('.area-atas').fadeIn();
            }
            if ($(window).scrollTop() > 80) {
              $('.area-atas').fadeOut();
            }
        });
		});
	});//]]> 
	
  $(document).ready(function() {
      $('.reqCaptcha').keyup(function() {
          this.value = this.value.toUpperCase();
      });

      <?
      if($pg == "" || $pg == "home")
      {
      ?>
        refreshing_Captcha();
      <?
      }
      ?>
  });

  function refreshing_Captcha() {
      $.get("login/getCapcha?", function(data) {
          var img = document.images['image_captcha'];
          img.src = "login/captcha?reqId="+data;
          $("#capcha").val(data);
      });
  }

	function setModal(target, link_url)
	{
		var s_url= link_url;
		var request = $.get(s_url);
		
		request.done(function(msg)
		{
			if(msg == ''){}
			else
			{
				$('#'+target).html(msg);
			}
		});
		//alert(target+'--'+link_url);
	}
	

	function validateForm() {
	    var x = document.forms["ajax-login-form"]["reqUser"].value;
	    var y = document.forms["ajax-login-form"]["reqPasswd"].value;
        var z = document.forms["ajax-login-form"]["reqCaptcha"].value;
	    if (x == "") {
	        alert("Nomor NIK tidak boleh kosong.");
	        $( "#reqUser" ).focus();
	        return false;
	    }
	    else if(x.indexOf(' ')>0)
	    {
	    	alert("Nomor NIK terdapat spasi, mohon cek ulang");
	    	return false;
	    }
	    else if (y === "") {
	    	alert("Password tidak boleh kosong.");
	    	$( "#reqPasswd" ).focus();
	        return false;	
	    }
        else if (z === "") {
            alert("Kode Captcha tidak boleh kosong.");
            $( "#reqCaptcha" ).focus();
            return false;   
        }
	}
	</script>
    
<!-- GlossyAccordionMenu -->
<link rel="stylesheet" href="libraries/GlossyAccordionMenu/glossymenu.css" type="text/css" />




<!-- STEP PROGRESS -->
<link href="libraries/css-progress-wizard-master/css/progress-wizard.min.css" rel="stylesheet">

<script>
$(window).scroll(function() {
// 100 = The point you would like to fade the nav in.
  
	if ($(window).scrollTop() > 0 ){
    
 		$('.bg-header').addClass('show');
    
  } else {
    
    $('.bg-header').removeClass('show');
    
 	};   	
});

</script>

<!-- PARALLAX -->
<link rel="stylesheet" type="text/css" href="libraries/ParallaxContentSlider/css/style2.css" />

<!-- SLICK -->
<link rel="stylesheet" type="text/css" href="libraries/slick-1.8.1/slick/slick.css">
<link rel="stylesheet" type="text/css" href="libraries/slick-1.8.1/slick/slick-theme.css">
<style type="text/css">
</style>

<!-- SELECT -->
<link rel="stylesheet" href="libraries/pure-css-select-style-master/css/pure-css-select-style.css">

<style type="text/css">
    .wrapp {
      width: calc(100% - 40px);
      /*height: 30px;*/
      /*height: 278px;*/
      height: 140px;
      margin-left: 20px;
      margin-right: 20px;

      /*z-index:-2;*/
      margin-top: -40px;
      z-index: 99;
      white-space: nowrap;
      overflow: hidden;

      padding-left: 60px;
      padding-right: 60px;

      position: relative;
      
      background-color: #000000; 
      background-image: url(images/linear_bg_1.png); 
      background-repeat: repeat-y; 
      background: -webkit-gradient(linear, left top, right top, from(#000000), to(#6b6b6b)); 
      background: -webkit-linear-gradient(left, #000000, #6b6b6b); 
      background: -moz-linear-gradient(left, #000000, #6b6b6b); 
      background: -ms-linear-gradient(left, #000000, #6b6b6b); 
      background: -o-linear-gradient(left, #000000, #6b6b6b);

      -webkit-border-radius: 20px; 
      -moz-border-radius: 20px;
      border-radius: 20px; 

      overflow: hidden;
    }
    .wrapp div:first-child{margin-left:-2%;}
    .progresss {
      margin:0;
      margin-left:0.5%;
      height: 140px;
      /*width: 25%;*/
      width: calc(100% / 6);
      position: relative;
      display: inline-block;
      text-align: center;
      line-height: 30px;
      transition: all 0.8s;
    }
    .progresss:before,
    .progresss:after {
      content: "";
      position: absolute;
      transition: all 0.8s;
      z-index:-1;
    }
    .progresss:before {
      height: 50%;
      width: 100%;
      top: 0;
      left: 0;
      background: rgba(0, 0, 0, 0.2);
      -webkit-transform: skew(45deg);
      -moz-transform: skew(45deg);
      transform: skew(45deg);
    }
    .progresss:after {
      height: 50%;
      width: 100%;
      top: 50%;
      left: 0;
      background: rgba(0, 0, 0, 0.2);
      -webkit-transform: skew(-45deg);
      -moz-transform: skew(-45deg);
      transform: skew(-45deg);
    }
    .progresss:hover:before,
    .progresss:hover:after {
      background: tomato;
    }

    .wrapp .progresss:nth-child(1):before,
    .wrapp .progresss:nth-child(1):after {
      background: #000000;
    }
    .wrapp .progresss:nth-child(2):before,
    .wrapp .progresss:nth-child(2):after {
      background: #24cc43;
    }
    .wrapp .progresss:nth-child(3):before,
    .wrapp .progresss:nth-child(3):after {
      background: #fbbe57;
    }
    .wrapp .progresss:nth-child(4):before,
    .wrapp .progresss:nth-child(4):after {
      background: #5ab5e3;
    }
    .wrapp .progresss:nth-child(5):before,
    .wrapp .progresss:nth-child(5):after {
      background: #8b8b8b;
    }
    .wrapp .progresss:nth-child(6):before,
    .wrapp .progresss:nth-child(6):after {
      background: #6b6b6b;
    }
</style>

</head>
<?
if($auth->userPelamarId == "")
{
	?>
<body style="padding-top: 0px;">
    <?
	
	}
else
{
?>
<!--<body style="padding-top: 60px;">-->
<body style="padding-top: 0px;">
<?
}
?>
	<!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top bg-header <? if($pg == "" || $pg == "home"){} else { ?>bg-header-detil<? } ?>" role="navigation">
        <!-- <div class="container-fluid"> -->
        
        	<!-- Brand and toggle get grouped for better mobile display -->
            <div class="container-fluid atas">
            	<div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php">
                        <div class="aplikasi-logo"><img src="images/logo.png"></div>
                        <div class="aplikasi-nama">Aplikasi Rekrutmen</div>
                        <div class="clearfix"></div>
                    </a>
                </div>
                
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse area-menu-atas-wrapper" id="bs-example-navbar-collapse-1">
                	<div class="area-menu-atas">
                    	<div class="inner">
                        	<ul class="nav navbar-nav">
                            <li <? if($pg == "" || $pg == "index" || $pg == "home"){?> class="active" <? }?>>
                                <a href="app/index">Beranda</a>
                            </li>
                            <li <? if($pg == "syarat_dan_ketentuan"){?> class="active" <? }?>>
                                <a href="app/index/syarat_ketentuan">Syarat dan Ketentuan</a>
                            </li>
                            <li <? if($pg == "faq"){?> class="active" <? }?>>
                                <a href="app/index/faq">FAQ</a>
                            </li>
                            <?php /*?><li>
                                <a href="app/index/lowongan">Lowongan</a>
                            </li><?php */?>
                          </ul>
                          <?
                          if($auth->userPelamarId == "")
                          {} else {
                          ?>
                          <ul class="nav navbar-nav navbar-right">
                            <li>
                              <a  class="btn btn-info btn-ganti-password" href="app/index/ganti_password"><i class="fa fa-key"></i> Ganti Password</a>
                            </li>
                            <li>
                              <a  class="btn btn-danger btn-logout" href="app/logout/"><i class="fa fa-sign-out"></i> Logout</a>
                            </li>
                          </ul>
                          <? } ?>
                        </div>
                    </div>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            
        <!-- </div> -->
        <!-- /.container -->
        <div style="position: absolute; right: 15px; bottom: -9px;">
          <img src="images/img-abstract-line-header.png" height="3">
        </div>
    </nav>
	
    <?
	if($auth->userPelamarId == "")
	{
	?>
    <?
    if($pg == "" || $pg == "home"){
	?>
    <div class="container-fluid banner-home">
    	<div class="row">
        	<!--<div class="col-lg-12" style="padding-left:0px; padding-right:0px;">-->
            <div class="col-lg-12 col-area-slide">
            	<!-- <div class="logo-erica-slide"><img src="images/logo-erica.png"></div> -->
                <div class="area-pencarian-slide">
                	<div class="inner">
                    	<form action="app/index/pencarian" method="post">
                        	<label>
                            	<i class="fa fa-pencil"></i>
                                <input type="text" name="reqPencarian" placeholder="Ketikkan kata kunci...">
                            </label>
                            <button type="submit">Cari Lowongan</button>

	    	      	        @csrf  
                        </form>
                    </div>
                </div>
            	<div class="area-slide">
                    <div id="da-slider" class="da-slider">
                        <div class="da-slide">
                            <div class="da-img"><img src="images/img-slide-1.jpg" alt="image01" /></div>
                        </div>
                        <div class="da-slide">
                            <div class="da-img"><img src="images/img-slide-2.jpg" alt="image02" /></div>
                        </div>
                        <nav class="da-arrows">
                            <span class="da-arrows-prev"></span>
                            <span class="da-arrows-next"></span>
                        </nav>
                    </div>
                </div>                
            </div>
            <div class="col-md-12">
                <div class="wrapp area-alur">
                  <div class="progresss">
                    <div class="item">
                      <!-- <div class="ikon"><img src="images/icon-registrasi.png"></div> -->
                      <div class="judul">registrasi akun</div>
                      <div class="nomor"><span>1</span></div>
                      <div class="keterangan">Pengisian data dasar hingga pendidkan terakhir</div>
                    </div>
                  </div>
                  <div class="progresss">
                    <div class="item">
                      <div class="judul">pilih lowongan</div>
                      <div class="nomor"><span>2</span></div>
                      <div class="keterangan">Calon pelamar memilih lowongan yang aktif</div>
                    </div>
                  </div>
                  <div class="progresss">
                    <div class="item">
                      <div class="judul">pengisian cv</div>
                      <div class="nomor"><span>3</span></div>
                      <div class="keterangan">Pengisian CV sesuai lowongan yang dipilih</div>
                    </div>
                  </div>
                  <div class="progresss">
                    <div class="item">
                      <div class="judul">upload file</div>
                      <div class="nomor"><span>4</span></div>
                      <div class="keterangan">Upload file/data pendukung yang dibutuhkan</div>
                    </div>
                  </div>
                  <div class="progresss">
                    <div class="item">
                      <div class="judul">verifikasi admin</div>
                      <div class="nomor"><span>5</span></div>
                      <div class="keterangan">Tunggu verifikasi dari pihak administrator</div>
                    </div>
                  </div>
                  <div class="progresss">
                    <div class="item">
                      <div class="judul">pengumuman tahap</div>
                      <div class="nomor"><span>6</span></div>
                      <div class="keterangan">Informasi / pengumuman setiap tahap seleksi</div>
                    </div>
                  </div>
                </div>
            </div>
            <div class="col-lg-12 area-alur" style="display: none;">
            	<div class="row">
                  <div class="item col-lg-2">
                  	<div class="ikon"><img src="images/icon-registrasi.png"></div>
                    <div class="judul">registrasi<br>akun</div>
                    <div class="nomor"><span>1</span></div>
                    <div class="keterangan">Pengisian data dasar hingga pendidkan terakhir</div>
                  </div>
                	<div class="item col-lg-2">
                    	<div class="ikon"><img src="images/icon-pilih-lowongan.png"></div>
                        <div class="judul">pilih<br>lowongan</div>
                        <div class="nomor"><span>2</span></div>
                        <div class="keterangan">Calon pelamar memilih lowongan yang aktif</div>
                    </div>
                	<div class="item col-lg-2">
                    	<div class="ikon"><img src="images/icon-pengisian-cv.png"></div>
                        <div class="judul">pengisian<br>cv</div>
                        <div class="nomor"><span>3</span></div>
                        <div class="keterangan">Pengisian CV sesuai lowongan yang dipilih</div>
                    </div>
                	<div class="item col-lg-2">
                    	<div class="ikon"><img src="images/icon-upload-file.png"></div>
                        <div class="judul">upload<br>file</div>
                        <div class="nomor"><span>4</span></div>
                        <div class="keterangan">Upload file/data pendukung yang dibutuhkan</div>
                    </div>
                	<div class="item col-lg-2">
                    	<div class="ikon"><img src="images/icon-verifikasi-admin.png"></div>
                        <div class="judul">verifikasi<br>admin</div>
                        <div class="nomor"><span>5</span></div>
                        <div class="keterangan">Tunggu verifikasi dari pihak administrator</div>
                    </div>
                	<div class="item col-lg-2">
                    	<div class="ikon"><img src="images/icon-pengumuman-tahap.png"></div>
                        <div class="judul">pengumuman<br>tahap</div>
                        <div class="nomor"><span>6</span></div>
                        <div class="keterangan">Informasi / pengumuman setiap tahap seleksi</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?
	}
	?>
    <?
	}
	?>
    
    <!-- <div class="bg-main">&nbsp;</div> -->
                
    <!-- Page Content -->
    <div class="container-fluid container-sisi-utama">
    	<!--<div class="row">
            <div class="col-sm-4 col-sm-push-8" style="background-color:lavender;">kanan</div>
            <div class="col-sm-8 col-sm-pull-4" style="background-color:lavenderblush;">kiri konten</div>
        </div>-->
    	<?
		if($pg == "" || $pg == "home"){
			if($auth->userPelamarId == "")
			{
			?>
				<div class="row main-home sisi-utama">
			<?
			}
			else
			{
			?>
		        <div class="row main-detil sisi-utama">
            <?	
			}
		} else {
		?>
        <div class="row main-detil sisi-utama">
        <?
		}
		?>
        	

            <!-- Blog Sidebar Widgets Column -->
            <!--<div class="col-md-4 sisi-kanan col-md-push-4">-->
            
            <?
            if($pg == "home_detil" || $pg == "isian_formulir")
			{}
			else
			{
			?>
            <div class="col-sm-4 col-sm-push-8">
            <?
			}
			?>
                

            	<?
				if($auth->userPelamarId == "")
				{
					if($pg == "home_detil" || $pg == "register" || $pg == "isian_formulir")
					{} 
					else 
					{
					?>
					<?php /*?><div class="area-cek-register">
						<div class="judul">Registrasi</div>
						<form>
							<input class="nik" id="reqKtp" type="text" placeholder="Masukkan 16 Digit NIK" maxlength="16">
							<span id="spanRegister" style="color:#D14F51"></span>
							<button type="button" onClick="checkKtp($('#reqKtp').val(), 'spanRegister');">Submit</button>
						</form>                        
					</div><?php */?>
					<? 
					} 
				}
				else
				{
					if($auth->LAMPIRAN_FOTO == "")
						$img = "images/img-pria.jpg";
					else
						$img = "uploads/".$auth->LAMPIRAN_FOTO;					
				?>
                
                <?
				if($pg == "isian_formulir"){} else {
				?>
                <div class="area-akun">
                	<div class="judul">Akun</div>
                    <div class="inner">
                        <div class="foto"><img src="<?=$img?>"></div>
                        <div class="title">Nama</div>
                        <div class="data"><?=$auth->nama?></div>
                        <div class="title">Nomor Registrasi</div>
                        <div class="data"><?=$auth->userNoRegister?></div>
                        <div class="title">Login Terakhir</div>
                        <div class="data"><?=$auth->loginTimeStr?></div>
                        <?
                        if($auth->KIRIM_LAMARAN == "0")
						{
						?>
								<style>
								.blink {
								  animation: blinker 1s step-start infinite;
								}
								@keyframes blinker {
								  30% {
									opacity: 0;
								  }
								}								
                                </style>
                        		<div class="alert alert-warning blink"><i class="fa fa-info-circle"></i> <a href="app/index/isian_formulir" style="text-decoration:none; color:#000000">Silahkan melengkapi data pribadi anda disini.</a></div>
                        <?
						}
						else
						{
							if($auth->LOWONGAN_ID == "")
							{
						?>
	                        	<div class="alert alert-success"><i class="fa fa-info-circle"></i> <a href="app/index/daftar_lowongan" style="text-decoration:none; color:#000000">Silahkan mengirim lamaran anda disini.</a></div>
						<?
							}
							else
							{
							?>
								<div class="alert alert-success"><i class="fa fa-info-circle"></i> <a href="app/index/cetak_registrasi" style="text-decoration:none; color:#000000">Silahkan cetak kartu registrasi anda disini.</a></div>                            
                            <?	
							}
						}
						?>
                    </div>
                </div>
                
                <? } ?> 
                <?	
				}
				?>
                
                <?
				//|| $pg == "konfirmasi" 
				if(	$auth->userPelamarId != "" || $pg == "pendaftaran" || 
				$pg == "data_pribadi_pangkat" || $pg == "data_pribadi_jabatan" || $pg == "data_pribadi_pendidikan" || $pg == "data_pribadi_pelatihan" || $pg == "data_pribadi_penugasan" || 
				$pg == "data_pribadi_lain" || 
				$pg == "data_pribadi" || $pg == "data_pendidikan_formal" || $pg == "pendidikan_formal" || $pg == "pengalaman_bekerja" || $pg == "pelatihan" || $pg == "arah_minat" || $pg == "data_pribadi_upload" || 
				$pg == "ganti_password" || $pg == "data_email_subscribe")
				{
					if($auth->userVerifikasi == "0")
					{
					?>
						<div class="glossymenu">
							<a class="menuitem submenuheader">Verifikasi</a>
							<div class="submenu">
							<ul>
								<li><a>Untuk Dapat mengisi biodata, mohon verifikasi akun anda terlebih dahulu.</a></li>
                  <li>
                    <a href="app/index/verifikasi_pelamar_resend">Kirim Email Verifikasi</a>
                  </li>
              </ul>
						</div>
						</div>
					<?
					}
					else
					{
					?>
                    
                    <?
					if($pg == "isian_formulir"){} else {
					?>
                    
					<div class="glossymenu">
	                    <a class="menuitem submenuheader"><span>Main Menu</span></a>
						<div class="submenu">
							<ul>
                <li><a href="app/index/isian_formulir" <? if($pg == "isian_formulir") { ?> class="submenu-current" <? } ?>>Isian Formulir</a></li>
                <li><a href="app/index/daftar_lowongan" <? if($pg == "daftar_lowongan") { ?> class="submenu-current" <? } ?>>Lamaran Aktif</a></li>
                <li><a href="app/index/daftar_lamaran" <? if($pg == "daftar_lamaran") { ?> class="submenu-current" <? } ?>>History Lamaran</a></li>
              </ul>
						</div>                    
	                    <?
                        
		
						
						$pelamar = new PelamarLowongan();
						$sudahKirim = $pelamar->getCountByParams(array("PELAMAR_ID" => $auth->UID, "PERIODE_ID_LAMAR" => $auth->PERIODE_ID_AKTIF));
						if($sudahKirim > 0)
						{}
						else
						{
						?>
						<?
						}
						?>
					</div>
                    <? } ?>
                    
				<?
					}
				}
				?>				
                
                
                <?
				if($pg == "" || $pg == "home"){
					$lowongan = new Lowongan();
					$pelamar  = new Pelamar();
					
					$visitor = new Visitor();
					$jumlahPengunjung = $visitor->totalHits();
					$jumlahLowongan = $lowongan->getCountByParams(array(), " AND A.PUBLISH_DATE IS NOT NULL AND CURRENT_DATE BETWEEN A.TANGGAL_AWAL AND A.TANGGAL_AKHIR AND COALESCE(NULLIF(A.STATUS_UNDANGAN, ''), '0') = '0' ");
					$jumlahPelamar  = $pelamar->getCountByParams(array());
				?>

        <!---- pindahan dari area atas ---->

        <div class="">
          <?
          if($auth->userPelamarId == "")
          {
          ?>
            <!--<li>
                <a class="login" href="#">Registrasi</a>
            </li>-->
            <div class="area-info-kanan">
              <div class="judul">Login</div>
              <div class="inner">
                <div class="area-login">
                  <form id="ajax-login-form" method="post" role="form" autocomplete="off" novalidate enctype="multipart/form-data" action="app/login" onsubmit="return validateForm()" >
                      <div class="form-group">
                          <label for="username">Username</label>
                          <input type="text" name="reqUser" maxlength="16" id="reqUser" class="easyui-validatebox form-control" required="required" placeholder="Nomor NIK" onkeydown="if(event.keyCode === 32) return false;" />
                      </div>

                      <div class="form-group">
                          <label for="password">Password</label>
                          <input type="password" name="reqPasswd" maxlength="30" id="reqPasswd" class="easyui-validatebox form-control" required="required" placeholder="Password" maxlength="30" />
                        <input type="hidden" name="reqMode" value="submitLogin">
                      </div>

                       <div class="form-group">
                                <div class="row">
                                   <div class="col-md-5">
                                   <input type="text" maxlength="5" placeholder="Kode Captcha" class="form-password form-control reqCaptcha" name="reqCaptcha" id="reqCaptcha" required="required">
                                   </div>
                                  <div class="col-md-6">
                                     <div class="row">
                                      <div class="col-sm-10">
                                      <img src="login/captcha" id='image_captcha' onclick="refreshing_Captcha();">
                                   </div>
                               </div>
                           </div>
                           </div>
                      </div>
                      <div style="font-size: 12px; color:red">
                          <?=$pesan?>
                      </div>

                      <div class="form-group">
                          <div class="row">
                              <div class="col-xs-7" style="padding-left:5px !important; text-align:center;">
                                  <div class="ket"><a href="app/index/password">Lupa Password</a></div>
                                  <div class="ket"><a href="app/index/aktivasi">Kirim Ulang Aktivasi</a></div>
                              </div>
                              <div class="col-xs-5 pull-right">
                                  <input type="submit" value="LOGIN">
                              </div>
                          </div>
                      </div>
                      @csrf  
                  </form>
              </div>
              </div>
            </div>

            <div class="area-info-kanan">
              <div class="judul">Registrasi</div>
              <div class="inner">
                <div class="area-login register">
                  <form>
                      <div class="form-group">
                            <label for="username">Cek NIK</label>
                            <input class="nik" id="reqKtp" type="text" placeholder="Masukkan 16 Digit NIK" maxlength="16" style="width: 100%;">
                        </div>
                        
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12 pull-right">
                                    <span id="spanRegister" style="color:#D14F51"></span>
                                    <button type="button" onClick="checkKtp($('#reqKtp').val(), 'spanRegister');">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
              </div>
            </div>

            <!-- <li class="dropdown">
              <a class="dropdown-toggle registrasi" data-toggle="dropdown">Registrasi <span class="caret"></span></a>
                <ul class="dropdown-menu dropdown-lr animated slideInRight area-login-wrapper" role="menu">
                  
                    <div class="area-login register">
                      <form>
                          <div class="form-group">
                                <label for="username">Cek NIK</label>
                                <input class="nik" id="reqKtp" type="text" placeholder="Masukkan 16 Digit NIK" maxlength="16" style="width: 100%;">
                            </div>
                            
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-12 pull-right">
                                        <span id="spanRegister" style="color:#D14F51"></span>
                                  <button type="button" onClick="checkKtp($('#reqKtp').val(), 'spanRegister');">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </ul>
            </li> -->
            <!-- <li class="dropdown">
              <a id="aLogin" class="dropdown-toggle login" data-toggle="dropdown">Log In <span class="caret"></span></a>
                <ul class="dropdown-menu dropdown-lr animated slideInRight area-login-wrapper" role="menu">
                    
                    ex login
                </ul>
            </li> -->
          <?
          }
          else
          {
          ?>
            

          <?
          }
          ?>

        </div>

        <!--------------------------------------->
        <!---- end pindahan dari area atas ---->

                <div class="judul-kanan"><span>Info Aplikasi</span></div>
                <div class="area-info-web">
                  <div class="inner">
                    <div class="item jumlah-lowongan">
                      <!-- <div class="ikon"><img src="images/icon-jumlah-lowongan.png"></div> -->
                        <div class="title">Jumlah Lowongan</div>
                        <div class="nilai"><?=$jumlahLowongan?></div>
                    </div>
                    <div class="item jumlah-pelamar">
                      <!-- <div class="ikon"><img src="images/icon-jumlah-pelamar.png"></div> -->
                        <div class="title">Jumlah Pelamar</div>
                        <div class="nilai"><?=$jumlahPelamar?></div>
                    </div>
                    <div class="item pengunjung-online">
                      <!-- <div class="ikon"><img src="images/icon-pengunjung-online.png"></div> -->
                        <div class="title">Jumlah Pengunjung</div>
                        <div class="nilai"><?=$jumlahPengunjung?></div>
                    </div>
                    <div class="clearfix"></div>
                  </div>
                	<!-- <div class="header"><img src="images/img-kantor-ttl.png"></div> -->
                </div>
                <? } ?>
			
            
            <?
            if($pg == "home_detil" || $pg == "isian_formulir")
			{}
			else
			{
			?>
            </div> <!-- /.sisi-kanan -->
            <?
			}
			?>
            <?=$content?>
            
        </div>
        <!-- /.row -->
        
    </div>
    <!-- /.container -->
    
    <div class="container-fluid footer">
    	<!-- Footer -->
        <footer>
        	<div class="container-fluid">
            	<div class="row">
                <div class="col-md-5ths col-xs-6">
                  <img src="images/logo-footer.png" class="logo-footer">
                </div>
                <div class="col-md-5ths col-xs-6">
                  <div class="item-footer">
                      <h4>Sitemap</h4>
                      <ul>
                          <li><a >Tentang Kami</a></li>
                          <li><a >Ketentuan Penggunaan</a></li>
                          <li><a >Kebijakan Kerahasiaan</a></li>
                      </ul>
                  </div>
                </div>
                <div class="col-md-5ths col-xs-6">
                  <div class="item-footer">
                    <h4>&nbsp;</h4>
                    <ul>
                          <li><a >Panduan Mencari Kerja Secara Aman</a></li>
                          <li><a >Bantuan</a></li>
                          <li><a >Kirim Saran</a></li>
                      </ul>
                  </div>
                </div>
                <div class="col-md-5ths col-xs-6">
                  <div class="item-footer">
                    <h4>Contact Us</h4>
                    <p>
                      <a class="email" >Email : recruitment@ptpn1.co.id</a><br>
                      Gedung Agro Plaza Lt. 14, Jl. H. R. Rasuna Said Kav. X2 No.1,<br>
                      Setia Budi, Jakarta Selatan 12950
                    </p>
                    
                  </div>
                </div>
                <div class="col-md-5ths col-xs-6">
                  <div class="item-footer area-sosmed-wrapper">
                      <div class="area-sosmed">
                          <span><i class="fa fa-facebook-square fa-2x"></i></span>
                          <span><i class="fa fa-twitter-square fa-2x"></i></span>
                          <span><i class="fa fa-linkedin-square fa-2x"></i></span>
                          <span><i class="fa fa-google-plus-square fa-2x"></i></span>
                      </div>
                  </div>
                </div>

                	<!-- <div class="col-md-2" style="border: 1px solid red;">
                  	ddd
                  </div>
                  <div class="col-md-2" style="border: 1px solid red;">
                      aaa
                  </div>
                  <div class="col-md-2" style="border: 1px solid red;">
                      hai
                  </div>
                  <div class="col-md-3" style="border: 1px solid red;">
                      haiii
                  </div>
                  <div class="col-md-2" style="border: 1px solid red;">
                      hooo
                  </div> -->
                </div>
                <div class="row">
                	<div class="col-md-12">
                    	<div class="area-copyright">© 2025 PT Perkebunan Nusantara I. All rights reserved.</div>
                    </div>
				</div>
            </div>
            
            <!-- /.row -->
        </footer>

    </div>
    
    <?php /*?><?
    if($pg == "" || $pg == "home")
    {
    ?>
    <!-- OWL CAROUSEL -->
    <script src="libraries/OwlCarousel2-2.2.1/docs/assets/vendors/jquery.min.js"></script>
    <script src="libraries/OwlCarousel2-2.2.1/docs/assets/owlcarousel/owl.carousel.js"></script>
    <?
	}
    ?><?php */?>
    
    <!-- PARALLAX -->
    <script type="text/javascript" src="libraries/ParallaxContentSlider/js/modernizr.custom.28468.js"></script>
	<script type="text/javascript" src="libraries/ParallaxContentSlider/js/jquery.cslider.js"></script>
    <script type="text/javascript">
	
		function checkKtp(ktp,idmsg)
		{
			if(ktp.trim().length < 16)
			{
				$("#"+idmsg).text("Masukkan 16 digit NIK anda.");
				return;	
			}
			$.post( "validasi_json/ktp", { reqId:'<?=$reqId?>', reqKtp:ktp, _token:"{{ csrf_token() }}"  })
			  .done(function( data ) {
				var obj = JSON.parse(data); 
				if(obj.VALIDASI == "1")
				{
					document.location.href = "registrasi";	
				}
				else
				{
					$("#"+idmsg).text(obj.PESAN);
				}
			});
				
		}
		
        $(function() {
        
            $('#da-slider').cslider({
                autoplay	: true,
                bgincrement	: 450,
				controlNav: false
            });
        
        });
    </script>
    
    <!-- SLICK -->
    <!--<script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>-->
	<script src="libraries/slick-1.8.1/slick/slick.js" type="text/javascript" charset="utf-8"></script>
    <?php /*?><script type="text/javascript">
    $(document).on('ready', function() {
		$(".vertical-center-4").slick({
			//dots: false,
			vertical: true,
			//centerMode: true,
			slidesToShow: 2,
			slidesToScroll: 1,
			
			autoplay: true,
			autoplaySpeed: 1000,
			
			dots: false,
			prevArrow: false,
			nextArrow: false
		});
    });
    </script><?php */?>
    
    <?php
	if(stristr($_SERVER['HTTP_USER_AGENT'], "Mobile")){ // if mobile browser
	?>
	<script>
		//alert("mobile");
		
	</script>
    <script type="text/javascript">
		$(document).on('ready', function() {
			$(".vertical-center-4").slick({
				vertical: true,
				slidesToShow: 1,
				slidesToScroll: 1,
				
				autoplay: true,
				autoplaySpeed: 1000,
				
				dots: false,
				prevArrow: false,
				nextArrow: false
			});
		});
    </script>
	<?
	} else { 
	?>
	<script>
		//alert("desktop");
	</script>
    <script type="text/javascript">
		$(document).on('ready', function() {
			$(".vertical-center-4").slick({
				vertical: true,
				slidesToShow: 2,
				slidesToScroll: 1,
				
				autoplay: true,
				autoplaySpeed: 1000,
				
				dots: false,
				prevArrow: false,
				nextArrow: false
			});
      $(".vertical-info-terbaru").slick({
        vertical: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        
        autoplay: true,
        autoplaySpeed: 1000,
        
        dots: false,
        prevArrow: false,
        nextArrow: false
      });
		});
    </script>
    <?
	}
	?>
    

</body>

</html>
