<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {
	public function __construct(){
		parent::__construct();

		$this->load->library('session');
	}

	public function index(){
		
		$db = $this->db->query("SELECT * FROM blw_produkvariasi as a JOIN blw_variasiwarna as b ON a.warna = b.id WHERE a.id = '36'")->row_array();

		$path = $path = 'cdn/uploads/'.$db['foto'];

		$this->load->helper("file");
		delete_files($path);
	}
}
