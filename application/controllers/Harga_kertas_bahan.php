<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Harga_kertas_bahan extends CI_Controller {
		
	public function __construct() {
		parent::__construct();
		
		$this->load->model('t_harga_kertas_model');
		$this->load->model('produk_model');
		$this->load->model('kertas_bahan_model');
		$this->load->model('ukuran_kertas_model');
	} 
	public function db(){
		$cek_1 		= 	$this->db->query("
		select 
			a.nama_produk,
			b.id_produk,
			c.nama_kertas,
			c.id_kertas,
			d.ukuran_kertas,
			d.id_ukuran_kertas,
			a.range_mulai_dari_sama_dengan,
			a.range_sampai_dari_sama_dengan,
			a.harga_satuan_1_sisi ,
			a.harga_satuan_2_sisi 
		from 
			daftar_harga a,
			m_produk b,
			m_kertas c,
			m_ukuran_kertas d
		where
			a.nama_produk=b.nama_produk
			and c.nama_kertas=a.jenis_kertas_bahan
			and a.ukuran_kertas_bahan = d.ukuran_kertas
		
		
		
		");	
		$i=1;
		$data_cek_1	=	$cek_1->result();
		/** 
		foreach($data_cek_1 as $data){
			
			$max 		= 	$this->db->query("select max(ID_T_HARGA_BARANG) as max from t_harga_kertas");	
			$data_max	=	$max->row();
			$new_id		=	$data_max->max + 1;
			
			$this->db->query("
			insert into
			t_harga_kertas
			(
			ID_T_HARGA_BARANG,
			 	ID_PRODUK ,
				 ID_KERTAS ,
				 ID_UKURAN_KERTAS ,
				 minimal,
				 maximal,
				  HARGA_SATU_SISI ,
				   HARGA_dua_SISI 
			)
			values
			(
			'".$new_id."',
			'".$data->id_produk."',
			'".$data->id_kertas."',
			'".$data->id_ukuran_kertas."',
			'".$data->range_mulai_dari_sama_dengan."',
			'".$data->range_sampai_dari_sama_dengan."',
			'".$data->harga_satuan_1_sisi."',
			'".$data->harga_satuan_2_sisi."'
			)
			
			");
			
			echo $this->db->last_query(). "-----" .$i;
			$i++;
		}**/
	}
	public function index(){		
	
		//$this->load->library("count_page_pdf");
		//echo $this->count_page_pdf->getNumPagesPdf('PANDUAN-BELAJAR-MS-EXCEL.pdf');
	
	
		$like 		= null;
		$order_by 	= 'nama_produk,nama_kertas,minimal'; 
		$urlSearch 	= null;
		
		if($this->input->get('field')){
			$like = array($_GET['field'] => $_GET['keyword']);
			$urlSearch = "?field=".$_GET['field']."&keyword=".$_GET['keyword'];
		}		
		
		$this->load->library('pagination');	
		
		$config['base_url'] 	= base_url().'harga_kertas/index'.$urlSearch;
		$this->jumlahData 		= $this->t_harga_kertas_model->getCount("",$like);		
		$config['total_rows'] 	= $this->jumlahData;		
		$config['per_page'] 	= 200;		
		
		$this->pagination->initialize($config);	
		$this->showData = $this->t_harga_kertas_model->showData("",$like,$order_by,$config['per_page'],$this->input->get('per_page'));
		$this->pagination->initialize($config);
		
		$this->template_view->load_view('harga_kertas/harga_kertas_view');
	}
	public function add(){
		
		$this->dataKertas 		= $this->kertas_bahan_model->showData('','','nama_kertas');
		$this->dataProduk 		= $this->produk_model->showData('','','nama_produk');
		$this->dataUkuranKertas = $this->ukuran_kertas_model->showData('','','ukuran_kertas');
		
		$this->template_view->load_view('harga_kertas/harga_kertas_add_view');
	}
	public function add_data(){
		
		$this->form_validation->set_rules('id_kertas', '', 'trim|required');		
		$this->form_validation->set_rules('id_produk', '', 'trim|required');		
		$this->form_validation->set_rules('id_ukuran_kertas', '', 'trim|required');		
		$this->form_validation->set_rules('minimal', '', 'trim|required');		
		$this->form_validation->set_rules('maximal', '', 'trim|required');		
		$this->form_validation->set_rules('harga_satu_sisi', '', 'trim|required');		
		$this->form_validation->set_rules('harga_dua_sisi', '', 'trim|required');	
		
		$this->form_validation->set_rules('harga_satu_sisi_member', '', 'trim|required');		
		$this->form_validation->set_rules('harga_dua_sisi_member', '', 'trim|required');		
		
		if ($this->form_validation->run() == FALSE)	{
			$status = array('status' => FALSE, 'pesan' => 'Gagal menyimpan Data, pastikan telah mengisi semua inputan yang diwajibkan untuk diisi.', 'message' => validation_errors());
		}
		else{		

			$maxIDTHargaBarang = $this->t_harga_kertas_model->getPrimaryKeyMax();
			$newId = $maxIDTHargaBarang->MAX + 1;			
			
			$minimal			=	str_replace(".","",$this->input->post('minimal'));
			$maximal			=	str_replace(".","",$this->input->post('maximal'));
			$harga_satu_sisi	=	str_replace(".","",$this->input->post('harga_satu_sisi'));
			$harga_dua_sisi		=	str_replace(".","",$this->input->post('harga_dua_sisi'));
			
			$harga_satu_sisi_member	=	str_replace(".","",$this->input->post('harga_satu_sisi_member'));
			$harga_dua_sisi_member		=	str_replace(".","",$this->input->post('harga_dua_sisi_member'));
			
			
			$data = array(					
				'id_t_harga_barang'	=> $newId	,							
				'id_produk' 		=> $this->input->post('id_produk')	,							
				'id_ukuran_kertas'	=> $this->input->post('id_ukuran_kertas')	,							
				'id_kertas' 		=> $this->input->post('id_kertas')	,							
				'minimal' 			=> $minimal	,							
				'maximal' 			=> $maximal	,							
				'harga_satu_sisi' 	=> $harga_satu_sisi	,							
				'harga_dua_sisi'	=> $harga_dua_sisi	,
				'harga_satu_sisi_member' 	=> $harga_satu_sisi_member	,							
				'harga_dua_sisi_member'	=> $harga_dua_sisi_member							
			);
			$query = $this->t_harga_kertas_model->insert($data);							
			$status = array('status' => true , 'redirect_link' => base_url()."".$this->uri->segment(1));
		}
		
		echo(json_encode($status));
	}
	
	
	public function edit($IdPrimaryKey){
		$where = array('id_t_harga_barang' => $IdPrimaryKey);
		$this->oldData = $this->t_harga_kertas_model->getData($where);	
		
		$this->dataKertas 		= $this->kertas_bahan_model->showData('','','nama_kertas');
		$this->dataProduk 		= $this->produk_model->showData('','','nama_produk');
		$this->dataUkuranKertas = $this->ukuran_kertas_model->showData('','','ukuran_kertas');

		$this->template_view->load_view('harga_kertas/harga_kertas_edit_view');
	}
	public function edit_data(){	
		
		$this->form_validation->set_rules('id_kertas', '', 'trim|required');		
		$this->form_validation->set_rules('id_produk', '', 'trim|required');		
		$this->form_validation->set_rules('id_ukuran_kertas', '', 'trim|required');		
		$this->form_validation->set_rules('minimal', '', 'trim|required');		
		$this->form_validation->set_rules('maximal', '', 'trim|required');		
		$this->form_validation->set_rules('harga_satu_sisi', '', 'trim|required');		
		$this->form_validation->set_rules('harga_dua_sisi', '', 'trim|required');	
		
		$this->form_validation->set_rules('harga_satu_sisi_member', '', 'trim|required');		
		$this->form_validation->set_rules('harga_dua_sisi_member', '', 'trim|required');		
		
		if ($this->form_validation->run() == FALSE)	{
			$status = array('status' => FALSE, 'pesan' => 'Gagal menyimpan Data, pastikan telah mengisi semua inputan yang diwajibkan untuk diisi.', 'message' => validation_errors());
		}
		else{		

			$minimal			=	str_replace(".","",$this->input->post('minimal'));
			$maximal			=	str_replace(".","",$this->input->post('maximal'));
			$harga_satu_sisi	=	str_replace(".","",$this->input->post('harga_satu_sisi'));
			$harga_dua_sisi		=	str_replace(".","",$this->input->post('harga_dua_sisi'));
			
			$harga_satu_sisi_member	=	str_replace(".","",$this->input->post('harga_satu_sisi_member'));
			$harga_dua_sisi_member		=	str_replace(".","",$this->input->post('harga_dua_sisi_member'));
		
			$data = array(									
				'id_produk' 		=> $this->input->post('id_produk')	,							
				'id_ukuran_kertas'	=> $this->input->post('id_ukuran_kertas')	,							
				'id_kertas' 		=> $this->input->post('id_kertas')	,							
				'minimal' 			=> $minimal	,							
				'maximal' 			=> $maximal	,							
				'harga_satu_sisi' 	=> $harga_satu_sisi	,							
				'harga_dua_sisi'	=> $harga_dua_sisi	,
				'harga_satu_sisi_member' 	=> $harga_satu_sisi_member	,							
				'harga_dua_sisi_member'	=> $harga_dua_sisi_member				
			);
			
			$where = array('id_t_harga_barang' => $this->input->post('id_t_harga_barang'));
			$query = $this->t_harga_kertas_model->update($where,$data);

			
				
			$status = array('status' => true , 'redirect_link' => base_url()."".$this->uri->segment(1));
		}
		
		echo(json_encode($status));
	}
	public function delete($IdPrimaryKey){
		$where = array('id_t_harga_barang' => $IdPrimaryKey);
		$delete = $this->t_harga_kertas_model->delete($where);		
		redirect(base_url()."".$this->uri->segment(1));
	}

	
}
