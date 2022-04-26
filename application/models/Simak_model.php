<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Simak_model extends CI_Model
{
	
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