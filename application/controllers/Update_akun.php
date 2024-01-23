<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update_akun extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

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
}