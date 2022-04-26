<?php
/*MULTI ACCESS */
defined('BASEPATH') OR exit('No direct script access allowed');

class Biodata extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		if(empty($_SESSION['logged_in']) or $_SESSION['logged_in']==FALSE){ redirect ('https://satu.unma.ac.id');}
		if(empty($_SESSION['app_level']) or $_SESSION['app_level']==FALSE){ redirect ('https://satu.unma.ac.id');}
	}
	
	public function index()
	{
		if($_SESSION['app_level']==2){
		$data['assets_css']	=array(	"themes/vendors/css/tables/datatable/datatables.min.css");
		$data['assets_js']	=array(	"themes/vendors/js/tables/datatable/datatables.min.js","assets/jquery-ui/jquery-ui.min.js");
		
		$detail=json_decode($this->curl->simple_get(ADD_API.'simak/dosen?nidn='.$_SESSION['username']))[0];
		$data['detail']	=$detail;
		$data['title']	='Detail '.$detail->nm_sdm;
		$data['view']	='dosen/detail';
		$data['nidn']	=$_SESSION['username'];
		$this->load->view('lyt/index',$data);
		
		}else if($_SESSION['app_level']==1){
		
		$data['assets_css']	=array(	"themes/vendors/css/tables/datatable/datatables.min.css");
		$data['assets_js']	=array(	"themes/vendors/js/tables/datatable/datatables.min.js","assets/jquery-ui/jquery-ui.min.js");

		$data['head'] = [
						'<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/univmajalengka/cdn@master/themes/vendors/css/forms/selects/selectize.css">',
						'<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/univmajalengka/cdn@master/themes/vendors/css/forms/selects/selectize.default.css">',
						'<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/univmajalengka/cdn@master/themes/css/plugins/forms/selectize/selectize.min.css">',
						''
					];
		$data['footer'] = [
						'<script src="https://cdn.jsdelivr.net/gh/univmajalengka/cdn@master/themes/vendors/js/forms/select/selectize.min.js"></script>',
						"<script>
							var select = $('.id_wil').selectize({
								valueField: 'id_wil',
								labelField: 'kecamatan',
								searchField: 'kecamatan',
								create: false,
								preload: true,
								render: {
									option: function(item, escape) {
										return '<div>'+ escape(item.kecamatan) +', '+ escape(item.kota) +'</div>';
									}
								},
								load: function(query, callback) {
									if (!query.length) return callback();
									$.ajax({
										url: '".base_url('biodata/get_wilayah')."',
										type: 'GET',
										data: {
												kecamatan: decodeURIComponent(query)
											},
										error: function() {
											callback();
										},
										success: function(res) {
											callback(JSON.parse(res).data);
										}
									});
								},
								onChange: function(value) {
									if (value == '') return false;
									$.ajax({
										url: '".base_url('biodata/save_wilayah')."',
										type: 'GET',
										data: {
											id_wil: value
										},
										success: function(res) {
											toastr.info(res);
										}
									});
								}
							})
						</script>"
					];
		
		$detail=json_decode($this->curl->simple_get(ADD_API.'simak/mahasiswa?id_mhs='.$_SESSION['username']))[0];
		$data['detail']	=$detail;
		$data['title']	='Detail '.$detail->nm_pd;
		$data['view']	='biodata/index';
		$data['id_mhs']	=$_SESSION['username'];
		
		$this->load->view('lyt/index',$data);
		}else{$this->load->view('auth/401'); }
	}

	function get_wilayah() {
		$kecamatan = json_decode($this->curl->simple_get(ADD_API.'aktivitas/get_kecamatan?kecamatan='.$this->input->get('kecamatan')), true);
		echo json_encode([ 'data' => $kecamatan ]);
	}

	function save_wilayah() {
		$wilayah = json_decode($this->curl->simple_get(ADD_API.'aktivitas/save_wilayah?id_wil='.$this->input->get('id_wil').'&username='.$_SESSION['username']), true);
		// echo json_encode([ 'data' => $wilayah ]);
		echo '<strong>Berhasil!</strong> Data Berhasil di Perbarui.';
	}

	/* function egy()
	{
		$url = $this->curl->simple_get(ADD_API.'simak/mahasiswa?id_mhs='.$_SESSION['username']);
		$detail=json_decode($url)[0];
		echo $detail->jalan;
	} */
	
	//tab detail#data_ajar
	function data_tugas($id_dosen=NULL)
	{
		$data['id_dosen']=$id_dosen;
		$this->load->view('dosen/data_tugas',$data);
	}
	
	//tab detail#data_ajar
	function data_ajar($id_dosen=NULL)
	{
		$data['id_dosen']	=$id_dosen;
		$this->load->view('dosen/data_ajar',$data);
	}
	
	//tab detail#data_wali
	function data_wali($id_dosen=NULL)
	{
		$data['id_dosen']	=$id_dosen;
		$this->load->view('dosen/data_wali',$data);
	}
	
	//tab detail#data_ajar
	function data_ajar_mhs()
	{
		$data['id_mhs']=$_SESSION['username'];
		$data['detail']	=json_decode($this->curl->simple_get(ADD_API.'simak/mahasiswa_pt?id_mahasiswa_pt='.$_SESSION['id_user']))[0];
		$this->load->view('biodata/data_ajar_mhs',$data);
	}
	
	function data_file_mhs()
	{
		$data['jenis_file']=array(18=>'Pas Foto','KTP','Kartu Keluarga','Ijazah Terakhir','Avatar');
		$data['id_mhs']=$_SESSION['username'];
		$data['assets_js']=	array(	"themes/js/core/libraries/jquery_ui/jquery-ui.min.js");
		$data['file_pmb']	=json_decode($this->curl->simple_get(ADD_API.'filez/files_mhs?id_mhs='.$data['id_mhs']));
		$this->load->view('biodata/data_file_mhs',$data);
	}
	
	function update_profil()
	{
		$username=$_SESSION['username'];
		$jalan=$this->input->post('jalan');
		$blok=$this->input->post('blok');
		$rt=$this->input->post('rt');
		$rw=$this->input->post('rw');
		$kelurahan=$this->input->post('kelurahan');
		
		$catatan=array(
			'username'	=>$username,
			'jalan'		=>$jalan,
			'blok'		=>$blok,
			'rt'		=>$rt,
			'rw'		=>$rw,
			'kelurahan'		=>$kelurahan,
		);
		
		//exec api
		$hapeemail=$this->curl->simple_get(ADD_API.'aktivitas/update_profil?'.http_build_query($catatan));
		if($hapeemail){
			echo '<strong>Berhasil!</strong> Data Berhasil di Perbarui.';
		}else{
			echo '<div class="col-12 mt-2">
		<div class="alert alert-icon-left alert-danger alert-dismissible mb-1" role="alert">
		<span class="alert-icon"><i class="la la-thumbs-o-down"></i></span>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">×</span>
		</button>
			<strong>Gagal!</strong> Coba Lagi.
		</div>
	</div>';
		}
	}
	
	public function upload()
	{
		if ($this->input->is_ajax_request()) {
				$nmr_daftar=$_SESSION['username'];
				$jenis_file=$this->input->post('jenis_file', true);
				$error_message = '';
				if ( ! empty($_FILES['cover']) ) {
					$upload = $this->upload_image($nmr_daftar,$jenis_file);
					if ($upload['status'] == 'success') {
						$new_img = $upload['file_name'];
					} else {
						$error_message = $upload['message'];
					}
				}
				if ( ! empty( $error_message ) ) {
					$this->vars['status'] = 'error';
					$this->vars['message'] = $error_message;
				} else {
					$catatan=array(
						'nmr_daftar'	=>$nmr_daftar,
						'jenis_file'	=>$jenis_file,
						'nama_file'		=>$new_img,
					);
					
					$url=ADD_API.'filez/store_img';
					//exec api
					$query=$this->curl->simple_put($url,$catatan);
					//$query = $this->Kegiatan_model->update($nmr_daftar,$jenis_file,$new_img);
					
					$this->vars['status'] = $query ? 'success' : 'error';
					$this->vars['message'] = $query ? 'Data Anda berhasil disimpan. Silahkan Reload jika diperlukan' : 'Terjadi kesalahan dalam menyimpan data';
					
				}
			
			$this->output
				->set_content_type('application/json', 'utf-8')
				->set_output(json_encode($this->vars, JSON_HEX_APOS | JSON_HEX_QUOT))
				->_display();
			exit;
		}
	}
	
	/**
	 * Post Image Upload Handler
	 * @param Integer $id
	 * @return 	Array
	 */
	private function upload_image($nmr_daftar,$jenis_file) {
		$config['upload_path'] = './files/mahasiswa/';
		$config['allowed_types'] = 'jpg|png|jpeg|gif';
		$config['max_size'] = 0;
		$config['encrypt_name'] = true;
		$this->load->library('upload', $config);
		if (!$this->upload->do_upload('cover')) {
			$this->vars['status'] = 'error';
			$this->vars['message'] = $this->upload->display_errors();
		} else {
			$file = $this->upload->data();
			// chmood new file
			@chmod(FCPATH.'files/mahasiswa/'.$file['file_name'], 0777);
			// resize new image
			$this->image_resize(FCPATH.'files/mahasiswa', $file['file_name']);
			$this->vars['status'] = 'success';
			$this->vars['file_name'] = $file['file_name'];
			
			$query = json_decode($this->curl->simple_get(ADD_API.'filez/get_file?id_mhs='.$nmr_daftar.'&jenis_file='.$jenis_file));
			if ($query ) {
				// chmood old file
				@chmod(FCPATH.'files/mahasiswa/thumbnail/'.$query[0]->nama_file, 0777);
				@chmod(FCPATH.'files/mahasiswa/large/'.$query[0]->nama_file, 0777);
				// unlink old file
				@unlink(FCPATH.'files/mahasiswa/thumbnail/'.$query[0]->nama_file);
				@unlink(FCPATH.'files/mahasiswa/large/'.$query[0]->nama_file);
			}
		}
		return $this->vars;
	}
	
	/**
	 * Image Resize
	 * @param String $path
	 * @param String $file_name
	 * @return Void
	 */
	private function image_resize($path, $file_name) {
		$this->load->library('image_lib');
		// Thumbnail Image
		$thumb['image_library'] = 'gd2';
		$thumb['source_image'] = $path .'/'. $file_name;
		$thumb['new_image'] = './files/mahasiswa/thumbnail/'. $file_name;
		$thumb['maintain_ratio'] = true;
		$thumb['width'] = 100;
		$thumb['height'] = 100;
		$this->image_lib->initialize($thumb);
		$this->image_lib->resize();
		$this->image_lib->clear();
		// Large Image
		$large['image_library'] = 'gd2';
		$large['source_image'] = $path .'/'. $file_name;
		$large['new_image'] = './files/mahasiswa/large/'. $file_name;
		$large['maintain_ratio'] = true;
		$large['width'] = 600;
		$large['height'] = 1000;
		$this->image_lib->initialize($large);
		$this->image_lib->resize();
		$this->image_lib->clear();
		// Remove Original File
		@unlink($path .'/'. $file_name);
	}
}