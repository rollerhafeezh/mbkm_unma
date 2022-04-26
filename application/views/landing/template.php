<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
	    <title>Merdeka Belajar Kampus Merdeka (MBKM) | Universitas Majalengka</title>
		<!-- <title><?= $title ?> - <?= APP_NAME ?></title> -->
	    <!-- META TAGS -->
		<meta name="robots" content="noindex">
		<meta name="googlebot" content="noindex">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
		<meta name="author" content="Hafidz Sanjaya, S.Kom.">
		<meta name="description" content="Terakreditasi B (BAN-PT). Keputusan BAN-PT No. 496/SK/BAN-PT/Akred/PT/XII/2018">
		<meta name="keywords" content="universitas, majalengka, unma, bijb, kampus, terakreditas b, prodi, program, studi">

	    <!-- FAV ICON(BROWSER TAB ICON) -->
	    <link rel="shortcut icon" href="https://i0.wp.com/unma.ac.id/wp-content/uploads/2020/02/cropped-logo_100.png?fit=32%2C32&ssl=1" type="image/x-icon">

	    <!-- GOOGLE FONT -->
	    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700%7CJosefin+Sans:600,700" rel="stylesheet">
	    
	    <!-- FONTAWESOME ICONS -->
	    <link rel="stylesheet" href="<?= base_url() ?>assets/css/font-awesome.min.css">
	    
	    <!-- ALL CSS FILES -->
	    <link href="<?= base_url() ?>assets/css/materialize.css" rel="stylesheet">
	    <link href="<?= base_url() ?>assets/css/bootstrap.css" rel="stylesheet" />
	    <link href="<?= base_url() ?>assets/css/style.css" rel="stylesheet" />
	    
	    <!-- RESPONSIVE.CSS ONLY FOR MOBILE AND TABLET VIEWS -->
	    <link href="<?= base_url() ?>assets/css/style-mob.css" rel="stylesheet" />

	    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	    <!-- <script src="https://www.google.com/recaptcha/api.js"></script> -->
	    <script src="https://www.google.com/recaptcha/api.js?render=6Ldh9pofAAAAAHRKrF24CnM9p3Mvhxr-qLCIF5x6"></script>

	    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!--[if lt IE 9]>
		<script src="<?= base_url() ?>assets/js/html5shiv.js"></script>
		<script src="<?= base_url() ?>assets/js/respond.min.js"></script>
		<![endif]-->
	</head>

	<body>
		<!-- MOBILE MENU -->
		<section>
		    <div class="ed-mob-menu">
		        <div class="ed-mob-menu-con">
		            <div class="ed-mm-left">
		                <div class="wed-logo">
		                    <a href="<?= base_url() ?>"><img src="<?= base_url() ?>assets/images/logo.png" alt="" />
							</a>
		                </div>
		            </div>
		            <div class="ed-mm-right">
		                <div class="ed-mm-menu">
		                    <a href="#!" class="ed-micon"><i class="fa fa-bars"></i></a>
		                    <div class="ed-mm-inn">
		                        <a href="#!" class="ed-mi-close"><i class="fa fa-times"></i></a>
		                        <h4>Menu Utama</h4>
		                        <ul>
		                            <li><a href="<?= base_url() ?>">Beranda</a></li>
		                            <li><a href="<?= base_url('program') ?>">Program</a></li>
		                        </ul>
		                        <h4>Akun</h4>
		                        <ul>
		                        	<?php if(!isset($_SESSION['logged_in'])): ?>
		                            <li><a href="#!" data-toggle="modal" data-target="#modal1">Masuk</a></li>
		                        	<?php else: ?>
		                            <li><a href="<?= base_url('dashboard') ?>">Hai, <?= $_SESSION['nama_user'] ?></a></li>
		                        	<?php endif; ?>
		                            <!-- <li><a href="#!" data-toggle="modal" data-target="#modal2">Register</a></li> -->
		                        </ul>
		                    </div>
		                </div>
		            </div>
		        </div>
		    </div>
		</section>

		<!--HEADER SECTION-->
		<section>
		    <!-- TOP BAR -->
		    <div class="ed-top">
		        <div class="container">
		            <div class="row">
		                <div class="col-md-12">
		                    <div class="ed-com-t1-left">
		                        <ul>
		                            <li><a href="javascript:void(0)"><i class="fa fa-map-marker mr-2"></i> Jl. KH. Abdul Halim No. 103</a></li>
		                            <li><a href="tel:0233281496"><i class="fa fa-phone mr-2"></i> (0233) 281 496</a></li>
		                            <li><a href="mailto:info@unma.ac.id"><i class="fa fa-envelope mr-2"></i> info@unma.ac.id</a></li>
		                        </ul>
		                    </div>
		                    <div class="ed-com-t1-right">
		                        <ul>
		                        	<?php if(!isset($_SESSION['logged_in'])): ?>
		                            <li><a href="#!" data-toggle="modal" data-target="#modal1"><i class="fa fa-user mr-2"></i> Masuk</a>
		                        	<?php else: ?>
		                            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-user mr-2"></i> Hai, <?= ucwords(strtolower($_SESSION['nama_user'])) ?></a></li>
		                        	<?php endif; ?>
		                            </li>
		                            <!-- <li><a href="#!" data-toggle="modal" data-target="#modal2">Daftar</a>
		                            </li> -->
		                        </ul>
		                    </div>
		                    <div class="ed-com-t1-social">
		                        <ul>
		                            <li><a href="https://facebook.com/unma2006"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
		                            <li><a href="https://twitter.com/univMajalengka"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
		                            <li><a href="https://instagram.com/univMajalengka"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
		                            <li><a href="https://www.youtube.com/c/UniversitasMajalengka"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
		                        </ul>
		                    </div>
		                </div>
		            </div>
		        </div>
		    </div>

		    <!-- LOGO AND MENU SECTION -->
		    <div class="top-logo" data-spy="affix" data-offset-top="250">
		        <div class="container">
		            <div class="row">
		                <div class="col-md-12">
		                    <div class="wed-logo">
		                        <a href="<?= base_url() ?>"><img src="<?= base_url() ?>assets/images/logo.png" alt="" />
		                        </a>
		                    </div>
		                    <div class="main-menu">
		                        <ul>
		                            <li><a href="<?= base_url() ?>">Beranda</a></li>
		                            <li><a href="<?= base_url('program') ?>">Program</a></li>
		                        </ul>
		                    </div>
		                </div>
		                <div class="all-drop-down-menu">

		                </div>

		            </div>
		        </div>
		    </div>

		    <!-- <div class="search-top">
	            <div class="container">
	                <div class="row">
	                    <div class="col-md-12">
	                    	<span style="color: white">Penting! Halaman ini digunakan hanyak untuk civitas akademika universitas majalengka.</span>
	                    </div>
	                </div>
	            </div>
	        </div> -->
		</section>
		<!--END HEADER SECTION-->
		<?php $this->load->view($view) ?>

	    <!-- FOOTER -->
	    <section class="wed-hom-footer">
	        <div class="container">
	            <div class="row wed-foot-link">
	                <div class="col-md-4 foot-tc-mar-t-o">
	                    <div class="clearfix"></div>
	                	<img src="https://i0.wp.com/unma.ac.id/wp-content/uploads/2020/02/logo.png?w=426&ssl=1" width="100px" style="padding-bottom: 20px" class="mt-4 mr-4 pull-left">
	                    <h4 style="border: none !important;">Universitas Majalengka</h4>
						<ul>
	                        <li style="width: 100%"><a href="javascript:void(0)"><i class="fa fa-certificate mr-2"></i> Terakreditasi "B"</a></li>
	                        <li style="width: 100%"><a href="javascript:void(0)"><i class="fa fa-map-marker mr-2"></i> Jl. KH. Abdul Halim No. 103</a></li>
	                        <li style="width: 100%"><a href="tel:0233281496"><i class="fa fa-phone mr-2"></i> (0233) 281 496</a></li>
	                        <li style="width: 100%"><a href="mailto:info@unma.ac.id"><i class="fa fa-envelope mr-2"></i> info@unma.ac.id</a></li>
	                    </ul>
	                </div>
	                <div class="col-md-4">
	                    <h4>Navigasi MBKM Kemdikbud</h4>
	                    <ul>
	                        <li class="pull-left"><a href="https://kampusmerdeka.kemdikbud.go.id/">Beranda</a></li>
	                        <li class="pull-left"><a href="https://kampusmerdeka.kemdikbud.go.id/web/about">Tentang Kami</a></li>
	                        <li class="pull-left"><a href="https://kampusmerdeka.kemdikbud.go.id/news">Berita</a></li>
	                        <li class="pull-left"><a href="https://kampusmerdeka.kemdikbud.go.id/announcement">Pengumuman</a></li>
	                        <li class="pull-left"><a href="https://sites.google.com/wartek.belajar.id/faqmahasiswakm/home">FAQ</a></li>
	                        <li class="pull-left"><a href="https://kampusmerdeka.kemdikbud.go.id/program">Program</a></li>
	                        <li class="pull-left"><a href="https://kampusmerdeka.kemdikbud.go.id/register">Daftar</a></li>
	                    </ul>
	                </div>
	                <div class="col-md-4">
	                    <h4>Portal Tautan Eksternal</h4>
	                    <ul>
	                        <li class="pull-left"><a href="https://unma.ac.id" target="_blank"><i class="fa fa-link mr-2"></i>UNMA</a></li>
	                        <li class="pull-left"><a href="https://pmb.unma.ac.id"><i class="fa fa-link mr-2"></i>PMB UNMA</a></li>
	                        <li class="pull-left"><a href="https://satu.unma.ac.id"><i class="fa fa-link mr-2"></i>SATU UNMA</a></li>
	                        <li class="pull-left"><a href="https://kampusmerdeka.kemdikbud.go.id/"><i class="fa fa-link mr-2"></i>Kampus Merdeka</a></li>
	                        <li class="pull-left"><a href="https://mitra.kampusmerdeka.kemdikbud.go.id/"><i class="fa fa-link mr-2"></i>Mitra Kampus Merdeka</a></li>
	                    </ul>
	                </div>
	            </div>
	            <div class="row wed-foot-link-1">
	                <div class="col-md-12 foot-tc-mar-t-o">
	                    <p>&copy; 2022 Universitas Majalengka. All Right Reserved.</p>
	                </div>
	            </div>
	        </div>
	    </section>

	    <!--SECTION LOGIN, REGISTER AND FORGOT PASSWORD-->
	    <section>
	        <!-- LOGIN SECTION -->
	        <div id="modal1" class="modal fade" role="dialog">
	            <div class="log-in-pop">
	                <div class="log-in-pop-left text-center">
	                	<img src="https://i0.wp.com/unma.ac.id/wp-content/uploads/2020/02/logo_mono.png?w=917&ssl=1" style="filter: brightness(0) invert(1);" width="40%" alt="" />
	                    <p>
	                    	<br>
	                    	<b>Universitas Majalengka</b> <br>
	                    	<i>"Bernas Karena Kualitas"</i>
	                    	<br>
	                    </p>
	                </div>
	                <div class="log-in-pop-right">
	                    <a href="#" class="pop-close" data-dismiss="modal"><img src="<?= base_url() ?>assets/images/cancel.png" alt="" />
	                    </a>
	                    <h4>Masuk</h4>
	                    <a href="https://satu.unma.ac.id" class="btn btn-primary btn-block"><i class="fa fa-user mr-2"></i> Sign In - SATU UNMA</a>
	                    <a href="https://satu.unma.ac.id/forgot" class="btn btn-info btn-block mt-4"><i class="fa fa-key mr-2"></i>  Lupa Kata Sandi</a>
	                    <a href="https://satu.unma.ac.id/help.html" class="btn btn-danger btn-block mt-4"><i class="fa fa-info-circle mr-2"></i>  Informasi Login</a>
	                    <hr>
	                    <div class="text-center show">
	                        <div class="input-field s12">Menu Program Kampus Merdeka Belum Ada  ?  <br><a href="<?= base_url('daftar') ?>" class="text-info"><b>Daftar Disini</b></a> </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </section>

	    <!--Import jQuery before materialize.js-->
	    <!-- <script src="<?= base_url() ?>assets/js/main.min.js"></script> -->
		<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>  
	    <script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
	    <script src="<?= base_url() ?>assets/js/materialize.min.js"></script>
	    <script src="<?= base_url() ?>assets/js/custom.js"></script>
	</body>
</html>