<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Barang extends CI_Controller {
		
	public function __construct() {
		parent::__construct();
		
		$this->load->model('barang_model');
		$this->load->model('t_harga_barang_model');
	} 

	public function index(){		
		$like 		= null;
		$order_by 	= 'nama_BARANG, id_BARANG'; 
		$urlSearch 	= null;
		
		if($this->input->get('field')){
			$like = array($_GET['field'] => $_GET['keyword']);
			$urlSearch = "?field=".$_GET['field']."&keyword=".$_GET['keyword'];
		}		
		
		$this->load->library('pagination');	
		
		$config['base_url'] 	= base_url().'barang/index'.$urlSearch;
		$this->jumlahData 		= $this->barang_model->getCount("",$like);		
		$config['total_rows'] 	= $this->jumlahData;		
		$config['per_page'] 	= 10;		
		
		$this->pagination->initialize($config);	
		$this->showData = $this->barang_model->showData("",$like,$order_by,$config['per_page'],$this->input->get('per_page'));
		$this->pagination->initialize($config);
		
		$this->template_view->load_view('barang/barang_view');
	}
	public function add(){
		$this->template_view->load_view('barang/barang_add_view');
	}
	public function add_data(){
		$this->form_validation->set_rules('NAMA_BARANG', '', 'trim|required');		
		$this->form_validation->set_rules('SATUAN', '', 'trim|required');		
		$this->form_validation->set_rules('JENIS_HARGA', '', 'trim|required');		
		
		if ($this->form_validation->run() == FALSE)	{
			$status = array('status' => FALSE, 'pesan' => 'Gagal menyimpan Data, pastikan telah mengisi semua inputan yang diwajibkan untuk diisi.', 'message' => validation_errors());
		}
		else{		

			$maxIDbarang = $this->barang_model->getPrimaryKeyMax();
			$newId = $maxIDbarang->MAX + 1;			
			
			$data = array(					
				'ID_BARANG' => $newId,			
				'NAMA_BARANG' => $this->input->post('NAMA_BARANG'),			
				'SATUAN' => $this->input->post('SATUAN'),			
				'KETERANGAN' => $this->input->post('KETERANGAN'),			
				'HARGA_SATUAN' => $this->input->post('HARGA_SATUAN'),			
				'JENIS_HARGA' => $this->input->post('JENIS_HARGA')				
			);
			$query = $this->barang_model->insert($data);	
			
			if($this->input->post('JENIS_HARGA') == 'BEDA'){
				$status = array('status' => true , 'redirect_link' => base_url()."".$this->uri->segment(1)."/edit/".$newId, 'pesan_modal' => 'Proses simpan data berhasil. Anda akan diarahkan ke halaman untuk mengisi Harga barang berdasarkan jumlah pembelian.');
			}
			else{
				$status = array('status' => true , 'redirect_link' => base_url()."".$this->uri->segment(1) );
			}
			
		}
		
		echo(json_encode($status));
	}
	public function edit($IdPrimaryKey){
		$where = array('id_BARANG' => $IdPrimaryKey);
		$this->oldData = $this->barang_model->getData($where);	

		$orde_by_harga = 'MIN_BARANG';
		$where_harga = array('id_BARANG' => $IdPrimaryKey);
		$this->data_harga = $this->t_harga_barang_model->showData($where_harga,null,$orde_by_harga );	
		
		$this->template_view->load_view('barang/barang_edit_view');
	}
	public function edit_data(){
		$this->form_validation->set_rules('NAMA_BARANG', '', 'trim|required');		
		$this->form_validation->set_rules('SATUAN', '', 'trim|required');		
		$this->form_validation->set_rules('JENIS_HARGA', '', 'trim|required');		
		
		if ($this->form_validation->run() == FALSE)	{
			$status = array('status' => FALSE, 'pesan' => 'Gagal menyimpan Data, pastikan telah mengisi semua inputan yang diwajibkan untuk diisi.', 'message' => validation_errors());
		}
		else{								
			$data = array(			
				'NAMA_BARANG' => $this->input->post('NAMA_BARANG')	,			
				'SATUAN' => $this->input->post('SATUAN')	,			
				'KETERANGAN' => $this->input->post('KETERANGAN')	,			
				'JENIS_HARGA' => $this->input->post('JENIS_HARGA')				
			);
			
			$where = array('id_BARANG' => $this->input->post('ID_BARANG'));
			$query = $this->barang_model->update($where,$data);							
			$status = array('status' => true , 'redirect_link' => base_url()."".$this->uri->segment(1));
		}
		
		echo(json_encode($status));
	}
	public function delete($IdPrimaryKey){
		$where = array('id_BARANG' => $IdPrimaryKey);
		$delete = $this->barang_model->delete($where);

		$delete = $this->t_harga_barang_model->delete($where);			
		redirect(base_url()."".$this->uri->segment(1));
	}
	public function search_barang(){
		$like = array('NAMA_BARANG' => $this->input->get('term'));
		$databarang = $this->barang_model->showData("",$like,"NAMA_BARANG");  
		echo '[';		
		$i=1;
		foreach($databarang as $data){			
			
			if($i > 1){echo ",";}
			echo '{ "label":"'.$data->NAMA_BARANG.'","id_barang":"'.$data->ID_BARANG.'","satuan_barang":"'.$data->SATUAN.'"} ';
			$i++;
		}
		echo ']';
	}
	
	
	
	public function add_data_harga_barang(){
		$this->form_validation->set_rules('MIN_BARANG', '', 'trim|required');		
		$this->form_validation->set_rules('MAX_BARANG', '', 'trim|required');		
		$this->form_validation->set_rules('HARGA', '', 'trim|required');		
		
		if ($this->form_validation->run() == FALSE)	{
			$status = array('status' => FALSE, 'pesan' => 'Gagal menyimpan Data, pastikan telah mengisi semua inputan yang diwajibkan untuk diisi.', 'message' => validation_errors());
		}
		else{		

			$maxIDbarang = $this->t_harga_barang_model->getPrimaryKeyMax();
			$newId = $maxIDbarang->MAX + 1;			
			
			$data = array(					
				'ID_T_HARGA_BARANG' => $newId,			
				'ID_BARANG' => $this->input->post('ID_BARANG'),			
				'MIN_BARANG' => $this->input->post('MIN_BARANG'),			
				'MAX_BARANG' => $this->input->post('MAX_BARANG'),			
				'HARGA' => $this->input->post('HARGA')				
			);
			$query = $this->t_harga_barang_model->insert($data);				
			
			$status = array('status' => true );			
			
		}
		
		echo(json_encode($status));
	}
	public function delete_harga_barang($IdPrimaryKey,$id_barang){
		$where = array('id_t_harga_BARANG' => $IdPrimaryKey);
		$delete = $this->t_harga_barang_model->delete($where);		
		redirect(base_url()."".$this->uri->segment(1)."/edit/".$id_barang);
	}
	
	public function get_data_harga(){		
		$where = array('id_BARANG' => $this->input->post('id_barang'));
		$dataBarang = $this->barang_model->getData($where);	
		
		if($dataBarang->JENIS_HARGA == 'SAMA'){
			$status = array('status' => true ,'harga_qty' => $dataBarang->HARGA_SATUAN );		
		}
		else{			
			$dataHargaBarang = $this->t_harga_barang_model->getDataHargaBeda($this->input->post('id_barang'), $this->input->post('jumlah'));	
			//echo $this->db->last_query();
			//var_dump($dataHargaBarang );
				
			$status = array('status' => true ,'harga_qty' => $dataHargaBarang->HARGA );
		}
		echo(json_encode($status));		
	}
	
}
