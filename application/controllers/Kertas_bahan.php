<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kertas_bahan extends CI_Controller {
		
	public function __construct() {
		parent::__construct();
		
		$this->load->model('kertas_bahan_model');
		$this->load->model('ukuran_kertas_model');
		$this->load->model('t_harga_kertas_model');
	} 

	public function index(){		
	
		//$this->load->library("count_page_pdf");
		//echo $this->count_page_pdf->getNumPagesPdf('PANDUAN-BELAJAR-MS-EXCEL.pdf');
	
	
		$like 		= null;
		$order_by 	= 'nama_kertas'; 
		$urlSearch 	= null;
		
		if($this->input->get('field')){
			$like = array($_GET['field'] => $_GET['keyword']);
			$urlSearch = "?field=".$_GET['field']."&keyword=".$_GET['keyword'];
		}		
		
		$this->load->library('pagination');	
		
		$config['base_url'] 	= base_url().'kertas_bahan/index'.$urlSearch;
		$this->jumlahData 		= $this->kertas_bahan_model->getCount("",$like);		
		$config['total_rows'] 	= $this->jumlahData;		
		$config['per_page'] 	= 10;		
		
		$this->pagination->initialize($config);	
		$this->showData = $this->kertas_bahan_model->showData("",$like,$order_by,$config['per_page'],$this->input->get('per_page'));
		$this->pagination->initialize($config);
		
		$this->template_view->load_view('kertas_bahan/kertas_bahan_view');
	}
	public function add(){
		$this->template_view->load_view('kertas_bahan/kertas_bahan_add_view');
	}
	public function add_data(){
		$this->form_validation->set_rules('NAMA_KERTAS', '', 'trim|required');		
		$this->form_validation->set_rules('HARGA_KERTAS', '', 'trim|required');		
		
		if ($this->form_validation->run() == FALSE)	{
			$status = array('status' => FALSE, 'pesan' => 'Gagal menyimpan Data, pastikan telah mengisi semua inputan yang diwajibkan untuk diisi.', 'message' => validation_errors());
		}
		else{		

			$maxIDCustomer = $this->kertas_bahan_model->getPrimaryKeyMax();
			$newId = $maxIDCustomer->MAX + 1;			
			
			$data = array(					
				'ID_KERTAS' => $newId	,						
				'NAMA_KERTAS' => $this->input->post('NAMA_KERTAS')	,	
				'HARGA_KERTAS' => $this->input->post('HARGA_KERTAS')		
			);
			$query = $this->kertas_bahan_model->insert($data);							
			$status = array('status' => true , 'redirect_link' => base_url()."".$this->uri->segment(1));
		}
		
		echo(json_encode($status));
	}
	
	public function add_data_ukuran_kertas(){
		$this->form_validation->set_rules('ID_KERTAS', '', 'trim|required');		
		
		if ($this->form_validation->run() == FALSE)	{
			$status = array('status' => FALSE, 'pesan' => 'Gagal menyimpan Data, pastikan telah mengisi semua inputan yang diwajibkan untuk diisi.', 'message' => validation_errors());
		}
		else{		

			$maxIDUkuranKertas 	= 	$this->t_harga_kertas_model->getPrimaryKeyMax();
			$newId 				= 	$maxIDUkuranKertas->MAX + 1;			
			
			$data = array(					
				'ID_T_HARGA_BARANG' => $newId,						
				'ID_KERTAS' 		=> $this->input->post('ID_KERTAS'),	
				'ID_UKURAN_KERTAS'	=> $this->input->post('ID_UKURAN_KERTAS'),	
				'MINIMAL'		 	=> $this->input->post('MINIMAL'),	
				'MAXIMAL' 		=> $this->input->post('MAXIMAL'),	
				'HARGA_SATU_SISI' 		=> $this->input->post('HARGA_SATU_SISI'),	
				'HARGA_DUA_SISI' 		=> $this->input->post('HARGA_DUA_SISI')	
			);
			$query = $this->t_harga_kertas_model->insert($data);							
			$status = array('status' => true );
		}
		
		echo(json_encode($status));
	}
	public function edit($IdPrimaryKey){
		$where = array('id_kertas' => $IdPrimaryKey);
		$this->oldData = $this->kertas_bahan_model->getData($where);	
		
		$this->kertasIndoorOutdoor =  $this->ukuran_kertas_model->showData("","","ukuran_kertas");
		
		
		
		$this->template_view->load_view('kertas_bahan/kertas_bahan_edit_view');
	}
	public function edit_data(){	
		$this->form_validation->set_rules('ID_KERTAS', '', 'trim|required');		
		$this->form_validation->set_rules('NAMA_KERTAS', '', 'trim|required');		
		$this->form_validation->set_rules('HARGA_KERTAS', '', 'trim|required');		
		
		if ($this->form_validation->run() == FALSE)	{
			$status = array('status' => FALSE, 'pesan' => 'Gagal menyimpan Data, pastikan telah mengisi semua inputan yang diwajibkan untuk diisi.', 'message' => validation_errors());
		}
		else{								
			$data = array(					
				'NAMA_KERTAS' => $this->input->post('NAMA_KERTAS')		,			
				'HARGA_KERTAS' => $this->input->post('HARGA_KERTAS')					
			);
			
			$where = array('id_kertas' => $this->input->post('ID_KERTAS'));
			$query = $this->kertas_bahan_model->update($where,$data);

			
				
			$status = array('status' => true , 'redirect_link' => base_url()."".$this->uri->segment(1));
		}
		
		echo(json_encode($status));
	}
	public function delete($IdPrimaryKey){
		$where = array('id_kertas' => $IdPrimaryKey);
		$delete = $this->kertas_bahan_model->delete($where);		
		redirect(base_url()."".$this->uri->segment(1));
	}
	public function delete_harga_barang($id_kertas,$IdPrimaryKey){
		
		$where = array('id_t_harga_barang' => $IdPrimaryKey);
		$delete = $this->t_harga_kertas_model->delete($where);
		
		redirect(base_url()."".$this->uri->segment(1)."/edit/".$id_kertas);
	}
	
	public function option_for_kertas(){
		
		$queryKertas	=	$this->db->query("select distinct(id_kertas) as id_kertas , nama_kertas from v_harga_kertas where id_produk='".$this->input->post('id_produk')."' order by nama_kertas");
		$dataKertas		=	$queryKertas->result();
	//	echo $this->db->last_query();
		echo "<option value=''>Silahkan Pilih Jenis Bahan</opton>";
		foreach($dataKertas as $kertas){
			echo "<option value='".$kertas->id_kertas."'>".$kertas->nama_kertas."</option>";
		}
	}

	
}
