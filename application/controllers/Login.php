<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	
	

	public function __construct() {
		parent::__construct();
		
		$this->load->model('karyawan_model');
		$this->load->model('kategori_user_model');
		
	} 

	public function index(){
		
		$this->load->view('template/login_view');
	}
	
	public function login_data(){
		$this->form_validation->set_rules('USERNAME_LOGIN', '', 'trim|required');		
		$this->form_validation->set_rules('PASSWORD_LOGIN', '', 'trim|required');
		
		if ($this->form_validation->run() == FALSE)	{
			$status = array('status' => FALSE, 'pesan' => 'Gagal Login, pastikan telah mengisi semua inputan.');
		}
		else{								
			$data = array(			
				'USERNAME' => $this->input->post('USERNAME'),				
				'ID_KATEGORI_USER' => $this->input->post('ID_KATEGORI_USER'),				
				'PASSWORD' => $this->input->post('PASSWORD')				
			);
			
			$dataUser = $this->karyawan_model->getData("username = '".$this->input->post('USERNAME_LOGIN') ."' and password='".$this->input->post('PASSWORD_LOGIN')."'");
							
			if($dataUser){
				$sess_array = array(
					'nama_karyawan' => $dataUser->NAMA_KARYAWAN, 'id_karyawan' => $dataUser->ID_KARYAWAN, 'id_kategori_karyawan' => $dataUser->ID_KATEGORI_USER
				);
				$this->session->set_userdata($sess_array);	
				if($dataUser->ID_KATEGORI_USER=='2'){
				    $awal= "order";
				}
				elseif($dataUser->ID_KATEGORI_USER=='5'){
				     $awal= "kasir";
				}
				elseif($dataUser->ID_KATEGORI_USER=='3'){
				     $awal= "grafis";
				}
				elseif($dataUser->ID_KATEGORI_USER=='4'){
				     $awal= "printing";
				}
				else{
				    $awal="user";
				}
				
				$status = array('status' => true,'redirect_link' => base_url()."dashboard");
			}
			else{
				$status = array('status' => false,'pesan' => 'Login gagal, pastikan Username dan Password anda benar.');
			}		
		}
		
		echo(json_encode($status));
	}
	
	
}
