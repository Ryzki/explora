<?php

class Barang_gudang_masuk_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		
		//$this->load->model('log_model');
	}	
	
	function showData($where = null,$like = null,$order_by = null,$limit = null, $fromLimit=null){
				
		$this->db->select('DATE_FORMAT(t_barang_gudang_masuk.tgl_entry, "%d-%m-%Y %H:%i") as TGL_ENTRY_INDO', FALSE);				
		$this->db->select('DATE_FORMAT(t_barang_gudang_masuk.tgl_barang_masuk, "%d-%m-%Y") as TGL_BARANG_MASUK_INDO', FALSE);				
		$this->db->select("t_barang_gudang_masuk.ID_T_BARANG_GUDANG_MASUK");		
		$this->db->select("t_barang_gudang_masuk.JUMLAH_MASUK");		
		$this->db->select("t_barang_gudang_masuk.keterangan as TRANS_KETERANGAN");		
		
		$this->db->select("m_barang_gudang.NAMA_BARANG_GUDANG");		
		$this->db->select("m_barang_gudang.SATUAN_BARANG_GUDANG");		
		$this->db->select("m_barang_gudang.STOK");		
		$this->db->select("m_barang_gudang.KETERANGAN");		
		$this->db->select("m_barang_gudang.ID_BARANG_GUDANG");		
		
		$this->db->select("m_karyawan.NAMA_KARYAWAN");		
		
		if($where){
			$this->db->where($where);
		}		
		if($like){
			$this->db->like($like);
		}		
		if($order_by){
			$this->db->order_by($order_by);
		}			
		
		$this->db->join('m_barang_gudang', 'm_barang_gudang.id_barang_gudang = t_barang_gudang_masuk.id_barang_gudang');
		$this->db->join('m_karyawan', 'm_karyawan.id_karyawan = t_barang_gudang_masuk.id_karyawan');
		return $this->db->get("t_barang_gudang_masuk",$limit,$fromLimit)->result();
	}
	
	function getCount($where = null,$like = null,$order_by = null,$limit = null, $fromLimit=null){
		$this->db->select("*");		
		if($where){
			$this->db->where($where);
		}		
		if($like){
			$this->db->like($like);
		}
		
		$this->db->join('m_barang_gudang', 'm_barang_gudang.id_barang_gudang = t_barang_gudang_masuk.id_barang_gudang');
		$this->db->join('m_karyawan', 'm_karyawan.id_karyawan = t_barang_gudang_masuk.id_karyawan');
		return $this->db->get("t_barang_gudang_masuk",$limit,$fromLimit)->num_rows();
	}
	
	function getData($where){
		$this->db->select("*");		
		$this->db->where($where);		
		return $this->db->get("t_barang_gudang_masuk")->row();
	}
	
	
	
	
	function getPrimaryKeyMax(){
		$query = $this->db->query('select max(id_t_barang_gudang_masuk) as MAX from t_barang_gudang_masuk') ;	
		return $query->row();
	}
	
	function insert($data){
		$this->db->insert('t_barang_gudang_masuk', $data);	
	}
	function update($where,$data){		
		$this->db->where($where);		
		$this->db->update('t_barang_gudang_masuk', $data);
	}
	function delete($where){
		$this->db->where($where);
		$this->db->delete('t_barang_gudang_masuk');		
	}
}

?>
