<?php

class Pelanggan_model extends CI_Model {
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
		return $this->db->get("master_pelanggan",$limit,$fromLimit)->result();
	}
	
	function getCount($where = null,$like = null,$order_by = null,$limit = null, $fromLimit=null){
		$this->db->select("*");		
		if($where){
			$this->db->where($where);
		}		
		if($like){
			$this->db->like($like);
		}
		return $this->db->get("master_pelanggan",$limit,$fromLimit)->num_rows();
	}
	
	function getData($where){
		$this->db->select("a.*");		
		$this->db->select("DATE_FORMAT(a.tgl_mulai_member, '%d-%m-%Y')as tgl_mulai");		
		$this->db->select("DATE_FORMAT(a.tgl_akhir_member, '%d-%m-%Y') as tgl_akhir");		
		
		$this->db->where($where);		
		return $this->db->get("master_pelanggan a")->row();
	}
	
	
	function getPrimaryKeyMax(){
		$query = $this->db->query('select max(id_pelanggan) as MAX from master_pelanggan') ;	
		return $query->row();
	}
	
	function insert($data){
		$this->db->insert('master_pelanggan', $data);	
	}
	function update($where,$data){		
		$this->db->where($where);		
		$this->db->update('master_pelanggan', $data);
	}
	function delete($where){
		$this->db->where($where);
		$this->db->delete('master_pelanggan');		
	}
}

?>
