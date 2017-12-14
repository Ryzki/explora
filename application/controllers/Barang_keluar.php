<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Barang_keluar extends CI_Controller {
		
	public function __construct() {
		parent::__construct();
		
		$this->load->model('barang_gudang_keluar_model');
		$this->load->model('barang_gudang_model');
	} 

	public function index(){		
		$like 		= null;
		$order_by 	= 'tgl_entry'; 
		$urlSearch 	= null;
		
		if($this->input->get('field')){
			$like = array($_GET['field'] => $_GET['keyword']);
			$urlSearch = "?field=".$_GET['field']."&keyword=".$_GET['keyword'];
		}		
		
		$this->load->library('pagination');	
		
		$config['base_url'] 	= base_url().'barang_gudang/index'.$urlSearch;
		$this->jumlahData 		= $this->barang_gudang_keluar_model->getCount("",$like);		
		$config['total_rows'] 	= $this->jumlahData;		
		$config['per_page'] 	= 10;		
		
		$this->pagination->initialize($config);	
		$this->showData = $this->barang_gudang_keluar_model->showData("",$like,$order_by,$config['per_page'],$this->input->get('per_page'));
		$this->pagination->initialize($config);
		
		$this->template_view->load_view('barang_keluar/barang_keluar_view');
	}
	public function add(){
		$order_by 	= 'nama_barang_gudang'; 
		$this->dataBarang = $this->barang_gudang_model->showData("","",$order_by);
		
		$this->template_view->load_view('barang_keluar/barang_keluar_add_view');
	}
	public function add_data(){
		$this->form_validation->set_rules('ID_BARANG_GUDANG', '', 'trim|required');		
		$this->form_validation->set_rules('JUMLAH_KELUAR', '', 'trim|required');		
		
		if ($this->form_validation->run() == FALSE)	{
			$status = array('status' => FALSE, 'pesan' => 'Gagal menyimpan Data, pastikan telah mengisi semua inputan yang diwajibkan untuk diisi.', 'message' => validation_errors());
		}
		else{								
			$data = array(			
				'tgl_barang_keluar' 			=> date('Y-m-d',strtotime($this->input->post('TGL_BARANG_KELUAR'))),				
				'ID_KARYAWAN' 				=> $this->session->userdata('id_karyawan'),
				'ID_BARANG_GUDANG' 		=> $this->input->post('ID_BARANG_GUDANG')				,
				'JUMLAH_KELUAR' 				=> $this->input->post('JUMLAH_KELUAR')				,
				'KETERANGAN' 					=> $this->input->post('KETERANGAN')				
			);
			$query = $this->barang_gudang_keluar_model->insert($data);							
			
			$queryStokLama				=	$this->db->query("select STOK from m_barang_gudang where ID_BARANG_GUDANG='".$this->input->post('ID_BARANG_GUDANG')."'");
			$dataStokLama				=	$queryStokLama->row();
			
			$newStok							=	$dataStokLama->STOK - $this->input->post('JUMLAH_KELUAR');
			
			$this->db->query("update m_barang_gudang set stok='".$newStok."' where ID_BARANG_GUDANG='".$this->input->post('ID_BARANG_GUDANG')."'");
			//echo $this->db->last_query();
			$status = array('status' => true , 'redirect_link' => base_url()."".$this->uri->segment(1));
		}
		
		echo(json_encode($status));
	}
	
}
