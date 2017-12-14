<?php

class T_log_order_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		
		//$this->load->model('log_model');
	}	
	
	function showData($where){
		$this->db->select("m_karyawan.NAMA_KARYAWAN");				
		$this->db->select("t_log_order.DARI");				
		$this->db->select("t_log_order.KE");				
		$this->db->select("t_log_order.CATATAN_LOG_ORDER");				
		$this->db->select('DATE_FORMAT(t_log_order.tgl_log_order, "%d-%m-%Y %H:%i") as TGL_LOG_ORDER', FALSE);			
		$this->db->order_by("t_log_order.tgl_log_order");				
		$this->db->where($where);	
		
		$this->db->join('m_karyawan', 'm_karyawan.id_karyawan = t_log_order.id_karyawan');	
		return $this->db->get("t_log_order")->result();
	}

	
	function getStartGrafis($id_order){
		
		$this->db->select('DATE_FORMAT(TGL_LOG_ORDER, "%Y-%m-%d %H:%i:%s") as TGL_JAM_MENIT_DETIK_ORDER', FALSE);			
		$this->db->where('id_order', $id_order);	
		$this->db->where('DARI','OP-GRAFIS');	
		$this->db->where('KE', 'START-DESIGN');	
		$this->db->order_by('TGL_LOG_ORDER', 'desc');	
		return $this->db->get("t_log_order")->row();
	}
	
	function insert($data){
		$this->db->insert('t_log_order', $data);	
	}
	function getDataOPGrafis($where){
		$this->db->select("m_karyawan.NAMA_KARYAWAN");		
		
		$this->db->where($where);	
		$this->db->where('dari', 'OP-GRAFIS');	
		$this->db->where('ke', 'START-DESIGN');	
		
		$this->db->join('m_karyawan', 'm_karyawan.id_karyawan = t_log_order.id_karyawan');	
		$this->db->order_by('t_log_order.tgl_log_order desc');	
		return $this->db->get("t_log_order")->row();
	}
	function update($where,$data){		
		$this->db->where($where);		
		$this->db->update('t_log_order', $data);
	}
	function delete($where){
		$this->db->where($where);
		$this->db->delete('t_log_order');		
	}
}

?>
