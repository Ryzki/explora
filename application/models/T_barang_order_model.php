<?php

class T_barang_order_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		
		//$this->load->model('log_model');
	}	
	
	
	
	function showData($where){		
		$this->db->select("*");	
		$this->db->where($where);	
		$this->db->order_by('count_barang');	
		
		return $this->db->get("v_barang_order")->result();
	}
	function getPrimaryKeyMax($idOrder){
		$query = $this->db->query("select max(count_barang) as MAX from t_barang_order where id_order='".$idOrder."'") ;	
		return $query->row();
	}
	function getCount($where = null,$like = null,$order_by = null,$limit = null, $fromLimit=null){
		$this->db->select("*");		
		if($where){
			$this->db->where($where);
		}		
		if($like){
			$this->db->like($like);
		}
		return $this->db->get("t_barang_order")->num_rows();
	}
	
	function insert($data){
		$this->db->insert('t_barang_order', $data);	
	}
	function update($where,$data){		
		$this->db->where($where);		
		$this->db->update('t_barang_order', $data);
	}
	function delete($where){
		$this->db->where($where);
		$this->db->delete('t_barang_order');		
	}
}

?>
