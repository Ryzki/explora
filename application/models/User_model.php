<?php

class User_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		
		//$this->load->model('log_model');
	}	
	
	function showData($where = null,$order_by = null){
		$this->db->select("*");
		
		if($where){
			$this->db->where($field, $value);			
		}
		
		if($order_by){
			$this->db->order_by($order_by);			
		}
			
		return $this->db->get("m_user")->result();
	}

}

?>
