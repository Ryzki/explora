<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cetak_ulang extends CI_Controller {
		
	public function __construct() {
		parent::__construct();
		
		$this->load->model('t_order_model');
		$this->load->model('t_barang_order_model');
		$this->load->model('t_log_order_model');
		$this->load->model('t_bayar_order_model');
	} 

	public function index(){		
		
		$this->showData = null;
		if($this->input->get('no_wo')){
			$where = array('no_wo' => $this->input->get('no_wo'));
			$this->showData = $this->t_order_model->getData($where);			
			
		}				
		
		$this->template_view->load_view('cetak_ulang/cetak_ulang_view.php');
	}
	
	
}
