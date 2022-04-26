<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Log_model extends CI_Model
{	
	function riwayat_usulan($id_usulan,$kegiatan)
	{
		$this->load->database();
		$data=array('id_usulan'=>$id_usulan,'kegiatan'=>$kegiatan,'oleh'=>$_SESSION['username']);
		return $this->db->insert(DB_HIBAH.'usulan_riwayat',$data);
	}

	function get_riwayat_usulan($id_usulan)
	{
		$this->load->database();
		return $this->db->get_where(DB_HIBAH.'usulan_riwayat',array('id_usulan' => $id_usulan));
	}

	public function log_hibah($whythis,$action)
	{
		$data=array(
			'whois'		=> $_SESSION['username'],
			'whythis'	=> $whythis,
			'whatdo'	=> $action,
			'wherefrom'	=> $this->getUserIpAddr()
		);				
		$url=ADD_API.'hibah/log_hibah';
		$this->curl->simple_post($url,$data);
	}
	
	public function log_keuangan($whythis,$action)
	{
		$data=array(
			'whois'		=> $_SESSION['username'],
			'whythis'	=> $whythis,
			'whatdo'	=> $action,
			'wherefrom'	=> $this->getUserIpAddr()
		);				
		$url=ADD_API.'keu/log_keuangan';
		$this->curl->simple_post($url,$data);
	}
	
	public function log_akademik($whythis,$action){	
		$data=array(	
			'whois'		=> $_SESSION['username'],
			'whythis'	=> $whythis,			
			'whatdo'	=> $action,			
			'wherefrom'	=> $this->getUserIpAddr()		
		);		
		$url=ADD_API.'simak/log_akademik';		
		$this->curl->simple_post($url,$data);	
	}

	public function log_knm($whythis,$action){	
		$data=array(	
			'whois'		=> $_SESSION['username'],
			'whythis'	=> $whythis,			
			'whatdo'	=> $action,			
			'wherefrom'	=> $this->getUserIpAddr()		
		);		
		$url=ADD_API.'knm/log_knm';		
		$this->curl->simple_post($url,$data);	
	}	
	
	function getUserIpAddr()
	{			
		if(!empty($_SERVER['HTTP_CLIENT_IP']))
		{	        
			//ip from share internet	       
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}			
			elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
		{	        
			//ip pass from proxy
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}		
			else
		{	     
			$ip = $_SERVER['REMOTE_ADDR'];
		}	
			
			return $ip;	
	}
}