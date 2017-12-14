<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Barang_gudang extends CI_Controller {
		
	public function __construct() {
		parent::__construct();
		
		$this->load->model('barang_gudang_model');
		$this->load->model('barang_gudang_keluar_model');
		$this->load->model('barang_gudang_masuk_model');
	} 

	public function index(){		
		$like 		= null;
		$order_by 	= 'nama_barang_gudang'; 
		$urlSearch 	= null;
		
		if($this->input->get('field')){
			$like = array($_GET['field'] => $_GET['keyword']);
			$urlSearch = "?field=".$_GET['field']."&keyword=".$_GET['keyword'];
		}		
		
		$this->load->library('pagination');	
		
		$config['base_url'] 	= base_url().'barang_gudang/index'.$urlSearch;
		$this->jumlahData 		= $this->barang_gudang_model->getCount("",$like);		
		$config['total_rows'] 	= $this->jumlahData;		
		$config['per_page'] 	= 10;		
		
		$this->pagination->initialize($config);	
		$this->showData = $this->barang_gudang_model->showData("",$like,$order_by,$config['per_page'],$this->input->get('per_page'));
		$this->pagination->initialize($config);
		
		$this->template_view->load_view('barang_gudang/barang_gudang_view');
	}
	public function add(){
		$this->template_view->load_view('barang_gudang/barang_gudang_add_view');
	}
	public function add_data(){
		$this->form_validation->set_rules('NAMA_BARANG_GUDANG', '', 'trim|required');		
		
		if ($this->form_validation->run() == FALSE)	{
			$status = array('status' => FALSE, 'pesan' => 'Gagal menyimpan Data, pastikan telah mengisi semua inputan yang diwajibkan untuk diisi.', 'message' => validation_errors());
		}
		else{								
			$data = array(			
				'NAMA_BARANG_GUDANG ' => $this->input->post('NAMA_BARANG_GUDANG')				,
				'SATUAN_BARANG_GUDANG ' => $this->input->post('SATUAN_BARANG_GUDANG')				,
				'KETERANGAN' => $this->input->post('KETERANGAN')				
			);
			$query = $this->barang_gudang_model->insert($data);							
			$status = array('status' => true , 'redirect_link' => base_url()."".$this->uri->segment(1));
		}
		
		echo(json_encode($status));
	}
	public function edit($IdPrimaryKey){
		$where = array('id_barang_gudang' => $IdPrimaryKey);
		$this->oldData = $this->barang_gudang_model->getData($where);	

		$whereKeluar = array('`t_barang_gudang_keluar.id_barang_gudang' => $IdPrimaryKey);
		$this->showDataKeluar = $this->barang_gudang_keluar_model->showData($whereKeluar,"","TGL_ENTRY desc");
		//echo $this->db->last_query();
		
		$whereMasuk = array('`t_barang_gudang_masuk.id_barang_gudang' => $IdPrimaryKey);
		$this->showDataMasuk = $this->barang_gudang_masuk_model->showData($whereMasuk,"","TGL_ENTRY desc");
		
		$this->template_view->load_view('barang_gudang/barang_gudang_edit_view');
	}
	public function edit_data(){
		$this->form_validation->set_rules('NAMA_BARANG_GUDANG', '', 'trim|required');		
		
		if ($this->form_validation->run() == FALSE)	{
			$status = array('status' => FALSE, 'pesan' => 'Gagal menyimpan Data, pastikan telah mengisi semua inputan yang diwajibkan untuk diisi.', 'message' => validation_errors());
		}
		else{								
			$data = array(			
				'NAMA_BARANG_GUDANG ' => $this->input->post('NAMA_BARANG_GUDANG')				,
				'SATUAN_BARANG_GUDANG ' => $this->input->post('SATUAN_BARANG_GUDANG')				,
				'KETERANGAN' => $this->input->post('KETERANGAN')					
			);
			
			$where = array('id_barang_gudang' => $this->input->post('ID_BARANG_GUDANG'));
			$query = $this->barang_gudang_model->update($where,$data);							
			$status = array('status' => true , 'redirect_link' => base_url()."".$this->uri->segment(1));
		}
		
		echo(json_encode($status));
	}
	public function delete($IdPrimaryKey){
		$where = array('id_barang_gudang' => $IdPrimaryKey);
		$delete = $this->barang_gudang_model->delete($where);		
		redirect(base_url()."".$this->uri->segment(1));
	}
	public function search_barang_gudang(){
		$like = array('nama_barang_gudang' => $this->input->get('term'));
		$dataKaryawan = $this->barang_gudang_model->showData("",$like,"nama_barang_gudang");  
		echo '[';		
		$i=1;
		foreach($dataKaryawan as $data){			
			
			if($i > 1){echo ",";}
			echo '{ "label":"'.$data->NAMA_KARYAWAN.'","id_barang_gudang":"'.$data->ID_KARYAWAN.'"} ';
			$i++;
		}
		echo ']';
	}
}
