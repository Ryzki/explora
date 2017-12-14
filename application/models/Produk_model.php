<?php

class Produk_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		
		//$this->load->model('log_model');
	}	
	
	function showData($where = null,$like = null,$order_by = null,$limit = null, $fromLimit=null){
		
		$this->db->select("m_produk.*");		
		$this->db->select("m_profil.NAMA_TOKO");		
		if($where){
			$this->db->where($where);
		}		
		if($like){
			$this->db->like($like);
		}		
		if($order_by){
			$this->db->order_by($order_by);
		}			
		$this->db->join('m_profil', 'm_produk.id_profil = m_profil.id_profil');
		return $this->db->get("m_produk",$limit,$fromLimit)->result();
	}
	
	function getCount($where = null,$like = null,$order_by = null,$limit = null, $fromLimit=null){
		$this->db->select("*");		
		if($where){
			$this->db->where($where);
		}		
		if($like){
			$this->db->like($like);
		}
		return $this->db->get("m_produk",$limit,$fromLimit)->num_rows();
	}
	
	function getData($where){
		$this->db->select("*");		
		$this->db->where($where);		
		return $this->db->get("m_produk")->row();
	}
	
	
	function getPrimaryKeyMax(){
		$query = $this->db->query('select max(id_produk) as MAX from m_produk') ;	
		return $query->row();
	}
	
	function insert($data){
		$this->db->insert('m_produk', $data);	
	}
	function update($where,$data){		
		$this->db->where($where);		
		$this->db->update('m_produk', $data);
	}
	function delete($where){
		$this->db->where($where);
		$this->db->delete('m_produk');		
	}
}

?>
