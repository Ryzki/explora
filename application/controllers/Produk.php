<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Produk extends CI_Controller {
		
	public function __construct() {
		parent::__construct();
		
		$this->load->model('produk_model');
	} 

	public function index(){		
	
		//$this->load->library("count_page_pdf");
		//echo $this->count_page_pdf->getNumPagesPdf('PANDUAN-BELAJAR-MS-EXCEL.pdf');
	
	
		$like 		= null;
		$order_by 	= 'nama_produk'; 
		$urlSearch 	= null;
		
		if($this->input->get('field')){
			$like = array($_GET['field'] => $_GET['keyword']);
			$urlSearch = "?field=".$_GET['field']."&keyword=".$_GET['keyword'];
		}		
		
		$where = 'id_produk != "1"';
		
		$this->load->library('pagination');	
		
		$config['base_url'] 	= base_url().'produk/index'.$urlSearch;
		$this->jumlahData 		= $this->produk_model->getCount($where,$like);		
		$config['total_rows'] 	= $this->jumlahData;		
		$config['per_page'] 	= 10;		
		
		
		
		$this->pagination->initialize($config);	
		$this->showData = $this->produk_model->showData($where,$like,$order_by,$config['per_page'],$this->input->get('per_page'));
		$this->pagination->initialize($config);
		//echo $this->db->last_query();
		$this->template_view->load_view('produk/produk_view');
	}
	public function add(){
		$queryToko= $this->db->query("select * from m_profil order by nama_toko");
		$this->dataToko = $queryToko->result();
		$this->template_view->load_view('produk/produk_add_view');
	}
	public function add_data(){
		$this->form_validation->set_rules('nama_produk', '', 'trim|required');		
		
		if ($this->form_validation->run() == FALSE)	{
			$status = array('status' => FALSE, 'pesan' => 'Gagal menyimpan Data, pastikan telah mengisi semua inputan yang diwajibkan untuk diisi.', 'message' => validation_errors());
		}
		else{		

			$maxIDCustomer = $this->produk_model->getPrimaryKeyMax();
			$newId = $maxIDCustomer->MAX + 1;			
			
			$data = array(					
				'id_produk' => $newId	,						
				'nama_produk' => $this->input->post('nama_produk')	,			
				'id_profil' => $this->input->post('id_profil')	,			
				'kategori' => $this->input->post('kategori')				
			);
			$query = $this->produk_model->insert($data);							
			$status = array('status' => true , 'redirect_link' => base_url()."".$this->uri->segment(1));
		}
		
		echo(json_encode($status));
	}
	public function edit($IdPrimaryKey){
		
		$queryToko= $this->db->query("select * from m_profil order by nama_toko");
		$this->dataToko = $queryToko->result();
		
		$where = array('id_produk' => $IdPrimaryKey);
		$this->oldData = $this->produk_model->getData($where);		
		$this->template_view->load_view('produk/produk_edit_view');
	}
	public function edit_data(){	
		$this->form_validation->set_rules('nama_produk', '', 'trim|required');			
		
		if ($this->form_validation->run() == FALSE)	{
			$status = array('status' => FALSE, 'pesan' => 'Gagal menyimpan Data, pastikan telah mengisi semua inputan yang diwajibkan untuk diisi.', 'message' => validation_errors());
		}
		else{								
			$data = array(					
				'nama_produk' => $this->input->post('nama_produk')	,			
					'id_profil' => $this->input->post('id_profil')	,	
				'kategori' => $this->input->post('kategori')							
			);
			
			$where = array('id_produk' => $this->input->post('id_produk'));
			$query = $this->produk_model->update($where,$data);							
			$status = array('status' => true , 'redirect_link' => base_url()."".$this->uri->segment(1));
		}
		
		echo(json_encode($status));
	}
	public function delete($IdPrimaryKey){
		$where = array('id_produk' => $IdPrimaryKey);
		$delete = $this->produk_model->delete($where);		
		redirect(base_url()."".$this->uri->segment(1));
	}

	
}
