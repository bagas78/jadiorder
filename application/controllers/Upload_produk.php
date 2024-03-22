<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_produk extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_terjual');
		$this->load->model('m_withdraw');
		$this->load->library('session');
	}

	public function index()
	{

		$this->load->view("headv2",array("titel"=>"Akun Saya"));
		$this->load->view("upload_produk/index");
		$this->load->view("footv2");
	}
	public function produk(){
 
		//get produk
		$res = $this->load->view('upload_produk/list',"",true);
		echo json_encode(["result"=>$res,"token"=>$this->security->get_csrf_hash()]);
	}
	public function add($id=0){

		
		if(isset($_POST["nama"])){
			
			$_POST["id"] = $this->admfunc->clean(@$_POST["id"]);
			
			//data
			$data = [
				"tgl"	=> date("Y-m-d H:i:s"),
				"nama"	=> @$_POST["nama"],
				"deskripsi"=> @$_POST["deskripsi"],
			];

			//submit
			if($_POST["id"] > 0){

				//update
				$this->db->where("id",@$_POST["id"]);
				$this->db->update("produk",$data);
				
				redirect(base_url("upload_produk"));
			}else{

				//simpan 
				$this->db->insert("produk",$data);
				$insertid = $this->db->insert_id();
				
				redirect(base_url("upload_produk"));
			}

		}else{
			$this->load->view("headv2",array("titel"=>"Akun Saya"));
			$this->load->view("upload_produk/add",["id"=>$id]);
			//$this->load->view("footv2");
			$this->load->view('atmin/admin/foot');
		}
	}
	function terjual(){

		$this->load->view("headv2",array("titel"=>"Akun Saya"));
		$this->load->view("upload_produk/terjual");
		$this->load->view("footv2");
	}
	function terjual_get(){

		$user = $_SESSION["usrid"];
		$where = array('blw_transaksi.status' => 3, 'blw_produk.user' => $user);

	    $data = $this->m_terjual->get_datatables($where);
		$total = $this->m_terjual->count_all($where);
		$filter = $this->m_terjual->count_filtered($where);

		$output = array(
			"draw" => $_GET['draw'],
			"recordsTotal" => $total,
			"recordsFiltered" => $filter,
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}
	function withdraw(){

		$this->load->view("headv2",array("titel"=>"Akun Saya"));
		$this->load->view("upload_produk/withdraw");
		$this->load->view("footv2");
	}
	function withdraw_get(){

		$user = $_SESSION["usrid"];
		$where = array('blw_transaksi.status' => 3, 'blw_produk.user' => $user);

	    $data = $this->m_withdraw->get_datatables($where);
		$total = $this->m_withdraw->count_all($where);
		$filter = $this->m_withdraw->count_filtered($where);

		$output = array(
			"draw" => $_GET['draw'],
			"recordsTotal" => $total,
			"recordsFiltered" => $filter,
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}
}