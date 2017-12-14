<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
	
	

	public function __construct() {
		parent::__construct();
		
		$this->load->model('karyawan_model');
		$this->load->model('kategori_user_model');
		
	} 

	public function index(){
		
		$like = null;
		$urlSearch = null;
		$order_by ='NAMA_KARYAWAN';
		$where = "username != ''	";
		
		if($this->input->get('field')){
			$like = array($_GET['field'] => $_GET['keyword']);
			$urlSearch = "?field=".$_GET['field']."&keyword=".$_GET['keyword'];
		}		
			
		$config['base_url'] 	= base_url().''.$this->uri->segment(1).'/index'.$urlSearch;
		$this->jumlahData 		= $this->karyawan_model->getCount($where,$like);		
		$config['total_rows'] 	= $this->jumlahData;		
		$config['per_page'] 	= 10;			
		$this->showData = $this->karyawan_model->showData($where,$like,$order_by,$config['per_page'],$this->input->get('per_page'));
		$this->pagination->initialize($config);
		$this->template_view->load_view('user/user_view');
	}
	public function add(){
		$order_by = 'nama_kategori_user'; 
		$this->dataKategoriUser = 	$this->kategori_user_model->showData("","",$order_by);	
		$this->template_view->load_view('user/user_add_view');
	}
	public function add_data(){
		$this->form_validation->set_rules('ID_KARYAWAN', '', 'trim|required');		
		$this->form_validation->set_rules('NAMA_KARYAWAN', '', 'trim|required');		
		$this->form_validation->set_rules('PASSWORD', '', 'trim|required');		
		$this->form_validation->set_rules('USERNAME', '', 'trim|required');		
		
		if ($this->form_validation->run() == FALSE)	{
			$status = array('status' => FALSE, 'pesan' => 'Gagal menyimpan Data, pastikan telah mengisi semua inputan.');
		}
		else{								
			$data = array(			
				'USERNAME' => $this->input->post('USERNAME'),				
				'ID_KATEGORI_USER' => $this->input->post('ID_KATEGORI_USER'),				
				'PASSWORD' => $this->input->post('PASSWORD')				
			);
			
			$query = $this->karyawan_model->update("ID_KARYAWAN = ".$this->input->post('ID_KARYAWAN'),$data);							
			$status = array('status' => true , 'redirect_link' => base_url()."".$this->uri->segment(1));
		}
		
		echo(json_encode($status));
	}
	
	public function edit($IdPrimaryKey){
		$where ="id_karyawan = '".$IdPrimaryKey."' ";
		$this->oldData = $this->karyawan_model->getData($where);
		
		$orderBy = " NAMA_KATEGORI_USER";
		$this->dataKategoriUser = 	$this->kategori_user_model->showData("",$orderBy);
		$this->template_view->load_view('user/user_edit_view');
	}
	public function edit_data(){
		$this->form_validation->set_rules('ID_KARYAWAN', '', 'trim|required');		
		$this->form_validation->set_rules('NAMA_KARYAWAN', '', 'trim|required');		
		$this->form_validation->set_rules('PASSWORD', '', 'trim|required');		
		$this->form_validation->set_rules('USERNAME', '', 'trim|required');		
		
		if ($this->form_validation->run() == FALSE)	{
			$status = array('status' => FALSE, 'pesan' => 'Gagal menyimpan Data, pastikan telah mengisi semua inputan.');
		}
		else{								
			$data = array(			
				'USERNAME' => $this->input->post('USERNAME'),				
				'ID_KATEGORI_USER' => $this->input->post('ID_KATEGORI_USER'),				
				'PASSWORD' => $this->input->post('PASSWORD')				
			);
			
			$query = $this->karyawan_model->update("ID_KARYAWAN = ".$this->input->post('ID_KARYAWAN'),$data);							
			$status = array('status' => true , 'redirect_link' => base_url()."".$this->uri->segment(1));
		}
		
		echo(json_encode($status));
	}
	public function delete($IdPrimaryKey){
									
		$data = array(			
			'USERNAME' => '',				
			'ID_KATEGORI_USER' => '',				
			'PASSWORD' => ''				
		);		
		$query = $this->karyawan_model->update("ID_KARYAWAN = ".$IdPrimaryKey,$data);
		redirect(base_url()."".$this->uri->segment(1));						
		
	}

}
