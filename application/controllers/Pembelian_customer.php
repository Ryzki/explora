<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pembelian_customer extends CI_Controller {
		
	public function __construct() {
		parent::__construct();
		
		$this->load->model('t_order_model');
		$this->load->model('t_barang_order_model');
		$this->load->model('t_log_order_model');
		$this->load->model('mesin_model');
		$this->load->model('produk_model');
		$this->load->model('kertas_bahan_model');
	} 

	
		
	

	public function index(){	
		$this->showData = null;
		if($this->input->get('HP_CUSTOMER')!=""){
			
			$where  = array('t_order.ID_CUSTOMER' => $this->input->get('ID_CUSTOMER'));
				
			$this->showData = $this->t_order_model->showData($where );
			
		}
		$this->template_view->load_view('laporan/laporan_pembelian_customer_view');
	}
}