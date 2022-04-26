<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model
{
	function sidebar_mhs()
	{
		$data=array(
			array(
				'has-sub'=>FALSE,
				'menu_link'=>'dashboard',
				'menu_text'=>'Dashboard',
				'menu_color'=>'',
				'menu_icon'=>'ft-home'
			),
			array(
				'has-sub'=>FALSE,
				'menu_link'=>'usulan',
				'menu_text'=>'Kampus Merdeka',
				'menu_color'=>'',
				'menu_icon'=>'ft-file-text'
			),
			// array(
			// 	'has-sub'=>FALSE,
			// 	'menu_link'=>'bimbingan',
			// 	'menu_text'=>'Bimbingan',
			// 	'menu_color'=>'',
			// 	'menu_icon'=>'fa fa-user-friends'
			// ),
			// array(
			// 	'has-sub'=>TRUE,
			// 	'menu_color'=>'',
			// 	'menu_text'=>'Aktivitas',
			// 	'menu_icon'=>'fas fa-user-friends',
			// 	//#1..n
			// 	'menu_child'=>	array(
			// 						array(
			// 							'menu_link'=>'bimbingan/dosen_pembimbing',
			// 							'menu_text'=>'Dosen Pembimbing',
									
			// 						),array(
			// 							'menu_link'=>'bimbingan/dosen_penguji',
			// 							'menu_text'=>'Dosen Penguji',
			// 						),array(
			// 							'menu_link'=>'bimbingan/ketua_sidang',
			// 							'menu_text'=>'Ketua Sidang',
			// 						)
			// 					),
			// ),
			array(
				'has-sub'=>FALSE,
				'menu_link'=>'biodata',
				'menu_text'=>'Data Diri',
				'menu_color'=>'',
				'menu_icon'=>'ft-user'
			),
			// array(
				// 'has-sub'=>TRUE,
				// 'menu_color'=>'bg-warning',
				// 'menu_text'=>'Perwalian (KRS)',
				// 'menu_icon'=>'fas fa-file-contract',
				// //#1..n
				// 'menu_child'=>	array(
									// array(
										// 'menu_link'=>'krs/add',
										// 'menu_text'=>'Kartu Rencana Studi',
									
									// ),array(
										// 'menu_link'=>'krs/krsriwayat',
										// 'menu_text'=>'Riwayat KRS (n/a)',
									// )
								// ),
			// ),
			
		);
		return $data;
	}

	function sidebar_dosen()
	{
		$data=array(
			array(
				'has-sub'=>FALSE,
				'menu_link'=>'dashboard',
				'menu_text'=>'Dashboard',
				'menu_color'=>'',
				'menu_icon'=>'ft-home'
			),
			//#1
			array(
				'has-sub'=>TRUE,
				'menu_text'=>'Peserta',
				'menu_icon'=>'ft-users',
				'menu_color'=>'bg-primary',
				//#1..n
				'menu_child'=>	array(
									array(
										'menu_link'=>'peserta',
										'menu_text'=>'Daftar Peserta',
									),array(
										'menu_link'=>'peserta/add_nilai',
										'menu_text'=>'Input Nilai',
									),
								),
			),
			array(
				'has-sub'=>FALSE,
				'menu_link'=>'kegiatan',
				'menu_text'=>'Kegiatan',
				'menu_color'=>'bg-warning',
				'menu_icon'=>'ft-layers'
			),
			//#1
			// array(
				// 'has-sub'=>TRUE,
				// 'menu_text'=>'e-DHMD',
				// 'menu_icon'=>'la la-bookmark',
				// 'menu_color'=>'bg-warning',
				// //#1..n
				// 'menu_child'=>	array(
									// array(
										// 'menu_link'=>'dhmd/kelas_kuliah',
										// 'menu_text'=>'Kelas Kuliah',
									// ),array(
										// 'menu_link'=>'dhmd/arsip/'. $this->session->userdata('username'),
										// 'menu_text'=>'Arsip Kelas Kuliah',
									// ),array(
										// 'menu_link'=>'dhmd/panduan',
										// 'menu_text'=>'Panduan e-DHMD',
									// ),
								// ),
			// ),
			//#2
			
		);
		return $data;
	}
	
	function sidebar_p3m()
	{
		$data=array(
			array(
				'has-sub'=>FALSE,
				'menu_link'=>'dashboard',
				'menu_text'=>'Dashboard',
				'menu_color'=>'',
				'menu_icon'=>'ft-home'
			),
			array(
				'has-sub'=>FALSE,
				'menu_link'=>'kegiatan',
				'menu_text'=>'Kegiatan',
				'menu_color'=>'bg-warning',
				'menu_icon'=>'ft-layers'
			),
			array(
				'has-sub'=>TRUE,
				'menu_text'=>'Peserta',
				'menu_icon'=>'ft-users',
				'menu_color'=>'bg-primary',
				//#1..n
				'menu_child'=>	array(
									array(
										'menu_link'=>'peserta',
										'menu_text'=>'Daftar Peserta',
									),
								),
			),
			//#1
			// array(
				// 'has-sub'=>TRUE,
				// 'menu_text'=>'e-DHMD',
				// 'menu_icon'=>'la la-bookmark',
				// 'menu_color'=>'bg-warning',
				// //#1..n
				// 'menu_child'=>	array(
									// array(
										// 'menu_link'=>'dhmd/kelas_kuliah',
										// 'menu_text'=>'Kelas Kuliah',
									// ),array(
										// 'menu_link'=>'dhmd/arsip/'. $this->session->userdata('username'),
										// 'menu_text'=>'Arsip Kelas Kuliah',
									// ),array(
										// 'menu_link'=>'dhmd/panduan',
										// 'menu_text'=>'Panduan e-DHMD',
									// ),
								// ),
			// ),
			//#2
			
		);
		return $data;
	}

}