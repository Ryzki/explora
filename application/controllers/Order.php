<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order extends CI_Controller {
		
	public function __construct() {
		parent::__construct();
		
		
		$this->load->model('t_harga_kertas_model');
		$this->load->model('customer_model');
		$this->load->model('t_log_order_model');
		$this->load->model('t_order_model');
		$this->load->model('pelanggan_model');
	} 

	public function index(){				
		redirect('order/add');
	}
	public function add(){				
		$this->template_view->load_view('order/form_order_view');
	}
	public function add_data(){	

	
		$jumlahIdBarang = count($this->input->post('id_barang'));
	//	var_dump($jumlahIdBarang);
		//if(    $jumlahIdBarang > 0   ){
			
			$cekMember	=	$this->db->query("select * from master_pelanggan where nomor_telp='".$this->input->post('HP_CUSTOMER')."'");
			$dataMember=	$cekMember->row();
		
			if(!$dataMember){
			
				///// input customer jika tidak ada di datasbe
				$maxIDPelanggan = $this->pelanggan_model->getPrimaryKeyMax();
				$idPelanggan = $maxIDPelanggan->MAX + 1;			

				$data = array(					
					'id_pelanggan' => $idPelanggan	,			
					'alamat' => $this->input->post('ALAMAT_CUSTOMER')	,			
					'nama_pelanggan' => $this->input->post('NAMA_CUSTOMER')	,			
					'nomor_telp' => $this->input->post('HP_CUSTOMER')				
				);
				$query = $this->pelanggan_model->insert($data);							
			}
			else{
				$idPelanggan = $this->input->post('ID_CUSTOMER');
			}
			
			
			////// input t_order
			$maxIDOrder = $this->t_order_model->getPrimaryKeyMax();
			$idOrder = $maxIDOrder->MAX + 1;
			
			$maxIDOrderToday = $this->t_order_model->getPrimaryKeyMaxToday();
			$NoOrder = $maxIDOrderToday->MAX + 1;
			
			switch($this->input->post('JENIS_ORDER')){
				case "1";
					$TujuanOrder = "OP-GRAFIS";
					break;
				case "2";
					$TujuanOrder = "OP-GRAFIS";
					break;
				case "3";
					$TujuanOrder = "OP-PRINT";
					break;
				case "4";
					$TujuanOrder = "KASIR";
					break;
			}
			
			
			if($this->input->post('JENIS_ORDER') == '4'){
				$noWO =   date('dmy').'-'.$idOrder;
				$data = array(					
					'ID_ORDER' 		=> 	$idOrder,			
					'ID_CUSTOMER'	=> 	$idPelanggan	,			
					'POSISI_ORDER' 	=> 	$TujuanOrder,
					'NO_ORDER_LAIN' 			=> 	$this->input->post('NO_ORDER_LAIN'),
					'LINE' 			=> 	$this->input->post('LINE'),
					'NO_WO' 		=>	$noWO	,
					'TUJUAN_ORDER' 	=>	$this->input->post('JENIS_ORDER')	,
					'NO_ORDER'		=> 	$NoOrder,
					'ID_KARYAWAN' 	=> 	$this->session->userdata('id_karyawan')	,		
					'LOG_MEMBER'	=> 	$this->input->post('LOG_MEMBER')
				);
				$this->db->set('TGL_ORDER', 'NOW()', FALSE);
			}
			else{
				$data = array(					
					'ID_ORDER' 		=> 	$idOrder,			
					'ID_CUSTOMER'	=> 	$idPelanggan	,			
					'POSISI_ORDER' 	=> 	$TujuanOrder,
					'ID_KARYAWAN' 	=> 	$this->session->userdata('id_karyawan')	,		
					'TUJUAN_ORDER' 	=>	$this->input->post('JENIS_ORDER')	,
					'LINE' 			=> 	$this->input->post('LINE'),
					'NO_ORDER_LAIN' 			=> 	$this->input->post('NO_ORDER_LAIN'),
					'NO_ORDER'		=> 	$NoOrder,
					'LOG_MEMBER'	=> 	$this->input->post('LOG_MEMBER')
				);
				$this->db->set('TGL_ORDER', 'NOW()', FALSE);
			}
			
			
			$query = $this->t_order_model->insert($data);
			
			
			/* foreach($this->input->post('id_barang') as $id_barang){
				$this->db->query("				
				insert into t_barang_order 
					(
						ID_BARANG,
						ID_ORDER,
						JUMLAH_QTY,
						HARGA_SATUAN,
						TOTAL_HARGA,
						
					)
					values
					(
						'".$id_barang."',
						'".$idOrder."',
						'".$this->input->post('jumlah_qty_'.$id_barang)."',
						'".$this->input->post('harga_qty_'.$id_barang)."',
						'".$this->input->post('total_harga_'.$id_barang)."'
					)
					
				");
				
			} */
			
			///// input Log WO
			$data = array(					
				'ID_ORDER' 			=> $idOrder	,			
				'ID_KARYAWAN' 		=> $this->session->userdata('id_karyawan')	,			
				'CATATAN_LOG_ORDER' => $this->input->post('CATATAN_LOG_ORDER')	,		
				'KE' 				=> $TujuanOrder	,		
				'DARI' 				=>  'CS'	
			);
			$this->db->set('TGL_LOG_ORDER', 'NOW()', FALSE);
			$query = $this->t_log_order_model->insert($data);
			
			$status = array('status' => true , 'redirect_link' => base_url()."dashboard" , 'pesan_modal' => '<b>Input Order berhasil disimpan.</b><h3>No Order : '.$NoOrder.'</h3>','id_order' =>$idOrder);
		//}
		//else{
		//	$status = array('status' => false , 'pesan' => 'Proses simpan gagal, anda belum input barang !');
	//	}
		
		echo(json_encode($status));
	}
	
	
}
