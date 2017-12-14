<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {
		
	public function __construct() {
		parent::__construct();
		
		
		$this->load->model('t_harga_kertas_model');
		$this->load->model('customer_model');
		$this->load->model('t_log_order_model');
		$this->load->model('t_order_model');
	} 

	public function index(){				
		$like 		= null;
		$order_by 	= 'tgl_order asc, no_order desc'; 
		$urlSearch 	= null;
		
		$where  	= array('POSISI_ORDER !=' => 'FINISH');
		
		if($this->input->get('field')){
			$like = array($_GET['field'] => $_GET['keyword']);
			$urlSearch = "?field=".$_GET['field']."&keyword=".$_GET['keyword'];
		}		
		
		$this->load->library('pagination');	
		
		$config['base_url'] 	= base_url().'barang/index'.$urlSearch;
		$this->jumlahData 		= $this->t_order_model->getCount($where ,$like);		
		$config['total_rows'] 	= $this->jumlahData;		
		$config['per_page'] 	= 100;		
		
		$this->pagination->initialize($config);	
		$this->showData = $this->t_order_model->showData($where ,$like,$order_by,$config['per_page'],$this->input->get('per_page'));
		$this->pagination->initialize($config);
		
		$whereAntri = array('POSISI_ORDER' => 'OP-PRINT');
		$this->showDataAntriPrint = $this->t_order_model->showData($whereAntri);
		
		$this->showDataAntriGrafis = $this->t_order_model->showDataForGrafis();
		
				$this->IsiTabel = "";
		
				$no = $this->input->get('per_page')+ 1;
				foreach($this->showData as $showData ){
					
					
				$queryOperator = $this->db->query("select m_karyawan.NAMA_KARYAWAN from t_log_order,m_karyawan where m_karyawan.id_karyawan=t_log_order.id_karyawan and t_log_order.id_order='".$showData->ID_ORDER."' and t_log_order.KE='KASIR' order by tgl_log_order");
				$dataOperator = $queryOperator->row();
				
				if($dataOperator!=""){
					$Operator = $dataOperator->NAMA_KARYAWAN;					
				}
				else{
					$Operator = "-";
				}
				
				if($showData->NO_WO !=""){
					$wo = $showData->NO_WO;					
				}
				else{
					
					$wo= "Belum memasukkan Barang";
				}
				
				$this->IsiTabel .=  '<tr>
					
					
					<td align="center">'.$wo.'</td>
					<td >
					'.$showData->nama_pelanggan."<br>".
					($showData->LOG_MEMBER == "Y" ? "( Member )" : "( Bukan Member )").'
					</td>
					<td >'.$showData->TGL_ORDER."<br>".$showData->JAM_ORDER.'</td>
					<td >'.$Operator.'</td>
					<td >'.$showData->LINE.'</td>
					<td >'.$showData->POSISI_ORDER.'</td>
				</tr>';
				}
				$no++;
				 
				
				if(!$this->showData){
					$this->IsiTabel = "<tr><td colspan='25' align='center'>Data tidak ada.</td></tr>";
				}
				
				
		
		$this->template_view->load_view('order/order_view');
	}
	
	
	
}
