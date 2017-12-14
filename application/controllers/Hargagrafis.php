<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hargagrafis extends CI_Controller {
		
	public function __construct() {
		parent::__construct();
		
		$this->load->model('m_harga_grafis_model');
	} 

	public function index(){		
		$like 		= null;
		$order_by 	= 'min_menit'; 
		$urlSearch 	= null;
		
		if($this->input->get('field')){
			$like = array($_GET['field'] => $_GET['keyword']);
			$urlSearch = "?field=".$_GET['field']."&keyword=".$_GET['keyword'];
		}		
		
		$this->load->library('pagination');	
		
		$config['base_url'] 	= base_url().'hargagrafis/index'.$urlSearch;
		$this->jumlahData 		= $this->m_harga_grafis_model->getCount("",$like);		
		$config['total_rows'] 	= $this->jumlahData;		
		$config['per_page'] 	= 10;		
		
		$this->pagination->initialize($config);	
		$this->showData = $this->m_harga_grafis_model->showData("",$like,$order_by,$config['per_page'],$this->input->get('per_page'));
		$this->pagination->initialize($config);
		
		$this->template_view->load_view('hargagrafis/hargagrafis_view');
	}
	public function add(){
		$this->template_view->load_view('hargagrafis/hargagrafis_add_view');
	}
	public function add_data(){
		$this->form_validation->set_rules('MIN_MENIT', '', 'trim|required');		
		$this->form_validation->set_rules('MAX_MENIT', '', 'trim|required');		
		$this->form_validation->set_rules('HARGA', '', 'trim|required');		
		
		if ($this->form_validation->run() == FALSE)	{
			$status = array('status' => FALSE, 'pesan' => 'Gagal menyimpan Data, pastikan telah mengisi semua inputan yang diwajibkan untuk diisi.', 'message' => validation_errors());
		}
		else{		

			$maxIDCustomer = $this->m_harga_grafis_model->getPrimaryKeyMax();
			$newId = $maxIDCustomer->MAX + 1;			
			
			$data = array(					
				'ID_HARGA_GRAFIS' => $newId	,			
				'MIN_MENIT' => $this->input->post('MIN_MENIT')	,			
				'MAX_MENIT' => $this->input->post('MAX_MENIT')	,			
				'HARGA' => $this->input->post('HARGA')				
			);
			$query = $this->m_harga_grafis_model->insert($data);							
			$status = array('status' => true , 'redirect_link' => base_url()."".$this->uri->segment(1));
		}
		
		echo(json_encode($status));
	}
	public function edit($IdPrimaryKey){
		$where = array('ID_HARGA_GRAFIS' => $IdPrimaryKey);
		$this->oldData = $this->m_harga_grafis_model->getData($where);		
		$this->template_view->load_view('hargagrafis/hargagrafis_edit_view');
	}
	public function edit_data(){
		$this->form_validation->set_rules('MIN_MENIT', '', 'trim|required');		
		$this->form_validation->set_rules('MAX_MENIT', '', 'trim|required');		
		$this->form_validation->set_rules('HARGA', '', 'trim|required');		
		
		if ($this->form_validation->run() == FALSE)	{
			$status = array('status' => FALSE, 'pesan' => 'Gagal menyimpan Data, pastikan telah mengisi semua inputan yang diwajibkan untuk diisi.', 'message' => validation_errors());
		}
		else{								
			$data = array(			
				'MIN_MENIT' => $this->input->post('MIN_MENIT')	,			
				'MAX_MENIT' => $this->input->post('MAX_MENIT')	,			
				'HARGA' => $this->input->post('HARGA')					
			);
			
			$where = array('ID_HARGA_GRAFIS' => $this->input->post('ID_HARGA_GRAFIS'));
			$query = $this->m_harga_grafis_model->update($where,$data);							
			$status = array('status' => true , 'redirect_link' => base_url()."".$this->uri->segment(1));
		}
		
		echo(json_encode($status));
	}
	public function delete($IdPrimaryKey){
		$where = array('ID_HARGA_GRAFIS' => $IdPrimaryKey);
		$delete = $this->m_harga_grafis_model->delete($where);		
		redirect(base_url()."".$this->uri->segment(1));
	}
	public function search_customer(){
		$like = array('nama_customer' => $this->input->get('term'));
		$datacustomer = $this->m_harga_grafis_model->showData("",$like,"nama_customer");  
		echo '[';		
		$i=1;
		foreach($datacustomer as $data){			
			
			if($i > 1){echo ",";}
			echo '{ "label":"'.$data->NAMA_customer.'","ID_HARGA_GRAFIS":"'.$data->ID_customer.'"} ';
			$i++;
		}
		echo ']';
	}

}
