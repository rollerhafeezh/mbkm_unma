<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//use \Firebase\JWT\JWT;

class Dashboard extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		if(empty($_SESSION['logged_in']) or $_SESSION['logged_in']==FALSE){ redirect ('https://satu.unma.ac.id');}
	}
	
	public function index()
	{
		$data['title']	='Dashboard';
		$data['view']	='dashboard/index';
		$this->load->view('lyt/index', $data);
	}
}