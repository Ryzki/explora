<?php

class T_order_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		
		//$this->load->model('log_model');
	}	
	
	function showData($where = null,$like = null,$order_by = null,$limit = null, $fromLimit=null){
		
		$this->db->select("t_order.NO_ORDER");		
		$this->db->select("t_order.NO_WO");		
		$this->db->select("t_order.ID_KARYAWAN");		
		$this->db->select("t_order.ID_ORDER");		
		$this->db->select("t_order.POSISI_ORDER");		
		$this->db->select("t_order.STATUS_BAYAR");		
		$this->db->select("t_order.TGL_ORDER");		
		$this->db->select("t_order.TUJUAN_ORDER");		
		$this->db->select("t_order.TOTAL_BAYAR");		
		$this->db->select("t_order.NO_ORDER_LAIN");		
		$this->db->select("t_order.LINE");		
		$this->db->select('DATE_FORMAT(t_order.TGL_ORDER, "%Y-%m-%d %H:%i:%s") as TGL_JAM_MENIT_DETIK_ORDER', FALSE);			
		$this->db->select('DATE_FORMAT(t_order.TGL_ORDER, "%d-%m-%Y %H:%i") as TGL_JAM_ORDER', FALSE);			
		$this->db->select('DATE_FORMAT(t_order.TGL_ORDER, "%d-%m-%Y") as TGL_ORDER', FALSE);			
		$this->db->select('DATE_FORMAT(t_order.TGL_ORDER, "%h:%i") as JAM_ORDER', FALSE);			
		$this->db->select("t_order.LOG_MEMBER");		
		$this->db->select("master_pelanggan.nama_pelanggan");		
		$this->db->select("master_pelanggan.id_pelanggan");		
		if($where){
			$this->db->where($where);
		}		
		if($like){
			$this->db->like($like);
		}		
		if($order_by){
			$this->db->order_by($order_by);
		}			
		
		$this->db->join('master_pelanggan', 't_order.id_customer = master_pelanggan.id_pelanggan');
		return $this->db->get("t_order",$limit,$fromLimit)->result();
	}
	
	function showDataForGrafis($where = null,$like = null,$order_by = null,$limit = null, $fromLimit=null){
		
		$this->db->select("t_order.NO_ORDER");		
		$this->db->select("t_order.NO_WO");		
		$this->db->select("t_order.ID_ORDER");		
		$this->db->select("t_order.POSISI_ORDER");		
		$this->db->select("t_order.TGL_ORDER");		
		$this->db->select("t_order.TUJUAN_ORDER");		
		$this->db->select("t_order.LINE");		
		$this->db->select("t_order.NO_ORDER_LAIN");		
		$this->db->select('DATE_FORMAT(t_order.TGL_ORDER, "%Y-%m-%d %H:%i:%s") as TGL_JAM_MENIT_DETIK_ORDER', FALSE);			
		$this->db->select('DATE_FORMAT(t_order.TGL_ORDER, "%d-%m-%Y %H:%i") as TGL_JAM_ORDER', FALSE);			
		$this->db->select('DATE_FORMAT(t_order.TGL_ORDER, "%d-%m-%Y") as TGL_ORDER_INDO', FALSE);			
		$this->db->select('DATE_FORMAT(t_order.TGL_ORDER, "%h:%i") as JAM_ORDER', FALSE);			
		$this->db->select("t_order.LOG_MEMBER");		
		$this->db->select("master_pelanggan.nama_pelanggan");		
		$this->db->select("master_pelanggan.id_pelanggan");		
		$this->db->where("t_order.POSISI_ORDER in ('START-DESIGN','OP-GRAFIS','FINISH-DESIGN')");
		if($where){
			$this->db->where($where);
		}		
		if($like){
			$this->db->like($like);
		}		
		if($order_by){
			$this->db->order_by($order_by);
		}			
		
		$this->db->join('master_pelanggan', 't_order.id_customer = master_pelanggan.id_pelanggan');
		return $this->db->get("t_order",$limit,$fromLimit)->result();
	}
	
	
	
	
	function getCountDataForGrafis($where = null,$like = null,$order_by = null,$limit = null, $fromLimit=null){
		$this->db->select("*");	
		$this->db->where("t_order.POSISI_ORDER in ('START-DESIGN','OP-GRAFIS','FINISH-DESIGN')");
		if($where){
			$this->db->where($where);
		}		
		if($like){
			$this->db->like($like);
		}
		return $this->db->get("t_order",$limit,$fromLimit)->num_rows();
	}
	
	
	function getCount($where = null,$like = null,$order_by = null,$limit = null, $fromLimit=null){
		$this->db->select("*");		
		if($where){
			$this->db->where($where);
		}		
		if($like){
			$this->db->like($like);
		}
		return $this->db->get("t_order",$limit,$fromLimit)->num_rows();
	}
	
	function getData($where){
		$this->db->select("t_order.NO_ORDER");		
		$this->db->select("t_order.NO_WO");		
		$this->db->select("t_order.ID_ORDER");		
		$this->db->select("t_order.DISCOUNT");		
		$this->db->select("t_order.TGL_AMBIL");			
		$this->db->select("t_order.TOTAL_BAYAR");		
		$this->db->select("t_order.ID_KARYAWAN");				
		$this->db->select("t_order.LINE");		
		$this->db->select("t_order.TUJUAN_ORDER");			
		$this->db->select("t_order.STATUS_BAYAR");			
		$this->db->select("t_order.NO_ORDER_LAIN");			
		$this->db->select("t_order.LOG_MEMBER");			
		$this->db->select('DATE_FORMAT(t_order.TGL_ORDER, "%Y-%m-%d %H:%i:%s") as TGL_JAM_MENIT_DETIK_ORDER', FALSE);			
		$this->db->select('DATE_FORMAT(t_order.TGL_ORDER, "%d-%m-%Y %H:%i") as TGL_JAM_ORDER', FALSE);			
		$this->db->select('DATE_FORMAT(t_order.TGL_ORDER, "%d-%m-%Y") as TGL_ORDER', FALSE);			
		$this->db->select('DATE_FORMAT(t_order.TGL_ORDER, "%h:%i") as JAM_ORDER', FALSE);				
		$this->db->select("t_order.POSISI_ORDER");		
		$this->db->select("m_karyawan.NAMA_KARYAWAN");		
		$this->db->select("master_pelanggan.nama_pelanggan");	
		$this->db->select("master_pelanggan.nomor_telp");	
		$this->db->select("master_pelanggan.alamat");	
		
		$this->db->where($where);		
		$this->db->join('master_pelanggan', 't_order.id_customer = master_pelanggan.id_pelanggan');
		$this->db->join('m_karyawan', 't_order.ID_KARYAWAN = m_karyawan.ID_KARYAWAN');
		return $this->db->get("t_order")->row();
	}
	
	
	function getPrimaryKeyMax(){
		$query = $this->db->query('select max(id_order) as MAX from t_order') ;	
		return $query->row();
	}
	function getPrimaryKeyMaxToday(){
		$query = $this->db->query('select max(no_order) as MAX from t_order where DATE(tgl_order) = CURDATE()') ;	
		return $query->row();
	}
	
	function insert($data){
		$this->db->insert('t_order', $data);	
	}
	function update($where,$data){		
		$this->db->where($where);		
		$this->db->update('t_order', $data);
	}
	function delete($where){
		$this->db->where($where);
		$this->db->delete('t_order');		
	}
}

?>
