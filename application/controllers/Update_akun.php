<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update_akun extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('m_withdraw_verif');
		$this->load->library('session');
	}


	public function save(){  
		$akun = $this->session->userdata('usrid');

		if (@$_FILES['ktp']['name']) { 
				
			$typefile = explode('/', $_FILES['ktp']['type']);
			$filename = $_FILES['ktp']['name']; 

			//replace name foto
			$type = explode(".", $filename);
	    	$no = count($type) - 1;
	    	$new_name = md5($akun).'_'.time().'.'.$type[$no];  

	    	$path = 'assets/dropshipper';
	        
	        if (move_uploaded_file($_FILES['ktp']['tmp_name'], $path.'/'.$new_name)) {
	        	
	        	$set = array(
								'akun' => $akun, 
								'nama' => strip_tags($_POST['nama']),
								'lahir_tempat' => strip_tags($_POST['lahir_tempat']),
								'lahir_tanggal' => strip_tags($_POST['lahir_tanggal']),
								'kelamin' => strip_tags($_POST['kelamin']),
								'alamat' => strip_tags($_POST['alamat']), 
								'agama' => strip_tags($_POST['agama']),
								'kawin' => strip_tags($_POST['kawin']),
								'pekerjaan' => strip_tags($_POST['pekerjaan']),
								'kewarganegaraan' => strip_tags($_POST['kewarganegaraan']),
								'ktp' => $path.'/'.$new_name,
							);

				$this->db->set($set);
				$this->db->insert('blw_dropshipper');

				$this->session->set_flashdata('success', 'Data berhasil di kirim');
		    }else{

		    	$this->session->set_flashdata('fail', 'Foto gagal di upload, ukuran foto maksimal 2MB');
		    }

		}else{
			$this->session->set_flashdata('fail', 'Data gagal di kirim');
		}

		redirect(base_url('manage'));
	}
	function bukti(){

		$akun = $this->session->userdata('usrid');

		if (@$_FILES['bukti']['name']) {
				
			$typefile = explode('/', $_FILES['bukti']['type']);
			$filename = $_FILES['bukti']['name'];

			//replace name foto
			$type = explode(".", $filename);
	    	$no = count($type) - 1;
	    	$new_name = 'bukti_'.time().'.'.$type[$no];

	    	$path = 'assets/dropshipper';
	        
	        if (move_uploaded_file($_FILES['bukti']['tmp_name'], $path.'/'.$new_name)) {
	        	
	        	$set = array(
								'pembayaran' => $path.'/'.$new_name,
								'status' => 2,
							);

				$this->db->set($set);
				$this->db->where('akun', $akun);
				$this->db->update('blw_dropshipper');

				$this->session->set_flashdata('success', 'Data berhasil di kirim');
		    }else{

		    	$this->session->set_flashdata('fail', 'Foto gagal di upload, ukuran foto maksimal 2MB');
		    }

		}else{
			$this->session->set_flashdata('fail', 'Data gagal di kirim');
		}

		redirect(base_url('manage'));
	}
	function syarat($admin = ''){

		if ($admin == 1) {
			// edit admin

			$data['data'] = $this->db->query("SELECT * FROM blw_dropshipper_syarat")->row_array();

			$this->load->view('atmin/admin/head',["menu"=>31]);
			$this->load->view('dropshipper/syarat_index', $data);
			$this->load->view('atmin/admin/foot');

		}else{

			$data['data'] = $this->db->query("SELECT * FROM blw_dropshipper_syarat")->row_array();

			$this->load->view("headv2");
			$this->load->view("dropshipper/syarat", $data);
			$this->load->view("footv2");
		}
	}
	function syarat_save(){

		$akun = $this->session->userdata('admusrid');

		$set = array(
						'akun' => $akun,
						'isi' => @$_POST['isi'],
					);

		$this->db->set($set);

		$cek = $this->db->query("SELECT * FROM blw_dropshipper_syarat")->num_rows();
		if ($cek > 0) {
			//update
			$this->db->where('akun', $akun);
			if ($this->db->update('blw_dropshipper_syarat')) {
				$this->session->set_flashdata('success', 'Data berhasil di simpan');
			}else{
				$this->session->set_flashdata('fail', 'Data gagal di simpan');
			}
		}else{
			//insert
			if ($this->db->insert('blw_dropshipper_syarat')) {
				$this->session->set_flashdata('success', 'Data berhasil di simpan');
			}else{
				$this->session->set_flashdata('fail', 'Data gagal di simpan');
			}
		}

		redirect(base_url('update_akun/syarat/1'));
	}
	function rekening(){

		$data['data'] = $this->db->query("SELECT * FROM blw_dropshipper_bank")->result_array();

		$this->load->view('atmin/admin/head',["menu"=>32]);
		$this->load->view('dropshipper/rekening', $data);
		$this->load->view('atmin/admin/foot');

	}
	function rekening_add(){

		$this->load->view('atmin/admin/head',["menu"=>32]);
		$this->load->view('dropshipper/rekening_add');
		$this->load->view('atmin/admin/foot');
	}
	function rekening_save(){

		$akun = $this->session->userdata('admusrid');

		$set = array(
						'akun' => $akun,
						'bank' => strip_tags(@$_POST['bank']),
						'nama' => strip_tags(@$_POST['nama']),
						'kode' => strip_tags(@$_POST['kode']),
						'rekening' => strip_tags(@$_POST['rekening']),
					);

		$this->db->set($set);
		if ($this->db->insert('blw_dropshipper_bank')) {
			$this->session->set_flashdata('success', 'Data berhasil di simpan');
		}else{
			$this->session->set_flashdata('fail', 'Data gagal di simpan');
		}

		redirect(base_url('update_akun/rekening'));
	}
	function rekening_delete($id){

		$this->db->where('id', $id);
		if ($this->db->delete('blw_dropshipper_bank')) {
			$this->session->set_flashdata('success', 'Data berhasil di hapus');
		}else{
			$this->session->set_flashdata('fail', 'Data gagal di hapus');
		}

		redirect(base_url('update_akun/rekening'));

	}
	function rekening_edit($id){

		$data['data'] = $this->db->query("SELECT * FROM blw_dropshipper_bank WHERE id = '$id'")->row_array();

		$this->load->view('atmin/admin/head',["menu"=>32]);
		$this->load->view('dropshipper/rekening_add');
		$this->load->view('dropshipper/rekening_edit', $data);
		$this->load->view('atmin/admin/foot');
	}
	function rekening_update($id){

		$akun = $this->session->userdata('admusrid');

		$set = array(
						'akun' => $akun,
						'bank' => strip_tags(@$_POST['bank']),
						'nama' => strip_tags(@$_POST['nama']),
						'kode' => strip_tags(@$_POST['kode']),
						'rekening' => strip_tags(@$_POST['rekening']),
					);

		$this->db->set($set);
		$this->db->where('id', $id);
		if ($this->db->update('blw_dropshipper_bank')) {
			$this->session->set_flashdata('success', 'Data berhasil di simpan');
		}else{
			$this->session->set_flashdata('fail', 'Data gagal di simpan');
		}

		redirect(base_url('update_akun/rekening'));
	}
	function rekening_nominal(){

		$nominal = strip_tags(@$_POST['nominal']);
		$save = $this->db->query("UPDATE blw_dropshipper_bank SET nominal = '$nominal'");

		if ($save) {
			$this->session->set_flashdata('success', 'Data berhasil di simpan');
		}else{
			$this->session->set_flashdata('fail', 'Data gagal di simpan');
		}

		redirect(base_url('update_akun/rekening'));
	}
	function verifikasi(){

		$data['data'] = $this->db->query("SELECT a.status AS status, a.id AS id, b.nama AS nama, a.ktp AS ktp, a.pembayaran AS pembayaran FROM blw_dropshipper AS a JOIN blw_userdata AS b ON a.akun = b.id WHERE a.hapus = 0")->result_array();

		$this->load->view('atmin/admin/head',["menu"=>33]);
		$this->load->view('dropshipper/verifikasi', $data);
		$this->load->view('atmin/admin/foot');
	}
	function verifikasi_delete($id){

		$this->db->set('hapus', 1);
		$this->db->where('id', $id);
		if ($this->db->update('blw_dropshipper')) {
			$this->session->set_flashdata('success', 'Data berhasil di hapus');
		}else{
			$this->session->set_flashdata('fail', 'Data gagal di hapus');
		}

		redirect(base_url('update_akun/verifikasi'));
	}
	function verifikasi_view($id){

		$data['data'] = $this->db->query("SELECT *, b.nama AS kota FROM blw_dropshipper AS a JOIN blw_kab AS b ON a.lahir_tempat = b.id WHERE a.id = '$id'")->row_array();

		$this->load->view('atmin/admin/head',["menu"=>33]);
		$this->load->view('dropshipper/verifikasi_view', $data);
		$this->load->view('atmin/admin/foot');
	}
	function verifikasi_add($id){

		$this->db->set('status', 3);
		$this->db->where('id', $id);
		if ($this->db->update('blw_dropshipper')) {
			$this->session->set_flashdata('success', 'Akun berhasil di verifikasi');
		}else{
			$this->session->set_flashdata('fail', 'Akun gagal di verifikasi');
		}

		redirect(base_url('update_akun/verifikasi'));
	}
	function verifikasi_alert(){

		$data = $this->db->query("SELECT * FROM blw_dropshipper WHERE status = 2")->num_rows();
		echo json_encode($data);
	}


	// UPDATE PENJUALAN // 
	public function penjualan(){ 

		$akun = $this->session->userdata('usrid');
		$path = 'assets/penjualan';

		//upload sample

		$typefile1 = explode('/', $_FILES['sample']['type']);
		$filename1 = $_FILES['sample']['name'];

		//replace name foto
		$type1 = explode(".", $filename1);
    	$no1 = count($type1) - 1;
    	$new_name1 = 'sample_'.time().'.'.$type1[$no1];

    	if (move_uploaded_file($_FILES['sample']['tmp_name'], $path.'/'.$new_name1)) {
    		
    		//upload katalog

    		$typefile2 = explode('/', $_FILES['katalog']['type']);
			$filename2 = $_FILES['katalog']['name'];

			//replace name foto
			$type2 = explode(".", $filename2);
	    	$no2 = count($type2) - 1;
	    	$new_name2 = 'katalog_'.time().'.'.$type2[$no2];

	    	if (move_uploaded_file($_FILES['katalog']['tmp_name'], $path.'/'.$new_name2)) {

	    		$set = array(	
	    						'akun' => $akun,
	    						'status' => 1,
								'sample' => $path.'/'.$new_name1,
								'katalog' => $path.'/'.$new_name2,
							);

				$this->db->set($set);

				if ($this->db->insert('blw_akun_penjualan')) {
					
					$this->session->set_flashdata('success_1', 'Data berhasil di kirim');
				}else{

					$this->session->set_flashdata('fail_1', 'Data gagal di kirim');
				}
	    	}
    	}

		redirect(base_url('manage'));
	}

	
	function verifikasi_penjualan(){

		$data['data'] = $this->db->query("SELECT a.id as id, a.sample AS sample, a.katalog AS katalog, a.status AS status, b.nama AS nama FROM blw_akun_penjualan AS a JOIN blw_userdata AS b ON a.akun = b.id WHERE a.hapus = 0")->result_array();

		$this->load->view('atmin/admin/head',["menu"=>34]);
		$this->load->view('penjual/verifikasi', $data);
		$this->load->view('atmin/admin/foot');
	}
	function verifikasi_penjualan_delete($id){

		$this->db->set('hapus', 1);
		$this->db->where('id', $id);
		if ($this->db->update('blw_akun_penjualan')) {
			$this->session->set_flashdata('success', 'Data berhasil di hapus');
		}else{
			$this->session->set_flashdata('fail', 'Data gagal di hapus');
		}

		redirect(base_url('update_akun/verifikasi_penjualan'));
	}
	function verifikasi_penjualan_add($id){

		$this->db->set('status', 2);
		$this->db->where('id', $id);
		if ($this->db->update('blw_akun_penjualan')) {
			$this->session->set_flashdata('success', 'Data berhasil di hapus');
		}else{
			$this->session->set_flashdata('fail', 'Data gagal di hapus');
		}

		redirect(base_url('update_akun/verifikasi_penjualan'));
	}


	// VERIFIKASI PRODUK //
	function verifikasi_produk(){

		$this->load->view('atmin/admin/head',["menu"=>35]);
		$this->load->view('penjual/produk');
		$this->load->view('atmin/admin/foot');
	}
	function produk(){

		//get produk
		$res = $this->load->view('penjual/list',"",true);
		echo json_encode(["result"=>$res,"token"=>$this->security->get_csrf_hash()]);
	}
	function setujui(){
		
		if(isset($_POST)){
			$this->db->where("id",$_POST["id"]);
			$this->db->set("status",1);
			$this->db->update("produk");

			echo json_encode(array("success"=>true,"msg"=>"berhasil","token"=> $this->security->get_csrf_hash()));
		}else{
			echo json_encode(array("success"=>false,"msg"=>"form not submitted!"));
		}
	}

	// USER WITHDRAW //

	function withdraw(){

		$this->load->view('atmin/admin/head',["menu"=>36]);
		$this->load->view('penjual/withdraw');
		$this->load->view('atmin/admin/foot');
	}
	function withdraw_get(){

		$where = array('hapus' => 0);

	    $data = $this->m_withdraw_verif->get_datatables($where);
		$total = $this->m_withdraw_verif->count_all($where);
		$filter = $this->m_withdraw_verif->count_filtered($where);

		$output = array(
			"draw" => $_GET['draw'],
			"recordsTotal" => $total,
			"recordsFiltered" => $filter,
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}
	function witdraw_verifikasi($id){

		$status = strip_tags(@$_POST['status']);

		if ($status == 1) {
			//setujui
			$set = array(
						'biaya' => strip_tags(@$_POST['biaya']),
						'status' => $status,
					);
		}else{
			//tolak
			$set = array(
						'status' =>  strip_tags(@$_POST['status']),
					);
		}

		$this->db->set($set);
		$this->db->where('id', $id);
		if ($this->db->update('blw_withdraw')) {
			$this->session->set_flashdata('success', 'Data berhasil di simpan');
		}else{
			$this->session->set_flashdata('fail', 'Data gagal di simpan');
		}

		redirect(base_url('update_akun/withdraw'));
	}
	function witdraw_kirim($id){

		$set = array(
						'status' => 2,
					);

		$this->db->set($set);
		$this->db->where('id', $id);
		if ($this->db->update('blw_withdraw')) {
			$this->session->set_flashdata('success', 'Data berhasil di simpan');
		}else{
			$this->session->set_flashdata('fail', 'Data gagal di simpan');
		}

		redirect(base_url('update_akun/withdraw'));
	}
}