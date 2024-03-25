<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_produk extends CI_Controller { 

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_terjual');
		$this->load->model('m_withdraw');
		$this->load->model('m_withdraw_history');
		$this->load->library('session');
	}

	public function index()
	{

		$this->load->view("headv2",array("titel"=>"Upload Produk"));
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
			$this->load->view("headv2",array("titel"=>"Upload Produk"));
			$this->load->view("upload_produk/add",["id"=>$id]);
			//$this->load->view("footv2");
			$this->load->view('atmin/admin/foot');
		}
	}
	function terjual(){

		$this->load->view("headv2",array("titel"=>"Terjual"));
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

		$user = $_SESSION["usrid"];
		$data['status'] = $this->db->query("SELECT status AS status, nominal AS nominal, DATE_FORMAT(tanggal, '%d/%m/%Y') as tanggal FROM blw_withdraw WHERE user = '$user' AND status = 0")->row_array();

		$this->load->view("headv2",array("titel"=>"Withdraw"));
		$this->load->view("upload_produk/withdraw", $data);
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
	function withdraw_nominal(){

		$user = $_SESSION["usrid"];

		$t = $this->db->query("SELECT SUM(b.hargabeli * b.jumlah) as total FROM blw_transaksi AS a JOIN blw_transaksiproduk AS b ON a.id = b.idtransaksi JOIN blw_produk AS c ON b.idproduk = c.id WHERE c.`user` = '$user'")->row_array();

		$w = $this->db->query("SELECT SUM(nominal) AS nominal FROM blw_withdraw WHERE user = '$user' AND status != 2 AND hapus = 0")->row_array();

		$x = @$t['total'] - @$w['nominal'];

		echo json_encode($x);
	}
	function withdraw_request(){

		$user = $_SESSION["usrid"];

		$set = array(
						'user' => $user,
						'rekening' => strip_tags(@$_POST['rekening']),
						'kode' => strip_tags(@$_POST['kode']),
						'nominal' => strip_tags(@$_POST['nominal']),
					);

		$this->db->set($set);
		if ($this->db->insert('blw_withdraw')) {

			$this->session->set_flashdata('sukses', 'data sudah di kirim');
		}else{
			$this->session->set_flashdata('gagal', 'gagal kirim data, coba ulangi beberapa saat lagi');
		}

		echo redirect(base_url('upload_produk/withdraw'));
	}
	function withdraw_history(){

		$this->load->view("headv2",array("titel"=>"Withdraw"));
		$this->load->view("upload_produk/withdraw_history");
		$this->load->view("footv2");
	}
	function withdraw_history_get(){

		$user = $_SESSION["usrid"];
		$where = array('status !=' => 0, 'user' => $user);

	    $data = $this->m_withdraw_history->get_datatables($where);
		$total = $this->m_withdraw_history->count_all($where);
		$filter = $this->m_withdraw_history->count_filtered($where);

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