<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends CI_Controller {
		
	public function __construct() {
		parent::__construct();
		
		$this->load->model('customer_model');
	} 

	public function index(){		
		$like 		= null;
		$order_by 	= 'nama_customer, id_customer'; 
		$urlSearch 	= null;
		
		if($this->input->get('field')){
			$like = array($_GET['field'] => $_GET['keyword']);
			$urlSearch = "?field=".$_GET['field']."&keyword=".$_GET['keyword'];
		}		
		
		$this->load->library('pagination');	
		
		$config['base_url'] 	= base_url().'customer/index'.$urlSearch;
		$this->jumlahData 		= $this->customer_model->getCount("",$like);		
		$config['total_rows'] 	= $this->jumlahData;		
		$config['per_page'] 	= 10;		
		
		$this->pagination->initialize($config);	
		$this->showData = $this->customer_model->showData("",$like,$order_by,$config['per_page'],$this->input->get('per_page'));
		$this->pagination->initialize($config);
		
		$this->template_view->load_view('customer/customer_view');
	}
	public function add(){
		$this->template_view->load_view('customer/customer_add_view');
	}
	public function add_data(){
		$this->form_validation->set_rules('NAMA_CUSTOMER', '', 'trim|required');		
		$this->form_validation->set_rules('HP_CUSTOMER', '', 'trim|required');		
		
		if ($this->form_validation->run() == FALSE)	{
			$status = array('status' => FALSE, 'pesan' => 'Gagal menyimpan Data, pastikan telah mengisi semua inputan yang diwajibkan untuk diisi.', 'message' => validation_errors());
		}
		else{		

			$maxIDCustomer = $this->customer_model->getPrimaryKeyMax();
			$newId = $maxIDCustomer->MAX + 1;			
			
			$data = array(					
				'ID_CUSTOMER' => $newId	,			
				'ALAMAT_CUSTOMER' => $this->input->post('ALAMAT_CUSTOMER')	,			
				'NAMA_CUSTOMER' => $this->input->post('NAMA_CUSTOMER')	,			
				'HP_CUSTOMER' => $this->input->post('HP_CUSTOMER')				
			);
			$query = $this->customer_model->insert($data);							
			$status = array('status' => true , 'redirect_link' => base_url()."".$this->uri->segment(1));
		}
		
		echo(json_encode($status));
	}
	public function edit($IdPrimaryKey){
		$where = array('id_customer' => $IdPrimaryKey);
		$this->oldData = $this->customer_model->getData($where);		
		$this->template_view->load_view('customer/customer_edit_view');
	}
	public function edit_data(){
		$this->form_validation->set_rules('NAMA_CUSTOMER', '', 'trim|required');		
		$this->form_validation->set_rules('ID_CUSTOMER', '', 'trim|required');		
		$this->form_validation->set_rules('HP_CUSTOMER', '', 'trim|required');		
		
		if ($this->form_validation->run() == FALSE)	{
			$status = array('status' => FALSE, 'pesan' => 'Gagal menyimpan Data, pastikan telah mengisi semua inputan yang diwajibkan untuk diisi.', 'message' => validation_errors());
		}
		else{								
			$data = array(			
				'ALAMAT_CUSTOMER' => $this->input->post('ALAMAT_CUSTOMER')	,			
				'NAMA_CUSTOMER' => $this->input->post('NAMA_CUSTOMER')	,			
				'HP_CUSTOMER' => $this->input->post('HP_CUSTOMER')					
			);
			
			$where = array('id_customer' => $this->input->post('ID_CUSTOMER'));
			$query = $this->customer_model->update($where,$data);							
			$status = array('status' => true , 'redirect_link' => base_url()."".$this->uri->segment(1));
		}
		
		echo(json_encode($status));
	}
	public function delete($IdPrimaryKey){
		$where = array('id_customer' => $IdPrimaryKey);
		$delete = $this->customer_model->delete($where);		
		redirect(base_url()."".$this->uri->segment(1));
	}
	public function search_customer(){
		$like = array('nama_customer' => $this->input->get('term'));
		$datacustomer = $this->customer_model->showData("",$like,"nama_customer");  
		echo '[';		
		$i=1;
		foreach($datacustomer as $data){			
			
			if($i > 1){echo ",";}
			echo '{ "label":"'.$data->NAMA_customer.'","id_customer":"'.$data->ID_customer.'"} ';
			$i++;
		}
		echo ']';
	}
	
	public function getDataByNoHP(){
		$where = array('hp_customer' => $this->input->post('no_hp') );		
		$dataMember = $this->customer_model->getData($where);	
		
		if ($dataMember)	{
			$status = array('status' => TRUE, 'nama' => $dataMember->NAMA_CUSTOMER, 'alamat' => $dataMember->ALAMAT_CUSTOMER, 'id_customer' => $dataMember->ID_CUSTOMER);
		}
		else{		
			$status = array('status' => FALSE);
		}
		
		echo(json_encode($status));
	}
}
