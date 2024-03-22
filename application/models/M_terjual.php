<?php

class M_terjual extends CI_Model { 
	
	//nama tabel
	var $table = 'blw_transaksi'; 

	//kolom yang di tampilkan
	var $column_order = array(null,'blw_transaksi.orderid'); 

	//kolom yang di tampilkan setelah seacrh
	var $column_search = array('blw_transaksi.orderid'); 

	//urutan 
	var $order = array('blw_transaksi.tgl' => 'desc'); 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		
		$this->db->from($this->table);

		$i = 0;
	
		foreach ($this->column_search as $item) // loop column 
		{
			if($_GET['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_GET['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_GET['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_GET['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_GET['order']['0']['column']], $_GET['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables($where)
	{
		$this->_get_datatables_query();
		if($_GET['length'] != -1)
		$this->db->select("blw_transaksi.orderid as id_transaksi, blw_transaksiproduk.hargabeli as harga, blw_transaksiproduk.jumlah as jumlah, blw_transaksi.tgl as tanggal, blw_produk.nama as produk");
		$this->db->where($where);
		$this->db->join('blw_transaksiproduk', 'blw_transaksiproduk.idtransaksi = blw_transaksi.id');
		$this->db->join('blw_produk', 'blw_produk.id = blw_transaksiproduk.idproduk');
		$this->db->limit($_GET['length'], $_GET['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered($where)
	{
		$this->_get_datatables_query();
		$this->db->where($where);
		$this->db->join('blw_transaksiproduk', 'blw_transaksiproduk.idtransaksi = blw_transaksi.id');
		$this->db->join('blw_produk', 'blw_produk.id = blw_transaksiproduk.idproduk');
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all($where)
	{
		$this->db->from($this->table);
		$this->db->where($where);
		$this->db->join('blw_transaksiproduk', 'blw_transaksiproduk.idtransaksi = blw_transaksi.id');
		$this->db->join('blw_produk', 'blw_produk.id = blw_transaksiproduk.idproduk');
		return $this->db->count_all_results();
	}

}
