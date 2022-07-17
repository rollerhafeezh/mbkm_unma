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
		$data['berita'] = json_decode($this->curl('https://unma.ac.id/wp-json/wp/v2/posts?categories=26&per_page=8'));

		$this->load->view('landing/template', $data);
	}

	public function program()
	{
		$data['title']	= '';
		$data['view']	= 'landing/program';
		$data['program'] = json_decode($this->curl('https://api.kampusmerdeka.kemdikbud.go.id/mbkm/program'));

		$this->load->view('landing/template', $data);
	}

	public function formulir_mahasiswa()
	{
		$active_smt = json_decode($this->curl->simple_get(ADD_API.'ref/smt?id_smt=active'))[0];
		$data['fakultas'] = json_decode($this->curl->simple_get(ADD_API.'ref/fakultas'));
		$data['smt'] = json_decode($this->curl->simple_get(ADD_API.'ref/smt?id_smt=next&id_semester='.(substr($active_smt->id_semester, -1) == '2' ? $active_smt->id_semester+1 : $active_smt->id_semester) ))[0];

		$this->load->view('landing/daftar_mahasiswa', $data);
	}

	public function formulir_dosen()
	{
		$this->load->view('landing/daftar_dosen');
	}

	public function daftar()
	{
		if (!isset($_SESSION['logged_in'])) {
			$data['title']	= '';
			$data['view']	= 'landing/daftar';

			$data['fakultas'] = json_decode($this->curl->simple_get(ADD_API.'ref/fakultas'));
			$active_smt = json_decode($this->curl->simple_get(ADD_API.'ref/smt?id_smt=active'))[0];
			$data['smt'] = json_decode($this->curl->simple_get(ADD_API.'ref/smt?id_smt=next&id_semester='.(substr($active_smt->id_semester, -1) == '2' ? $active_smt->id_semester+1 : $active_smt->id_semester) ))[0];

			$this->load->view('landing/template', $data);
		} else {
			redirect('dashboard','refresh');
		}
	}

	public function email()
	{
		$this->load->view('landing/email');
	}

	public function simpan() 
	{
		$arr = [];
		$data = $this->input->post();
		$data['id_mahasiswa_pt'] = str_replace(' ', '', $data['id_mahasiswa_pt']);

		if(isset($data['token'])) {
			if ($this->verify(trim($data['token']))) {
				if (isset($data['nidn'])) { // SIMPAN DOSEN
					$data['nidn'] = explode(' ', $data['nidn'])[0];
					$data['id_sdm'] = strtolower($data['id_sdm']);

					$dosen = json_decode($this->curl->simple_get(ADD_API.'simak/dosen?nidn='.$data['nidn']));
					
					if (count($dosen) > 0) {
						$arr['error']['code'] = '404';
						$arr['error']['message'] = 'Data kamu sudah terdaftar sebagai dosen. Apabila menemui kendala silahkan hubungi CS UNMA.';	
					} else {
						unset($data['token']);
						$daftar = json_decode($this->curl->simple_post(ADD_API.'mbkm/daftar_dosen', $data));

						$data_email = [ 'nama_lengkap' => $data['nm_sdm'], 'username' => $data['nidn'], 'password' => date("dmY", strtotime($data['tgl_lahir'])), 'aktivasi' => 'dosen/'.sha1($data['nidn'])];
					}

				} else {  // SIMPAN MAHASISWA
					$aktivitas = json_decode($this->curl->simple_get(ADD_API.'mbkm/anggota?id_mahasiswa_pt='.$data['id_mahasiswa_pt'].'&id_smt='.$data['id_smt']));

					if (count($aktivitas) > 0) {
						$arr['error']['code'] = '404';
						$arr['error']['message'] = 'Kamu sudah terdaftar pada program kampus merdeka di semester yang sama. Silahkan lakukan pendaftaran kembali di semester selanjutnya.';	
					} else {
						$cek_email = json_decode($this->curl->simple_get(ADD_API.'mbkm/cek_email?email='.$data['email']));

						if (count($cek_email) > 0 AND $data['kode_pt'] != '041043') {
							$arr['error']['code'] = '404';
							$arr['error']['message'] = 'Email yang didaftarkan sudah digunakan. Silahkan gunakan email yang lain.';	
						} else {
							if(isset($data['nim'])) {
								$data['nm_pd'] = explode(' - ', $data['nim'])[1];
								$data_email = [ 'nama_lengkap' => $data['nm_pd'], 'username' => $data['id_mahasiswa_pt'], 'password' => date("dmY", strtotime($data['tgl_lahir'])), 'aktivasi' => 'mahasiswa/'.sha1($data['id_mahasiswa_pt'])];
							}

							$daftar = json_decode($this->curl->simple_post(ADD_API.'mbkm/daftar', $data));
						}
						
					}
				}

				if (isset($data_email)) {

					 $config = Array(
		                'protocol' => 'smtp',
		                'smtp_host' => 'smtp.gmail.com',
		                'smtp_port' => 465,
		                'smtp_user' => 'dev@unma.ac.id',
		                'smtp_pass' => 'ardimardiana182',
		                'mailtype'  => 'html', 
		                'charset'   => 'utf-8',
		                'smtp_crypto'   => 'ssl'
					);

					$this->load->library('email', $config);
        			$this->email->set_newline("\r\n");
					

					$this->email->from('dev@unma.ac.id', "MBKM Universitas Majalengka");
					$this->email->to($data['email']);
					$this->email->subject("Aktivasi Akun : MBKM UNMA");
					
					$mesg 		= $this->load->view('landing/email', $data_email, true);
					$this->email->message($mesg);

					$mail = $this->email->send();

					$arr['data'] = $daftar;
				}
				
				echo json_encode($arr);
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
				if ($mahasiswa_pt[0]->ipk < 3) {
					$arr['error']['code'] = '404';
					$arr['error']['message'] = 'Indeks Prestasi Kumulatif (IPK) kamu '.($mahasiswa_pt[0]->ipk != '' ? $mahasiswa_pt[0]->ipk : '0.00').' dan tidak memenuhi syarat untuk mengikuti Program Kampus Merdeka.';	
				} else {
					$arr['data'] = $mahasiswa_pt[0];
				}
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

	public function api_search_dosen($keyword=null)
	{
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api-frontend.kemdikbud.go.id/hit/'.str_replace('.', '', $keyword),
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

		$dosen = $res['dosen'];
		for ($i=0; $i < sizeof($res['dosen']); $i++) { 
			$dosen[$i]['nidn'] = $keyword;
			$dosen[$i]['show'] = $keyword.' ('.explode(',', $dosen[$i]['text'])[0].')';
			$dosen[$i]['name'] = $keyword.' ('.explode(',', $dosen[$i]['text'])[0].')';
			$dosen[$i]['link'] = 'https://pddikti.kemdikbud.go.id/'.$dosen[$i]['website-link'];
			$dosen[$i]['id'] = substr($dosen[$i]['website-link'], -48);

			unset($dosen[$i]['text'], $dosen[$i]['website-link']);
		}

		$obj['data'] = $dosen;
		$obj['meta'] = null;
		echo json_encode($obj);
	}

	public function api_detail_dosen($id=null)
	{
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api-frontend.kemdikbud.go.id/detail_dosen/'.$id,
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

		$data = json_decode($response, TRUE)['dataumum'];
		echo json_encode($data);
	}
}

/* End of file Landing.php */
/* Location: ./application/controllers/Landing.php */