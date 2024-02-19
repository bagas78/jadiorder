<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_produk extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->library('session');
	}

	public function index()
	{

		$this->load->view("headv2",array("titel"=>"Akun Saya"));
		$this->load->view("Upload_produk/index");
		$this->load->view("footv2");
	}
}