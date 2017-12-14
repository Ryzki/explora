<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class produk_lain extends CI_Controller {
		
	public function __construct() {
		parent::__construct();
		
		$this->load->model('produk_lain_model');
	} 

	public function index(){		
	
		//$this->load->library("count_page_pdf");
		//echo $this->count_page_pdf->getNumPagesPdf('PANDUAN-BELAJAR-MS-EXCEL.pdf');
	
	
		$like 		= null;
		$order_by 	= 'produk_lain'; 
		$urlSearch 	= null;
		
		if($this->input->get('field')){
			$like = array($_GET['field'] => $_GET['keyword']);
			$urlSearch = "?field=".$_GET['field']."&keyword=".$_GET['keyword'];
		}		
		
		
		
		$this->load->library('pagination');	
		
		$config['base_url'] 	= base_url().'produk_lain/index'.$urlSearch;
		$this->jumlahData 		= $this->produk_lain_model->getCount("",$like);		
		$config['total_rows'] 	= $this->jumlahData;		
		$config['per_page'] 	= 10;		
		
		
		$this->pagination->initialize($config);	
		$this->showData = $this->produk_lain_model->showData('',$like,$order_by,$config['per_page'],$this->input->get('per_page'));
		$this->pagination->initialize($config);
		//echo $this->db->last_query();
		$this->template_view->load_view('produk_lain/produk_lain_view');
	}
	public function add(){
		$this->template_view->load_view('produk_lain/produk_lain_add_view');
	}
	public function add_data(){
		$this->form_validation->set_rules('produk_lain', '', 'trim|required');		
		
		if ($this->form_validation->run() == FALSE)	{
			$status = array('status' => FALSE, 'pesan' => 'Gagal menyimpan Data, pastikan telah mengisi semua inputan yang diwajibkan untuk diisi.', 'message' => validation_errors());
		}
		else{		

			$maxIDCustomer = $this->produk_lain_model->getPrimaryKeyMax();
			$newId = $maxIDCustomer->MAX + 1;			
			
			$data = array(					
				'id_produk_lain' => $newId	,						
				'produk_lain' => $this->input->post('produk_lain')		
			);
			$query = $this->produk_lain_model->insert($data);							
			$status = array('status' => true , 'redirect_link' => base_url()."".$this->uri->segment(1));
		}
		
		echo(json_encode($status));
	}
	public function edit($IdPrimaryKey){
		$where = array('id_produk_lain' => $IdPrimaryKey);
		$this->oldData = $this->produk_lain_model->getData($where);		
		$this->template_view->load_view('produk_lain/produk_lain_edit_view');
	}
	public function edit_data(){	
		$this->form_validation->set_rules('produk_lain', '', 'trim|required');			
		
		if ($this->form_validation->run() == FALSE)	{
			$status = array('status' => FALSE, 'pesan' => 'Gagal menyimpan Data, pastikan telah mengisi semua inputan yang diwajibkan untuk diisi.', 'message' => validation_errors());
		}
		else{								
			$data = array(					
				'produk_lain' => $this->input->post('produk_lain')							
			);
			
			$where = array('id_produk_lain' => $this->input->post('id_produk_lain'));
			$query = $this->produk_lain_model->update($where,$data);							
			$status = array('status' => true , 'redirect_link' => base_url()."".$this->uri->segment(1));
		}
		
		echo(json_encode($status));
	}
	public function delete($IdPrimaryKey){
		$where = array('id_produk_lain' => $IdPrimaryKey);
		$delete = $this->produk_lain_model->delete($where);		
		redirect(base_url()."".$this->uri->segment(1));
	}

	
}
