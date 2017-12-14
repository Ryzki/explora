<?php

class M_harga_grafis_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		
		//$this->load->model('log_model');
	}	
	
	function showData($where = null,$like = null,$order_by = null,$limit = null, $fromLimit=null){
		
		$this->db->select("*");		
		if($where){
			$this->db->where($where);
		}		
		if($like){
			$this->db->like($like);
		}		
		if($order_by){
			$this->db->order_by($order_by);
		}			
		return $this->db->get("m_harga_grafis",$limit,$fromLimit)->result();
	}
	
	function getCount($where = null,$like = null,$order_by = null,$limit = null, $fromLimit=null){
		$this->db->select("*");		
		if($where){
			$this->db->where($where);
		}		
		if($like){
			$this->db->like($like);
		}
		return $this->db->get("m_harga_grafis",$limit,$fromLimit)->num_rows();
	}
	
	function getData($where){
		$this->db->select("*");		
		$this->db->where($where);		
		return $this->db->get("m_harga_grafis")->row();
	}
	
	
	function getPrimaryKeyMax(){
		$query = $this->db->query('select max(id_harga_grafis) as MAX from m_harga_grafis') ;	
		return $query->row();
	}
	
	function insert($data){
		$this->db->insert('m_harga_grafis', $data);	
	}
	function update($where,$data){		
		$this->db->where($where);		
		$this->db->update('m_harga_grafis', $data);
	}
	function delete($where){
		$this->db->where($where);
		$this->db->delete('m_harga_grafis');		
	}
	function getDataHarga($jumlahMenit){
		$this->db->select("*");			
		$this->db->where('min_menit <=', $jumlahMenit);
		$this->db->where('max_menit >=', $jumlahMenit);		
		return $this->db->get("m_harga_grafis")->row();
	}
}

?>
