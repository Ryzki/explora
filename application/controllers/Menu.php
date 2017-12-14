<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends CI_Controller {
		
	public function __construct() {
		parent::__construct();
		
		$this->load->model('karyawan_model');
	} 

	public function index(){		
		$like 		= null;
		$order_by 	= 'nama_karyawan, id_karyawan'; 
		$urlSearch 	= null;
		
		if($this->input->get('field')){
			$like = array($_GET['field'] => $_GET['keyword']);
			$urlSearch = "?field=".$_GET['field']."&keyword=".$_GET['keyword'];
		}		
		
		$this->load->library('pagination');	
		
		$config['base_url'] 	= base_url().'karyawan/index'.$urlSearch;
		$this->jumlahData 		= $this->karyawan_model->getCount("",$like);		
		$config['total_rows'] 	= $this->jumlahData;		
		$config['per_page'] 	= 10;		
		
		$this->pagination->initialize($config);	
		$this->showData = $this->karyawan_model->showData("",$like,$order_by,$config['per_page'],$this->input->get('per_page'));
		$this->pagination->initialize($config);
		
		$this->template_view->load_view('karyawan/karyawan_view');
	}
	public function add(){
		$this->template_view->load_view('karyawan/karyawan_add_view');
	}
	public function add_data(){
		$this->form_validation->set_rules('NAMA_KARYAWAN', '', 'trim|required');		
		
		if ($this->form_validation->run() == FALSE)	{
			$status = array('status' => FALSE, 'pesan' => 'Gagal menyimpan Data, pastikan telah mengisi semua inputan yang diwajibkan untuk diisi.', 'message' => validation_errors());
		}
		else{								
			$data = array(			
				'NAMA_KARYAWAN' => $this->input->post('NAMA_KARYAWAN')				
			);
			$query = $this->karyawan_model->insert($data);							
			$status = array('status' => true , 'redirect_link' => base_url()."".$this->uri->segment(1));
		}
		
		echo(json_encode($status));
	}
	public function edit($IdPrimaryKey){
		$where = array('id_karyawan' => $IdPrimaryKey);
		$this->oldData = $this->karyawan_model->getData($where);		
		$this->template_view->load_view('karyawan/karyawan_edit_view');
	}
	public function edit_data(){
		$this->form_validation->set_rules('NAMA_KARYAWAN', '', 'trim|required');		
		$this->form_validation->set_rules('ID_KARYAWAN', '', 'trim|required');		
		
		if ($this->form_validation->run() == FALSE)	{
			$status = array('status' => FALSE, 'pesan' => 'Gagal menyimpan Data, pastikan telah mengisi semua inputan yang diwajibkan untuk diisi.', 'message' => validation_errors());
		}
		else{								
			$data = array(			
				'NAMA_KARYAWAN' => $this->input->post('NAMA_KARYAWAN')				
			);
			
			$where = array('id_karyawan' => $this->input->post('ID_KARYAWAN'));
			$query = $this->karyawan_model->update($where,$data);							
			$status = array('status' => true , 'redirect_link' => base_url()."".$this->uri->segment(1));
		}
		
		echo(json_encode($status));
	}
	public function delete($IdPrimaryKey){
		$where = array('id_karyawan' => $IdPrimaryKey);
		$delete = $this->karyawan_model->delete($where);		
		redirect(base_url()."".$this->uri->segment(1));
	}
	public function search_karyawan(){
		$like = array('nama_karyawan' => $this->input->get('term'));
		$dataKaryawan = $this->karyawan_model->showData("",$like,"nama_karyawan");  
		echo '[';		
		$i=1;
		foreach($dataKaryawan as $data){			
			
			if($i > 1){echo ",";}
			echo '{ "label":"'.$data->NAMA_KARYAWAN.'","id_karyawan":"'.$data->ID_KARYAWAN.'"} ';
			$i++;
		}
		echo ']';
	}
}
