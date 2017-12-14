<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profil extends CI_Controller {
		
	public function __construct() {
		parent::__construct();
		
		$this->load->model('m_profil_model');
	} 

	public function index(){		
	
		//$this->load->library("count_page_pdf");
		//echo $this->count_page_pdf->getNumPagesPdf('PANDUAN-BELAJAR-MS-EXCEL.pdf');
	
	
		$like 		= null;
		$order_by 	= 'NAMA_TOKO'; 
		$urlSearch 	= null;
		
		if($this->input->get('field')){
			$like = array($_GET['field'] => $_GET['keyword']);
			$urlSearch = "?field=".$_GET['field']."&keyword=".$_GET['keyword'];
		}		
		
		
		
		$this->load->library('pagination');	
		
		$config['base_url'] 	= base_url().'profil/index'.$urlSearch;
		$this->jumlahData 		= $this->m_profil_model->getCount("",$like);		
		$config['total_rows'] 	= $this->jumlahData;		
		$config['per_page'] 	= 10;		
		
		
		$this->pagination->initialize($config);	
		$this->showData = $this->m_profil_model->showData('',$like,$order_by,$config['per_page'],$this->input->get('per_page'));
		$this->pagination->initialize($config);
		//echo $this->db->last_query();
		$this->template_view->load_view('profil/profil_view');
	}
	public function add(){
		$this->template_view->load_view('profil/profil_add_view');
	}
	public function add_data(){
		$this->form_validation->set_rules('NAMA_TOKO', '', 'trim|required');		
		
		if ($this->form_validation->run() == FALSE)	{
			$status = array('status' => FALSE, 'pesan' => 'Gagal menyimpan Data, pastikan telah mengisi semua inputan yang diwajibkan untuk diisi.', 'message' => validation_errors());
		}
		else{		

			$maxIDProfil = $this->m_profil_model->getPrimaryKeyMax();
			$newId = $maxIDProfil->MAX + 1;			
			
			
			$this->db->query("
			insert into m_profil 
			(
			id_profil,
			NAMA_TOKO,
			TELP_TOKO,
			EMAIL_OWNER,
			EMAIL_FROM,
			WEBSITE,
			PASS_EMAIL_FROM,
			ALAMAT_TOKO
			)
			values
			(
			'".$newId."',
			'".$this->input->post('NAMA_TOKO')."',
			'".$this->input->post('TELP_TOKO')."',
			'".$this->input->post('EMAIL_OWNER')."',
			 '".$this->input->post('EMAIL_FROM')."',
			 '".$this->input->post('WEBSITE')."',
			  '".$this->input->post('PASS_EMAIL_FROM')."',
			   '".$this->input->post('ALAMAT_TOKO')."'
			)
			
			");
		
			
			$status = array('status' => true , 'redirect_link' => base_url()."".$this->uri->segment(1));
		}
		
		echo(json_encode($status));
	}
	public function edit($IdPrimaryKey){
		$where = array('id_profil' => $IdPrimaryKey);
		$this->oldData = $this->m_profil_model->getData($where);		
		$this->template_view->load_view('profil/profil_edit_view');
	}
	public function edit_data(){	
		$this->form_validation->set_rules('NAMA_TOKO', '', 'trim|required');			
		
		if ($this->form_validation->run() == FALSE)	{
			$status = array('status' => FALSE, 'pesan' => 'Gagal menyimpan Data, pastikan telah mengisi semua inputan yang diwajibkan untuk diisi.', 'message' => validation_errors());
		}
		else{								
		$this->db->query("
			update m_profil set 
			NAMA_TOKO = '".$this->input->post('NAMA_TOKO')."',
			TELP_TOKO = '".$this->input->post('TELP_TOKO')."',
			EMAIL_OWNER = '".$this->input->post('EMAIL_OWNER')."',
			EMAIL_FROM = '".$this->input->post('EMAIL_FROM')."',
			WEBSITE = '".$this->input->post('WEBSITE')."',
			PASS_EMAIL_FROM = '".$this->input->post('PASS_EMAIL_FROM')."',
			ALAMAT_TOKO = '".$this->input->post('ALAMAT_TOKO')."'
			where id_profil='".$this->input->post('ID_PROFIL')."'
			");					
			$status = array('status' => true , 'redirect_link' => base_url()."".$this->uri->segment(1));
		}
		
		echo(json_encode($status));
	}
	public function delete($IdPrimaryKey){
		$where = array('id_profil' => $IdPrimaryKey);
		$delete = $this->m_profil_model->delete($where);		
		redirect(base_url()."".$this->uri->segment(1));
	}

	
}
