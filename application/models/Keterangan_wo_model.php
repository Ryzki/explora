<?php

class Keterangan_wo_model extends CI_Model {
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
		return $this->db->get("keterangan_wo",$limit,$fromLimit)->result();
	}
	
	function getCount($where = null,$like = null,$order_by = null,$limit = null, $fromLimit=null){
		$this->db->select("*");		
		if($where){
			$this->db->where($where);
		}		
		if($like){
			$this->db->like($like);
		}
		return $this->db->get("keterangan_wo",$limit,$fromLimit)->num_rows();
	}
	
	function getData($where){
		$this->db->select("*");		
		$this->db->where($where);		
		return $this->db->get("keterangan_wo")->row();
	}
	
	
	
	
	function getPrimaryKeyMax(){
		$query = $this->db->query('select max(id_keterangan) as MAX from keterangan_wo') ;	
		return $query->row();
	}
	
	function insert($data){
		$this->db->insert('keterangan_wo', $data);	
	}
	function update($where,$data){		
		$this->db->where($where);		
		$this->db->update('keterangan_wo', $data);
	}
	function delete($where){
		$this->db->where($where);
		$this->db->delete('keterangan_wo');		
	}
}

?>
