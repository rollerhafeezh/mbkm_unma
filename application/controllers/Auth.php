<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->library('encryption');
	}
	
	function index()
	{
		if(isset($_SESSION['logged_in'])){redirect(base_url('dashboard'));}
		$this->load->view('auth/401.php');
	}
	
	function forbid()
	{
		$this->load->view('auth/401.php');
	}
	
	function verify($id=NULL)
	{
		if($id==NULL){redirect(base_url('auth'));}
		$ciphertext=base64_decode($id."==");
		$this->session->set_tempdata('ciphertext', $ciphertext, 120);
		$this->load->view('auth/index');
	}
	
	function g2fa($id=NULL)
	{
		if($id==NULL){redirect(base_url('auth'));}
		$ciphertext=base64_decode($id.'==');
		$this->session->set_tempdata('ciphertext', $ciphertext, 120);
		$this->load->view('auth/index_g2fa');
	}
	
	function otp($id=NULL,$proc=NULL)
	{
		// if($id==NULL){redirect(base_url('auth'));}
		$id			= $this->input->post('id');
		$proc		= $this->input->post('proc');
		
		//IF TYPE OTP
		if($proc=='otp'){
			$salt_key	= 'vqP1AjdKA0gfvJbbFNkMUKHMCDVufAlo'.$id;
			$ciphertext = NULL;
			$ciphertext = $_SESSION['ciphertext'];
			
			//dekrip data
			$this->encryption->initialize(array(	
												'cipher' => 'aes-256',
												'mode' => 'ctr',
												'key' => $salt_key
												));
			$plain_text=NULL;
			$plain_text=$this->encryption->decrypt($ciphertext);
			$data=explode('#', $plain_text);
			
			//REDESIGN ORDER
			//[0] = OTP
			//[1] = USERNAME (id_mahasiswa,nidn,nik_pgw)
			//[2] = ID_LEVEL
			//[3] = APP_LEVEL
			//[4] = SRC_DETAIL
						
			if($plain_text==NULL or $data[0]!=$id){
				$this->result(0,$plain_text);
			}else{
				$this->result(1,$plain_text);
			}
			
		//IF TYPE G2FA
		}else{
			
			$this->load->library('GoogleAuthenticator');
			$ga = new GoogleAuthenticator();
		
			$ciphertext = NULL;
			$ciphertext = $_SESSION['ciphertext'];
			
			//dekrip data
			$this->encryption->initialize(array(	
													'driver' => 'mcrypt',
													'cipher' => 'cast5',
													'mode' => 'cbc',
													'key' => 'vqP1AjdKA0gfvJbbFNkMUKHMCDVufAlo'
													));
			$plain_text=NULL;
			$plain_text=$this->encryption->decrypt($ciphertext);
			$data=explode('#', $plain_text);
				
			//REDESIGN ORDER
			//[0] = OTP
			//[1] = USERNAME (id_mahasiswa,nidn,nik_pgw)
			//[2] = ID_LEVEL
			//[3] = APP_LEVEL
			//[4] = SRC_DETAIL
			//[5] = G2FA
			
			$checkResult = $ga->verifyCode($data[5], $id);
			if($checkResult){
				$this->result(1,$plain_text);
			}else{
				$this->result(0,$plain_text);
			}
		}
	}
	
	function result($result,$plain_text)
	{
		$data=explode('#', $plain_text);
		//if($plain_text==NULL or $data[0]!=$id)
		if($result==0)
		{
			//GAGAL
			$result='
					<div class="alert alert-danger border-0 my-2" role="alert">
						<strong>Maaf!</strong> Kode OTP yang anda masukan salah.
                    </div>
					<div class="alert border-0" role="alert">
						<i class="la la-spinner spinner"></i> 
						Halaman akan tertutup dalam <div id="countdown">3 detik</div>
                    </div>
					<script type="text/javascript">
						var timeleft = 2;
						var downloadTimer = setInterval(function(){
						  document.getElementById("countdown").innerHTML = timeleft + " detik";
						  timeleft -= 1;
						  if(timeleft <= 0){
							clearInterval(downloadTimer);
							document.getElementById("countdown").innerHTML = "Bye.."
						  }
						}, 1000);
						setTimeout(function () { window.location.replace("https://satu.unma.ac.id");}, 3000);
					</script>';
		}else{
		
			$_SESSION['logged_in']=TRUE;
			
			$active_smt=json_decode($this->curl->simple_get(ADD_API.'ref/smt?id_smt=active'))[0];
			$_SESSION['active_smt']=$active_smt->id_semester;
			$_SESSION['nama_smt']=$active_smt->nama_semester;
			
			//GET FROM DATA
			$_SESSION['id_app']=2;//PRECONFIGURED
			$_SESSION['username']=$data[1];
			$_SESSION['id_level']=$data[2];//ID_LEVEL
			$_SESSION['app_level']=$data[3];//APP_LEVEL
			$_SESSION['src_detail']=$data[4];//SRC_DETAIL

			if($_SESSION['app_level'] == 11 ){$_SESSION['src_detail']=4;}
			//generate token
			$api_key = json_decode($this->curl->simple_get(ADD_API.'simak/token?username='.$this->session->userdata('username')))[0];
			$_SESSION['API_KEY'] =  $api_key->api_token;
			
			$_SESSION['level_name']=json_decode($this->curl->simple_get(ADD_API.'ref/level?id_level='.$data[2]))[0]->level_name;
			
			//GET USER DATA
			$user_data=json_decode($this->curl->simple_get(ADD_API.'simak/detail_user/'.$_SESSION['username'].'/'.$_SESSION['src_detail']))[0];
			// print_r($user_data); exit;
			$_SESSION['id_user']	=$user_data->id_user;
			$_SESSION['nama_user']	=$user_data->nama_user;
			
			$detail=json_decode($this->curl->simple_get(ADD_API.'simak/detail_login?id_level='.$_SESSION['id_level']))[0];
			
			$_SESSION['kode_prodi']	=$detail->kode_prodi;
			$_SESSION['nama_prodi']	=$detail->nama_prodi;
			$_SESSION['kode_fak']	=$detail->kode_fak;
			$_SESSION['nama_fak']	=$detail->nama_fak;
			
			$result='<div class="alert alert-success border-0 my-2" role="alert">
						<strong>Selamat!</strong> Kode OTP yang anda masukan valid. 
                    </div>
					<div class="alert border-0" role="alert">
						<i class="la la-spinner spinner"></i> 
						Anda akan diarahkan ke halaman utama dalam <div id="countdown">3 detik</div>. 
						Atau klik <a class="alert-link" href="'.base_url('dashboard').'">disini</a>
                    </div>
					<script type="text/javascript">
						var timeleft = 2;
						var downloadTimer = setInterval(function(){
						  document.getElementById("countdown").innerHTML = timeleft + " detik";
						  timeleft -= 1;
						  if(timeleft <= 0){
							clearInterval(downloadTimer);
							document.getElementById("countdown").innerHTML = "Go.."
						  }
						}, 1000);
						setTimeout(function () { window.location.replace("'.base_url('dashboard').'");}, 3000);
					</script>';
		}
		
		echo $result;
	}
	
	function logout()
	{
		// echo "		halaman akan tertutup dalam 3 detik
		// 			<script>
		// 			setTimeout(function () { window.location.href='https://satu.unma.ac.id';}, 1000);
		// 			</script>";
		$this->session->sess_destroy();
		unset($_SESSION);
		redirect('https://mbkm.unma.ac.id','refresh');
	}
}
