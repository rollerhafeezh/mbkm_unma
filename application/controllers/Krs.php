<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Krs extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Simak_model');
		//if($_SESSION['app_level']!=1){$this->load->view('auth/401.php'); exit();}
	}

	public function add($id_mahasiswa_pt=null, $id_semester=null)
	{
		//cek mahasiswa atau bukan
		if(	$_SESSION['app_level']!=1){
			$id_mahasiswa_pt=$id_mahasiswa_pt;
		}else{
			$id_mahasiswa_pt=$_SESSION['id_user'];
		}

		if($id_mahasiswa_pt==NULL OR $id_semester==NULL){ $data['view']	='auth/404';$data['title']	='Error 404'; } else {
		
		$data['detail_mhs_pt']=json_decode($this->curl->simple_get(ADD_API.'mbkm/mahasiswa_pt?id_mahasiswa_pt='.$id_mahasiswa_pt))[0];
		$data['aktivitas_mahasiswa'] = json_decode($this->curl->simple_get(ADD_API.'mbkm/anggota?id_mahasiswa_pt='.$id_mahasiswa_pt.'&id_smt='.$id_semester))[0];

		// if($data['detail_mhs_pt']->id_jns_keluar==0){
			//check kuliah mahasiswa
			$data['kuliah_mahasiswa']=$this->Simak_model->check_kuliah_mahasiswa($id_mahasiswa_pt, $id_semester);
			if(!$data['kuliah_mahasiswa']) {
				redirect("krs/add/$id_mahasiswa_pt/$id_semester",'refresh');
			}
			//check lunas
			// print_r($data['kuliah_mahasiswa']); exit();
			// $smt=str_split($id_semester);
			//check semester terlebih dahulu, ganjil or genap or pendek
			// if($smt[4]==1){
			// 	if($data['detail_mhs_pt']->mulai_smt>$id_semester){
			// 		//exit();
			// 	}else{
			// 		$data['lunas']=$this->Simak_model->check_tagihan($id_mahasiswa_pt);
			// 	}
			// }else{
			// 	$data['lunas']='ok';
			// }
			
			$data['cek_krs']=json_decode($this->curl->simple_get(ADD_API.'simak/krs_mhs_cek?id_mahasiswa_pt='.$id_mahasiswa_pt.'&id_smt='.$id_semester));
			
			/*form helpder & validation*/
			$this->load->helper('form');
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<div class="row"><div class="col"><div class="alert bg-danger alert-icon-left alert-arrow-left alert-dismissible mb-2" role="alert">  <span class="alert-icon"><i class="la la-commenting"></i></span><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><i class="la la-times"></i></span></button><strong>', '</strong></div></div></div>');
			$this->form_validation->set_rules('id_mahasiswa_pt', 'NPM Mahasiswa', 'required');
		
			/*proses simpan*/
			if ($this->form_validation->run()){
				$id_mhs_pt=$this->input->post('id_mahasiswa_pt');
				//membuat status mahasiswa menjadi aktif
				$this->patch_kuliah_mahasiswa($id_mhs_pt, $id_semester, $data['aktivitas_mahasiswa']->id_aktivitas);
				
				//create note mahasiswa
				$note=$this->patch_note($id_mhs_pt, $id_semester);
				
				//creator,id_pesan
				// $id_notif=$this->Notif_model->push_notif($id_mhs_pt,2);
				
				//var_dump($id_notif); exit();
				// $this->Notif_model->user_notif($data['detail_mhs_pt']->nidn,2,$id_notif);
				
				//menghapus semua record krs pada semester berjalan ketika kontrak ulang
				//$this->remove_krs();
				
				//proses simpan krs
				//$save=$this->store_krs();
				
				
				if($note){
					$this->session->set_flashdata('msg', 'Kontrak Mata Kuliah Tersimpan');
					$this->session->set_flashdata('color', 'success');
				}else{
					$this->session->set_flashdata('msg', 'Data Gagal Tersimpan');
					$this->session->set_flashdata('color', 'danger');
				}
				
				//dialihkan ke halaman krs
				//redirect(base_url('krs'));
			}
			
			$data['krs_log']=json_decode($this->curl->simple_get(ADD_API.'mbkm/krs_log?id_mahasiswa_pt='.$id_mahasiswa_pt.'&id_smt='.$id_semester),true);
			$smt_lalu=$id_semester-10;
			$ips_smt_lalu=json_decode($this->curl->simple_get(ADD_API.'simak/kuliah_mahasiswa_get?id_mahasiswa_pt='.$id_mahasiswa_pt.'&id_smt='.$smt_lalu));
			$semester = json_decode($this->curl->simple_get(ADD_API.'ref/smt?id_smt='.$id_semester))[0];

			$data['batas_sks']	=$this->batas_sks($id_mahasiswa_pt, $id_semester);
			$data['assets_css']=	array(	"themes/vendors/css/tables/datatable/datatables.min.css");
			$data['assets_js']=		array(	"themes/vendors/js/tables/datatable/datatables.min.js");
			$data['title']	='Kartu Rencana Studi MBKM';
			$data['semester']	=$semester;
			$data['smt_lalu']	=$smt_lalu;
			$data['ips_smt_lalu']	=$ips_smt_lalu;
			$data['view']	='krs/add';
		// }else{
		// 	$data['title']	='Kartu Rencana Studi';
		// 	$data['view']	='krs/lulus';
		// }
		}
			
			$this->load->view('lyt/index',$data);
	}

	private function batas_sks($id_mahasiswa_pt, $id_semester)
	{
		$smt_lalu=$id_semester-10;
		/*
		IPS 3.26 sd 4.00 	-> 24 SKS
		IPS 3.00 sd 3.25 	-> 22 SKS
		IPS 2.75 sd 2.99 	-> 20 SKS
		IPS 2.00 sd 2.74 	-> 18 SKS
		IPS <= 2.00 		-> 16 SKS
		*/
		$batas_sks=json_decode($this->curl->simple_get(ADD_API.'simak/kuliah_mahasiswa_get?id_mahasiswa_pt='.$id_mahasiswa_pt.'&id_smt='.$smt_lalu));
		if($batas_sks){
			if($batas_sks->detail[0]->ips > 3.25){
				return 24;
			}else if($batas_sks->detail[0]->ips > 2.99){
				return 22;
			}else if($batas_sks->detail[0]->ips > 2.74){
				return 20;
			}else if($batas_sks->detail[0]->ips > 2.00){
				return 18;
			}else{
				return 16;
			}
		}else{
			return 24;
		}
	}
	
	public function index()
	{
		if($_SESSION['app_level']!=1){$this->load->view('auth/401'); }
		$data['assets_css']=	array(	"themes/vendors/css/tables/datatable/datatables.min.css");
		$data['assets_js']=		array(	"themes/vendors/js/tables/datatable/datatables.min.js");
		$data['krs_log']=json_decode($this->curl->simple_get(ADD_API.'simak/krs_log?id_mahasiswa_pt='.$_SESSION['id_user'].'&id_smt='.$id_semester));
		$data['title']	='KRS';
		$data['view']	='krs/index';
		$data['add_item']	='krs/add';
		$this->load->view('lyt/index',$data);
	}

	function mahasiswa_mbkm($id_dosen=NULL)
	{
		$data['assets_css']=	array(	"themes/vendors/css/tables/datatable/datatables.min.css");
		$data['assets_js']=		array(	"themes/vendors/js/tables/datatable/datatables.min.js");
		
		$data['title']	='Mahasiswa MBKM';
		$data['view']	='krs/mahasiswa_mbkm';

		$this->load->view('lyt/index',$data);
	}

	function validasi_mahasiswa_mbkm()
	{
		$url=ADD_API.'mbkm/validasi_mbkm';
		//exec api
		echo $this->curl->simple_post($url, $this->input->post()) ? 'success' : 'failed';
	}
	
	public function validasi($id_mahasiswa_pt=null)
	{
		if($_SESSION['app_level'] == 4 OR $_SESSION['app_level'] == 7 OR $_SESSION['app_level'] == 3 OR $_SESSION['app_level'] == 6 OR $_SESSION['app_level'] == 12){
		$data['assets_css']=	array(	"themes/vendors/css/tables/datatable/datatables.min.css");
		$data['assets_js']=		array(	"themes/vendors/js/tables/datatable/datatables.min.js");
		
		$data['nama_semester']	= json_decode($this->curl->simple_get(ADD_API.'ref/smt/'));
		$data['fakultas']		= json_decode($this->curl->simple_get(ADD_API.'ref/fakultas?kode_fak='.$_SESSION['kode_fak']));
		
		$data['title']	='Validasi KRS Mahasiswa';
		$data['view']	='krs/validasi_krs';
		$this->load->view('lyt/index',$data);
		}else{$this->load->view('auth/401'); }
	}

	function gnrt_sks($id_mahasiswa_pt=null)
	{
		if($_SESSION['app_level'] == 4 OR $_SESSION['app_level'] == 7){
		if($id_mahasiswa_pt==null){$this->load->view('auth/401');}else{
			$save=$this->Simak_model->create_tag_sks($id_mahasiswa_pt);
			echo '<img src="https://www.zikoko.com/wp-content/uploads/2019/06/JLypLpqVPBaKaRaouqJKpK1JreX63Cyei6SL51PK9fWosvw1zpvB31bL2U6Ls6SQkcCEmoKzg7k2W4DtM52VLuoXeyb1jjgTQKWsLrvHEQzD2CEE9Xurm4pFWXiU3abZtU5epzfi2V4Ls7DVnb7fdayc27TJ5EmpUuvCzUKDtwHTeyPSHAEkVoRU54rJxP7WuU.png"><br>';
			sleep(2);
		echo '<h3>';
		var_dump($save);
		echo '</h3>';
			echo '<p><button onclick="window.close()">close</button></p>';
		}}else{$this->load->view('auth/401'); }
	}

	function gnrt_dpp($id_mahasiswa_pt=null)
	{
		if($_SESSION['app_level'] == 4 OR $_SESSION['app_level'] == 7){
		if($id_mahasiswa_pt==null){$this->load->view('auth/401');}else{
			$save=$this->Simak_model->create_tag_dpp($id_mahasiswa_pt);
			var_dump($save);
			echo '<p><button onclick="window.close()">close</button></p>';
		}}else{$this->load->view('auth/401'); }
	}

	function gnrt_kelas($id_mahasiswa_pt=null,$active_smt=null)
	{
		
		if($_SESSION['app_level']!=1){$id_mahasiswa_pt=$id_mahasiswa_pt;}else{$id_mahasiswa_pt=$_SESSION['id_user'];}
		if($id_mahasiswa_pt==null){$this->load->view('auth/401');}else{
		$active_smt=($active_smt)?:$id_semester;
			echo '<img src="https://www.zikoko.com/wp-content/uploads/2019/06/JLypLpqVPBaKaRaouqJKpK1JreX63Cyei6SL51PK9fWosvw1zpvB31bL2U6Ls6SQkcCEmoKzg7k2W4DtM52VLuoXeyb1jjgTQKWsLrvHEQzD2CEE9Xurm4pFWXiU3abZtU5epzfi2V4Ls7DVnb7fdayc27TJ5EmpUuvCzUKDtwHTeyPSHAEkVoRU54rJxP7WuU.png"><br>';
			sleep(2);
		$save=$this->Simak_model->generate_kelas($id_mahasiswa_pt,$active_smt);
		echo '<h3>';
		var_dump($save);
		echo '</h3>';
		echo '<p><button onclick="window.close()">close</button></p>';
		
		}
	}
	
	
	function proses_validasi()
	{
		$id_mahasiswa_pt=$this->input->post('id_mhs_pt');
		$oleh=$this->input->post('oleh');
		$id_smt=$this->input->post('id_smt');
		if($oleh=='keu'){
			$this->Simak_model->generate_kelas($id_mahasiswa_pt,$id_smt);
			
			$data=array(
					'id_mahasiswa_pt'	=>$id_mahasiswa_pt,
				);
			$url=ADD_API.'keu/update_krs_to_nilai_mhs';
			//exec api
			$this->curl->simple_post($url,$data);
		}
		
		$catatan=array(
			'id_mahasiswa_pt'	=>$id_mahasiswa_pt,
			'id_smt'			=>$id_smt,
			'oleh'				=>$oleh,
			'validator'			=>$_SESSION['nama_user'],
			'tgl_acc'			=>date('Y-m-d')
		);
		
		$url=ADD_API.'simak/validasi_krs_by';
		//exec api
		$this->curl->simple_put($url,$catatan);
	}

	function proses_unvalidasi()
	{
		$id_mahasiswa_pt=$this->input->post('id_mhs_pt');
		$oleh=$this->input->post('oleh');
		$id_smt=$this->input->post('id_smt');
		if($oleh=='keu'){
			
			$data=array(
					'id_mahasiswa_pt'	=>$id_mahasiswa_pt,
				);
			$url=ADD_API.'keu/update_krs_to_nilai_mhs';
			//exec api
			$this->curl->simple_post($url,$data);
		}
		
		$catatan=array(
			'id_mahasiswa_pt'	=>$id_mahasiswa_pt,
			'id_smt'			=>$id_smt,
			'oleh'				=>$oleh,
			'validator'			=>'0',
			'tgl_acc'			=>NULL
		);
		
		$url=ADD_API.'simak/validasi_krs_by';
		//exec api
		$this->curl->simple_put($url,$catatan);
	}
	
	private function patch_kuliah_mahasiswa($id_mhs_pt=null, $id_semester, $id_aktivitas)
	{
		$kuliah_mahasiswa=array(
			'id_smt'			=> $id_semester,
			'id_mahasiswa_pt' 	=> $id_mhs_pt,
			'id_aktivitas' 		=> $id_aktivitas,
			'stat_mhs' 			=> '2'
		);
		$url=ADD_API.'mbkm/kuliah_mahasiswa';
		// $this->curl->http_header('token',$_SESSION['API_KEY']);
		// $this->curl->http_header('bearer','SIMAK');
		
		//update kuliah_mahasiswa
		return $this->curl->simple_put($url,$kuliah_mahasiswa);
	}
	
	//hapus_krs/ batal
	function batal_krs()
	{
		$id_krs=$this->input->post('id_krs');
		$krs=array(
			'id_krs'			=> $id_krs,
		);
		
		$url=ADD_API.'mbkm/batal_krs';
		// $this->curl->http_header('token',$_SESSION['API_KEY']);
		// $this->curl->http_header('bearer','SIMAK');
		
		//batal krs
		return $this->curl->simple_delete($url, $krs);
	}
	
	//hapus_krs/ batal
	function ubah_status_krs()
	{
		$id_krs=$this->input->post('id_krs');
		$status=$this->input->post('status');
		$krs=array(
			'id_krs'			=> $id_krs,
			'status'			=> $status,
		);
		
		$url=ADD_API.'simak/ubah_status_krs';
		$this->curl->http_header('token',$_SESSION['API_KEY']);
		$this->curl->http_header('bearer','SIMAK');
		
		//batal krs
		return $this->curl->simple_put($url,$krs);
	}
	
	//hapus_krs/ batal
	function drop_satu_krs()
	{
		$id_krs=$this->input->post('id_krs');
		$krs=array(
			'id_krs'			=> $id_krs,
		);
		
		$url=ADD_API.'simak/drop_satu_krs';
		$this->curl->http_header('token',$_SESSION['API_KEY']);
		$this->curl->http_header('bearer','SIMAK');
		
		//batal krs
		return $this->curl->simple_delete($url,$krs);
	}
	
	function batal_krs_temp()
	{
		$id_krs_temp=$this->input->post('id_krs_temp');
		$krs=array(
			'id_krs_temp'			=> $id_krs_temp,
		);
		
		$url=ADD_API.'simak/batal_krs_temp';
		$this->curl->http_header('token',$_SESSION['API_KEY']);
		$this->curl->http_header('bearer','SIMAK');
		
		//batal krs
		return $this->curl->simple_delete($url,$krs);
	}

	public function ambil_kelas()
	{
		$mk=json_decode($this->curl->simple_get(ADD_API.'simak/matkul?id_matkul='.$this->input->get('id_matkul')))[0];
		$ada=json_decode($this->curl->simple_get(ADD_API.'simak/check_kode_mk_krs?id_mahasiswa_pt='.$this->input->get('id_mahasiswa_pt').'&active_smt='.$id_semester.'&kode_mk='.$mk->kode_mk));
		var_dump($ada);
		echo $mk->kode_mk;
	}
	
	function take_kelas()
	{
		// $data_kirim=explode('-', $this->input->post('id_kelas_kuliah'));
		$id_matkul = $this->input->post('id_matkul');
		$status = $this->input->post('status');
		$get_kode_mk=json_decode($this->curl->simple_get(ADD_API.'simak/matkul?id_matkul='.$id_matkul))[0];
		$sudah_ada_kode_mk=json_decode($this->curl->simple_get(ADD_API.'mbkm/check_kode_mk_krs?id_mahasiswa_pt='.$this->input->post('id_mahasiswa_pt').'&active_smt='.$this->input->post('id_semester').'&kode_mk='.$get_kode_mk->kode_mk));
		if($sudah_ada_kode_mk==0){
			$krs=array(
						'id_smt'			=> $this->input->post('id_semester'),
						// 'id_kelas_kuliah' 	=> $data_kirim[0],
						'id_matkul' 		=> $id_matkul,
						'id_mahasiswa_pt' 	=> $this->input->post('id_mahasiswa_pt')
						);

			$url=ADD_API.'mbkm/krs_mhs';
			//simpan krs
			$result=json_decode($this->curl->simple_post($url,$krs));
		}
	}
	
	function take_kelas_temp()
	{
		$data_kirim=explode('-', $this->input->post('id_kelas_kuliah'));

		$krs=array(
					'id_smt'			=> $id_semester,
					'id_kelas_kuliah' 	=> $data_kirim[0],
					'id_matkul' 		=> $data_kirim[1],
					'id_mahasiswa_pt' 	=> $this->input->post('id_mahasiswa_pt')
					);
		$url=ADD_API.'simak/krs_temp_mhs';
		//simpan krs
		$result=json_decode($this->curl->simple_post($url,$krs));
	}
	
	function json_krs()
	{
		$id_mhs_pt=$this->input->get('id_mhs_pt');
		if($_SESSION['app_level']!=1){$id_mhs_pt=$id_mhs_pt;}else{$id_mhs_pt=$_SESSION['id_user'];}
		
		$krs=json_decode($this->curl->simple_get(ADD_API.'datatable/krs_mhs_mbkm?id_mahasiswa_pt='.$id_mhs_pt.'&active_smt='.$this->input->get('id_semester')));
		echo json_encode($krs);
	}
	
	function json_krs_temp()
	{
		$id_mhs_pt=$this->input->get('id_mhs_pt');
		if($_SESSION['app_level']!=1){$id_mhs_pt=$id_mhs_pt;}else{$id_mhs_pt=$_SESSION['id_user'];}
		
		$krs=json_decode($this->curl->simple_get(ADD_API.'datatable/krs_temp_mhs?id_mahasiswa_pt='.$id_mhs_pt.'&active_smt='.$id_semester));
		echo json_encode($krs);
	}
	
	function kelas_kuliah_detail($id_matkul=NULL)
	{
		$data['id_matkul']=$this->input->get('id_matkul');
		$data['jml_kontrak']=$this->input->get('jml_kontrak');
		$this->load->view('krs/kelas_kuliah_detail',$data);
	}
	
	function krsriwayat($id_mahasiswa_pt=null)
	{
		if($_SESSION['app_level']!=1){$id_mahasiswa_pt=$id_mahasiswa_pt;}else{$id_mahasiswa_pt=$_SESSION['id_user'];}
		$data['detail_mhs_pt']=json_decode($this->curl->simple_get(ADD_API.'simak/mahasiswa_pt?id_mahasiswa_pt='.$id_mahasiswa_pt))[0];
		//if($_SESSION['app_level']!=1){$this->load->view('auth/401');}
		$data['assets_css']=	array(	"themes/vendors/css/tables/datatable/datatables.min.css");
		$data['assets_js']=		array(	"themes/vendors/js/tables/datatable/datatables.min.js");
		$data['riwayat']=json_decode($this->curl->simple_get(ADD_API.'datatable/validasi_krs?id_mahasiswa_pt='.$id_mahasiswa_pt.'&id_smt=0'),true);
		$data['title']	='Riwayat Ajar '.$data['detail_mhs_pt']->nm_pd.' ('.$id_mahasiswa_pt.')';
		$data['view']	='krs/riwayat';
		$this->load->view('lyt/index',$data);
	}
	
	function patch_note($id_mhs_pt=null, $id_semester=null)
	{
		$catatan=array(
		    'validasi_krs'     	=>'0',
		    'isi_catatan'       =>'-',
			'id_mahasiswa_pt'	=>$id_mhs_pt,
			'tgl_acc'			=>NULL,
			'id_smt'			=>$id_semester
		);
		
		$url=ADD_API.'mbkm/krs_log';
		//exec api
		
		return $this->curl->simple_put($url,$catatan);
		
	}
	
	function patch_note_temp($id_mhs_pt=null,$alasan=null)
	{
		$catatan=array(
		    'isi_note'			=>$alasan,
		    'id_mahasiswa_pt'	=>$id_mhs_pt,
			'id_smt'			=>$id_semester
		);
		
		$url=ADD_API.'simak/krs_temp_log';
		//exec api
		
		return $this->curl->simple_put($url,$catatan);
		
	}
	
	function reset_krs($id_mhs_pt=null,$id_smt=null)
	{
		$id_mahasiswa_pt=$this->input->post('id_mhs_pt');
		$data_krs=$this->input->post('data_krs');
		$data_tagihan=$this->input->post('data_tagihan');
		$data_validasi=$this->input->post('data_validasi');
		$id_smt=$this->input->post('id_smt');
		
		if($data_krs='1'){
			$data=array(
				'id_mahasiswa_pt'	=> $id_mahasiswa_pt,
				'id_smt'			=> $id_smt,
			);
			$whythis='delete_krs_by_adddrop';
			$action='#npm:'.$id_mahasiswa_pt;
			$this->Log_model->log_akademik($whythis,$action);
			
			$url=ADD_API.'simak/reset_krs';
			$this->curl->http_header('token',$_SESSION['API_KEY']);
			$this->curl->http_header('bearer','SIMAK');
			$this->curl->simple_delete($url,$data);
			
		}
		
		if($data_validasi='1'){
			$data=array(
				'id_mahasiswa_pt'	=> $id_mahasiswa_pt,
				'id_smt'			=> $id_smt,
			);
			$action='delete_val_by_adddrop';
			$action='#npm:'.$id_mahasiswa_pt;
			$this->Log_model->log_akademik($whythis,$action);
			
			$url=ADD_API.'simak/reset_krs_note';
			$this->curl->http_header('token',$_SESSION['API_KEY']);
			$this->curl->http_header('bearer','SIMAK');
			$this->curl->simple_delete($url,$data);
		}
		
		/*if($data_tagihan='1'){

			$data=array(
				'npm'	=> $id_mahasiswa_pt,
				'id_smt'		=> $id_smt,
				'jenis_tagihan'	=> 'SKS'
			);
			
			$whythis='delete_tag_sks_by_adddrop:';
			$action='#npm:'.$id_mahasiswa_pt;
			$this->Log_model->log_keuangan($whythis,$action);

			$url=ADD_API.'keu/hapus_tagihan_by_mhs';
			$this->curl->http_header('token',$_SESSION['API_KEY']);
			$this->curl->http_header('bearer','SIMAK');
			$this->curl->simple_delete($url,$data);
		
		}*/
		return true;
	}
	
	public function drop_krs($id_mahasiswa_pt=null, $id_semester=null, $id_aktivitas=null)
	{
		// if($_SESSION['app_level']!=1){$id_mahasiswa_pt=$id_mahasiswa_pt;}else{$id_mahasiswa_pt=$_SESSION['id_user'];}
		// if($id_mahasiswa_pt==NULL){ $data['view']	='auth/404';$data['title']	='Error 404';}else{
		// $data['detail_mhs_pt']=json_decode($this->curl->simple_get(ADD_API.'simak/mahasiswa_pt?id_mahasiswa_pt='.$id_mahasiswa_pt))[0];
		// $this->curl->simple_post(ADD_API.'simak/copy_krs_mhs?id_mahasiswa_pt='.$data['detail_mhs_pt']->id_mahasiswa_pt.'&id_smt='.$id_semester);
		// $krs		= json_decode($this->curl->simple_get(ADD_API.'datatable/krs_mhs?id_mahasiswa_pt='.$data['detail_mhs_pt']->id_mahasiswa_pt.'&active_smt='.$id_semester));
		// $kelas		= json_decode($this->curl->simple_get(ADD_API.'datatable/kelas_mhs?id_mahasiswa_pt='.$data['detail_mhs_pt']->id_mahasiswa_pt.'&active_smt='.$id_semester));
		// $krs_note	= json_decode($this->curl->simple_get(ADD_API.'datatable/validasi_krs?id_mahasiswa_pt='.$data['detail_mhs_pt']->id_mahasiswa_pt.'&id_smt='.$id_semester));
		// $kuliah_mhs	= json_decode($this->curl->simple_get(ADD_API.'simak/kuliah_mahasiswa_get?id_mahasiswa_pt='.$data['detail_mhs_pt']->id_mahasiswa_pt.'&id_smt='.$id_semester),true);
		
		$drop_krs	= json_decode($this->curl->simple_get(ADD_API.'mbkm/drop_krs?id_mahasiswa_pt='.$_SESSION['id_user'].'&id_smt='.$id_semester.'&id_aktivitas='.$id_aktivitas), true);
		redirect('krs/add/'.$_SESSION['id_user'].'/'.$id_semester, 'refresh');

		// $data['krs']		=$krs;
		// $data['kelas']		=$kelas;
		// $data['krs_note']	=$krs_note;
		// $data['tagihan']	=$tagihan;
		// $data['kuliah_mhs']	=$kuliah_mhs;
		// $data['title']	='Add Drop KRS';
		// $data['view']	='krs/add_drop';
		// }
		// $this->load->view('lyt/index',$data);
	}

	public function cetak_krs($id_mhs_pt=null,$id_smt=null)
	{
		if($id_smt==NULL){$id_smt=$id_semester;}else{$id_smt=$id_smt;}
		if($_SESSION['app_level']==1){$id_mhs_pt=$_SESSION['id_user'];}else{$id_mhs_pt=$id_mhs_pt;}
		$krs 	= json_decode($this->curl->simple_get(ADD_API.'datatable/krs_mhs_mbkm?id_mahasiswa_pt='.$id_mhs_pt.'&active_smt='.$id_smt), true);
		$mhs 	= json_decode($this->curl->simple_get(ADD_API.'simak/mahasiswa_pt?id_mahasiswa_pt='.$id_mhs_pt));
		$validasi 	= json_decode($this->curl->simple_get(ADD_API.'datatable/validasi_krs?db_mbkm=1&id_mahasiswa_pt='.$id_mhs_pt.'&id_smt='.$id_smt),true);
		$data['aktivitas_mahasiswa'] = json_decode($this->curl->simple_get(ADD_API.'mbkm/anggota?id_mahasiswa_pt='.$id_mhs_pt.'&id_smt='.$id_smt))[0];

		$data['validasi'] = $validasi;
		$data['krs'] = $krs;
		$data['mhs'] = $mhs[0];
		$data['id_smt'] = $id_smt;

		$mpdf = new \Mpdf\Mpdf();

    	if(!$validasi['data']){
    	 	echo "<h1>KRS Belum diajukan</h1>";
    	}else{ 
			//$this->load->view('krs/cetak_krs', $data);
			$template = $this->load->view('krs/cetak_krs', $data, true);
			$mpdf->WriteHTML($template);
			$mpdf->Output('KRS MAHASISWA MBKM.pdf', 'D');	
    	}
	}
	
	public function lihat_krs($id_smt,$id_mhs_pt=null)
	{
		if($id_smt==NULL){$id_smt=$id_semester;}else{$id_smt=$id_smt;}
		if($_SESSION['app_level']==1){$id_mhs_pt=$_SESSION['id_user'];}else{$id_mhs_pt=$id_mhs_pt;}
		$krs 	= json_decode($this->curl->simple_get(ADD_API.'datatable/krs_mhs?id_mahasiswa_pt='.$id_mhs_pt.'&active_smt='.$id_smt), true);
		$mhs 	= json_decode($this->curl->simple_get(ADD_API.'simak/mahasiswa_pt?id_mahasiswa_pt='.$id_mhs_pt));
		$validasi 	= json_decode($this->curl->simple_get(ADD_API.'datatable/validasi_krs?id_mahasiswa_pt='.$id_mhs_pt.'&id_smt='.$id_smt),true);
		$data['validasi'] = $validasi;
		$data['krs'] = $krs;
		$data['mhs'] = $mhs[0];
		$data['id_smt'] = $id_smt;

		if(!$validasi['data']){
    	 	echo "<h1>KRS Belum diajukan</h1>";
			echo '<img src="https://i.imgflip.com/ced64.jpg">';
    	}else{ 
			$this->load->view('krs/cetak_krs', $data);
		}
	}
	
	public function cetak_ksm($id_smt=null,$id_mhs_pt=null)
	{
		if($id_smt==NULL){$id_smt=$id_semester;}else{$id_smt=$id_smt;}
		if($_SESSION['app_level']==1){$id_mhs_pt=$_SESSION['id_user'];}else{$id_mhs_pt=$id_mhs_pt;}
		
		$krs 	= json_decode($this->curl->simple_get(ADD_API.'datatable/krs_mhs?id_mahasiswa_pt='.$id_mhs_pt.'&active_smt='.$id_smt), true);
		$mhs 	= json_decode($this->curl->simple_get(ADD_API.'simak/mahasiswa_pt?id_mahasiswa_pt='.$id_mhs_pt));
		$validasi 	= json_decode($this->curl->simple_get(ADD_API.'datatable/validasi_krs?id_mahasiswa_pt='.$id_mhs_pt.'&id_smt='.$id_smt),true);
		if(!$validasi['data']) { echo'<img src="https://i.imgur.com/jYlJHXO.png"><br>Boooooooooo!!!!'; 
		}else{
		//var_dump($validasi); exit();
		$data['validasi'] = $validasi;
		$data['krs'] = $krs;
		$data['mhs'] = $mhs[0];
		$data['id_smt'] = $id_smt;

		$mpdf = new \Mpdf\Mpdf();
		//$this->load->view('krs/cetak_ksm', $data);	
		if($validasi['data'][0]['validasi_krs']=='0' or $validasi['data'][0]['validasi_aka']=='0' or $validasi['data'][0]['validasi_keu']=='0' or $validasi['data'][0]['validasi_prodi']=='0') {
            echo '<h2> Status Validasi Belum Lengkap</h2>';
            echo '<ol>
                        <li>Validasi Dosen Wali : '.$validasi['data'][0]['validasi_krs'].'</li>
                        <li>Validasi Akademik : '.$validasi['data'][0]['validasi_aka'].'</li>
                        <li>Validasi Keuangan : '.$validasi['data'][0]['validasi_keu'].'</li>
                        <li>Validasi Program Studi : '.$validasi['data'][0]['validasi_prodi'].'</li>
                        ';
        }else{
			$template = $this->load->view('krs/cetak_ksm', $data, true);
			$mpdf->WriteHTML($template);	
			$mpdf->Output('nilai/cetak_ksm.pdf', 'D');
		}
		}

	}
	
	public function lihat_ksm($id_smt=null,$id_mhs_pt=null)
	{
		if($id_smt==NULL){$id_smt=$id_semester;}else{$id_smt=$id_smt;}
		if($_SESSION['app_level']==1){$id_mhs_pt=$_SESSION['id_user'];}else{$id_mhs_pt=$id_mhs_pt;}
		
		$krs 	= json_decode($this->curl->simple_get(ADD_API.'datatable/krs_mhs?id_mahasiswa_pt='.$id_mhs_pt.'&active_smt='.$id_smt), true);
		$mhs 	= json_decode($this->curl->simple_get(ADD_API.'simak/mahasiswa_pt?id_mahasiswa_pt='.$id_mhs_pt));
		$validasi 	= json_decode($this->curl->simple_get(ADD_API.'datatable/validasi_krs?id_mahasiswa_pt='.$id_mhs_pt.'&id_smt='.$id_smt),true);
		if(!$validasi['data']) {
			echo'<img src="https://img.memecdn.com/morphius-404_o_1938383.webp"><br>Boooooooooo!!!!'; 
		}else{
		//var_dump($validasi); exit();
		$data['validasi'] = $validasi;
		$data['krs'] = $krs;
		$data['mhs'] = $mhs[0];
		$data['id_smt'] = $id_smt;

		if($validasi['data'][0]['validasi_krs']=='0' or $validasi['data'][0]['validasi_aka']=='0' or $validasi['data'][0]['validasi_keu']=='0' or $validasi['data'][0]['validasi_prodi']=='0') {
            echo '<h2> Status Validasi Belum Lengkap</h2>';
            echo '<ol>
                        <li>Validasi Dosen Wali : '.$validasi['data'][0]['validasi_krs'].'</li>
                        <li>Validasi Akademik : '.$validasi['data'][0]['validasi_aka'].'</li>
                        <li>Validasi Keuangan : '.$validasi['data'][0]['validasi_keu'].'</li>
                        <li>Validasi Program Studi : '.$validasi['data'][0]['validasi_prodi'].'</li>
                        ';
        }else{
			$this->load->view('krs/cetak_ksm', $data);	
		}
		}

	}
	
	public function lihat_khs($id_smt=null,$id_mhs_pt=null)
	{
		if($id_smt==NULL){$id_smt=$id_semester;}else{$id_smt=$id_smt;}
		if($_SESSION['app_level']==1){$id_mhs_pt=$_SESSION['id_user'];}else{$id_mhs_pt=$id_mhs_pt;}
		$khs 	= json_decode($this->curl->simple_get(ADD_API.'nilai/khs?id_mahasiswa_pt='.$id_mhs_pt.'&id_smt='.$id_smt));
		$mhs 	= json_decode($this->curl->simple_get(ADD_API.'simak/mahasiswa_pt?id_mahasiswa_pt='.$id_mhs_pt));
		$data['khs'] = $khs;
		$data['mhs'] = $mhs[0];
		$data['id_smt'] = $id_smt;

		if(!$khs || !$mhs){
    	 	echo "<h1>something wong</h1>";
			echo '<img src="https://i.imgflip.com/ced64.jpg">';
    	}else{ 
			$this->load->view('krs/cetak_khs', $data);
		}
	}
	
	public function cetak_khs($id_smt=null,$id_mhs_pt=null)
	{
		if($id_smt==NULL){$id_smt=$id_semester;}else{$id_smt=$id_smt;}
		if($_SESSION['app_level']==1){$id_mhs_pt=$_SESSION['id_user'];}else{$id_mhs_pt=$id_mhs_pt;}
		$khs 	= json_decode($this->curl->simple_get(ADD_API.'nilai/khs?id_mahasiswa_pt='.$id_mhs_pt.'&id_smt='.$id_smt));
		$mhs 	= json_decode($this->curl->simple_get(ADD_API.'simak/mahasiswa_pt?id_mahasiswa_pt='.$id_mhs_pt));
		$data['khs'] = $khs;
		$data['mhs'] = $mhs[0];
		$data['id_smt'] = $id_smt;

		if(!$khs || !$mhs){
    	 	echo "<h1>something wong</h1>";
			echo '<img src="https://i.imgflip.com/ced64.jpg">';
    	}else{ 
			$mpdf = new \Mpdf\Mpdf();
			$template = $this->load->view('krs/cetak_khs', $data, true);
			$mpdf->WriteHTML($template);	
			//$mpdf->Output('nilai/cetak_khs.pdf', 'F');
			$mpdf->Output();
		}
	}
}
	/*
	// $detail_mhs_pt=json_decode($this->curl->simple_get(ADD_API.'simak/mahasiswa_pt?id_mahasiswa_pt='.$id_mahasiswa_pt))[0];
		
		// $tag_sks=json_decode($this->curl->simple_get(ADD_API.'keu/cek_tag_mhs?nmr_daftar='.$detail_mhs_pt->id_mhs.'&id_smt='.$id_semester.'&jenis_tagihan=SKS'),true);
		// $tag_dpp=json_decode($this->curl->simple_get(ADD_API.'keu/cek_tag_mhs?nmr_daftar='.$detail_mhs_pt->id_mhs.'&id_smt='.$id_semester.'&jenis_tagihan=DPP'),true);
		// if($tag_sks['status']==false or $tag_dpp['status']==false){
			// $save="Tagihan tidak ada";
		// }elseif ($tag_sks['status']==true and $tag_dpp['status']==true) {
			// $bayar_sks=$tag_sks['detail'][0]['besar_tagihan']-$tag_sks['detail'][0]['sisa_tagihan'];
			// $bayar_dpp=$tag_dpp['detail'][0]['besar_tagihan']-$tag_dpp['detail'][0]['sisa_tagihan'];
			// $persen_sks=($bayar_sks / $tag_sks['detail'][0]['besar_tagihan']);
			// $persen_dpp=($bayar_dpp / $tag_dpp['detail'][0]['besar_tagihan']);
			// $besar_tagih=$tag_sks['detail'][0]['besar_tagihan']+$tag_dpp['detail'][0]['besar_tagihan'];
			// $besar_bayar=$tag_sks['detail'][0]['sisa_tagihan']+$tag_dpp['detail'][0]['sisa_tagihan'];
			// $bayar_total=$besar_tagih-$besar_bayar;
			// $persen_bayar=$bayar_total/$besar_tagih;

			// if($bayar_dpp == 0 and $bayar_sks==0){
				// $save="Belum melakukan Pembayaran";
			// //}elseif($persen_sks>0.24 and $persen_dpp>0.24){
			// }elseif($persen_bayar > 0.24 ){
				// //$save="Pembayaran SKS Sudah lebih dari 25%";
				// $kelas_mhs=array(
					// 'nmr_tagihan'		=> $tag_sks['detail'][0]['nmr_tagihan'],
				// );
				// $url=ADD_API.'simak/proses_validasi_kelas_krs';
				// $this->curl->http_header('token',$_SESSION['API_KEY']);
				// $this->curl->http_header('bearer','SIMAK');
				
				// //update kuliah_mahasiswa
				// $save= $this->curl->simple_put($url,$kelas_mhs);

				// $data=array(
					// 'id_mahasiswa_pt'	=>$id_mahasiswa_pt,
				// );

				// $url=ADD_API.'keu/update_krs_to_nilai_mhs';
				// //exec api
				// $this->curl->simple_post($url,$data);

			// }else{
				// $save="Pembayaran SKS atau DPP Kurang dari 25%";
			// }
		// }
	// $detail_kk 			= $this->curl->simple_get(ADD_API.'dhmd/detail_kelas_kuliah/'.$id_kelas_kuliah);
		// $data['detail_kk'] 	= json_decode($detail_kk, true)[0];

		// $riwayat_kuliah		= $this->curl->simple_get(ADD_API.'dhmd/riwayat_kuliah/'.$id_kelas_kuliah);
		// $data['riwayat_kuliah'] = json_decode($riwayat_kuliah, true);

		// $peserta_kuliah 	= $this->curl->simple_get(ADD_API.'dhmd/peserta_kuliah/'.$id_kelas_kuliah);
		// $data['mahasiswa'] 	= json_decode($peserta_kuliah, true);

		// $persentase_nilai 	= $this->curl->simple_get(ADD_API.'dhmd/persentase_nilai/'.$id_kelas_kuliah);
		// $cek_persentase 	= json_decode($persentase_nilai, true);
		// if (count($cek_persentase) <= 0)
		// {
		// 	$this->curl->simple_get(ADD_API.'dhmd/input_persentase_nilai/'.$id_kelas_kuliah);
		// 	redirect($this->uri->uri_string(),'refresh');
		// }
		// $data['persentase_nilai'] 	= json_decode($persentase_nilai, true)[0];

		// $data['title']	= $data['detail_kk']['nm_mk'].'_'.$data['detail_kk']['nm_kls'].'_('.strtoupper($data['detail_kk']['nama_prodi']).')';

		// $template = $this->load->view('dhmd/cetaknilai', $data, true);

		// $mpdf->SetHTMLHeader('
		// 	<div style="text-align: right;">
		// 		<small>'.$data['detail_kk']['nm_mk'].' ('.$data['detail_kk']['nm_kls'].') - '.$data['detail_kk']['nama_semester'].'</small>
		// 	</div>');

		
		
		// $filename	= $data['detail_kk']['id_semester'].' '.$data['detail_kk']['inisial_fak'].' '.$data['detail_kk']['inisial_prodi'].' - '.$data['detail_kk']['nm_mk'].' ('.$data['detail_kk']['nm_kls'].')_'.time().'.pdf';
		// $mpdf->Output('nilai/'.$filename, 'F');
	// $detail_kk 			= $this->curl->simple_get(ADD_API.'dhmd/detail_kelas_kuliah/'.$id_kelas_kuliah);
		// $data['detail_kk'] 	= json_decode($detail_kk, true)[0];

		// $riwayat_kuliah		= $this->curl->simple_get(ADD_API.'dhmd/riwayat_kuliah/'.$id_kelas_kuliah);
		// $data['riwayat_kuliah'] = json_decode($riwayat_kuliah, true);

		// $peserta_kuliah 	= $this->curl->simple_get(ADD_API.'dhmd/peserta_kuliah/'.$id_kelas_kuliah);
		// $data['mahasiswa'] 	= json_decode($peserta_kuliah, true);

		// $persentase_nilai 	= $this->curl->simple_get(ADD_API.'dhmd/persentase_nilai/'.$id_kelas_kuliah);
		// $cek_persentase 	= json_decode($persentase_nilai, true);
		// if (count($cek_persentase) <= 0)
		// {
		// 	$this->curl->simple_get(ADD_API.'dhmd/input_persentase_nilai/'.$id_kelas_kuliah);
		// 	redirect($this->uri->uri_string(),'refresh');
		// }
		// $data['persentase_nilai'] 	= json_decode($persentase_nilai, true)[0];

		// $data['title']	= $data['detail_kk']['nm_mk'].'_'.$data['detail_kk']['nm_kls'].'_('.strtoupper($data['detail_kk']['nama_prodi']).')';

		// $template = $this->load->view('dhmd/cetaknilai', $data, true);

		// $mpdf->SetHTMLHeader('
		// 	<div style="text-align: right;">
		// 		<small>'.$data['detail_kk']['nm_mk'].' ('.$data['detail_kk']['nm_kls'].') - '.$data['detail_kk']['nama_semester'].'</small>
		// 	</div>');

		
		
		// $filename	= $data['detail_kk']['id_semester'].' '.$data['detail_kk']['inisial_fak'].' '.$data['detail_kk']['inisial_prodi'].' - '.$data['detail_kk']['nm_mk'].' ('.$data['detail_kk']['nm_kls'].')_'.time().'.pdf';
		// $mpdf->Output('nilai/'.$filename, 'F');

// function $this->create_tag_dpp($id_mhs_pt=null)
	// {
		// if($id_mhs_pt==null){return false;}else{
			// return $this->Simak_model->create_tag_dpp($id_mhs_pt);
		// }
		// // $km=json_decode($this->curl->simple_get(ADD_API.'simak/kuliah_mahasiswa_get?id_mahasiswa_pt='.$id_mhs_pt.'&id_smt='.$id_semester),true);
		// // $detail_mhs=json_decode($this->curl->simple_get(ADD_API.'simak/mahasiswa_pt?id_mahasiswa_pt='.$id_mhs_pt))[0];
		// // $check_krs_skr=json_decode($this->curl->simple_get(ADD_API.'simak/check_krs_skr?id_mahasiswa_pt='.$id_mhs_pt.'&id_smt='.$id_semester));
		// // $check_jml_krs=json_decode($this->curl->simple_get(ADD_API.'simak/check_jml_krs?id_mahasiswa_pt='.$id_mhs_pt.'&id_smt='.$id_semester));
		// // $start_smt=substr($detail_mhs->mulai_smt,0,4);
		// // $mulai_smt=$start_smt.'/'.($start_smt+1);
		
		// // $detail_dpp=json_decode($this->curl->simple_get(ADD_API.'keu/detail_biaya?kode_prodi='.$detail_mhs->kode_prodi.'&tahun_akademik='.$mulai_smt.'&kode_jenis_tagihan=DPP'))[0];
		
		// // /*KALKULASI BIAYA DPP
		// // if($km['detail'][0]['smt_mhs']>=9 and $check_krs_skr and $check_jml_krs==1){
			// // $biaya_dpp=$detail_dpp->jumlah*0.25;
		// // }else if($km['detail'][0]['smt_mhs']>=9 and $check_krs_skr and $check_jml_krs>1){
			// // $biaya_dpp=$detail_dpp->jumlah*0.5;
		// // }else{
			// // $biaya_dpp=$detail_dpp->jumlah;
		// // }
		
		// // $smt=str_split($id_semester);
		// // if($smt[4]==1){
			// // $smt_akademik='Ganjil';
		// // }elseif($smt[4]==2){
			// // $smt_akademik='Genap';
		// // }else{
			// // $smt_akademik='Pendek';
		// // }
		
		// // $thn_aka=substr($id_semester,0,4);
		// // $thn_akademik=$thn_aka.'/'.($thn_aka+1);
		// // $tag_dpp=array(
			// // 'npm' 				=> $id_mhs_pt,
			// // 'nmr_daftar' 		=> $detail_mhs->id_mhs,
			// // 'kode_prodi' 		=> $detail_mhs->kode_prodi,
			// // 'jenis_tagihan' 	=> 'DPP',
			// // 'thn_akademik' 		=> $thn_akademik,
			// // 'smt_akademik' 		=> $smt_akademik,
			// // 'tgl_tagihan' 		=> date('Y-m-d'),
			// // 'besar_tagihan' 	=> $biaya_dpp,
			// // 'sisa_tagihan' 		=> $biaya_dpp,
			// // 'keterangan' 		=> 'DPP Tahun Akademik '.$thn_akademik.' Semester '.$smt_akademik,
			// // 'id_smt'			=> $id_semester,
		// // );
		
		// // $url=ADD_API.'keu/create_tag_mhs';
		// // $this->curl->http_header('token',$_SESSION['API_KEY']);
		// // $this->curl->http_header('bearer','SIMAK');
		
		// // //store tagihan mahasiswa
		// // $save_dpp=$this->curl->simple_post($url,$tag_dpp);	
		// // //var_dump($tag_dpp);
		// // //if kelas karyawan
		// // if($detail_mhs->kelas_mhs==2){
			// // $detail_dkk=json_decode($this->curl->simple_get(ADD_API.'keu/detail_biaya?kode_prodi='.$detail_mhs->kode_prodi.'&tahun_akademik='.$mulai_smt.'&kode_jenis_tagihan=DKK'))[0];
			// // $jml_dkk=$detail_dkk->jumlah-$detail_dpp->jumlah;
			// // $tag_dkk=array(
				// // 'npm' 				=> $id_mhs_pt,
				// // 'nmr_daftar' 		=> $detail_mhs->id_mhs,
				// // 'kode_prodi' 		=> $detail_mhs->kode_prodi,
				// // 'jenis_tagihan' 	=> 'DKK',
				// // 'thn_akademik' 		=> $thn_akademik,
				// // 'smt_akademik' 		=> $smt_akademik,
				// // 'tgl_tagihan' 		=> date('Y-m-d'),
				// // 'besar_tagihan' 	=> $jml_dkk,
				// // 'sisa_tagihan' 		=> $jml_dkk,
				// // 'keterangan' 		=> 'DPP Kelas Karyawan Tahun Akademik '.$thn_akademik.' Semester '.$smt_akademik,
				// // 'id_smt'			=> $id_semester,
			// // );
		// // $url=ADD_API.'keu/create_tag_mhs';
		// // $this->curl->http_header('token',$_SESSION['API_KEY']);
		// // $this->curl->http_header('bearer','SIMAK');
		
		// // //store tagihan mahasiswa
		// // $save_dkk=$this->curl->simple_post($url,$tag_dkk);
		// // }
		// // return $save_dpp;
	// } */