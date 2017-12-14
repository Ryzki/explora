<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Keterangan_wo extends CI_Controller {
		
	public function __construct() {
		parent::__construct();
		
		$this->load->model('keterangan_wo_model');
	} 

	public function index(){		
		$like 		= null;
		$order_by 	= 'keterangan'; 
		$urlSearch 	= null;
		
		if($this->input->get('field')){
			$like = array($_GET['field'] => $_GET['keyword']);
			$urlSearch = "?field=".$_GET['field']."&keyword=".$_GET['keyword'];
		}		
		
		$this->load->library('pagination');	
		
		$config['base_url'] 	= base_url().'keterangan_nota/index'.$urlSearch;
		$this->jumlahData 		= $this->keterangan_wo_model->getCount("",$like);		
		$config['total_rows'] 	= $this->jumlahData;		
		$config['per_page'] 	= 10;		
		
		$this->pagination->initialize($config);	
		$this->showData = $this->keterangan_wo_model->showData("",$like,$order_by,$config['per_page'],$this->input->get('per_page'));
		$this->pagination->initialize($config);
		
		$this->template_view->load_view('keterangan_nota/keterangan_nota_view');
	}
	public function add(){
		$this->template_view->load_view('keterangan_nota/keterangan_nota_add_view');
	}
	public function add_data(){
		$this->form_validation->set_rules('KETERANGAN', '', 'trim|required');		
		
		if ($this->form_validation->run() == FALSE)	{
			$status = array('status' => FALSE, 'pesan' => 'Gagal menyimpan Data, pastikan telah mengisi semua inputan yang diwajibkan untuk diisi.', 'message' => validation_errors());
		}
		else{								
			$data = array(			
				'KETERANGAN ' => $this->input->post('KETERANGAN')	
			);
			$query = $this->keterangan_wo_model->insert($data);							
			$status = array('status' => true , 'redirect_link' => base_url()."".$this->uri->segment(1));
		}
		
		echo(json_encode($status));
	}
	public function edit($IdPrimaryKey){
		$where = array('id_keterangan' => $IdPrimaryKey);
		$this->oldData = $this->keterangan_wo_model->getData($where);	
		
		$this->template_view->load_view('keterangan_nota/keterangan_nota_edit_view');
	}
	public function edit_data(){
		$this->form_validation->set_rules('KETERANGAN', '', 'trim|required');		
		
		if ($this->form_validation->run() == FALSE)	{
			$status = array('status' => FALSE, 'pesan' => 'Gagal menyimpan Data, pastikan telah mengisi semua inputan yang diwajibkan untuk diisi.', 'message' => validation_errors());
		}
		else{								
			$data = array(			
				'KETERANGAN ' => $this->input->post('KETERANGAN')			
			);
			
			$where = array('ID_KETERANGAN' => $this->input->post('ID_KETERANGAN'));
			$query = $this->keterangan_wo_model->update($where,$data);							
			$status = array('status' => true , 'redirect_link' => base_url()."".$this->uri->segment(1));
		}
		
		echo(json_encode($status));
	}
	public function delete($IdPrimaryKey){
		$where = array('id_keterangan' => $IdPrimaryKey);
		$delete = $this->keterangan_wo_model->delete($where);		
		redirect(base_url()."".$this->uri->segment(1));
	}
	
}
