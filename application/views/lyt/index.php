<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
<meta name="robots" content="noindex">
<meta name="googlebot" content="noindex">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="author" content="SPTIK">
  <meta name="description" content="Terakreditasi B (BAN-PT). Keputusan BAN-PT No. 496/SK/BAN-PT/Akred/PT/XII/2018">
  <meta name="keywords" content="universitas, majalengka, unma, bijb, kampus, terakreditas b, prodi, program, studi">
  <title><?=$title?> - <?= APP_NAME ?></title>
  <link href="<?= base_url() ?>assets/js/jquery.simpleTicker/jquery.simpleTicker.css" rel="stylesheet">
  <link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>assets/images/logo_100.png">

  <?php $this->load->view('lyt/assets_css.php'); 
		/*additional ASSET CSS*/
		if(isset($assets_css))
		{
		foreach($assets_css as $page_css)
        {
          echo'<link href="'.CDN.$page_css.'" rel="stylesheet"> ';
        }
		}
		
		$this->load->view('lyt/assets_js.php'); 
		/*additional ASSET JS*/
		if(isset($assets_js))
		{
        foreach($assets_js as $page_js)
        {
          echo'<script src="'.CDN.$page_js.'"></script> ';
        }
		}
	?>

    <?php  
    	if (isset($head))
    		for ($i=0; $i < count($head); $i++) { echo $head[$i]; }
    ?>

</head>
<body class="vertical-layout vertical-menu-modern 2-columns   menu-collapsed fixed-navbar"
data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
  <!-- fixed-top-->
  <?php $this->load->view('lyt/menu.php'); ?>
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  <?php $this->load->view('lyt/sidebar2.php'); ?>
  <div class="app-content content">
    <div class="content-wrapper">
	<div class="content-body">
	  <!--START-->
	  <section id="compact-style">
	  <!-- <div class="row">
	  	<div class="col-12">
	  		<div class="card bg-info text-white">
	  			<div class="card-content p-1 font-small-3">
	  				<div class="pull-left pr-1 font-medium-2">
	  					<i class="ft-info"></i>
	  				</div>
	  				<div id="pengumuman" class="ticker">
					  <ul>
					    <li>Selamat datang di Sistem Informasi Kerja Praktek / Praktek Kerja Lapangan</li>
					    <li>Batas Akhir Pendaftaran Kerja Praktek / PKL pada tanggal 26 April 2020</li>
					    <li>Kepada Mahasiswa yang belum melakukan validasi silahkan untuk menghubungi bagian akademik</li>
					  </ul>
					</div>
	  			</div>
	  		</div>
	  	</div>
	  </div> -->
	  <div class="row">
		<div class="col-12">
			<?php $this->load->view($view); ?>
		</div>
	  </div>
	</section>
	<!--END-->
      </div>
    </div>
  </div>
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  <footer class="footer footer-static footer-light navbar-border navbar-shadow d-print-none">
    <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2">
      <span class="float-md-left d-block d-md-inline-block"><a href="https://dev.unma.ac.id/" target="_blank">v<?=APP_VER?></a> &copy; <?=date("Y")?> <a class="text-bold-800 grey darken-2" href="https://themeforest.net/user/pixinvent/portfolio?ref=pixinvent"
        target="_blank">UNMAKU </a></span>
		<span class="float-md-center d-block d-md-inline-block">Merdeka Belajar Kampus Merdeka (MBKM)</span>
      <span id="with-title" class="float-md-right d-block d-md-inline-blockd-none d-lg-block">Bernas Karena Kualitas <i class="ft-heart pink"></i><span id="scroll-top"></span></span>
    </p>
  </footer>
  <!-- BEGIN MODERN JS-->
	<script type="text/javascript">
		$(document).ready(function(){
			$("#with-title").on("click",function(){swal("Selamat","Anda merupakan salah satu orang yang beruntung memenangkan Undian dari UNMA. Hadiahnya kami doakan semoga anda selalu sehat dan banyak rezekinya. Amiin.")})
		});
	</script>
	<script src="<?=CDN?>themes/js/core/app-menu.js" type="text/javascript"></script>
	<script src="<?=CDN?>themes/js/core/app.js" type="text/javascript"></script>
	<script src="<?=CDN?>themes/js/scripts/customizer.js" type="text/javascript"></script>
	<script src="<?=CDN?>themes/js/scripts/footer.min.js" type="text/javascript"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script> 
<!-- END MODERN JS-->

	<?php 
		if (isset($footer))
			for ($i=0; $i < count($footer); $i++) { echo $footer[$i]; } 
	?>

	<script src="<?= base_url() ?>assets/js/jquery.simpleTicker/jquery.simpleTicker.js"></script>
	<script>
		$(function(){
		  $.simpleTicker($("#pengumuman"),
		  	{
		  		'effectType':'roll',
		  		delay: 3000
		  	}
		  );
		});
	</script>
</body>

</html>