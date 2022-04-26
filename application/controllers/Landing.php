<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Landing extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('encryption');
	}

	public function curl($url, $param='')
	{
		$ch = curl_init($url);

		# Setup request to send json via POST.
		if ($param != '') {
			$payload = json_encode($param);
			curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
			curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		}
		
		# Return response instead of printing.
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		# Send request.
		$result = curl_exec($ch);
		curl_close($ch);
		# Print response.
		return $result;
	}

	public function index()
	{
		$data['title']	= '';
		$data['view']	= 'landing/index';
		$data['pengumuman'] = json_decode($this->curl('https://api.kampusmerdeka.kemdikbud.go.id/mbkm/news/pengumuman?limit=4'));

		$this->load->view('landing/template', $data);
	}

	public function program()
	{
		$data['title']	= '';
		$data['view']	= 'landing/program';
		$data['program'] = json_decode($this->curl('https://api.kampusmerdeka.kemdikbud.go.id/mbkm/program'));

		$this->load->view('landing/template', $data);
	}

	public function daftar()
	{
		if (!isset($_SESSION['logged_in'])) {
			$data['title']	= '';
			$data['view']	= 'landing/daftar';

			$data['fakultas'] = json_decode($this->curl->simple_get(ADD_API.'ref/fakultas'));
			$active_smt = json_decode($this->curl->simple_get(ADD_API.'ref/smt?id_smt=active'))[0];
			$data['smt'] = json_decode($this->curl->simple_get(ADD_API.'ref/smt?id_smt=next&id_semester='.(substr($active_smt->id_semester, -1) == '2' ? $active_smt->id_semester+1 : $active_smt->id_semester) ))[0];
			// echo substr($active_smt->id_semester, -1); exit;

			$this->load->view('landing/template', $data);
		} else {
			redirect('dashboard','refresh');
		}
	}

	public function simpan() 
	{
		$data = $this->input->post();

		if(isset($data['token'])) {
			if ($this->verify(trim($data['token']))) {
				
				if(isset($data['nim']))
					$data['nm_pd'] = explode(' - ', $data['nim'])[1];

				$daftar = json_decode($this->curl->simple_post(ADD_API.'mbkm/daftar', $data));
				if ($daftar) {
					print_r($daftar);
				}
				
			}
		}

	}

	private function verify($token='')
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://www.google.com/recaptcha/api/siteverify',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS => array('secret' => '6Ldh9pofAAAAAE2bTrYybePUqqOeV3BIFl_L5hdW','response' => trim($token), 'remoteip' => $this->input->ip_address()),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		return json_decode($response)->success;
	}


	public function search_prodi($kode_fak)
	{
		$prodi = json_decode($this->curl->simple_get(ADD_API.'ref/prodi?kode_fak='.$kode_fak));
		echo '<option value="" hidden="">Pilih Program Studi</option>';
		foreach ($prodi as $row) {
			echo "<option value='$row->kode_prodi'>$row->nama_prodi</option>";
		}
	}

	public function search_mhs()
	{
		$arr = [];
		if ($this->input->post('kode_pt') == '041043') {
			$mahasiswa_pt = json_decode($this->curl->simple_get(ADD_API.'simak/mahasiswa_pt?'.http_build_query($this->input->post())));
			if (count($mahasiswa_pt) > 0) {
				$arr['data'] = $mahasiswa_pt[0];
			} else {
				$arr['error']['code'] = '404';
				$arr['error']['message'] = 'Data mahasiswa tidak ditemukan. Pastikan data yang diinputkan sesuai dengan biodata mahasiswa di UNMAKU.';
			}

			echo json_encode($arr);
		} else {
			$mahasiswa = json_decode($this->api_detail_mhs($this->input->post('id_pd')));
			$mahasiswa->dataumum->{'tgl_lahir'} = $this->input->post('tgl_lahir');
			$mahasiswa->dataumum->{'id_mahasiswa_pt'} = $mahasiswa->dataumum->nipd;
			$mahasiswa->dataumum->{'pt_name'} = $this->input->post('nama_pt');
			$mahasiswa->dataumum->{'nama_prodi'} = $this->input->post('nama_prodi');

			if ($mahasiswa->dataumum) {
				$arr['data'] = $mahasiswa->dataumum;
			} else {
				$arr['error']['code'] = '404';
				$arr['error']['message'] = 'Data mahasiswa gagal dimuat / diklaim. Silahkan hubungi operator PDDIKTI pada perguruan tinggi kamu.';
			}

			echo json_encode($arr);
		}
	}

	public function api_detail_mhs($id_pd=null)
	{
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api-frontend.kemdikbud.go.id/detail_mhs/'.$id_pd,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'GET',
		));

		$response = curl_exec($curl);
		curl_close($curl);

		return $response;
	}

	public function search_pt()
	{
		$ch = curl_init('https://api.kampusmerdeka.kemdikbud.go.id/mbkm/pt/search');
		# Setup request to send json via POST.
		$payload = json_encode([ "keyword" => $this->input->post('keyword'), "limit" => 1 ]);
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		# Return response instead of printing.
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		# Send request.
		$result = curl_exec($ch);
		curl_close($ch);
		# Print response.
		echo $result;
	}

	public function api_search_prodi()
	{
		$ch = curl_init('https://api.kampusmerdeka.kemdikbud.go.id/mbkm/prodi/search');
		# Setup request to send json via POST.
		$payload = json_encode([ "keyword" => $this->input->post('keyword'), "pt_id" => $this->input->post('pt_id'), "limit" => 1 ]);
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		# Return response instead of printing.
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		# Send request.
		$result = curl_exec($ch);
		curl_close($ch);
		# Print response.
		echo $result;
	}

	public function api_search_mhs($keyword=null)
	{
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api-frontend.kemdikbud.go.id/hit_mhs/'.str_replace('.', '', $keyword),
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'GET',
		));
		// $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE) != 0 ? 'wadidaw' : 'Error: Server PDDIKTI Sedang Maintenance. Silahkan Ulangi Lagi Nanti.' ;
		$response = curl_exec($curl);
		curl_close($curl);
		$res = json_decode($response, TRUE);

		$mahasiswa = $res['mahasiswa'];
		for ($i=0; $i < sizeof($res['mahasiswa']); $i++) { 
			$mahasiswa[$i]['nim'] = $keyword;
			$mahasiswa[$i]['show'] = $keyword.' - '.explode('(', $mahasiswa[$i]['text'])[0];
			$mahasiswa[$i]['name'] = $mahasiswa[$i]['text'];
			$mahasiswa[$i]['link'] = 'https://pddikti.kemdikbud.go.id/'.$mahasiswa[$i]['website-link'];
			$mahasiswa[$i]['id'] = substr($mahasiswa[$i]['website-link'], -48);

			unset($mahasiswa[$i]['text'], $mahasiswa[$i]['website-link']);
		}

		$obj['data'] = $mahasiswa;
		$obj['meta'] = null;
		echo json_encode($obj);
	}

	// public function api_search_mhs()
	// {
	// 	$ch = curl_init('https://api.kampusmerdeka.kemdikbud.go.id/mbkm/mhs/pddikti');
	// 	# Setup request to send json via POST.
	// 	$payload = json_encode($this->input->post());
	// 	// $payload = json_encode([ "keyword" => $this->input->post('keyword'), "pt_id" => $this->input->post('pt_id'), "limit" => 1 ]);
	// 	curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
	// 	curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
	// 	# Return response instead of printing.
	// 	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
	// 	# Send request.
	// 	$result = curl_exec($ch);
	// 	curl_close($ch);
	// 	# Print response.
	// 	echo $result;
	// }
}

/* End of file Landing.php */
/* Location: ./application/controllers/Landing.php */