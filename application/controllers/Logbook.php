<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//use \Firebase\JWT\JWT;

class Logbook extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		if(empty($_SESSION['logged_in']) or $_SESSION['logged_in']==FALSE){ redirect ('https://satu.unma.ac.id');}
	}

	public function index ($id_aktivitas='')
	{
		echo $id_aktivitas; exit;
		$data['title']	='Logbook Kampus Merdeka';
		$data['view']	='logbook/index';
		$data['head']	= [ '<link rel="stylesheet" type="text/css" href="https://pixinvent.com/modern-admin-clean-bootstrap-4-dashboard-html-template/app-assets/css/pages/timeline.min.css">' ];
		$data['footer'] = [ 
							'<script src="'.base_url('assets/js/timeago/timeago.full.min.js').'"></script>'
						  ];

		$data['usulan'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/usulan?id_kat_mk=3&id_mahasiswa_pt='.$_SESSION['id_user']));
		$data['detail'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/mahasiswa_pt?id_mahasiswa_pt='.$_SESSION['id_user']))[0];
		$data['aktivitas_mahasiswa'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/anggota?id_jenis_aktivitas_mahasiswa=6&id_mahasiswa_pt='.$_SESSION['id_user']));
		
		$data['pembimbing'] = [];
		if (count($data['aktivitas_mahasiswa']) > 0) {
			$data['pembimbing'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/pembimbing?id_aktivitas='.$data['aktivitas_mahasiswa'][0]->id_aktivitas));
		}

		$data['anggota']	= json_decode($this->curl->simple_get(ADD_API.'aktivitas/anggota?id_aktivitas='.$data['aktivitas_mahasiswa'][0]->id_aktivitas)) ?: [];
		$data['penjadwalan']	= json_decode($this->curl->simple_get(ADD_API.'aktivitas/penjadwalan?id_aktivitas='.$data['aktivitas_mahasiswa'][0]->id_aktivitas)) ?: [];
		// $data['bimbingan']	= json_decode($this->curl->simple_get(ADD_API.'aktivitas/bimbingan?level_name=Dosen&id_aktivitas='.$data['aktivitas_mahasiswa'][0]->id_aktivitas.'&jenis_bimbingan=2')) ?: [];

		$this->load->view('lyt/index', $data);
	}

	public function detail($id_bimbingan, $act = null)
	{
		$data['bimbingan'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/bimbingan?id_bimbingan='.$id_bimbingan))[0];
		
		if ($act == 'edit') {
			echo json_encode($data['bimbingan']); exit;
		}

		$this->load->view('logbook/detail_logbook', $data);
	}

	public function detail_laporan($id_laporan, $act = null)
	{
		$data['laporan'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/laporan?id_laporan='.$id_laporan))[0];
		
		if ($act == 'edit') {
			echo json_encode($data['laporan']); exit;
		}

		$this->load->view('logbook/detail_laporan', $data);
	}

	public function logbook_pembimbing($id_user='') {
		if ($id_user != '') {
			$_SESSION['id_user'] = $id_user;
		}

		$data['detail'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/mahasiswa_pt?id_mahasiswa_pt='.$_SESSION['id_user']))[0];
		$data['usulan'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/usulan?id_kat_mk=3&id_mahasiswa_pt='.$_SESSION['id_user']));
		$data['title'] = ($data['usulan'][0]->nm_mk == 'Kerja Praktek' ? 'Laporan Kemajuan ' : 'Jurnal ').$data['usulan'][0]->nm_mk.' ('.$_SESSION['nama_user'].')';
		$data['aktivitas_mahasiswa'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/anggota?id_jenis_aktivitas_mahasiswa=6&id_mahasiswa_pt='.$_SESSION['id_user']));
		$data['pembimbing'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/pembimbing?id_aktivitas='.$data['aktivitas_mahasiswa'][0]->id_aktivitas));
		$data['penguji'] = [];
		if (count($data['aktivitas_mahasiswa']) > 0) {
			$data['penguji'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/penguji?id_aktivitas='.$data['aktivitas_mahasiswa'][0]->id_aktivitas));
		}
		$data['bimbingan'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/bimbingan?jenis_bimbingan=1&id_kegiatan=00&id_aktivitas='.$data['aktivitas_mahasiswa'][0]->id_aktivitas));

		$mpdf = new \Mpdf\Mpdf([ 'mode'=>'utf-8', 'format'=>'FOLIO' ]);
		$html = $this->load->view('bimbingan/logbook-pembimbing', $data, true);
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

	public function logbook_penguji($id_user='') {
		if ($id_user != '') {
			$_SESSION['id_user'] = $id_user;
		}

		$data['detail'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/mahasiswa_pt?id_mahasiswa_pt='.$_SESSION['id_user']))[0];
		$data['usulan'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/usulan?id_kat_mk=3&id_mahasiswa_pt='.$_SESSION['id_user']));
		$data['title'] = 'Catatan Revisi '.$data['usulan'][0]->nm_mk.' ('.$_SESSION['nama_user'].')';
		
		$data['aktivitas_mahasiswa'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/anggota?id_jenis_aktivitas_mahasiswa=6&id_mahasiswa_pt='.$_SESSION['id_user']));
		$data['pembimbing'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/pembimbing?id_aktivitas='.$data['aktivitas_mahasiswa'][0]->id_aktivitas));
		$data['penguji'] = [];
		if (count($data['aktivitas_mahasiswa']) > 0) {
			$data['penguji'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/penguji?id_aktivitas='.$data['aktivitas_mahasiswa'][0]->id_aktivitas));
		}
		$data['bimbingan'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/bimbingan?jenis_bimbingan=2&id_aktivitas='.$data['aktivitas_mahasiswa'][0]->id_aktivitas));

		$mpdf = new \Mpdf\Mpdf([ 'mode'=>'utf-8', 'format'=>'FOLIO' ]);
		$html = $this->load->view('bimbingan/logbook-penguji', $data, true);
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

	public function dosen_penguji($id_aktivitas='')
	{
		$data['title']	='Bimbingan: Dosen Penguji';
		$data['view']	='bimbingan/dosen-penguji';
		$data['head']	= [ '<link rel="stylesheet" type="text/css" href="https://pixinvent.com/modern-admin-clean-bootstrap-4-dashboard-html-template/app-assets/css/pages/timeline.min.css">' ];
		$data['footer'] = [ 
							'<script src="https://pkl.unma.ac.id/assets/js/timeago/timeago.full.min.js"></script>'
						  ];

		$data['usulan'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/usulan?id_kat_mk=3&id_mahasiswa_pt='.$_SESSION['id_user']));
		$data['detail'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/mahasiswa_pt?id_mahasiswa_pt='.$_SESSION['id_user']))[0];
		
		$data['aktivitas_mahasiswa'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/anggota?id_jenis_aktivitas_mahasiswa=6&id_mahasiswa_pt='.$_SESSION['id_user']));
		$data['anggota']	= json_decode($this->curl->simple_get(ADD_API.'aktivitas/anggota?id_aktivitas='.$data['aktivitas_mahasiswa'][0]->id_aktivitas)) ?: [];


		$data['penguji'] = [];
		if (count($data['aktivitas_mahasiswa']) > 0) {
			$data['penguji'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/penguji?id_aktivitas='.$data['aktivitas_mahasiswa'][0]->id_aktivitas));
		}
		$data['penjadwalan']	= json_decode($this->curl->simple_get(ADD_API.'aktivitas/penjadwalan?id_aktivitas='.$data['aktivitas_mahasiswa'][0]->id_aktivitas)) ?: [];

		$this->load->view('lyt/index', $data);
	}

	public function ketua_sidang($id_aktivitas='')
	{
		$data['title']	='Bimbingan: Ketua Sidang';
		$data['view']	='bimbingan/ketua-sidang';
		$data['head']	= [ '<link rel="stylesheet" type="text/css" href="https://pixinvent.com/modern-admin-clean-bootstrap-4-dashboard-html-template/app-assets/css/pages/timeline.min.css">' ];
		$data['footer'] = [ 
							'<script src="https://pkl.unma.ac.id/assets/js/timeago/timeago.full.min.js"></script>'
						  ];

		$data['usulan'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/usulan?id_kat_mk=3&id_mahasiswa_pt='.$_SESSION['id_user']));
		$data['detail'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/mahasiswa_pt?id_mahasiswa_pt='.$_SESSION['id_user']))[0];
		
		$data['aktivitas_mahasiswa'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/anggota?id_jenis_aktivitas_mahasiswa=6&id_mahasiswa_pt='.$_SESSION['id_user']));
		$data['anggota']	= json_decode($this->curl->simple_get(ADD_API.'aktivitas/anggota?id_aktivitas='.$data['aktivitas_mahasiswa'][0]->id_aktivitas)) ?: [];


		$data['penguji'] = [];
		if (count($data['aktivitas_mahasiswa']) > 0) {
			$data['penguji'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/penguji?id_aktivitas='.$data['aktivitas_mahasiswa'][0]->id_aktivitas));
		}

		$data['pembimbing'] = [];
		if (count($data['aktivitas_mahasiswa']) > 0) {
			$data['pembimbing'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/pembimbing?id_aktivitas='.$data['aktivitas_mahasiswa'][0]->id_aktivitas));
		}

		$data['penjadwalan']	= json_decode($this->curl->simple_get(ADD_API.'aktivitas/penjadwalan?id_aktivitas='.$data['aktivitas_mahasiswa'][0]->id_aktivitas)) ?: [];

		if (count($data['penjadwalan']) > 0) {
			if ($data['penjadwalan'][0]->nidn == $data['pembimbing'][0]->nidn) {
				redirect('bimbingan/dosen_pembimbing','refresh');
			}
		}


		$this->load->view('lyt/index', $data);
	}

	public function aktivitas($jenis_bimbingan='')
	{
		$data['aktivitas_mahasiswa'] = json_decode($this->curl->simple_get(ADD_API.'aktivitas/anggota?id_jenis_aktivitas_mahasiswa=6&id_mahasiswa_pt='.$_SESSION['id_user']));
		$data['bimbingan']	= json_decode($this->curl->simple_get(ADD_API.'aktivitas/bimbingan?level_name=Dosen&revisi=2&id_aktivitas='.$data['aktivitas_mahasiswa'][0]->id_aktivitas.'&jenis_bimbingan='.$jenis_bimbingan)) ?: [];

		$this->load->view('bimbingan/aktivitas', $data);
	}

	public function sse()
	{
		header("Content-Type: text/event-stream");
		header("Cache-Control: no-cache");
		header("Connection: keep-alive");

		$time = date('r');
		echo "data: The server time is: {$time}\n\n";
		ob_end_flush();
		flush();
	}

	public function kirim($laporan = null)
	{
		date_default_timezone_set('Asia/Jakarta');

		$data = $this->input->post();
		$data['id_user'] = $_SESSION['id_user'];
		$data['nama_user'] = ucwords(strtolower($_SESSION['nama_user']));
		$data['level_name'] = ucwords(strtolower($_SESSION['level_name']));
		$data['created_at'] = date('Y-m-d H:i:s');
		// echo $data['isi'] = nl2br(htmlentities($data['isi'], ENT_QUOTES, 'UTF-8'));
		// exit;
		// $data['isi'] = urlencode($this->input->post('isi'));


		if($_FILES)  {
			$config['upload_path']          = './berkas/logbook';
		    $config['allowed_types']        = 'pdf|jpg|png|gif';
		    $config['overwrite']			= true;
		    $config['max_size']             = 5000; // 1MB

		    $this->load->library('upload', $config);

		    if ($this->upload->do_upload('file')) {
		    	$data['file'] = base_url('berkas/logbook/'.$this->upload->data('file_name'));
		    } else {
		    	echo $this->upload->display_errors();
		    }

		    if ($this->upload->do_upload('file_gambar')) {
		    	$data['file_gambar'] = base_url('berkas/logbook/'.$this->upload->data('file_name'));
		    } else {
		    	echo $this->upload->display_errors();
		    }
		}

		if ($laporan != null) {
			$data['laporan'] = '1';
		}

		$bimbingan  = json_decode($this->curl->simple_post(ADD_API.'aktivitas/bimbingan', $data));
		
		echo json_encode($data);
	}

	public function hapus()
	{
		if ($this->input->post('file') != '') {
			$file = explode('/', $this->input->post('file'));
			unlink('./berkas/bimbingan/'.$file[5]);
		}

		if ($this->input->post('id_laporan')) {
			$bimbingan  = json_decode($this->curl->simple_get(ADD_API.'aktivitas/hapus?id_laporan='.$this->input->post('id_laporan')));
		} else {
			$bimbingan  = json_decode($this->curl->simple_get(ADD_API.'aktivitas/hapus?id_bimbingan='.$this->input->post('id_bimbingan')));
		}
		
		print_r($bimbingan);
	}

	function json_bimbingan()
	{
		$bimbingan=json_decode($this->curl->simple_get(ADD_API.'datatable/bimbingan_mhs_mbkm?jenis_bimbingan=1&level_name=Mahasiswa&id_user='.$this->input->get('id_user').'&id_aktivitas='.$this->input->get('id_aktivitas')));
		echo json_encode($bimbingan);
	}

	function json_laporan()
	{
		$laporan=json_decode($this->curl->simple_get(ADD_API.'datatable/laporan_mhs_mbkm?level_name=Mahasiswa&id_user='.$this->input->get('id_user').'&id_aktivitas='.$this->input->get('id_aktivitas')));
		echo json_encode($laporan);
	}
}