<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Simak_model extends CI_Model
{

		function check_tagihan($id_mhs_pt)
	{
		// $data['kode']	=$this->generate_kode_bayar();
		//data yang melalui controller ini dipastikan sudah membuat detail kuliah mahasiswa
		//check semester/ tahun awal mahasiswa 
		//$data['check_kuliah_mahasiswa']	=json_decode($this->curl->simple_get(ADD_API.'simak/kuliah_mahasiswa_get?id_mahasiswa_pt='.$id_mhs_pt.'&id_smt='.$_SESSION['active_smt']),true);
		$data['mahasiswa_pt']			=json_decode($this->curl->simple_get(ADD_API.'simak/mahasiswa_pt?id_mahasiswa_pt='.$id_mhs_pt),true);
		//if($data['check_kuliah_mahasiswa']['detail'][0]['smt_mhs']==1)
			
		//2021-11-05 CEK KALO MAHASISWA COBA BUAT KRS
		if($data['mahasiswa_pt'][0]['mulai_smt']>$_SESSION['active_smt'])
		{
			return 'err3'; //Belum Bisa KRS
		}
		if($data['mahasiswa_pt'][0]['mulai_smt']==$_SESSION['active_smt'])
		{ //jika mahasiswa baru
			$kode_jenis='REG';
		} //jika mahasiswa baru
		else
		{ //jika mahasiswa lama
			$kode_jenis='HER';
		} //jika mahasiswa lama
		
		//echo 'keu/cek_tag_mhs?nmr_daftar='.$data['mahasiswa_pt'][0]['id_mhs'].'&id_smt='.$_SESSION['active_smt'].'&jenis_tagihan='.$kode_jenis; exit();
		
		//check tagihan hereg
		$data['check_tagihan']=json_decode($this->curl->simple_get(ADD_API.'keu/cek_tag_mhs?nmr_daftar='.$data['mahasiswa_pt'][0]['id_mhs'].'&id_smt='.$_SESSION['active_smt'].'&jenis_tagihan='.$kode_jenis),true);
		
		//generate tagihan hereg
		if(!$data['check_tagihan']['status'] )
		{ //jika tagihan belum ditemukan maka generate tagihan
			return 'bayar'; 
		} //jika tagihan belum ditemukan maka generate tagihan
		
		//check invoice pembayaran
		$data['check_pembayaran']=json_decode($this->curl->simple_get(ADD_API.'keu/cek_inv?nmr_tagihan='.$data['check_tagihan']['detail'][0]['nmr_tagihan']),true);
		
		//generate invoice
		if(!$data['check_pembayaran']['status'])
		{ //jika invoice tidak ditemukan
			return 'bayar'; 
		} //jike invoice tidak ditemukan
		
		//$data['check_pembayaran_terbayar']=json_decode($this->curl->simple_get(ADD_API.'keu/cek_pem_terbayar?kode_bayar='.$data['check_pembayaran']['detail'][0]['kode_bayar']),true);
		$data['check_pembayaran_terbayar']=json_decode($this->curl->simple_get(ADD_API.'keu/cek_pem_terbayar?nmr_tagihan='.$data['check_tagihan']['detail'][0]['nmr_tagihan']),true);
			
		if($data['check_tagihan']['detail'][0]['sisa_tagihan']!=0 && $data['check_pembayaran_terbayar']['status']==false)
		{
			return $data['check_pembayaran']['detail'][0]['kode_bayar']; //tagihan tidak 0 dan belum terbayar
		}
		else if ($data['check_tagihan']['detail'][0]['sisa_tagihan']!=0 && $data['check_pembayaran_terbayar']['status']==true)
		{
			return 'err1'; //tagihan tidak 0 dan terbayar
		}
		else if ($data['check_tagihan']['detail'][0]['sisa_tagihan']==0 && $data['check_pembayaran_terbayar']['status']==false)
		{
			return 'err2'; //tagihan 0 dan belum berbayar
		}
		else
		{
			return 'ok'; //tagihan 0 dan terbayar
		}
	}
	
	function check_kuliah_mahasiswa($id_mhs_pt, $id_semester)
	{
		$mhs=json_decode($this->curl->simple_get(ADD_API.'mbkm/mahasiswa_pt?id_mahasiswa_pt='.$id_mhs_pt))[0];
		$km=json_decode($this->curl->simple_get(ADD_API.'mbkm/kuliah_mahasiswa_get?id_mahasiswa_pt='.$id_mhs_pt.'&id_smt='.$id_semester),true);
		
		if(!isset($km['status']) && $mhs->mulai_smt <= $id_semester){

			if(!$km){
				if($mhs->mulai_smt <= $id_semester){
					$patch=$this->mhs_patch($id_mhs_pt, $id_semester);
					$km=json_decode($this->curl->simple_get(ADD_API.'simak/kuliah_mahasiswa_get?id_mahasiswa_pt='.$id_mhs_pt.'&id_smt='.$id_semester),true);
				}else{
					$patch=$this->mhs_patch($id_mhs_pt, $id_semester);
					$km['detail'][0]['smt_mhs']=0;
				}
				
			} else {
				if($km['detail'][0]['smt_mhs']==0 && $mhs->mulai_smt <= $id_semester){
					$patch=$this->mhs_patch($id_mhs_pt, $id_semester);
					$km=json_decode($this->curl->simple_get(ADD_API.'simak/kuliah_mahasiswa_get?id_mahasiswa_pt='.$id_mhs_pt.'&id_smt='.$id_semester),true);
				}else if($km['detail'][0]['smt_mhs']!=0){
					$km=json_decode($this->curl->simple_get(ADD_API.'simak/kuliah_mahasiswa_get?id_mahasiswa_pt='.$id_mhs_pt.'&id_smt='.$id_semester),true);
				}else{
					$patch=$this->mhs_patch($id_mhs_pt, $id_semester);
					$km['detail'][0]['smt_mhs']=0;
				}
			}

		}
		
		return $km;
	}

	function mhs_patch($id_mhs_pt, $id_semester)
	{
		$smt_mhs=$this->smt_mhs($id_mhs_pt, $id_semester);
		//jika tidak ditemukan record kuliah_mahasiswa buat dulu
		$data_kirim=array(
			'id_mahasiswa_pt'	=>$id_mhs_pt,
			'id_smt'			=>$id_semester,
			'smt_mhs'			=>$smt_mhs
		);
		
		$url=ADD_API.'mbkm/kuliah_mahasiswa_set';
		//exec api
		$this->curl->http_header('token',$_SESSION['API_KEY']);
		$this->curl->http_header('bearer','SIMAK');
		$this->curl->simple_post($url,$data_kirim);
	}

	private function smt_mhs($id_mhs_pt, $id_semester)
	{
		/*semester berjalan genap / gajil/ pendek*/
		$smt=str_split($id_semester);
		if($smt[4]==3){
			$smt_mhs=0;
		}else{
			//CEK SEMESTER RUNNING MAHASISWA
			$cek_smt=json_decode($this->curl->simple_get(ADD_API.'simak/cek_smt?id_mahasiswa_pt='.$id_mhs_pt));
			$diff_smt=$id_semester-$cek_smt[0]->mulai_smt;
			switch($diff_smt){
				case 0 		: $smt_mhs=$cek_smt[0]->diterima_smt+0; 	break;
				case 1 		: $smt_mhs=$cek_smt[0]->diterima_smt+1; 	break;
				case 9 		: $smt_mhs=$cek_smt[0]->diterima_smt+1; 	break;
				case 10 	: $smt_mhs=$cek_smt[0]->diterima_smt+2; 	break;
				case 11 	: $smt_mhs=$cek_smt[0]->diterima_smt+3; 	break;
				case 19 	: $smt_mhs=$cek_smt[0]->diterima_smt+3; 	break;
				case 20 	: $smt_mhs=$cek_smt[0]->diterima_smt+4; 	break;
				case 21 	: $smt_mhs=$cek_smt[0]->diterima_smt+5; 	break;
				case 29 	: $smt_mhs=$cek_smt[0]->diterima_smt+5; 	break;
				case 30 	: $smt_mhs=$cek_smt[0]->diterima_smt+6; 	break;
				case 31 	: $smt_mhs=$cek_smt[0]->diterima_smt+7; 	break;
				case 39 	: $smt_mhs=$cek_smt[0]->diterima_smt+7; 	break;
				case 40 	: $smt_mhs=$cek_smt[0]->diterima_smt+8; 	break;
				case 41 	: $smt_mhs=$cek_smt[0]->diterima_smt+9; 	break;
				case 49 	: $smt_mhs=$cek_smt[0]->diterima_smt+9; 	break;
				case 50 	: $smt_mhs=$cek_smt[0]->diterima_smt+10; 	break;
				case 51 	: $smt_mhs=$cek_smt[0]->diterima_smt+11; 	break;
				case 59 	: $smt_mhs=$cek_smt[0]->diterima_smt+11; 	break;
				case 60 	: $smt_mhs=$cek_smt[0]->diterima_smt+12; 	break;
				case 61 	: $smt_mhs=$cek_smt[0]->diterima_smt+13; 	break;
				case 69 	: $smt_mhs=$cek_smt[0]->diterima_smt+13; 	break;
				case 70 	: $smt_mhs=$cek_smt[0]->diterima_smt+14; 	break;
				default		: $smt_mhs=0; break;
			}
		}
		return $smt_mhs;
	}
}