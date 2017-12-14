<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Revisi_wo extends CI_Controller {
		
	public function __construct() {
		parent::__construct();
		
		$this->load->model('t_order_model');
		$this->load->model('t_barang_order_model');
		$this->load->model('t_log_order_model');
		$this->load->model('t_bayar_order_model');
	} 

	public function index(){		
		
		$this->showData = null;
		if($this->input->get('no_wo')){
			$where = array('no_wo' => $this->input->get('no_wo'));
			$this->showData = $this->t_order_model->getData($where);	
			
			if($this->showData){
				
				$IdPrimaryKey= $this->showData->ID_ORDER;
			
				$this->load->library('text_barang');
				//var_dump($this->text_barang->getText('8','1'));
				
				$where = array('id_order' => $IdPrimaryKey);
				$this->oldData = $this->t_order_model->getData($where);	
				
				
				$queryBarang = $this->db->query("select * from v_barang_order where id_order = '".$IdPrimaryKey."' order by count_barang");		
				$this->dataBarang  = $queryBarang->result();	
				
				$queryBarangCancel = $this->db->query("select * from v_barang_order_cancel where id_order = '".$IdPrimaryKey."' order by count_barang");	
				$this->dataBarangCancel  = $queryBarangCancel->result();	
				
				$this->jumlahBarang  = $this->t_barang_order_model->getCount($where);	
				
				//var_dump($this->jumlahBarang );
				
				$this->logAlur  = $this->t_log_order_model->showData($where);	
			}
			
			
		}				
		
		$this->template_view->load_view('kasir/proses_revisi_view');
	}
	
	public function proses($IdPrimaryKey){
		
		$this->load->library('text_barang');
		//var_dump($this->text_barang->getText('8','1'));
		
		$where = array('id_order' => $IdPrimaryKey);
		$this->oldData = $this->t_order_model->getData($where);	
		
		
		$queryBarang = $this->db->query("select * from v_barang_order where id_order = '".$IdPrimaryKey."' order by count_barang");		
		$this->dataBarang  = $queryBarang->result();	
		
		$this->jumlahBarang  = $this->t_barang_order_model->getCount($where);	
		
		//var_dump($this->jumlahBarang );
		
		$this->logAlur  = $this->t_log_order_model->showData($where);	
		
		
		
		if($this->oldData){
		
			$bayar  = $this->t_bayar_order_model->getData($where);	
			
			//var_dump($bayar->JUMLAH_BAYAR);
			if($bayar){
				$this->jumlahDP 	= 	$bayar->JUMLAH_BAYAR;
				$this->caraBayar 	= 	$bayar->JENIS_BAYAR;
			}
			else{
				$this->jumlahDP = "0";
				$this->caraBayar ="";
			}
			
			$this->template_view->load_view('kasir/proses_view');
			
			
		}
		else{
			redirect($this->uri->segment('1'));
		}		
	
	}
	
	function format_rupiah($angka){
		$rupiah=number_format($angka,0,',','.');
		return "Rp. ".$rupiah.",00";
	}
	
	public function proses_data(){
		
			$diskon = str_replace(".", "", $this->input->post('DISCOUNT') );
			$jumlahBayar = str_replace(".", "", $this->input->post('JUMLAH_BAYAR') );
		
			$queryBayar 	= $this->db->query("select max(id_t_bayar_order) as MAX from t_bayar_order");
			$idBayar 	= $queryBayar->row();
			$newIdBayar	= $idBayar->MAX + 1;	
			
			//var_dump($jumlahBayar);
			//var_dump($this->input->post('TOTAL_BAYAR'));

			if($jumlahBayar >= $this->input->post('TOTAL_BAYAR')){
				$catatan = 'Proses bayar selesai (Lunas)';
				$statusBayar= "L";
			}
			else{
				$catatan = 'Proses bayar selesai (Hanya DP sebesar : '.$this->format_rupiah($jumlahBayar).')';
				$statusBayar= "BL";
			}
			
			//var_dump($catatan);
			
			$dataBayar = array(								
				'ID_T_BAYAR_ORDER' 	=> 	$newIdBayar	,
				'JENIS_BAYAR' 		=> 	$this->input->post('JENIS_BAYAR')	,
				'ID_ORDER' 			=> 	$this->input->post('ID_ORDER')	,
				'JUMLAH_KEMBALI' 			=> 	$this->input->post('JUMLAH_KEMBALI')	,
				'ID_KARYAWAN' 		=> $this->session->userdata('id_karyawan')	,		
				'JUMLAH_BAYAR' 		=> 	$jumlahBayar 	
				
			);
			$this->db->set('TGL_BAYAR', 'NOW()', FALSE);
			$query = $this->t_bayar_order_model->insert($dataBayar);
			
			
			$data = array(					
				'TOTAL_BAYAR' 	=> $this->input->post('TOTAL_BAYAR')	,		
				'DISCOUNT' 		=> 	$diskon,
				'POSISI_ORDER' 	=> 	'FINISH'	,
				'STATUS_BAYAR' 	=> 	$statusBayar					
			);			
			$where  = array('ID_ORDER' => $this->input->post('ID_ORDER'));
			$query = $this->t_order_model->update($where,$data);	
			
			
			
			//// update Harga barang
			
			
			//// input barang
			foreach($this->input->post('COUNT_BARANG') as $COUNT_BARANG){
				
				$maxCountBarang = $this->t_barang_order_model->getPrimaryKeyMax($this->input->post('ID_ORDER'));
				$newId = $maxCountBarang->MAX + 1;	
				
				$jumlah 	= 	str_replace('.','',$this->input->post('JUMLAH_QTY_'.$COUNT_BARANG));
				$hargaSatuan 	= 	str_replace('.','',$this->input->post('HARGA_SATUAN_'.$COUNT_BARANG));
				$hargaTotal 	= 	str_replace('.','',$this->input->post('TOTAL_HARGA_'.$COUNT_BARANG));
				
				
				$this->db->query("				
					update 
						t_barang_order 
					set
						
						JUMLAH_QTY = '".$jumlah."',
						HARGA_SATUAN = '".$hargaSatuan."',
						TOTAL_HARGA = '".$hargaTotal."'	
					where
						id_order= '".$this->input->post('ID_ORDER')."'
						and count_barang= '".$COUNT_BARANG."'
					
				");
				
			}
			
			///// input Log WO
			$data = array(					
				'ID_ORDER' 			=> $this->input->post('ID_ORDER')	,		
				'ID_KARYAWAN' 		=> $this->session->userdata('id_karyawan')	,			
				'CATATAN_LOG_ORDER' => $catatan,
				'DARI' 				=> 'KASIR',			
				'KE' 				=> 'FINISH'	
			);
			$this->db->set('TGL_LOG_ORDER', 'NOW()', FALSE);
			$query = $this->t_log_order_model->insert($data);
			
			
			$status = array('status' => true,'id_order' => $this->input->post('ID_ORDER'),'kasir' => true,'pesan_modal' => 'Data berhasil disimpan.. silahkan proses WO untuk mencetak Nota.','redirect_link' => base_url()."".$this->uri->segment(1)."/proses/". $this->input->post('ID_ORDER') );
				
				
			echo(json_encode($status));
		
	}
	
}
