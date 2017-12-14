<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lap_penjualan extends CI_Controller {
		
	public function __construct() {
		parent::__construct();
		
		$this->load->model('t_order_model');
		$this->load->model('t_barang_order_model');
		$this->load->model('t_log_order_model');
		$this->load->model('t_bayar_order_model');
	} 

	public function index(){		
		
		$this->load->library('text_barang');
		
		if($this->input->get('date')){
				$queryLaporan 	= $this->db->query("select * from v_barang_order where tgl_order_indo = '".$this->input->get('date')."' order by tgl_order , id_order,count_barang");
				$this->showData = $queryLaporan->result();
		}
		$this->template_view->load_view('laporan/laporan_penjualan_view');
	}
	
	
	
}
