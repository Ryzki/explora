<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pelanggan extends CI_Controller {
		
	public function __construct() {
		parent::__construct();
		
		$this->load->model('pelanggan_model');
	} 

	public function index(){		
		$like 		= null;
		$order_by 	= 'nama_pelanggan'; 
		$urlSearch 	= null;
		
		if($this->input->get('field')){
			$like = array($_GET['field'] => $_GET['keyword']);
			$urlSearch = "?field=".$_GET['field']."&keyword=".$_GET['keyword'];
		}		
		
		$this->load->library('pagination');	
		
		$config['base_url'] 	= base_url().'pelanggan/index'.$urlSearch;
		$this->jumlahData 		= $this->pelanggan_model->getCount("",$like);		
		$config['total_rows'] 	= $this->jumlahData;		
		$config['per_page'] 	= 10;		
		
		$this->pagination->initialize($config);	
		$this->showData = $this->pelanggan_model->showData("",$like,$order_by,$config['per_page'],$this->input->get('per_page'));
		$this->pagination->initialize($config);
		
		$this->template_view->load_view('pelanggan/pelanggan_view');
	}
	public function add(){
		$this->template_view->load_view('pelanggan/pelanggan_add_view');
	}
	public function add_data(){
		$this->form_validation->set_rules('nama_pelanggan', '', 'trim|required');		
		$this->form_validation->set_rules('nomor_telp', '', 'trim|required');		
		
		if ($this->form_validation->run() == FALSE)	{
			$status = array('status' => FALSE, 'pesan' => 'Gagal menyimpan Data, pastikan telah mengisi semua inputan yang diwajibkan untuk diisi.', 'message' => validation_errors());
		}
		else{		

			$maxIDpelanggan = $this->pelanggan_model->getPrimaryKeyMax();
			$newId = $maxIDpelanggan->MAX + 1;			
		
			if($this->input->post('tgl_akhir_member')){
				$data = array(								
					'nama_pelanggan' => $this->input->post('nama_pelanggan')	,			
					'nomor_telp' => $this->input->post('nomor_telp')	,			
					'email' => $this->input->post('email')	,			
					'alamat' => $this->input->post('alamat')	,			
					'kode_pos' => $this->input->post('kode_pos')	,	
					'tgl_akhir_member' => date('Y-m-d',strtotime($this->input->post('tgl_akhir_member'))),				
					'tgl_mulai_member' => date('Y-m-d',strtotime($this->input->post('tgl_mulai_member'))),				
					'kantor' => $this->input->post('kantor')	,			
					'alamat_kantor' => $this->input->post('alamat_kantor')	,			
					'no_telp_kantor' => $this->input->post('no_telp_kantor')				
				);
			}
			else{
				$data = array(								
					'nama_pelanggan' => $this->input->post('nama_pelanggan')	,			
					'nomor_telp' => $this->input->post('nomor_telp')	,			
					'email' => $this->input->post('email')	,			
					'alamat' => $this->input->post('alamat')	,			
					'kode_pos' => $this->input->post('kode_pos')	,				
					'kantor' => $this->input->post('kantor')	,			
					'alamat_kantor' => $this->input->post('alamat_kantor')	,			
					'no_telp_kantor' => $this->input->post('no_telp_kantor')				
				);
			}
				
			$query = $this->pelanggan_model->insert($data);							
			$status = array('status' => true , 'redirect_link' => base_url()."".$this->uri->segment(1));
		}
		
		echo(json_encode($status));
	}
	public function edit($IdPrimaryKey){
		$where = array('id_pelanggan' => $IdPrimaryKey);
		$this->oldData = $this->pelanggan_model->getData($where);		
		$this->template_view->load_view('pelanggan/pelanggan_edit_view');
	}
	public function edit_data(){
		$this->form_validation->set_rules('nama_pelanggan', '', 'trim|required');		
		$this->form_validation->set_rules('nomor_telp', '', 'trim|required');		
		
		if ($this->form_validation->run() == FALSE)	{
			$status = array('status' => FALSE, 'pesan' => 'Gagal menyimpan Data, pastikan telah mengisi semua inputan yang diwajibkan untuk diisi.', 'message' => validation_errors());
		}
		else{		

			$maxIDpelanggan = $this->pelanggan_model->getPrimaryKeyMax();
			$newId = $maxIDpelanggan->MAX + 1;	

			if($this->input->post('tgl_akhir_member')){
				$data = array(								
				'nama_pelanggan' => $this->input->post('nama_pelanggan')	,			
				'nomor_telp' => $this->input->post('nomor_telp')	,			
				'email' => $this->input->post('email')	,			
				'alamat' => $this->input->post('alamat')	,			
				'kode_pos' => $this->input->post('kode_pos')	,	
				'tgl_akhir_member' => date('Y-m-d',strtotime($this->input->post('tgl_akhir_member'))),				
				'tgl_mulai_member' => date('Y-m-d',strtotime($this->input->post('tgl_mulai_member'))),				
				'kantor' => $this->input->post('kantor')	,			
				'alamat_kantor' => $this->input->post('alamat_kantor')	,			
				'no_telp_kantor' => $this->input->post('no_telp_kantor')				
			);
			}
			else{
				$data = array(								
				'nama_pelanggan' => $this->input->post('nama_pelanggan')	,			
				'nomor_telp' => $this->input->post('nomor_telp')	,			
				'email' => $this->input->post('email')	,			
				'alamat' => $this->input->post('alamat')	,			
				'kode_pos' => $this->input->post('kode_pos')	,				
				'kantor' => $this->input->post('kantor')	,			
				'alamat_kantor' => $this->input->post('alamat_kantor')	,			
				'no_telp_kantor' => $this->input->post('no_telp_kantor')				
			);
				
			}
			
			
	
			
			
			$where = array('id_pelanggan' => $this->input->post('id_pelanggan'));
			
			$query = $this->pelanggan_model->update($where,$data);
//var_dump( $this->input->post('tgl_akhir_member'));
		//	echo date('Y-m-d',strtotime($this->input->post('tgl_mulai_member')));			
		//	echo date('Y-m-d',strtotime($this->input->post('tgl_akhir_member')));			
			$status = array('status' => true , 'redirect_link' => base_url()."".$this->uri->segment(1));
		}
		
		echo(json_encode($status));
	}
	public function delete($IdPrimaryKey){
		$where = array('id_pelanggan' => $IdPrimaryKey);
		$delete = $this->pelanggan_model->delete($where);		
		redirect(base_url()."".$this->uri->segment(1));
	}
	public function search_pelanggan(){
		$like = array('nama_pelanggan' => $this->input->get('term'));
		$datapelanggan = $this->pelanggan_model->showData("",$like,"nama_pelanggan");  
		echo '[';		
		$i=1;
		foreach($datapelanggan as $data){			
			
			if($i > 1){echo ",";}
			echo '{ "label":"'.$data->nama_pelanggan.'","id_pelanggan":"'.$data->id_pelanggan.'"} ';
			$i++;
		}
		echo ']';
	}
	
	public function search_pelangan(){
		
		//$where = array('nomor_telp' => $this->input->post('no_hp') );		
		//$dataMember = $this->pelanggan_model->getData($where);	
		
		$cekMember	=	$this->db->query("select * from v_member_aktif where nomor_telp='".$this->input->post('no_hp')."'");
		$dataMember=	$cekMember->row();
		
		if ($dataMember)	{
			$status = array('status' => TRUE,'pelanggan'=> true, 'nama' => $dataMember->nama_pelanggan, 'alamat' => $dataMember->alamat, 'id_pelanggan' => $dataMember->id_pelanggan, 'tgl_mulai_member' => $dataMember->tgl_mulai_member, 'tgl_akhir_member' => $dataMember->tgl_akhir_member);
		}
		else{		
			$cekPelanggan	=	$this->db->query("select * from master_pelanggan where nomor_telp='".$this->input->post('no_hp')."'");
			$dataPelanggan=	$cekPelanggan->row();
			
			if ($dataPelanggan)	{
				$status = array('status' => TRUE, 'nama' => $dataPelanggan->nama_pelanggan, 'alamat' => $dataPelanggan->alamat, 'id_pelanggan' => $dataPelanggan->id_pelanggan, 'tgl_mulai_member' => $dataPelanggan->tgl_mulai_member, 'tgl_akhir_member' => $dataPelanggan->tgl_akhir_member);
			}
			else{		
				$status = array('status' => FALSE);
			}
		}
		
		echo(json_encode($status));
	}
	
		public function pelanggan_search(){
			$querySearch	=	$this->db->query("select * from master_pelanggan where nama_pelanggan like '%".$this->input->get('term')."%' or nomor_telp like '%".$this->input->get('term')."%'");
			$dataSearch = $querySearch->result();
			echo '[';		
			$i=1;
			foreach($dataSearch as $data){			
				
				
				echo '{ "label":"'.$data->nomor_telp.'","nama_pelanggan":"'.$data->nama_pelanggan.'" ,"id_pelanggan":"'.$data->id_pelanggan .'" ,"alamat_pelanggan":"'.$data->alamat.'" ,"nomor_telp":"'.$data->nomor_telp.'"} ';
				$i++;
				echo ',';
			}
			echo '{ "label":"'.$this->input->get('term').'"} ';
			echo ']';
	}
	
}
