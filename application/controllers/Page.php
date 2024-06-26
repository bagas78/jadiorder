<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller {
	public function __construct(){
		parent::__construct();

		$this->load->library('session');
	}

	public function index($slug){
		$this->load->view("headv2",array("titel"=>ucwords(strtolower($slug))));
		$this->load->view("main/page",["slug"=>$slug]);
		$this->load->view("footv2");
	}
}
