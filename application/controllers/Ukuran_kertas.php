<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ukuran_kertas extends CI_Controller {
		
	public function __construct() {
		parent::__construct();
		
		$this->load->model('ukuran_kertas_model');
	} 

	public function index(){		
	
		//$this->load->library("count_page_pdf");
		//echo $this->count_page_pdf->getNumPagesPdf('PANDUAN-BELAJAR-MS-EXCEL.pdf');
	
	
		$like 		= null;
		$order_by 	= 'ukuran_kertas'; 
		$urlSearch 	= null;
		
		if($this->input->get('field')){
			$like = array($_GET['field'] => $_GET['keyword']);
			$urlSearch = "?field=".$_GET['field']."&keyword=".$_GET['keyword'];
		}		
		
		$this->load->library('pagination');	
		
		$config['base_url'] 	= base_url().'ukuran_kertas/index'.$urlSearch;
		$this->jumlahData 		= $this->ukuran_kertas_model->getCount("",$like);		
		$config['total_rows'] 	= $this->jumlahData;		
		$config['per_page'] 	= 50;		
		
		$this->pagination->initialize($config);	
		$this->showData = $this->ukuran_kertas_model->showData("",$like,$order_by,$config['per_page'],$this->input->get('per_page'));
		$this->pagination->initialize($config);
		
		$this->template_view->load_view('ukuran_kertas/ukuran_kertas_view');
	}
	public function add(){
		$this->template_view->load_view('ukuran_kertas/ukuran_kertas_add_view');
	}
	public function add_data(){
		$this->form_validation->set_rules('UKURAN_KERTAS', '', 'trim|required');		
		
		if ($this->form_validation->run() == FALSE)	{
			$status = array('status' => FALSE, 'pesan' => 'Gagal menyimpan Data, pastikan telah mengisi semua inputan yang diwajibkan untuk diisi.', 'message' => validation_errors());
		}
		else{		

			$maxIDCustomer = $this->ukuran_kertas_model->getPrimaryKeyMax();
			$newId = $maxIDCustomer->MAX + 1;			
			
			$data = array(					
				'ID_UKURAN_KERTAS' => $newId	,						
				'UKURAN_KERTAS' => $this->input->post('UKURAN_KERTAS')		
			);
			$query = $this->ukuran_kertas_model->insert($data);							
			$status = array('status' => true , 'redirect_link' => base_url()."".$this->uri->segment(1));
		}
		
		echo(json_encode($status));
	}
	public function edit($IdPrimaryKey){
		$where = array('ID_UKURAN_KERTAS' => $IdPrimaryKey);
		$this->oldData = $this->ukuran_kertas_model->getData($where);		
		$this->template_view->load_view('ukuran_kertas/ukuran_kertas_edit_view');
	}
	public function edit_data(){	
		$this->form_validation->set_rules('ID_UKURAN_KERTAS', '', 'trim|required');		
		$this->form_validation->set_rules('UKURAN_KERTAS', '', 'trim|required');		
		
		if ($this->form_validation->run() == FALSE)	{
			$status = array('status' => FALSE, 'pesan' => 'Gagal menyimpan Data, pastikan telah mengisi semua inputan yang diwajibkan untuk diisi.', 'message' => validation_errors());
		}
		else{								
			$data = array(					
				'UKURAN_KERTAS' => $this->input->post('UKURAN_KERTAS')					
			);
			
			$where = array('ID_UKURAN_KERTAS' => $this->input->post('ID_UKURAN_KERTAS'));
			$query = $this->ukuran_kertas_model->update($where,$data);							
			$status = array('status' => true , 'redirect_link' => base_url()."".$this->uri->segment(1));
		}
		
		echo(json_encode($status));
	}
	public function delete($IdPrimaryKey){
		$where = array('ID_UKURAN_KERTAS' => $IdPrimaryKey);
		$delete = $this->ukuran_kertas_model->delete($where);		
		redirect(base_url()."".$this->uri->segment(1));
	}

	public function option_for_ukuran_kertas(){
		
		$queryUkruanKertas	=	$this->db->query("select distinct(id_ukuran_kertas) as id_ukuran_kertas , ukuran_kertas from v_harga_kertas where id_produk='".$this->input->post('id_produk')."' and id_kertas='".$this->input->post('id_kertas')."' order by ukuran_kertas");
		$dataUkuranKertas		=	$queryUkruanKertas->result();
		echo "<option value=''>Silahkan Pilih Jenis Bahan</opton>";
		foreach($dataUkuranKertas as $ukuran_kertas){
			echo "<option value='".$ukuran_kertas->id_ukuran_kertas."'>".$ukuran_kertas->ukuran_kertas."</option>";
		}
	}

}
