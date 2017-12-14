<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pelunasan extends CI_Controller {
		
	public function __construct() {
		parent::__construct();
		
		$this->load->model('t_order_model');
		$this->load->model('t_barang_order_model');
		$this->load->model('t_log_order_model');
		$this->load->model('t_bayar_order_model');
	} 

	public function index(){		
		$like 		= null;
		$order_by 	= 'tgl_order'; 
		$urlSearch 	= null;
		
		$where  = array('t_order.POSISI_ORDER' => 'FINISH','t_order.STATUS_BAYAR' => 'BL');
		
		if($this->input->get('field')){
			$like = array($_GET['field'] => $_GET['keyword']);
			$urlSearch = "?field=".$_GET['field']."&keyword=".$_GET['keyword'];
		}		
		
		$this->load->library('pagination');	
		
		$config['base_url'] 	= base_url().'barang/index'.$urlSearch;
		$this->jumlahData 		= $this->t_order_model->getCount($where ,$like);		
		$config['total_rows'] 	= $this->jumlahData;		
		$config['per_page'] 	= 50;		
		
		$this->pagination->initialize($config);	
		$this->showData = $this->t_order_model->showData($where ,$like,$order_by,$config['per_page'],$this->input->get('per_page'));
		$this->pagination->initialize($config);
		
		$this->template_view->load_view('kasir/kasir_view');
	}
	
	public function proses($IdPrimaryKey){
		
		$this->load->library('text_barang');
		
		$where = array('id_order' => $IdPrimaryKey);
		$this->oldData = $this->t_order_model->getData($where);	
		
		
		$this->dataBarang  = $this->t_barang_order_model->showData($where);	
		
		$this->jumlahBarang  = $this->t_barang_order_model->getCount($where);	
		
		$this->logAlur  = $this->t_log_order_model->showData($where);	
		$this->dataBayar  = $this->t_bayar_order_model->showData($where);	
		
		
		
		if($this->oldData){
		
			$this->template_view->load_view('pelunasan/proses_view');
			
			
		}
		else{
			redirect($this->uri->segment('1'));
		}		
	
	}
	
	public function proses_data(){
			
			$jumlahBayar = str_replace('.','',$this->input->post('JUMLAH_BAYAR_SEKARANG'));
			
			$totalBayarSemua = $this->input->post('TOTAL_CICILAN') + $jumlahBayar;
			
			if( $totalBayarSemua >=  $this->input->post('TOTAL_BAYAR')){
				$data = array(					
					'STATUS_BAYAR' 	=> 	"L"				
				);			
				$where  = array('ID_ORDER' => $this->input->post('ID_ORDER'));
				$query = $this->t_order_model->update($where,$data);
				
				$kurangBayar = '0';
			}
			else{
				$kurang = $this->input->post('TOTAL_BAYAR') - $totalBayarSemua;			
				$kurangBayar = "Rp. ".number_format($kurang,0,',','.') ;
			}
						
			
			$queryBayar 	= $this->db->query("select max(id_t_bayar_order) as MAX from t_bayar_order");
			$idBayar 	= $queryBayar->row();
			$newIdBayar	= $idBayar->MAX + 1;			
			
			$dataBayar = array(								
				'ID_T_BAYAR_ORDER' 	=> 	$newIdBayar	,
				'JENIS_BAYAR' 		=> 	$this->input->post('JENIS_BAYAR')	,
				'ID_ORDER' 			=> 	$this->input->post('ID_ORDER')	,
				'JUMLAH_KEMBALI' 			=> 	$this->input->post('KELEBIHAN_CICILAN')	,
				'ID_KARYAWAN' 		=> $this->session->userdata('id_karyawan')	,		
				'JUMLAH_BAYAR' 		=> 	$jumlahBayar
				
			);
			$this->db->set('TGL_BAYAR', 'NOW()', FALSE);
			$query = $this->t_bayar_order_model->insert($dataBayar);
			
			
			$status = array('status' => true,'pesan_modal' => 'Data berhasil disimpan.. Pembayaran Cicilan kurang = '.$kurangBayar,'redirect_link' => base_url()."".$this->uri->segment(1)."/proses/". $this->input->post('ID_ORDER') );
				
				
			echo(json_encode($status));
		
	}
	
}
