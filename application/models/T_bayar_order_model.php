<?php

class T_bayar_order_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		
		//$this->load->model('log_model');
	}	
	
	function showData($where){
		$this->db->select("*");			
		
		$this->db->select("m_karyawan.NAMA_KARYAWAN");				
		$this->db->select("t_bayar_order.ID_ORDER");							
		$this->db->select("t_bayar_order.JUMLAH_BAYAR");							
		$this->db->select("t_bayar_order.JENIS_BAYAR");							
		$this->db->select('DATE_FORMAT(t_bayar_order.tgl_bayar, "%d-%m-%Y %H:%i") as TGL_JAM_BAYAR', FALSE);			
		$this->db->order_by("t_bayar_order.tgl_bayar");				
		$this->db->where($where);	
		
		$this->db->join('m_karyawan', 'm_karyawan.id_karyawan = t_bayar_order.id_karyawan');	
		return $this->db->get("t_bayar_order")->result();
	}
	
	function getPrimaryKeyMax($idOrder){
		$query = $this->db->query("select max(ID_T_BAYAR_ORDER) as MAX from t_bayar_order where id_order='".$idOrder."'") ;	
		return $query->row();
	}
	
	function getData($where){
		$this->db->select("*");	
		$this->db->where($where);			
		return $this->db->get("t_bayar_order")->row();
	}
	
	function insert($data){
		$this->db->insert('t_bayar_order', $data);	
	}
	function update($where,$data){		
		$this->db->where($where);		
		$this->db->update('t_bayar_order', $data);
	}
	function delete($where){
		$this->db->where($where);
		$this->db->delete('t_bayar_order');		
	}
}

?>
