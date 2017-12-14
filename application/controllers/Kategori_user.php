<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kategori_user extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model('kategori_user_model');
	} 

	public function index(){
		$like = null;
		$order_by = 'nama_kategori_user'; 
		$urlSearch = null;
		
		if($this->input->get('field')){
			$like = array($_GET['field'] => $_GET['keyword']);
			$urlSearch = "?field=".$_GET['field']."&keyword=".$_GET['keyword'];
		}		
			
		$config['base_url'] 	= base_url().'karyawan/index'.$urlSearch;
		$this->jumlahData = $this->kategori_user_model->getCount("",$like);		
		$config['total_rows'] 	= $this->jumlahData;		
		$config['per_page'] 	= 10;			

		$this->showData = $this->kategori_user_model->showData("",$like,$order_by,$config['per_page'],$this->input->get('per_page'));
		$this->pagination->initialize($config);
		
		$this->template_view->load_view('kategori_user/kategori_user_view');
	}
	public function add(){
		$this->template_view->load_view('kategori_user/kategori_user_add_view');
	}
	public function add_data(){
		$this->form_validation->set_rules('NAMA_KATEGORI_USER', '', 'trim|required');		
		
		if ($this->form_validation->run() == FALSE)	{
			$status = array('status' => FALSE, 'pesan' => 'Gagal menyimpan Data, pastikan telah mengisi semua inputan.');
		}
		else{					
			$maxId = $this->kategori_user_model->getPrimaryKeyMax();
			$new_id_kategori_user = $maxId->MAX + 1;
						
			$data = array(			
				'ID_KATEGORI_USER' => $new_id_kategori_user,				
				'NAMA_KATEGORI_USER' => $this->input->post('NAMA_KATEGORI_USER'),				
				'KETERANGAN' => $this->input->post('KETERANGAN')				
			);
			$query = $this->kategori_user_model->insert($data);							
			$status = array('status' => true , 'redirect_link' => base_url()."".$this->uri->segment(1)."/edit/".$new_id_kategori_user);
		}
		
		echo(json_encode($status));
	}
	public function edit($IdPrimaryKey){
		$where = array('id_kategori_user' => $IdPrimaryKey);
		$orderBy = 'urutan_menu';
		$this->oldData = $this->kategori_user_model->getData($where);		
		
		$this->load->model('menu_model');
		$this->load->model('t_hak_akses_model');
		$this->checkboxMenu = "<div class='col-sm-9 col-sm-offset-3'><table class='table table-bordered' width='100%'><thead><tr><td align='center'><div class='checkbox'><label><input type='checkbox' id='checkAllDelete' onclick='checkAllDeleteButton()'> &nbsp;Nama Menu</label></div> </td><td>Tambah</td><td>Ubah</td><td>Hapus</td></tr></thead><tbody>";
		$whereMenuSatu = array('id_parent' => '0');
		foreach( $this->menu_model->showData($whereMenuSatu,'',$orderBy) as $menuSatu){
			$whereDataSatu = array('id_kategori_user' => $IdPrimaryKey, 'id_menu' => $menuSatu->ID_MENU);
			$dataSatu = $this->t_hak_akses_model->getData($whereDataSatu);
			
			if($dataSatu){
				$aktifMenuSatu = "checked";
				if($dataSatu->ADD_BUTTON == 'Y'){
					$addAktifSatu = "checked";
				}
				else{
					$addAktifSatu = "";
				}
				if($dataSatu->EDIT_BUTTON == 'Y'){
					$editAktifSatu = "checked";
				}
				else{
					$editAktifSatu = "";
				}
				if($dataSatu->DELETE_BUTTON == 'Y'){
					$deleteAktifSatu = "checked";
				}
				else{
					$deleteAktifSatu = "";
				}
			}
			else{
				$aktifMenuSatu = "";
				$addAktifSatu = "";
				$editAktifSatu = "";
				$deleteAktifSatu = "";
			}
			
			
			$this->checkboxMenu.= "<tr><td><div class='checkbox'><label><input ".$aktifMenuSatu." type='checkbox' value='".$menuSatu->ID_MENU."' name='id_menu[]'>".$menuSatu->NAMA_MENU."</label></div></td>";
			if($menuSatu->LINK_MENU!=""){
				if($menuSatu->ADD_BUTTON == "Y"){
					$this->checkboxMenu.= "<td align='center'><input ".$addAktifSatu." type='checkbox' name='add_".$menuSatu->ID_MENU."' value='Y'></td>";
				}
				else{
					$this->checkboxMenu.= "<td></td>";
				}
				if($menuSatu->EDIT_BUTTON == "Y"){
					$this->checkboxMenu.= "<td align='center'><input ".$editAktifSatu." type='checkbox' name='edit_".$menuSatu->ID_MENU."' value='Y'></td>";
				}
				else{
					$this->checkboxMenu.= "<td></td>";
				}
				if($menuSatu->DELETE_BUTTON == "Y"){
					$this->checkboxMenu.= "<td align='center'><input ".$deleteAktifSatu." type='checkbox' name='delete_".$menuSatu->ID_MENU."' value='Y'></td>";
				}
				else{
					$this->checkboxMenu.= "<td></td>";
				}
				
			}
			else{
				$this->checkboxMenu.="<td colspan='3'></td>";
			}
			
			$this->checkboxMenu.= "</tr>";
			
			////////////////////// ---> Menu Dua <---------- ////////////////
			$whereMenuDua = array('id_parent' => $menuSatu->ID_MENU , 'aktif_menu' => 'Y');
			foreach( $this->menu_model->showData($whereMenuDua,'',$orderBy) as $menuDua){
				$whereDataDua = array('id_kategori_user' => $IdPrimaryKey, 'id_menu' => $menuDua->ID_MENU);
				$dataDua = $this->t_hak_akses_model->getData($whereDataDua);
				
				if($dataDua){
					$aktifMenuDua = "checked";
					if($dataDua->ADD_BUTTON == 'Y'){
						$addAktifDua = "checked";
					}
					else{
						$addAktifDua = "";
					}
					if($dataDua->EDIT_BUTTON == 'Y'){
						$editAktifDua = "checked";
					}
					else{
						$editAktifDua = "";
					}
					if($dataDua->DELETE_BUTTON == 'Y'){
						$deleteAktifDua = "checked";
					}
					else{
						$deleteAktifDua = "";
					}
				}
				else{
					$aktifMenuDua = "";
					$addAktifDua = "";
					$editAktifDua = "";
					$deleteAktifDua = "";
				}
				
				$this->checkboxMenu.= "<tr><td><div class='col-sm-6 col-sm-offset-1'><div class='checkbox'><label><input type='checkbox' ".$aktifMenuDua." value='".$menuDua->ID_MENU."' name='id_menu[]'>".$menuDua->NAMA_MENU."</label></div></div></td>";
				if($menuDua->LINK_MENU!=""){
					if($menuDua->ADD_BUTTON == "Y"){
						$this->checkboxMenu.= "<td align='center'><input ".$addAktifDua." type='checkbox' name='add_".$menuDua->ID_MENU."' value='Y'></td>";
					}
					else{
						$this->checkboxMenu.= "<td></td>";
					}
					if($menuDua->EDIT_BUTTON == "Y"){
						$this->checkboxMenu.= "<td align='center'><input ".$editAktifDua." type='checkbox' name='edit_".$menuDua->ID_MENU."' value='Y'></td>";
					}
					else{
						$this->checkboxMenu.= "<td></td>";
					}
					if($menuDua->DELETE_BUTTON == "Y"){
						$this->checkboxMenu.= "<td align='center'><input type='checkbox' ".$deleteAktifDua." name='delete_".$menuDua->ID_MENU."' value='Y'></td>";
					}
					else{
						$this->checkboxMenu.= "<td></td>";
					}
					
				}
				else{
					$this->checkboxMenu.="<td colspan='3'></td>";
				}
				
				$this->checkboxMenu.= "</tr>";
				
				//////////////////--> Menu Tiga <--- ///////////////////
				$whereMenuTiga = array('id_parent' => $menuDua->ID_MENU);
				foreach( $this->menu_model->showData($whereMenuTiga) as $menuTiga){
					
					$whereDataTiga = array('id_kategori_user' => $IdPrimaryKey, 'id_menu' => $menuTiga->ID_MENU);
					$dataTiga = $this->t_hak_akses_model->getData($whereDataTiga);
					
					
					
					if($dataTiga){
						$aktifMenuTiga = "checked";
						if($dataTiga->ADD_BUTTON == 'Y'){
							$addAktifTiga = "checked";
						}
						else{
							$addAktifTiga = "";
						}
						if($dataTiga->EDIT_BUTTON == 'Y'){
							$editAktifTiga = "checked";
						}
						else{
							$editAktifTiga = "";
						}
						if($dataTiga->DELETE_BUTTON == 'Y'){
							$deleteAktifTiga = "checked";
						}
						else{
							$deleteAktifTiga = "";
						}
					}
					else{
						$aktifMenuTiga = "";
						$addAktifTiga = "";
						$editAktifTiga = "";
						$deleteAktifTiga = "";
					}
					
					$this->checkboxMenu.= "<tr><td><div class='col-sm-6 col-sm-offset-2'><div class='checkbox'><label><input type='checkbox' ".$aktifMenuTiga." value='".$menuTiga->ID_MENU."' name='id_menu[]'>".$menuTiga->NAMA_MENU."</label></div></div></td>";
					if($menuTiga->LINK_MENU!=""){
						if($menuTiga->ADD_BUTTON == "Y"){
							$this->checkboxMenu.= "<td align='center'><input type='checkbox' name='add_".$menuTiga->ID_MENU."' ".$addAktifTiga." value='Y'></td>";
						}
						else{
							$this->checkboxMenu.= "<td></td>";
						}
						if($menuTiga->EDIT_BUTTON == "Y"){
							$this->checkboxMenu.= "<td align='center'><input type='checkbox' name='edit_".$menuTiga->ID_MENU."' ".$editAktifTiga." value='Y'></td>";
						}
						else{
							$this->checkboxMenu.= "<td></td>";
						}
						if($menuTiga->DELETE_BUTTON == "Y"){
							$this->checkboxMenu.= "<td align='center'><input type='checkbox' name='delete_".$menuTiga->ID_MENU."' ".$deleteAktifTiga." value='Y'></td>";
						}
						else{
							$this->checkboxMenu.= "<td></td>";
						}
						
					}
					else{
						$this->checkboxMenu.="<td colspan='3'></td>";
					}
					
					$this->checkboxMenu.= "</tr>";
					
					//////////////////--> Menu Tiga <--- ///////////////////
					$whereMenuEmpat = array('id_parent' => $menuTiga->ID_MENU);
					foreach( $this->menu_model->showData($whereMenuEmpat) as $menuEmpat){
						$whereDataEmpat = array('id_kategori_user' => $IdPrimaryKey, 'id_menu' => $menuEmpat->ID_MENU);
						$dataEmpat = $this->t_hak_akses_model->getData($whereDataEmpat);
						
						if($dataEmpat){
							$aktifMenuEmpat = "checked";
							if($dataEmpat->ADD_BUTTON == 'Y'){
								$addAktifEmpat = "checked";
							}
							else{
								$addAktifEmpat = "";
							}
							if($dataEmpat->EDIT_BUTTON == 'Y'){
								$editAktifEmpat = "checked";
							}
							else{
								$editAktifEmpat = "";
							}
							if($dataEmpat->DELETE_BUTTON == 'Y'){
								$deleteAktifEmpat = "checked";
							}
							else{
								$deleteAktifEmpat = "";
							}
						}
						else{
							$aktifMenuEmpat = "";
							$addAktifEmpat = "";
							$editAktifEmpat = "";
							$deleteAktifEmpat = "";
						}
						
						$this->checkboxMenu.= "<tr><td><div class='col-sm-6 col-sm-offset-3'><div class='checkbox'><label><input type='checkbox' ".$aktifMenuEmpat." value='".$menuEmpat->ID_MENU."' name='id_menu[]'>".$menuEmpat->NAMA_MENU."</label></div></div></td>";
						if($menuEmpat->LINK_MENU!=""){
							if($menuEmpat->ADD_BUTTON == "Y"){
								$this->checkboxMenu.= "<td align='center'><input type='checkbox' name='add_".$menuEmpat->ID_MENU."' ".$addAktifEmpat." value='Y'></td>";
							}
							else{
								$this->checkboxMenu.= "<td></td>";
							}
							if($menuEmpat->EDIT_BUTTON == "Y"){
								$this->checkboxMenu.= "<td align='center'><input type='checkbox' name='edit_".$menuEmpat->ID_MENU."'  ".$editAktifEmpat." value='Y'></td>";
							}
							else{
								$this->checkboxMenu.= "<td></td>";
							}
							if($menuEmpat->DELETE_BUTTON == "Y"){
								$this->checkboxMenu.= "<td align='center'><input type='checkbox' name='delete_".$menuEmpat->ID_MENU."' ".$deleteAktifEmpat." value='Y'></td>";
							}
							else{
								$this->checkboxMenu.= "<td></td>";
							}
							
						}
						else{
							$this->checkboxMenu.="<td colspan='3'></td>";
						}
						
						$this->checkboxMenu.= "</tr>";
					}
				}
			}
		}
		$this->checkboxMenu .= "</tbody></table></div>";
		
		$this->template_view->load_view('kategori_user/kategori_user_edit_view');
	}
	public function edit_data(){
		$this->form_validation->set_rules('ID_KATEGORI_USER', '', 'trim|required');	
		$this->form_validation->set_rules('NAMA_KATEGORI_USER', '', 'trim|required');	
		//echo $this->input->post('ID_KATEGORI_USER');
		if ($this->form_validation->run() == FALSE)	{
			$status = array('status' => FALSE, 'pesan' => 'Gagal menyimpan Data, pastikan telah mengisi semua inputan.');
		}
		else{								
			$data = array(			
				'NAMA_KATEGORI_USER' => $this->input->post('NAMA_KATEGORI_USER'),				
				'KETERANGAN' => $this->input->post('KETERANGAN')				
			);
			$query = $this->kategori_user_model->update($this->input->post('ID_KATEGORI_USER'),$data);					
			$this->db->query("delete from t_hak_akses where ID_KATEGORI_USER='".$this->input->post('ID_KATEGORI_USER')."'");
			foreach($this->input->post('id_menu') as $id_menu){
				$insert = "
				insert into 
					t_hak_akses 
					( 	ID_KATEGORI_USER,ID_MENU,ADD_BUTTON,EDIT_BUTTON,DELETE_BUTTON  )
					values
					('".$this->input->post('ID_KATEGORI_USER')."','".$id_menu."','".$this->input->post('add_'.$id_menu)."','".$this->input->post('edit_'.$id_menu)."','".$this->input->post('delete_'.$id_menu)."')
				";
				$this->db->query($insert);
			}
								
			$status = array('status' => true , 'redirect_link' => base_url()."".$this->uri->segment(1));
		}
		
		echo(json_encode($status));
	}
	public function delete($IdPrimaryKey){
		$where = array('id_kategori_user' => $IdPrimaryKey);
		$this->oldData = $this->kategori_user_model->delete($where);
		
		redirect(base_url()."".$this->uri->segment(1));
	}

}
