<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Grafis extends CI_Controller {
		
	public function __construct() {
		parent::__construct();
		
		$this->load->model('t_order_model');
		$this->load->model('t_barang_order_model');
		$this->load->model('t_log_order_model');
		$this->load->model('m_harga_grafis_model');
		$this->load->model('mesin_model');
		$this->load->model('kertas_bahan_model');
		$this->load->model('produk_model');
	} 

	public function index(){		
		$like 		= null;
		$order_by 	= 'tgl_order,no_order'; 
		$urlSearch 	= null;
		
		$where  = array();
	
		
		if($this->input->get('field')){
			$like = array($_GET['field'] => $_GET['keyword']);
			$urlSearch = "?field=".$_GET['field']."&keyword=".$_GET['keyword'];
		}		
		
		$this->load->library('pagination');	
		
		$config['base_url'] 	= base_url().'barang/index'.$urlSearch;
		$this->jumlahData 		= $this->t_order_model->getCountDataForGrafis($where ,$like);		
		$config['total_rows'] 	= $this->jumlahData;		
		$config['per_page'] 	= 50;		
		
		$this->pagination->initialize($config);	
		$this->showData = $this->t_order_model->showDataForGrafis($where ,$like,$order_by,$config['per_page'],$this->input->get('per_page'));
		$this->pagination->initialize($config);
		
		//echo $this->db->last_query();
		
		$this->template_view->load_view('grafis/grafis_view');
	}
	
	public function proses($IdPrimaryKey){
	
		
		
		
		$where = array('id_order' => $IdPrimaryKey);
		$this->oldData = $this->t_order_model->getData($where);	
		
		$this->dataMesin  		= $this->mesin_model->showData();	
		
		$query_produk			=	$this->db->query("select distinct(id_produk) as id_produk,nama_produk from v_harga_kertas where kategori='1' order by nama_produk");
		$this->dataProduk  		= 	$query_produk->result();	
		
		$whereProdukIndoorOutdoor 		= array('kategori' => '2');
		$this->dataProdukIndoorOutdoor  = $this->produk_model->showData($whereProdukIndoorOutdoor,'','nama_produk');	
		
		$whereProdukLain 		= array('kategori' => '3');
		$this->dataProdukLain  = $this->produk_model->showData($whereProdukLain,'','nama_produk');		
		
		$this->logAlur  = $this->t_log_order_model->showData($where);	
		
		if($this->oldData){
			$this->template_view->load_view('grafis/proses_view');
		}
		else{
			redirect($this->uri->segment('1'));
		}		

	
	}
	
	public function ukuran_kertas(){
		
		$query_ukuran			=	$this->db->query("select distinct(id_ukuran_kertas) as id_ukuran_kertas,ukuran_kertas from v_harga_kertas where id_kertas='".$this->input->post('id_kertas')."' and id_produk='".$this->input->post('id_produk')."' order by ukuran_kertas");
		echo "<option value=''>Silahkan Pilih</option>";
		foreach( $query_ukuran->result() as $ukuran  ){
			
			echo "<option value='".$ukuran->id_ukuran_kertas."'>".$ukuran->ukuran_kertas."</option>";
		}
	}
	
	
	function cari_harga_kertas($id_produk,$id_kertas,$id_ukuran_kertas,$klik){
		
	}
	
	public function proses_data(){
		
		$queryDataLama = $this->db->query("select * from t_order where id_order = '".$this->input->post('ID_ORDER')."'");
		$dataLama		=	$queryDataLama->row();
		
		$where = array('id_order' => $this->input->post('ID_ORDER'));
		$this->oldData = $this->t_order_model->getData($where);	
	
		if($this->oldData->POSISI_ORDER=='FINISH-DESIGN'){
			
			///// input Log WO
			$data = array(					
				'ID_ORDER' 			=> $this->input->post('ID_ORDER')	,		
				'ID_KARYAWAN' 		=> $this->session->userdata('id_karyawan')	,			
				'CATATAN_LOG_ORDER' => 'Ke Proses Pembayaran'	,		
				'DARI' 				=> 'FINISH-DESIGN',			
				'KE' 				=> 'KASIR'	
			);
			$this->db->set('TGL_LOG_ORDER', 'NOW()', FALSE);
			$query = $this->t_log_order_model->insert($data);			
			
			
				////////////////////////////////////////////////
			///		Jika Digital Printing (5)
			////////////////////////////////////////////////
			
			if(is_array($this->input->post('ID_BARANG_GRAFIS'))){
				
				$JumlahKlik	=	"0";
				foreach($this->input->post('ID_BARANG_GRAFIS') as $ID_BARANG_GRAFIS){
					$JumlahKlik += $this->input->post('klik_'.$ID_BARANG_GRAFIS);
				}
				
				//// input barang
				foreach($this->input->post('ID_BARANG_GRAFIS') as $ID_BARANG_GRAFIS){
					
					$harga	=	"0";
					
					/***********
					
					///// cara lama
					
					$queryHarga	=	$this->db->query("
					select 
						harga_satu_sisi,harga_dua_sisi 
					from 
						t_harga_kertas 
					where 
						id_produk='".$this->input->post('id_produk_'.$ID_BARANG_GRAFIS)."'	
						and id_kertas='".$this->input->post('id_kertas_'.$ID_BARANG_GRAFIS)."'
						and id_ukuran_kertas='".$this->input->post('id_ukuran_kertas_'.$ID_BARANG_GRAFIS)."'
						and minimal <= '".$this->input->post('klik_'.$ID_BARANG_GRAFIS)."'
						and maximal >= '".$this->input->post('klik_'.$ID_BARANG_GRAFIS)."'
					");
					
					***********************/
					
					$queryHarga	=	$this->db->query("
					select 
						harga_satu_sisi,harga_dua_sisi ,harga_satu_sisi_member,harga_dua_sisi_member
					from 
						t_harga_kertas 
					where 
						id_produk='".$this->input->post('id_produk_'.$ID_BARANG_GRAFIS)."'	
						and id_kertas='".$this->input->post('id_kertas_'.$ID_BARANG_GRAFIS)."'
						and id_ukuran_kertas='".$this->input->post('id_ukuran_kertas_'.$ID_BARANG_GRAFIS)."'
						and minimal <= '".$JumlahKlik."'
						and maximal >= '".$JumlahKlik."'
					");
					$dataharga = $queryHarga->row();
					if($dataharga){
						if($dataLama->LOG_MEMBER=='Y'){
							if($this->input->post('jml_sisi_'.$ID_BARANG_GRAFIS) == '1'){
								$harga = $dataharga->harga_satu_sisi_member;
							}
							else{
								$harga = $dataharga->harga_dua_sisi_member;
							}
						}
						else{
							if($this->input->post('jml_sisi_'.$ID_BARANG_GRAFIS) == '1'){
								$harga = $dataharga->harga_satu_sisi;
							}
							else{
								$harga = $dataharga->harga_dua_sisi;
							}
						}
					}
					else{
						$harga = "0";
					}
					
					$maxCountBarang = $this->t_barang_order_model->getPrimaryKeyMax($this->input->post('ID_ORDER'));
					$newId = $maxCountBarang->MAX + 1;	
					
					
					/**$this->db->query("				
					insert into t_barang_order 
						(
							COUNT_BARANG,
							ID_ORDER,
							NAMA_BARANG,
							JUMLAH_QTY,
							SATUAN_BARANG,
							HARGA_SATUAN,
							TOTAL_HARGA						
						)
						values
						(
							'".$newId."',
							'".$this->input->post('ID_ORDER')."',
							'".$this->input->post('NAMA_BARANG_'.$ID_BARANG_GRAFIS)."',
							'".$this->input->post('JUMLAH_QTY_'.$ID_BARANG_GRAFIS)."',
							'".$this->input->post('SATUAN_BARANG_'.$ID_BARANG_GRAFIS)."',
							'".$this->input->post('HARGA_QTY_'.$ID_BARANG_GRAFIS)."',
							'".$this->input->post('TOTAL_QTY_'.$ID_BARANG_GRAFIS)."'						
						)
						
					");**/
					
					
					//var_dump($harga);
					
					$total_harga	=	$harga * $this->input->post('klik_'.$ID_BARANG_GRAFIS);
					
					$this->db->query("				
					insert into t_barang_order 
						(
							ID_KARYAWAN,
							COUNT_BARANG,
							ID_ORDER,
							ID_PRODUK,
							ID_KERTAS,
							ID_UKURAN_KERTAS,
							JUMLAH_QTY,
							HARGA_SATUAN,
							TOTAL_HARGA,
							
							NAMA_FILE_PEKERJAAN	,					
							KETERANGAN	,					
							KETERANGAN_FINISHING	,					
							PAGE_IMG	,					
							JML_SISI	,					
							JML_COPY	,					
							JML_KLIK	,					
							UP	,					
							PAGE_ON_SITE_SIDE				
						)
						values
						(
							'".$this->session->userdata('id_karyawan')."',
							'".$newId."',
							'".$this->input->post('ID_ORDER')."',
							'".$this->input->post('id_produk_'.$ID_BARANG_GRAFIS)."',
							'".$this->input->post('id_kertas_'.$ID_BARANG_GRAFIS)."',
							'".$this->input->post('id_ukuran_kertas_'.$ID_BARANG_GRAFIS)."',
							'".$this->input->post('klik_'.$ID_BARANG_GRAFIS)."',
							'".$harga."',
							'".$total_harga."',
												
							'".$this->input->post('nama_file_pekerjaan_'.$ID_BARANG_GRAFIS)."',						
							'".$this->input->post('keterangan_'.$ID_BARANG_GRAFIS)."',						
							'".$this->input->post('keterangan_finishing_'.$ID_BARANG_GRAFIS)."',						
							'".$this->input->post('page_img_'.$ID_BARANG_GRAFIS)."',								
							'".$this->input->post('jml_sisi_'.$ID_BARANG_GRAFIS)."',								
							'".$this->input->post('jml_copy_'.$ID_BARANG_GRAFIS)."',								
							'".$this->input->post('klik_'.$ID_BARANG_GRAFIS)."',								
							'".$this->input->post('up_'.$ID_BARANG_GRAFIS)."',								
							'".$this->input->post('page_on_site_side_'.$ID_BARANG_GRAFIS)."'								
						)
						
					");
					//echo $this->db->last_query();
				}
			}
			
			
			////////////////////////////////////////////////
			///		Jika Indoor (6)
			////////////////////////////////////////////////
			
			if(is_array($this->input->post('ID_BARANG_INDOOR'))){		
				
				
			
				//// input barang
				foreach($this->input->post('ID_BARANG_INDOOR') as $ID_BARANG_INDOOR){
				
					$maxCountBarang = $this->t_barang_order_model->getPrimaryKeyMax($this->input->post('ID_ORDER'));
					$newId = $maxCountBarang->MAX + 1;	
					
					$panjangIndoor	=	str_replace(".","",$this->input->post('panjang_indoor_'.$ID_BARANG_INDOOR));
					$copyIndoor		=	str_replace(".","",$this->input->post('jml_copy_indoor_'.$ID_BARANG_INDOOR));
					
					if($panjangIndoor < 50){
						$panjang	=	50;						
					}
					else{
						$panjang	=	$panjangIndoor;
					}
					
					$jumlahSatuanForDatabase	=	$panjang * $copyIndoor;
					
					////////////////////////////// cari harga di database
					$queryHarga	=	$this->db->query("
					select 
						harga_satu_sisi ,harga_satu_sisi_member
					from 
						t_harga_kertas 
					where 
						id_produk='".$this->input->post('id_produk_indoor_'.$ID_BARANG_INDOOR)."'	
						and id_kertas='".$this->input->post('id_kertas_indoor_'.$ID_BARANG_INDOOR)."'
						and id_ukuran_kertas='".$this->input->post('id_ukuran_kertas_indoor_'.$ID_BARANG_INDOOR)."'
						and minimal <= '".$jumlahSatuanForDatabase."'
						and maximal >= '".$jumlahSatuanForDatabase."'
					");
					//echo $this->db->last_query();
					$dataharga = $queryHarga->row();
					
					if($dataharga){
						if($dataLama->LOG_MEMBER=='Y'){
							$harga_indoor			=	$dataharga->harga_satu_sisi_member;
						}
						else{
							$harga_indoor			=	$dataharga->harga_satu_sisi;
						}
					
					}
					else{
						$harga_indoor	 = "0";
					}
				
					
					//$total_harga_indoor	=	$harga_indoor * $this->input->post('jml_copy_indoor_'.$ID_BARANG_INDOOR);
					$total_harga_indoor	=	$harga_indoor * $jumlahSatuanForDatabase ;
					
					$this->db->query("				
					insert into t_barang_order 
						(
							ID_KARYAWAN,
							COUNT_BARANG,
							ID_ORDER,
							ID_PRODUK,
							ID_KERTAS,
							ID_UKURAN_KERTAS,
							JUMLAH_QTY,
							HARGA_SATUAN,
							TOTAL_HARGA,
							
							NAMA_FILE_PEKERJAAN	,					
							KETERANGAN	,					
							KETERANGAN_FINISHING	,				
							JML_COPY	,			
							PANJANG,
							LEBAR
						)
						values
						(
							'".$this->session->userdata('id_karyawan')."',
							'".$newId."',
							'".$this->input->post('ID_ORDER')."',
							'".$this->input->post('id_produk_indoor_'.$ID_BARANG_INDOOR)."',
							'".$this->input->post('id_kertas_indoor_'.$ID_BARANG_INDOOR)."',
							'".$this->input->post('id_ukuran_kertas_indoor_'.$ID_BARANG_INDOOR)."',
							'".$jumlahSatuanForDatabase."',
							'".$harga_indoor."',
							'".$total_harga_indoor."',
												
							'".$this->input->post('nama_file_pekerjaan_indoor_'.$ID_BARANG_INDOOR)."',						
							'".$this->input->post('keterangan_indoor_'.$ID_BARANG_INDOOR)."',						
							'".$this->input->post('keterangan_finishing_indoor_'.$ID_BARANG_INDOOR)."',							
							'".$copyIndoor."',										
							'".$panjangIndoor."',										
							'".$this->input->post('lebar_indoor_'.$ID_BARANG_INDOOR)."'									
						)
						
					");
					//echo $this->db->last_query();
					
				}
			}
			
			
			
			////////////////////////////////////////////////
			///		Jika Kartu nama (10)
			////////////////////////////////////////////////
			
			if(is_array($this->input->post('ID_BARANG_KARTU_NAMA'))){		
				
				
			
				//// input barang
				foreach($this->input->post('ID_BARANG_KARTU_NAMA') as $ID_BARANG_KARTU_NAMA){
				
					$maxCountBarang = $this->t_barang_order_model->getPrimaryKeyMax($this->input->post('ID_ORDER'));
					$newId = $maxCountBarang->MAX + 1;	
					
					////////////////////////////// cari harga di database
					$queryHarga	=	$this->db->query("
					select 
						harga_satu_sisi ,
						harga_dua_sisi ,
						harga_satu_sisi_member,
						harga_dua_sisi_member
					from 
						t_harga_kertas 
					where 
						id_produk='".$this->input->post('id_produk')."'	
						and id_kertas='".$this->input->post('id_kertas_kartu_nama_'.$ID_BARANG_KARTU_NAMA)."'
						and id_ukuran_kertas='".$this->input->post('id_ukuran_kertas_kartu_nama_'.$ID_BARANG_KARTU_NAMA)."'
						and minimal <= '".$this->input->post('box_kartu_nama_'.$ID_BARANG_KARTU_NAMA)."'
						and maximal >= '".$this->input->post('box_kartu_nama_'.$ID_BARANG_KARTU_NAMA)."'
					");
				//	echo $this->db->last_query();
					$dataharga = $queryHarga->row();
					//echo $this->db->last_query();
					//var_dump($dataharga);
					if($dataharga){
						if($dataLama->LOG_MEMBER=='Y'){
							if($this->input->post('jml_sisi_kartu_nama_'.$ID_BARANG_KARTU_NAMA) == '1'){
								$harga_satuan			=	$dataharga->harga_satu_sisi_member;
							}
							else{
								$harga_satuan			=	$dataharga->harga_dua_sisi_member;
							}
						}
						else{
							if($this->input->post('jml_sisi_kartu_nama_'.$ID_BARANG_KARTU_NAMA) == '1'){
								$harga_satuan			=	$dataharga->harga_satu_sisi;
							}
							else{
								$harga_satuan			=	$dataharga->harga_dua_sisi;
							}
						}
					}
					else{
						$harga_satuan	= "0";
					}
					
					
					
					
					$total_harga	=	$harga_satuan * $this->input->post('box_kartu_nama_'.$ID_BARANG_KARTU_NAMA);
					
					$pageImageKartuNama = str_replace(".","",$this->input->post('page_img_kartu_nama_'.$ID_BARANG_KARTU_NAMA));
					$copyKartuNama 		= str_replace(".","",$this->input->post('jml_copy_kartu_nama_'.$ID_BARANG_KARTU_NAMA));
					
					$this->db->query("				
					insert into t_barang_order 
						(
							ID_KARYAWAN,
							COUNT_BARANG,
							ID_ORDER,
							ID_PRODUK,
							ID_KERTAS,
							ID_UKURAN_KERTAS,
							JUMLAH_QTY,
							HARGA_SATUAN,
							TOTAL_HARGA,
							
							NAMA_FILE_PEKERJAAN	,					
							KETERANGAN	,							
							JML_COPY	,
							JML_SISI,
							JML_KLIK,
							PAGE_IMG
						)
						values
						(
							'".$this->session->userdata('id_karyawan')."',
							'".$newId."',
							'".$this->input->post('ID_ORDER')."',
							'".$this->input->post('id_produk')."',
							'".$this->input->post('id_kertas_kartu_nama_'.$ID_BARANG_KARTU_NAMA)."',
							'".$this->input->post('id_ukuran_kertas_kartu_nama_'.$ID_BARANG_KARTU_NAMA)."',
							'".$this->input->post('box_kartu_nama_'.$ID_BARANG_KARTU_NAMA)."',
							'".$harga_satuan."',
							'".$total_harga."',
												
							'".$this->input->post('nama_file_setelah_upload_kartu_nama_'.$ID_BARANG_KARTU_NAMA)."',						
							'".$this->input->post('keterangan_kartu_nama_'.$ID_BARANG_KARTU_NAMA)."',								
							'".$copyKartuNama."',														
							'".$this->input->post('jml_sisi_kartu_nama_'.$ID_BARANG_KARTU_NAMA)."'	,							
							'".$this->input->post('klik_kartu_nama_'.$ID_BARANG_KARTU_NAMA)."'	,							
							'".$pageImageKartuNama."'							
						)
						
					");
					//echo $this->db->last_query();
					
				}
			}
			
			
			////////////////////////////////////////////////
			///		Jika Indoor Poster (15)
			////////////////////////////////////////////////
			
			if(is_array($this->input->post('ID_BARANG_INDOOR_POSTER'))){						
			
				//// input barang
				foreach($this->input->post('ID_BARANG_INDOOR_POSTER') as $ID_BARANG_INDOOR_POSTER){
				
					 $panjangIndoorPoster = 	str_replace(".","",$this->input->post('panjang_indoor_poster_'.$ID_BARANG_INDOOR_POSTER));
					//echo "<br>";
					 $lebarIndoorPoster 	= 	str_replace(".","",$this->input->post('lebar_indoor_poster_'.$ID_BARANG_INDOOR_POSTER));
					//echo "<br>";
					 $jmlCopyIndoorPoster =	str_replace(".","",$this->input->post('jml_copy_indoor_poster_'.$ID_BARANG_INDOOR_POSTER));  
					//echo "<br>";
										
					$maxCountBarang = $this->t_barang_order_model->getPrimaryKeyMax($this->input->post('ID_ORDER'));
					$newId = $maxCountBarang->MAX + 1;
					
					////////////////////////////// cari harga di database
					$queryHarga	=	$this->db->query("
					select 
						harga_satu_sisi ,harga_satu_sisi_member
					from 
						t_harga_kertas 
					where 
						id_produk='".$this->input->post('id_produk_indoor_poster_'.$ID_BARANG_INDOOR_POSTER)."'	
						and id_kertas='".$this->input->post('id_kertas_indoor_poster_'.$ID_BARANG_INDOOR_POSTER)."'
						and minimal <= '".$jmlCopyIndoorPoster."'
						and maximal >= '".$jmlCopyIndoorPoster."'
					");
					//echo $this->db->last_query();
					$dataharga = $queryHarga->row();
					if($dataharga){
						if($dataLama->LOG_MEMBER=='Y'){
							$harga_indoor_poster			=	$dataharga->harga_satu_sisi_member;
						}
						else{
							$harga_indoor_poster			=	$dataharga->harga_satu_sisi;
						}
					}
					else{
						$harga_indoor_poster ="0";
					}
					
					$total_harga_indoor_poster		=	$harga_indoor_poster * $jmlCopyIndoorPoster;
					
					$this->db->query("				
					insert into t_barang_order 
						(
							ID_KARYAWAN,
							COUNT_BARANG,
							ID_ORDER,
							ID_PRODUK,
							ID_KERTAS,
							ID_UKURAN_KERTAS,
							JUMLAH_QTY,
							HARGA_SATUAN,
							TOTAL_HARGA,
							
							NAMA_FILE_PEKERJAAN	,					
							KETERANGAN	,					
							KETERANGAN_FINISHING	,				
							JML_COPY	,			
							PANJANG,
							LEBAR
						)
						values
						(
							'".$this->session->userdata('id_karyawan')."',
							'".$newId."',
							'".$this->input->post('ID_ORDER')."',
							'".$this->input->post('id_produk_indoor_poster_'.$ID_BARANG_INDOOR_POSTER)."',
							'".$this->input->post('id_kertas_indoor_poster_'.$ID_BARANG_INDOOR_POSTER)."',
							'".$this->input->post('id_ukuran_kertas_indoor_poster_'.$ID_BARANG_INDOOR_POSTER)."',
							'".$jmlCopyIndoorPoster."',
							'".$harga_indoor_poster."',
							'".$total_harga_indoor_poster."',
												
							'".$this->input->post('nama_file_pekerjaan_indoor_poster_'.$ID_BARANG_INDOOR_POSTER)."',						
							'".$this->input->post('keterangan_indoor_poster_'.$ID_BARANG_INDOOR_POSTER)."',						
							'".$this->input->post('keterangan_finishing_indoor_poster_'.$ID_BARANG_INDOOR_POSTER)."',							
							'".$jmlCopyIndoorPoster."',										
							'".$panjangIndoorPoster."',										
							'".$lebarIndoorPoster."'									
						)
						
					");
					//echo $this->db->last_query();
					
				}
			}
			
			
			////////////////////////////////////////////////
			///		Jika paket banner (16)
			////////////////////////////////////////////////
			
			if(is_array($this->input->post('ID_BARANG_PAKET_BANNER'))){						
			
				//// input barang
				foreach($this->input->post('ID_BARANG_PAKET_BANNER') as $ID_BARANG_PAKET_BANNER){
				
					 $panjangPaketBanner = 	str_replace(".","",$this->input->post('panjang_paket_banner_'.$ID_BARANG_PAKET_BANNER));
					//echo "<br>";
					 $lebarPaketBanner 	= 	str_replace(".","",$this->input->post('lebar_paket_banner_'.$ID_BARANG_PAKET_BANNER));
					//echo "<br>";
					 $jmlCopyPaketBanner =	str_replace(".","",$this->input->post('jml_copy_paket_banner_'.$ID_BARANG_PAKET_BANNER));  
					//echo "<br>";
										
					$maxCountBarang = $this->t_barang_order_model->getPrimaryKeyMax($this->input->post('ID_ORDER'));
					$newId = $maxCountBarang->MAX + 1;
					
					////////////////////////////// cari harga di database
					$queryHarga	=	$this->db->query("
					select 
						harga_satu_sisi ,harga_satu_sisi_member
					from 
						t_harga_kertas 
					where 
						id_produk='".$this->input->post('id_produk_paket_banner_'.$ID_BARANG_PAKET_BANNER)."'	
						and id_kertas='".$this->input->post('id_kertas_paket_banner_'.$ID_BARANG_PAKET_BANNER)."'
						and minimal <= '".$jmlCopyPaketBanner."'
						and maximal >= '".$jmlCopyPaketBanner."'
					");
					//echo $this->db->last_query();
					$dataharga = $queryHarga->row();
					if($dataharga){
						if($dataLama->LOG_MEMBER=='Y'){
							$harga_paket_banner			=	$dataharga->harga_satu_sisi_member;
						}
						else{
							$harga_paket_banner		=	$dataharga->harga_satu_sisi;
						}
					}
					else{
						$harga_paket_banner = "0";
					}
					
					
					$total_harga_paket_banner		=	$harga_paket_banner * $jmlCopyPaketBanner;
					
					$this->db->query("				
					insert into t_barang_order 
						(
							ID_KARYAWAN,
							COUNT_BARANG,
							ID_ORDER,
							ID_PRODUK,
							ID_KERTAS,
							ID_UKURAN_KERTAS,
							JUMLAH_QTY,
							HARGA_SATUAN,
							TOTAL_HARGA,
							
							NAMA_FILE_PEKERJAAN	,					
							KETERANGAN	,					
							KETERANGAN_FINISHING	,				
							JML_COPY	,			
							PANJANG,
							LEBAR
						)
						values
						(
							'".$this->session->userdata('id_karyawan')."',
							'".$newId."',
							'".$this->input->post('ID_ORDER')."',
							'".$this->input->post('id_produk_paket_banner_'.$ID_BARANG_PAKET_BANNER)."',
							'".$this->input->post('id_kertas_paket_banner_'.$ID_BARANG_PAKET_BANNER)."',
							'".$this->input->post('id_ukuran_kertas_paket_banner_'.$ID_BARANG_PAKET_BANNER)."',
							'".$jmlCopyPaketBanner."',
							'".$harga_paket_banner."',
							'".$total_harga_paket_banner."',
												
							'".$this->input->post('nama_file_pekerjaan_paket_banner_'.$ID_BARANG_PAKET_BANNER)."',						
							'".$this->input->post('keterangan_paket_banner_'.$ID_BARANG_PAKET_BANNER)."',						
							'".$this->input->post('keterangan_finishing_paket_banner_'.$ID_BARANG_PAKET_BANNER)."',							
							'".$jmlCopyPaketBanner."',										
							'".$panjangPaketBanner."',										
							'".$lebarPaketBanner."'									
						)
						
					");
					//echo $this->db->last_query();
					
				}
			}
			
			////////////////////////////////////////////////
			///		Jika Outdoor (5)
			////////////////////////////////////////////////
			
			if(is_array($this->input->post('ID_BARANG_OUTDOOR'))){						
			
				//// input barang
				foreach($this->input->post('ID_BARANG_OUTDOOR') as $ID_BARANG_OUTDOOR){
				
					 $panjangOutdoor = 	str_replace(".","",$this->input->post('panjang_outdoor_'.$ID_BARANG_OUTDOOR));
					//echo "<br>";
					 $lebarOutdoor 	= 	str_replace(".","",$this->input->post('lebar_outdoor_'.$ID_BARANG_OUTDOOR));
					//echo "<br>";
					 $jmlCopyOutdoor =	str_replace(".","",$this->input->post('jml_copy_outdoor_'.$ID_BARANG_OUTDOOR));  
					//echo "<br>";
										
					$maxCountBarang = $this->t_barang_order_model->getPrimaryKeyMax($this->input->post('ID_ORDER'));
					$newId = $maxCountBarang->MAX + 1;
					
					 $panjang 		= 	$panjangOutdoor / 100;
					 $bulatPanjang = number_format($panjang, 2, '.', '');
					// $bulatPanjang	=	$panjang ;
					
					 $lebar 			= 	$lebarOutdoor / 100;
					$bulatLebar = number_format($lebar, 2, '.', '');
					// $bulatLebar		=	$lebar ;
					
					  $jumlahSatuanForDatabase	=	$bulatPanjang * $bulatLebar * $jmlCopyOutdoor;
					
					
					////////////////////////////// cari harga di database
					$queryHarga	=	$this->db->query("
					select 
						harga_satu_sisi ,harga_satu_sisi_member
					from 
						t_harga_kertas 
					where 
						id_produk='".$this->input->post('id_produk_outdoor_'.$ID_BARANG_OUTDOOR)."'	
						and id_kertas='".$this->input->post('id_kertas_outdoor_'.$ID_BARANG_OUTDOOR)."'
						and minimal <= '".$jumlahSatuanForDatabase."'
						and maximal >= '".$jumlahSatuanForDatabase."'
					");
					//echo $this->db->last_query();
					$dataharga = $queryHarga->row();
					
					if($dataharga){
					
						if($dataLama->LOG_MEMBER=='Y'){
							$harga_outdoor			=	$dataharga->harga_satu_sisi_member;
						}
						else{
							$harga_outdoor			=	$dataharga->harga_satu_sisi;
						}
					}
					else{
						$dataharga = "0";
					}
					
				//	var_dump($harga_outdoor);
					
					//var_dump($harga_outdoor);
					$total_harga_outdoor		=	$harga_outdoor * $jumlahSatuanForDatabase;
					
					$this->db->query("				
					insert into t_barang_order 
						(
							ID_KARYAWAN,
							COUNT_BARANG,
							ID_ORDER,
							ID_PRODUK,
							ID_KERTAS,
							JUMLAH_QTY,
							HARGA_SATUAN,
							TOTAL_HARGA,
							
							NAMA_FILE_PEKERJAAN	,					
							KETERANGAN	,					
							KETERANGAN_FINISHING	,				
							JML_COPY	,			
							PANJANG,
							LEBAR
						)
						values
						(
							'".$this->session->userdata('id_karyawan')."',
							'".$newId."',
							'".$this->input->post('ID_ORDER')."',
							'".$this->input->post('id_produk_outdoor_'.$ID_BARANG_OUTDOOR)."',
							'".$this->input->post('id_kertas_outdoor_'.$ID_BARANG_OUTDOOR)."',
							'".$jumlahSatuanForDatabase."',
							'".$harga_outdoor."',
							'".$total_harga_outdoor."',
												
							'".$this->input->post('nama_file_pekerjaan_outdoor_'.$ID_BARANG_OUTDOOR)."',						
							'".$this->input->post('keterangan_outdoor_'.$ID_BARANG_OUTDOOR)."',						
							'".$this->input->post('keterangan_finishing_outdoor_'.$ID_BARANG_OUTDOOR)."',							
							'".$jmlCopyOutdoor."',										
							'".$panjangOutdoor."',										
							'".$lebarOutdoor."'									
						)
						
					");
					//echo $this->db->last_query();
					
				}
			}
			
				/////////////////////////////////////////////
			///////////////  BARANG Lain
			
			if(is_array($this->input->post('ID_BARANG_LAIN'))){		
				
				
				foreach($this->input->post('ID_BARANG_LAIN') as $ID_BARANG_LAIN){
				
					$maxCountBarang = $this->t_barang_order_model->getPrimaryKeyMax($this->input->post('ID_ORDER'));
					$newId = $maxCountBarang->MAX + 1;						
					
					$quantity = str_replace(".","",$this->input->post('quantity_lain_'.$ID_BARANG_LAIN));
					
					$this->db->query("				
					insert into t_barang_order 
						(
							ID_KARYAWAN,
							COUNT_BARANG,
							ID_ORDER,
							ID_PRODUK,					
							JUMLAH_QTY,					
							KETERANGAN	
						)
						values
						(
							'".$this->session->userdata('id_karyawan')."',
							'".$newId."',
							'".$this->input->post('ID_ORDER')."',
							'".$this->input->post('id_produk_lain_'.$ID_BARANG_LAIN)."',
							'".$quantity."',
							'".$this->input->post('keterangan_produk_lain_'.$ID_BARANG_LAIN)."'				
						)
						
					");
					
					//echo $this->db->last_query();
					
				}
			}
			
			
			
			//////  update posisi order
			$dataOrder = array(								
				'POSISI_ORDER' 	=> 	'KASIR',			
			);
			$where = array('id_order' =>	$this->input->post('ID_ORDER'));
			$query = $this->t_order_model->update($where ,$dataOrder);
			
			$status = array('status' => true ,'redirect_link' => base_url()."grafis" , 'pesan_modal' => '<h3>Work Order berhasil disimpan dengan Nomor Wo :  '.$this->oldData->NO_WO.'</h3><br>WO sekarang sudah berada di Kasir untuk Proses pembayaran.','print_job' => true);
			
		}
		else{
			$selanjutnya = 'FINISH-DESIGN';			
			
			///// input Log WO
			$data = array(					
				'ID_ORDER' 			=> $this->input->post('ID_ORDER')	,		
				'ID_KARYAWAN' 		=> $this->session->userdata('id_karyawan')	,			
				'CATATAN_LOG_ORDER' => $this->input->post('CATATAN_LOG_ORDER')	,		
				'DARI' 				=> 'OP-GRAFIS',			
				'KE' 				=> $selanjutnya	
			);
			$this->db->set('TGL_LOG_ORDER', 'NOW()', FALSE);
			$query = $this->t_log_order_model->insert($data);			

			date_default_timezone_set("Asia/Jakarta");
			
			
			
			$this->start_grafis = $this->t_log_order_model->getStartGrafis($this->input->post('ID_ORDER'));	
			
			//echo $this->start_grafis->TGL_JAM_MENIT_DETIK_ORDER;
			
			$selisih = time() - strtotime($this->start_grafis->TGL_JAM_MENIT_DETIK_ORDER)  ;
			//echo "ini waktu sekarang".time() ;
		//echo "<br>ini waktu db".strtotime($this->start_grafis->TGL_JAM_MENIT_DETIK_ORDER) ;
			$detik = $selisih ;
			$menit = round($selisih / 60 );
			$jam = round($selisih / 3600 );
			$hari = round($selisih / 86400 );
			$minggu = round($selisih / 604800 );
			$bulan = round($selisih / 2419200 );
			$tahun = round($selisih / 29030400 );

			/**if ($detik <= 60) {
				$waktu = $detik.' detik yang lalu';
			} else if ($menit <= 60) {
				$waktu = $menit.' menit yang lalu';
			} else if ($jam <= 24) {
				$waktu = $jam.' jam yang lalu';
			} else if ($hari <= 7) {
				$waktu = $hari.' hari yang lalu';
			} else if ($minggu <= 4) {
				$waktu = $minggu.' minggu yang lalu';
			} else if ($bulan <= 12) {
				$waktu = $bulan.' bulan yang lalu';
			} else {
				$waktu = $tahun.' tahun yang lalu';
			}


			echo waktu_lalu( $this->oldData->TGL_JAM_MENIT_DETIK_ORDER );


			
			//// input barang
			/**foreach($this->input->post('ID_BARANG_GRAFIS') as $ID_BARANG_GRAFIS){**/
			
			/// cari harga Jasa Grafis
			//var_dump( $menit);
			
			/// delete Jasa Grafis Sebelumnya
			$whereDeletJasaGrafis	=	array('id_order' =>	$this->input->post('ID_ORDER'),'keterangan' => 'Jasa Design Grafis');
			$deleteJasaGrafis	=	$this->t_barang_order_model->delete($whereDeletJasaGrafis);
			
			
			$dataHargaBarang = $this->m_harga_grafis_model->getDataHarga( $menit  );				
			// var_dump($dataHargaBarang);
			$maxCountBarang = $this->t_barang_order_model->getPrimaryKeyMax($this->input->post('ID_ORDER'));
			$newId = $maxCountBarang->MAX + 1;	
				
				
			$ket = "Jasa Design dengan Waktu : ".$menit." Menit.";	
			$this->db->query("				
			insert into t_barang_order 
				(
					COUNT_BARANG,
					ID_KARYAWAN,
					ID_ORDER,
					ID_PRODUK,
					KETERANGAN,
					JUMLAH_QTY,
					HARGA_SATUAN,
					TOTAL_HARGA						
				)
				values
				(
					'".$newId."',
					'".$this->session->userdata('id_karyawan')."',
					'".$this->input->post('ID_ORDER')."',
					'1',
					'".$ket."',
					'1',
					'".$dataHargaBarang->HARGA."',						
					'".$dataHargaBarang->HARGA."'						
				)
				
			");
				
			/**}**/
			
			$noWO =   date('dmy').'-'.$this->input->post('NO_ORDER');
			//////  update posisi order
			$dataOrder = array(								
				'POSISI_ORDER' 	=> $selanjutnya	,
				'NO_WO' 		=>	$noWO				
			);
			$where = array('id_order' =>	$this->input->post('ID_ORDER'));
			$query = $this->t_order_model->update($where ,$dataOrder);
			//var_dump($this->db->last_query());
			$status = array('status' => true ,'redirect_link' => base_url()."grafis/proses/".$this->input->post('ID_ORDER') ,'pesan_modal' => '<h3>Work Order berhasil disimpan dengan Nomor Wo :  '.$noWO.'</h3><h4>Waktu pengerjaan Design Grafis adalah '.$menit .' Menit</h4><br>Untuk Proses selanjutnya, silahkan masukkan data barang.');
		}
		
			
		echo(json_encode($status));
	}
	
	
	
	function add_data_finish_design(){
		///// input Log WO
			$data = array(					
				'ID_ORDER' 			=> $this->input->post('id_order_finish_design')	,		
				'ID_KARYAWAN' 		=> $this->session->userdata('id_karyawan')	,			
				'CATATAN_LOG_ORDER' => $this->input->post('keterangan_finish_design')	,		
				'DARI' 				=> 'START-DESIGN',			
				'KE' 				=> 'FINISH-DESIGN'	
			);
			$this->db->set('TGL_LOG_ORDER', 'NOW()', FALSE);
			$query = $this->t_log_order_model->insert($data);
			
		//////  update posisi order
			$dataOrder = array(								
				'POSISI_ORDER' 	=> 	'FINISH-DESIGN'			
			);
			$where = array('id_order' =>	$this->input->post('id_order_finish_design'));
			$query = $this->t_order_model->update($where ,$dataOrder);
			
			$status = array('status' => true );
			
			echo(json_encode($status));
	}
	
	
	function start_grafis(){
		///// input Log WO
			$data = array(					
				'ID_ORDER' 			=> $this->input->post('input_id_order_start_grafis')	,		
				'ID_KARYAWAN' 		=> $this->session->userdata('id_karyawan')	,			
				'CATATAN_LOG_ORDER' => 'Mulai Start Design Grafis'	,		
				'DARI' 				=> 'OP-GRAFIS',			
				'KE' 				=> 'START-DESIGN'	
			);
			$this->db->set('TGL_LOG_ORDER', 'NOW()', FALSE);
			$query = $this->t_log_order_model->insert($data);
			//echo $this->db->last_query();
		//////  update posisi order
			$dataOrder = array(								
				'POSISI_ORDER' 	=> 	'START-DESIGN'			
			);
			$where = array('id_order' =>	$this->input->post('input_id_order_start_grafis'));
			$query = $this->t_order_model->update($where ,$dataOrder);
			//echo $this->db->last_query();
			$status = array('status' => true );
			
			echo(json_encode($status));
	}
	
function cek_jumlah_halaman_pdf(){
		
	$path= "upload/file_pdf/".$this->input->post("path");

	$pdfcontent = file_get_contents("upload/file_pdf/".$this->input->post("path"), NULL, NULL, 0, 300);

	
	preg_match("~Linearized.*?\/N ([0-9]+)~s", $pdfcontent, $pages);
	if(isset($pages[1])){
		$status = array('jumlah_halaman' => $pages[1] );

	}
	else{
		
		$this->load->library('count_page_pdf');

		$path = base_url().'upload/file_pdf/'.$this->input->post('path');
	
		$jumlahHalaman = $this->count_page_pdf->getNumPagesPdf($path);
	
		$status = array('jumlah_halaman' => $jumlahHalaman );
		
		
	}
	
	$files = glob("./upload/file_pdf/*"); //get all file names
	foreach($files as $file){
		if(is_file($file))
		unlink($file); //delete file
	}


	echo(json_encode($status));
}
	
	
	
	
	
	public function cari_kertas_berdasar_produk(){
		$queryKertas		=	$this->db->query("select distinct(id_kertas) as id_kertas ,nama_kertas from v_harga_kertas where id_produk='".$this->input->post('id_produk')."' order by nama_kertas");
		$dataKertas			=	$queryKertas->result();
			echo "<option value=''>Silahkan Pilih</option>";
		
		foreach($dataKertas as $data){
			echo "<option value='".$data->id_kertas."'>".$data->nama_kertas."</option>";
			
		}
		
	}
	
	public function upload() { 	
         $config['upload_path']   = './upload/file_pdf/'; 
         $config['allowed_types'] = 'pdf'; 
		 
         $this->load->library('upload', $config);
		 $this->upload->do_upload('userfile');
		if ( ! $this->upload->do_upload('userfile')) {
            $error = array('status'=> false,'pesan' => $this->upload->display_errors()); 
        }			
         else { 
		// echo "asd";
			 $fileUpload = $this->upload->data();
			
			$final_file_name = $fileUpload['raw_name'].''.$fileUpload['file_ext'];
			rename($fileUpload['full_path'],$fileUpload['file_path'].$final_file_name);
			
			echo $final_file_name;
           
         } 		 
     } 
	 

}


