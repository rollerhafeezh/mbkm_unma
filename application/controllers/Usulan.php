<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//use \Firebase\JWT\JWT;

class Usulan extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		// if(empty($_SESSION['logged_in']) or $_SESSION['logged_in']==FALSE){ redirect ('https://mbkm.unma.ac.id');}
	}

	public function print_usulan()
	{
		$usulan = json_decode($this->curl->simple_get(ADD_API.'aktivitas/usulan?id_kat_mk=3&id_mahasiswa_pt='.$_SESSION['id_user']));

		print_r(ADD_API.'aktivitas/usulan?id_kat_mk=3&id_mahasiswa_pt='.$_SESSION['id_user']);
	}
	
	public function index()
	{
		if(empty($_SESSION['logged_in']) or $_SESSION['logged_in']==FALSE){ redirect ('https://mbkm.unma.ac.id');}
		$data['title']	='Program Kampus Merdeka';
		$data['view']	='usulan/index';

		$data['aktivitas_mahasiswa'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/anggota?mbkm=1&id_mahasiswa_pt='.$_SESSION['id_user']));
		$data['detail'] = json_decode($this->curl->simple_get(ADD_API.'mbkm/mahasiswa_pt?id_mahasiswa_pt='.$_SESSION['id_user']))[0];

		$this->load->view('lyt/index', $data);
	}

	public function logbook ($id_aktivitas='')
	{
		$data['title']	='Logbook Kampus Merdeka';
		$data['view']	='logbook/index';
		$data['head']	= [ '<link rel="stylesheet" type="text/css" href="https://pixinvent.com/modern-admin-clean-bootstrap-4-dashboard-html-template/app-assets/css/pages/timeline.min.css">', 
							'<link href="https://cdn.jsdelivr.net/gh/univmajalengka/cdn@master/themes/vendors/css/tables/datatable/datatables.min.css" rel="stylesheet">',
							'<script src="https://cdn.ckeditor.com/4.16.0/basic/ckeditor.js"></script>'
						];
		$data['footer'] = [ 
							'<script src="'.base_url('assets/js/timeago/timeago.full.min.js').'"></script>', '<script src="https://cdn.jsdelivr.net/gh/univmajalengka/cdn@master/themes/vendors/js/tables/datatable/datatables.min.js"></script> '
						  ];

	  	$data['detail'] = json_decode($this->curl->simple_get(ADD_API.'mbkm/mahasiswa_pt?id_mahasiswa_pt='.$_SESSION['id_user']))[0];
		$data['aktivitas_mahasiswa'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/anggota?mbkm=1&id_aktivitas='.$id_aktivitas))[0];

		if (!$data['aktivitas_mahasiswa']){
			echo '<img src="'.base_url('assets/images/404.jpg').'" width="100%">'; exit;
		}
		$data['pembimbing'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/pembimbing?id_aktivitas='.$data['aktivitas_mahasiswa']->id_aktivitas));
		$data['koordinator'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/koordinator?id_aktivitas='.$data['aktivitas_mahasiswa']->id_aktivitas));
		$data['anggota']	= json_decode($this->curl->simple_get(ADD_API.'aktivitas/anggota?id_aktivitas='.$id_aktivitas)) ?: [];

		$this->load->view('lyt/index', $data);
	}

	public function laporan ($id_aktivitas='')
	{
		$data['title']	='Laporan Kampus Merdeka';
		$data['view']	='logbook/laporan';
		$data['head']	= [ '<link rel="stylesheet" type="text/css" href="https://pixinvent.com/modern-admin-clean-bootstrap-4-dashboard-html-template/app-assets/css/pages/timeline.min.css">', 
							'<link href="https://cdn.jsdelivr.net/gh/univmajalengka/cdn@master/themes/vendors/css/tables/datatable/datatables.min.css" rel="stylesheet">',
							'<script src="https://cdn.ckeditor.com/4.16.0/basic/ckeditor.js"></script>'
						];
		$data['footer'] = [ 
							'<script src="'.base_url('assets/js/timeago/timeago.full.min.js').'"></script>', '<script src="https://cdn.jsdelivr.net/gh/univmajalengka/cdn@master/themes/vendors/js/tables/datatable/datatables.min.js"></script> '
						  ];

	  	$data['detail'] = json_decode($this->curl->simple_get(ADD_API.'mbkm/mahasiswa_pt?id_mahasiswa_pt='.$_SESSION['id_user']))[0];
		$data['aktivitas_mahasiswa'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/anggota?mbkm=1&id_aktivitas='.$id_aktivitas))[0];

		if (!$data['aktivitas_mahasiswa']){
			echo '<img src="'.base_url('assets/images/404.jpg').'" width="100%">'; exit;
		}
		$data['pembimbing'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/pembimbing?id_aktivitas='.$data['aktivitas_mahasiswa']->id_aktivitas));
		$data['koordinator'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/koordinator?id_aktivitas='.$data['aktivitas_mahasiswa']->id_aktivitas));
		$data['anggota']	= json_decode($this->curl->simple_get(ADD_API.'aktivitas/anggota?id_aktivitas='.$id_aktivitas)) ?: [];

		$this->load->view('lyt/index', $data);
	}

	public function riwayat_logbook($id_aktivitas='', $jenis_logbook='', $id_kegiatan='')
	{
		$id_kegiatan = $id_kegiatan == '' ? '' : '&id_kegiatan='.$id_kegiatan;

		$data['id_aktivitas'] = $id_aktivitas;
		$data['logbook']	= json_decode($this->curl->simple_get(ADD_API.'mbkm/riwayat_logbook?level_name=Dosen&id_aktivitas='.$id_aktivitas.'&jenis_logbook='.$jenis_logbook.$id_kegiatan)) ?: [];

		$this->load->view('logbook/riwayat', $data);
	}

	public function sse()
	{
		header("Content-Type: text/event-stream");
		header("Cache-Control: no-cache");
		header("Connection: keep-alive");

		$time = date('r');
		echo "data: The server time is: {$time}\n\n";
		// ob_end_flush();
		flush();
	}

	public function masukkan_judul()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$id_aktivitas = $this->input->post('id_aktivitas');
			$judul = urlencode(trim(preg_replace( "/\r|\n/", "", strip_tags($this->input->post('judul')))));
			$judul_en = urlencode(trim(preg_replace( "/\r|\n/", "", strip_tags($this->input->post('judul_en')))));

			$masukkan_judul = json_decode($this->curl->simple_get(ADD_API.'aktivitas/masukkan_judul?id_aktivitas='.$id_aktivitas.'&judul='.$judul.'&judul_en='.$judul_en));
			echo json_encode($masukkan_judul);
			exit;
		}

		$data['title']	='Masukkan Judul ';
		$data['usulan'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/usulan?id_kat_mk=3&id_mahasiswa_pt='.$_SESSION['id_user']));
		$data['view']	='usulan/masukkan-judul';
		$data['footer']	= [ 
							'<script src="'.CDN.'themes/vendors/js/editors/tinymce/tinymce.min.js"></script>',
							"<script>
								tinymce.init({
									selector: '.judul',
									height: 150,
									force_br_newlines : true,
  									force_p_newlines : true,
									toolbar_items_size : 'small',
									plugins: [ 'charmap', 'searchreplace' ],
									toolbar1: 'undo redo | copy paste | bold italic underline | subscript superscript | charmap',
									setup: function (editor) {
										editor.on('keydown', function (e) {
											if (e.keyCode === 13) {
												console.log('prevent default');
												e.preventDefault();
											}
										});
									},
									content_css: [
										'//www.tinymce.com/css/codepen.min.css'
									]
								});
							</script>"
						  ];

		$data['detail'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/mahasiswa_pt?id_mahasiswa_pt='.$_SESSION['id_user']))[0];
		$data['usulan'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/usulan?id_kat_mk=3&id_mahasiswa_pt='.$_SESSION['id_user']));
		$data['aktivitas_mahasiswa'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/anggota?id_jenis_aktivitas_mahasiswa=6&id_mahasiswa_pt='.$_SESSION['id_user']));

		$this->load->view('lyt/index', $data);
	}

	public function atur_lokasi()
	{
		if (isset($_POST['lokasi'])) {
			$id_aktivitas = $this->input->post('id_aktivitas');
			// $lokasi = strip_tags(stripslashes($this->input->post('lokasi')));
			$lokasi = urlencode(trim(preg_replace( "/\r|\n/", "", strip_tags($this->input->post('lokasi')))));

			$atur_lokasi = json_decode($this->curl->simple_get(ADD_API.'aktivitas/atur_lokasi?id_aktivitas='.$id_aktivitas.'&lokasi='.$lokasi));
			echo json_encode($atur_lokasi);
			exit;
		}

		$data['title']	='Lokasi ';
		$data['usulan'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/usulan?id_kat_mk=3&id_mahasiswa_pt='.$_SESSION['id_user']));
		$data['view']	='usulan/atur-lokasi';
		$data['footer']	= [ 
							'<script src="'.CDN.'themes/vendors/js/editors/tinymce/tinymce.min.js"></script>',
							"<script>
								tinymce.init({
									selector: '.lokasi',
									height: 150,
									forced_root_block : '',
									force_br_newlines : true,
  									force_p_newlines : true,
  									force_p_newlines : false,
									toolbar_items_size : 'small',
									plugins: [ 'charmap', 'searchreplace' ],
									toolbar1: 'undo redo | copy paste | bold italic underline | subscript superscript | charmap',
									setup: function (editor) {
										editor.on('keydown', function (e) {
											if (e.keyCode === 13) {
												console.log('prevent default');
												e.preventDefault();
											}
										});
									},
									content_css: [
										'//www.tinymce.com/css/codepen.min.css'
									]
								});
							</script>"
						  ];

		$data['detail'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/mahasiswa_pt?id_mahasiswa_pt='.$_SESSION['id_user']))[0];
		$data['aktivitas_mahasiswa'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/anggota?id_jenis_aktivitas_mahasiswa=6&id_mahasiswa_pt='.$_SESSION['id_user']));
		$data['usulan'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/usulan?id_kat_mk=3&id_mahasiswa_pt='.$_SESSION['id_user']));

		$this->load->view('lyt/index', $data);
	}

	public function upload($id_kat_berkas='')
	{	
		if ($id_kat_berkas == '') {
			redirect('usulan','refresh');
		}

		$title = json_decode($this->curl->simple_get(ADD_API.'aktivitas/berkas?id_kat_berkas='.$id_kat_berkas))[0];

		$data['detail'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/mahasiswa_pt?id_mahasiswa_pt='.$_SESSION['id_user']))[0];
		$data['usulan'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/usulan?id_kat_mk=3&id_mahasiswa_pt='.$_SESSION['id_user']));
		
		$data['title']  = $data['detail']->id_mahasiswa_pt.'_'.$data['detail']->nm_pd.'_'.$title->nama_kategori.' '.$data['usulan'][0]->nm_mk.'.pdf';

		// $data['title']  = $title->nama_kategori.' '.$data['usulan'][0]->nm_mk.' ('.$data['detail']->nm_pd.' - '.$data['detail']->id_mahasiswa_pt.').pdf';

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$config['upload_path']          = './berkas/kp/';
		    $config['allowed_types']        = 'pdf|ppt|pptx';
		    $config['file_name']            = $data['title'];
		    $config['overwrite']			= true;
		    $config['max_size']             = 10240; // 1MB

		    $this->load->library('upload', $config);

		    if ($this->upload->do_upload('berkas')) {
		        $data = [
		    		'id_kat_berkas' => $id_kat_berkas,
		    		'id_jenis_aktivitas_mahasiswa' => '6',
		    		'id_mahasiswa_pt' => $_SESSION['id_user'],
		    		'berkas' => $this->upload->data("file_name"),
		    		'upload_by' => $_SESSION['id_user']
		    	];

		        $this->curl->simple_post(ADD_API.'aktivitas/upload', $data);

		        redirect('usulan','refresh');
		    } else {
		    	echo $this->upload->display_errors();
		    }

 			// print_r($_FILES);
			exit;
		}

		$data['title']	='Upload Berkas '.$title->nama_kategori;
		$data['id_kat_berkas'] = $id_kat_berkas;
		$data['nama_kategori'] = $title->nama_kategori;

		$data['view']	='usulan/upload';
		$data['footer']	= [ 
							"<script>
								$('.custom-file input').change(function (e) {
							      $(this).next('.custom-file-label').html(e.target.files[0].name);
							      var src = URL.createObjectURL(event.target.files[0]);
							      var obj = document.querySelector('object');
							      obj.data = src
							  });
							</script>"
						  ];

		$this->load->view('lyt/index', $data);
	}

	public function pendaftaran($id_user='') {
		if ($id_user != '') {
			$_SESSION['id_user'] = $id_user;
		}

		$data['detail'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/mahasiswa_pt?id_mahasiswa_pt='.$_SESSION['id_user']))[0];
		$data['usulan'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/usulan?id_kat_mk=3&id_mahasiswa_pt='.$_SESSION['id_user']));
		// print_r(ADD_API.'aktivitas/usulan?id_kat_mk=3&id_mahasiswa_pt='.$_SESSION['id_user']);
		// exit;
		$data['title'] = 'Pendaftaran '.$data['usulan'][0]->nm_mk.' ('.$_SESSION['nama_user'].')';

		$mpdf = new \Mpdf\Mpdf([ 'mode'=>'utf-8', 'format'=>'FOLIO' ]);
		$html = $this->load->view('usulan/pendaftaran', $data, true);
		$mpdf->writeHTML(utf8_encode($html));
		$mpdf->SetHTMLFooter('
			<table width="100%" style="font-size:9pt;">
				<tr>
					<td width="50%" align="right"><i>Berkas ini dicetak oleh UNMAKU pada tanggal {DATE d/m/Y h:i:s}</i></td>
				</tr>
			</table>
		');

		$mpdf->output($data['title'].'.pdf', 'I');
	}

	public function pendaftaran_seminar($id_user='') {
		if ($id_user != '') {
			$_SESSION['id_user'] = $id_user;
		}

		$data['detail'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/mahasiswa_pt?id_mahasiswa_pt='.$_SESSION['id_user']))[0];
		$data['usulan'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/usulan?id_kat_mk=3&id_mahasiswa_pt='.$_SESSION['id_user']));
		$data['title'] = 'Pendaftaran Seminar '.$data['usulan'][0]->nm_mk.' ('.$_SESSION['nama_user'].')';

		$data['aktivitas_mahasiswa'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/anggota?id_jenis_aktivitas_mahasiswa=6&id_mahasiswa_pt='.$_SESSION['id_user']));
		$data['pembimbing'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/pembimbing?id_aktivitas='.$data['aktivitas_mahasiswa'][0]->id_aktivitas));

		$mpdf = new \Mpdf\Mpdf([ 'mode'=>'utf-8', 'format'=>'FOLIO' ]);
		$html = $this->load->view('usulan/pendaftaran-seminar', $data, true);
		$mpdf->writeHTML(utf8_encode($html));
		$mpdf->SetHTMLFooter('
			<table width="100%" style="font-size:9pt;">
				<tr>
					<td width="50%" align="right"><i>Berkas ini dicetak oleh UNMAKU pada tanggal {DATE d/m/Y h:i:s}</i></td>
				</tr>
			</table>
		');

		$mpdf->output($data['title'].'.pdf', 'I');
	}

	public function berita_acara($id_user='') {
		if ($id_user != '') {
			$_SESSION['id_user'] = $id_user;
			$_SESSION['nama_smt'] = $_REQUEST['nama_smt'];
			$data['data'] = isset($_REQUEST['data']) ? $_REQUEST['data'] : 0;

			if ($data['data'] == 1) {
				$berita_acara = json_decode($this->curl->simple_get(ADD_API.'aktivitas/berkas?id_jenis_aktivitas_mahasiswa=6&jenis_aktivitas=kp&id_kat_berkas=4&id_mahasiswa_pt='.$_SESSION['id_user']))[0];
				
				if ($berita_acara->berkas != '') {
					redirect('berkas/kp/'.$berita_acara->berkas,'refresh');
					exit;
				}

				$anggota = json_decode($this->curl->simple_get(ADD_API.'aktivitas/anggota?id_jenis_aktivitas_mahasiswa=6&id_mahasiswa_pt='.$_SESSION['id_user']));

				$data['nilai_pembimbing'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/get_nilai?id_kegiatan='.$_REQUEST['id_kegiatan'].'&jenis_nilai=1&id_anggota='.$anggota['0']->id_anggota.'&id_aktivitas='.$anggota[0]->id_aktivitas));
				$data['nilai_penguji'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/get_nilai?id_kegiatan='.$_REQUEST['id_kegiatan'].'&jenis_nilai=2&id_anggota='.$anggota['0']->id_anggota.'&id_aktivitas='.$anggota[0]->id_aktivitas));
				$data['nilai_ketua_sidang'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/get_nilai?id_kegiatan='.$_REQUEST['id_kegiatan'].'&jenis_nilai=3&id_anggota='.$anggota['0']->id_anggota.'&id_aktivitas='.$anggota[0]->id_aktivitas));
				
				$data['nilai'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/get_nilai?id_kegiatan='.$_REQUEST['id_kegiatan'].'&id_anggota='.$anggota['0']->id_anggota.'&id_aktivitas='.$anggota[0]->id_aktivitas));

				if (count($data['nilai']) < 1) {
					echo "<b>Informasi</b> Belum ada dosen yang memasukkan nilai! <br> <a href='https://pkl.unma.ac.id/usulan/berita_acara/$_SESSION[id_user]?id_kegiatan=2&nama_smt=$_SESSION[nama_smt]'>Klik Disini</a> untuk meng-unduh format berita acara.";
					exit;
				}
			} else {
				$data['nilai_pembimbing'] = [];
				$data['nilai_penguji'] = [];
				$data['nilai_ketua_sidang'] = [];
				$data['nilai'] = [];
			}
		} else {
			$data['data'] = 0;
		}

		$data['detail'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/mahasiswa_pt?id_mahasiswa_pt='.$_SESSION['id_user']))[0];
		$_SESSION['nama_user'] = $data['detail']->nm_pd;

		$data['usulan'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/usulan?id_kat_mk=3&id_mahasiswa_pt='.$_SESSION['id_user']));
		$data['aktivitas_mahasiswa'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/anggota?id_jenis_aktivitas_mahasiswa=6&id_mahasiswa_pt='.$_SESSION['id_user']));
		$data['pembimbing'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/pembimbing?id_aktivitas='.$data['aktivitas_mahasiswa'][0]->id_aktivitas));
		$data['penguji']	= json_decode($this->curl->simple_get(ADD_API.'aktivitas/penguji?id_aktivitas='.$data['aktivitas_mahasiswa'][0]->id_aktivitas.'&id_kegiatan='.$_REQUEST['id_kegiatan'])) ?: [];

		$penjadwalan	= json_decode($this->curl->simple_get(ADD_API.'aktivitas/penjadwalan?id_kegiatan='.$_REQUEST['id_kegiatan'].'&id_aktivitas='.$data['aktivitas_mahasiswa'][0]->id_aktivitas));

		if (count($penjadwalan) > 0) {
			$data['penjadwalan'] = $penjadwalan[0];
		} else {
			echo "Jadwal Seminar / Sidang Belum Di Input !!!";
			exit;
		}
		
		$data['title'] = 'Berita Acara '.$data['usulan'][0]->nm_mk.' ('.$_SESSION['nama_user'].')';
		$mpdf = new \Mpdf\Mpdf([ 'mode'=>'utf-8', 'format'=>'FOLIO' ]);
		
		$berita_acara = $this->load->view('usulan/berita-acara', $data, true);
		$mpdf->writeHTML(utf8_encode($berita_acara));

		$mpdf->SetHTMLFooter('
			<table width="100%" style="font-size:9pt;">
				<tr>
					<td width="50%" align="right"><i>Berkas ini dicetak oleh UNMAKU pada tanggal {DATE d/m/Y h:i:s}</i></td>
				</tr>
			</table>
		');
		
		$mpdf->addPage();
		$form_penilaian = $this->load->view('usulan/form-penilaian', $data, true);
		$mpdf->writeHTML(utf8_encode($form_penilaian));

		$mpdf->SetHTMLFooter('
			<table width="100%" style="font-size:9pt;">
				<tr>
					<td width="50%" align="right"><i>Berkas ini dicetak oleh UNMAKU pada tanggal {DATE d/m/Y h:i:s}</i></td>
				</tr>
			</table>
		');

		$mpdf->addPage();
		$catata_revisi_pembimbing = $this->load->view('usulan/catatan-revisi-pembimbing', $data, true);
		$mpdf->writeHTML(utf8_encode($catata_revisi_pembimbing));

		$mpdf->SetHTMLFooter('
			<table width="100%" style="font-size:9pt;">
				<tr>
					<td width="50%" align="right"><i>Berkas ini dicetak oleh UNMAKU pada tanggal {DATE d/m/Y h:i:s}</i></td>
				</tr>
			</table>
		');

		if (count($data['penguji']) > 0) {
			$mpdf->addPage();
			$catata_revisi_penguji = $this->load->view('usulan/catatan-revisi-penguji', $data, true);
			$mpdf->writeHTML(utf8_encode($catata_revisi_penguji));

			$mpdf->SetHTMLFooter('
			<table width="100%" style="font-size:9pt;">
				<tr>
					<td width="50%" align="right"><i>Berkas ini dicetak oleh UNMAKU pada tanggal {DATE d/m/Y h:i:s}</i></td>
				</tr>
			</table>
		');
		}

		if ($data['pembimbing'][0]->nidn != $data['penjadwalan']->nidn) {
			$mpdf->addPage();
			$catatan_revisi_ketua_sidang = $this->load->view('usulan/catatan-revisi-ketua-sidang', $data, true);
			$mpdf->writeHTML(utf8_encode($catatan_revisi_ketua_sidang));

			$mpdf->SetHTMLFooter('
			<table width="100%" style="font-size:9pt;">
				<tr>
					<td width="50%" align="right"><i>Berkas ini dicetak oleh UNMAKU pada tanggal {DATE d/m/Y h:i:s}</i></td>
				</tr>
			</table>
		');
		}
		
		$mpdf->addPage();
		$daftar_hadir_peserta = $this->load->view('usulan/daftar-hadir-peserta', $data, true);
		$mpdf->writeHTML(utf8_encode($daftar_hadir_peserta));

		$mpdf->SetHTMLFooter('
			<table width="100%" style="font-size:9pt;">
				<tr>
					<td width="50%" align="right"><i>Berkas ini dicetak oleh UNMAKU pada tanggal {DATE d/m/Y h:i:s}</i></td>
				</tr>
			</table>
		');

		$mpdf->output($data['title'].'.pdf', 'I');
	}

	public function daftar_hadir_peserta($id_user='') {
		if ($id_user != '') {
			$_SESSION['id_user'] = $id_user;
			$_SESSION['nama_smt'] = $_REQUEST['nama_smt'];
		}

		$data['detail'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/mahasiswa_pt?id_mahasiswa_pt='.$_SESSION['id_user']))[0];
		$data['usulan'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/usulan?id_kat_mk=3&id_mahasiswa_pt='.$_SESSION['id_user']));
		$data['aktivitas_mahasiswa'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/anggota?id_jenis_aktivitas_mahasiswa=6&id_mahasiswa_pt='.$_SESSION['id_user']));
		$data['pembimbing'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/pembimbing?id_aktivitas='.$data['aktivitas_mahasiswa'][0]->id_aktivitas));
		$data['penguji']	= json_decode($this->curl->simple_get(ADD_API.'aktivitas/penguji?id_aktivitas='.$data['aktivitas_mahasiswa'][0]->id_aktivitas)) ?: [];
		$data['penjadwalan']	= json_decode($this->curl->simple_get(ADD_API.'aktivitas/penjadwalan?id_aktivitas='.$data['aktivitas_mahasiswa'][0]->id_aktivitas))[0];

		$data['title'] = 'Daftar Hadir Peserta Seminar '.$data['usulan'][0]->nm_mk.' ('.$_SESSION['nama_user'].')';
		$mpdf = new \Mpdf\Mpdf([ 'mode'=>'utf-8', 'format'=>'FOLIO' ]);
		
		$daftar_hadir_peserta = $this->load->view('usulan/daftar-hadir-peserta', $data, true);
		$mpdf->writeHTML(utf8_encode($daftar_hadir_peserta));
		
		$mpdf->SetHTMLFooter('
			<table width="100%" style="font-size:9pt;">
				<tr>
					<td width="50%" align="right"><i>Berkas ini dicetak oleh UNMAKU pada tanggal {DATE d/m/Y h:i:s}</i></td>
				</tr>
			</table>
		');

		$mpdf->output($data['title'].'.pdf', 'I');
	}

	public function laporan_kemajuan($id_user='') {
		if ($id_user != '') {
			$_SESSION['id_user'] = $id_user;
		}

		$data['detail'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/mahasiswa_pt?id_mahasiswa_pt='.$_SESSION['id_user']))[0];
		$data['usulan'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/usulan?id_kat_mk=3&id_mahasiswa_pt='.$_SESSION['id_user']));
		$data['title'] = ($data['usulan'][0]->nm_mk == 'Kerja Praktek' ? 'Laporan Kemajuan ' : 'Jurnal ').$data['usulan'][0]->nm_mk.' ('.$_SESSION['nama_user'].')';
		$data['aktivitas_mahasiswa'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/anggota?id_jenis_aktivitas_mahasiswa=6&id_mahasiswa_pt='.$_SESSION['id_user']));
		$data['pembimbing'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/pembimbing?id_aktivitas='.$data['aktivitas_mahasiswa'][0]->id_aktivitas));

		$mpdf = new \Mpdf\Mpdf([ 'mode'=>'utf-8', 'format'=>'FOLIO' ]);
		$html = $this->load->view('usulan/laporan-kemajuan', $data, true);
		$mpdf->writeHTML(utf8_encode($html));
		$mpdf->SetHTMLFooter('
			<table width="100%" style="font-size:9pt;">
				<tr>
					<td width="50%" align="right"><i>Berkas ini dicetak oleh UNMAKU pada tanggal {DATE d/m/Y h:i:s}</i></td>
				</tr>
			</table>
		');

		$mpdf->output($data['title'].'.pdf', 'I');
	}

	public function bukti_penyerahan_laporan($id_user='') {
		if ($id_user != '') {
			$_SESSION['id_user'] = $id_user;
		}

		$data['detail'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/mahasiswa_pt?id_mahasiswa_pt='.$_SESSION['id_user']))[0];
		$data['usulan'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/usulan?id_kat_mk=3&id_mahasiswa_pt='.$_SESSION['id_user']));
		$data['title'] = 'Bukti Penyerahan Laporan '.$data['usulan'][0]->nm_mk.' ('.$_SESSION['nama_user'].')';
		$data['aktivitas_mahasiswa'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/anggota?id_jenis_aktivitas_mahasiswa=6&id_mahasiswa_pt='.$_SESSION['id_user']));

		$mpdf = new \Mpdf\Mpdf([ 'mode'=>'utf-8', 'format'=>'FOLIO' ]);
		$html = $this->load->view('usulan/bukti-penyerahan-laporan', $data, true);
		$mpdf->writeHTML(utf8_encode($html));
		$mpdf->SetHTMLFooter('
			<table width="100%" style="font-size:9pt;">
				<tr>
					<td width="50%" align="right"><i>Berkas ini dicetak oleh UNMAKU pada tanggal {DATE d/m/Y h:i:s}</i></td>
				</tr>
			</table>
		');
		$mpdf->output($data['title'].'.pdf', 'I');
	}
}