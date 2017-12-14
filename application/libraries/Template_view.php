<?php
class Template_view extends CI_Controller {
    protected $_ci;
    
    function __construct(){
        $this->_ci = &get_instance();

    }
    
    function load_view($content, $data = NULL){
    
		//echo time();
	
		$jam = $this->_ci->db->query("select  current_time() as jam from dual");
		$dataJam = $jam->row(); 
		//echo "Jam Database : ".$dataJam->jam;
    
		$queryActive = $this->_ci->db->query("
		select 
			m_menu.ID_MENU,
			m_menu.TINGKAT_MENU,
            m_menu.NAMA_MENU,
			m_menu.ID_PARENT as ID_ATASPERTAMA,
			(select menuataskedua.ID_PARENT from m_menu menuataskedua where menuataskedua.ID_MENU=m_menu.ID_PARENT) as ID_ATASKEDUA,
			(select menuatasketiga.ID_PARENT from m_menu menuatasketiga where menuatasketiga.ID_MENU= ID_ATASKEDUA) as ID_ATASKETIGA
		from 
			m_menu,t_hak_akses
		WHERE
			m_menu.aktif_menu='Y' and m_menu.LINK_MENU = '".$this->_ci->uri->segment(1)."' and m_menu.id_menu=t_hak_akses.id_menu and t_hak_akses.id_kategori_user= '".$this->_ci->session->userdata('id_kategori_karyawan')."'
		");
		$dataActive = $queryActive->row();      


		if(!$dataActive){			
			//redirect(base_url());
		}
				
		
		$menuHtml = "";
        $menu1 = $this->_ci->db->query("
        select m_menu.* from m_menu,t_hak_akses where m_menu.ID_PARENT = '0' and m_menu.aktif_menu='Y' and  m_menu.id_menu=t_hak_akses.id_menu and t_hak_akses.id_kategori_user= '".$this->_ci->session->userdata('id_kategori_karyawan')."' order by m_menu.URUTAN_MENU");
        $dataMenu1 = $menu1->result(); 

		
		
        $noMenuSatu = 1;
        foreach($dataMenu1 as $dataMenuSatu){
			
			
			$Parent1 = $this->_ci->db->query("select count(m_menu.ID_MENU) as jumlah from m_menu,t_hak_akses where m_menu.ID_PARENT = '".$dataMenuSatu->ID_MENU."' and m_menu.id_menu=t_hak_akses.id_menu  and m_menu.aktif_menu='Y' and t_hak_akses.id_kategori_user= '".$this->_ci->session->userdata('id_kategori_karyawan')."' order by m_menu.URUTAN_MENU");
			
			
			
			$jumlahParent1 = $Parent1->row();		

		
			if($jumlahParent1->jumlah > 0) {
				$treeview1 = 'treeview'; 
				$iconTurun1 = "<span class='pull-right-container'><i class='fa fa-angle-left 	pull-right'></i></span>";
				$link1 = "#";
				
			}else{ 
				$treeview1 = '';
				$iconTurun1 = "";
				$link1 = base_url().$dataMenuSatu->LINK_MENU;
			}
			
			
			if($dataActive->TINGKAT_MENU=='4' && $dataActive->ID_ATASKETIGA==$dataMenuSatu->ID_MENU){
				$active1="active";
			}else{
				if($dataActive->TINGKAT_MENU=='3' && $dataActive->ID_ATASKEDUA==$dataMenuSatu->ID_MENU){
					$active1="active";
				}else{
					if($dataActive->TINGKAT_MENU=='2' && $dataActive->ID_ATASPERTAMA==$dataMenuSatu->ID_MENU){
						$active1="active";
					}else{
						if($dataActive->TINGKAT_MENU=='1' && $dataActive->ID_MENU==$dataMenuSatu->ID_MENU){
							$active1="active";
						}else{
							$active1="";
						}
					}
				}
			}
				
			$menuHtml .= "
			<li class=' $active1 ".$treeview1."'>
				<a href='".$link1."'>
					<i class='fa fa-".$dataMenuSatu->ICON_MENU."'></i> 
						<span>".$dataMenuSatu->NAMA_MENU."</span>
						".$iconTurun1."
				</a>
			";
			
			if($jumlahParent1->jumlah > 0) {
				
				$menu2 = $this->_ci->db->query("select m_menu.* from m_menu,t_hak_akses where m_menu.ID_PARENT = '".$dataMenuSatu->ID_MENU."' and m_menu.id_menu=t_hak_akses.id_menu and m_menu.aktif_menu='Y' and  t_hak_akses.id_kategori_user= '".$this->_ci->session->userdata('id_kategori_karyawan')."' order by m_menu.URUTAN_MENU");
				
				$dataMenu2 = $menu2->result();        
				$noMenuDua = 1;
				$menuHtml .= '<ul class="treeview-menu">';
				foreach($dataMenu2 as $dataMenuDua){
					
					$Parent2 = $this->_ci->db->query("select count(m_menu.ID_MENU) as jumlah from m_menu,t_hak_akses where m_menu.ID_PARENT = '".$dataMenuDua->ID_MENU."' and m_menu.aktif_menu='Y' and  m_menu.id_menu=t_hak_akses.id_menu and t_hak_akses.id_kategori_user= '".$this->_ci->session->userdata('id_kategori_karyawan')."' order by m_menu.URUTAN_MENU");
					
					$jumlahParent2 = $Parent2->row();			
					
					if($jumlahParent2->jumlah > 0) {
						$treeview2 = 'treeview'; 
						$iconTurun2 = "<span class='pull-right-container'><i class='fa fa-angle-left 	pull-right'></i></span>";
						$link2 = "#";
						$iconPanah1 = "";
						
					}else{ 
						$treeview2 = '';
						$iconTurun2 = "";
						$link2 = base_url().$dataMenuDua->LINK_MENU;
						$iconPanah1 = '<i class="fa fa-angle-right"></i> ';
					}
					
					
					
					
					
					if($dataActive->TINGKAT_MENU=='4' && $dataActive->ID_ATASKEDUA==$dataMenuDua->ID_MENU){
						$active2="active";
					}else{
						if($dataActive->TINGKAT_MENU=='3' && $dataActive->ID_ATASPERTAMA==$dataMenuDua->ID_MENU){
							$active2="active";
						}else{
							if($dataActive->TINGKAT_MENU=='2' && $dataActive->ID_MENU==$dataMenuDua->ID_MENU){
								$active2="active";
							}else{
								$active2="";
							}
						}
					}
						
					$menuHtml .= "
					<li class='$active2 ".$treeview2."'>
						<a href='".$link2."'>
							$iconPanah1
								<span>".$dataMenuDua->NAMA_MENU."</span>
								".$iconTurun2."
						</a>
					";
					
					if($jumlahParent2->jumlah > 0) {
					
						$menu3 = $this->_ci->db->query("select m_menu.* from m_menu,t_hak_akses where m_menu.ID_PARENT = '".$dataMenuDua->ID_MENU."' and m_menu.id_menu=t_hak_akses.id_menu  and  m_menu.aktif_menu='Y' and t_hak_akses.id_kategori_user= '".$this->_ci->session->userdata('id_kategori_karyawan')."' order by m_menu.URUTAN_MENU");
						
						$dataMenu3 = $menu3->result();        
						$noMenuTiga = 1;
						$menuHtml .= '<ul class="treeview-menu">';
						foreach($dataMenu3 as $dataMenuTiga){
	
							$Parent3 = $this->_ci->db->query("select count(ID_MENU) as jumlah from m_menu,t_hak_akses where m_menu.ID_PARENT = '".$dataMenuTiga->ID_MENU."' and m_menu.id_menu=t_hak_akses.id_menu and  m_menu.aktif_menu='Y' and t_hak_akses.id_kategori_user= '".$this->_ci->session->userdata('id_kategori_karyawan')."' order by m_menu.URUTAN_MENU");
							
							$jumlahParent3 = $Parent3->row();			
							
							if($jumlahParent3->jumlah > 0) {
								$treeview3 = 'treeview'; 
								$iconTurun3 = "<span class='pull-right-container'><i class='fa fa-angle-left 	pull-right'></i></span>";
								$link3 = "#";
								$iconPanah2 = '';
								
							}else{ 
								$treeview3 = '';
								$iconTurun3 = "";
								$link3 = base_url().$dataMenuTiga->LINK_MENU;
								$iconPanah2 = '<i class="fa fa-angle-right"></i> ';
							}
							
							
							
							if($dataActive->TINGKAT_MENU=='4' && $dataActive->ID_ATASPERTAMA==$dataMenuTiga->ID_MENU){
								$active3="active";
							}else{
								if($dataActive->TINGKAT_MENU=='3' && $dataActive->ID_MENU==$dataMenuTiga->ID_MENU){
									$active3="active";
								}else{
									$active3="";
								}
							}
					
							$menuHtml .= "
							<li class='$active3 ".$treeview3."'>
								<a href='".$link3."'>
									$iconPanah2
										<span>".$dataMenuTiga->NAMA_MENU."</span>
										".$iconTurun3."
								</a>
							";
							
												
							if($jumlahParent3->jumlah > 0) {
						
								$menu4 = $this->_ci->db->query("select m_menu.* from m_menu,t_hak_akses where m_menu.ID_PARENT = '".$dataMenuTiga->ID_MENU."' and m_menu.id_menu=t_hak_akses.id_menu and t_hak_akses.id_kategori_user= '".$this->_ci->session->userdata('id_kategori_karyawan')."' order by m_menu.URUTAN_MENU");
								$dataMenu4 = $menu4->result();        
								$noMenuEmpat = 1;
								$menuHtml .= '<ul class="treeview-menu">';
								foreach($dataMenu4 as $dataMenuEmpat){
					
									$Parent4 = $this->_ci->db->query("select count(ID_MENU) as jumlah from m_menu,t_hak_akses where m_menu.ID_PARENT = '".$dataMenuTiga->ID_MENU."' and m_menu.id_menu=t_hak_akses.id_menu and t_hak_akses.id_kategori_user= '".$this->_ci->session->userdata('id_kategori_karyawan')."' order by m_menu.URUTAN_MENU");
									$jumlahParent4 = $Parent4->row();			
									
									if($jumlahParent4->jumlah > 0) {
										$treeview4 = 'treeview'; 
										$iconTurun4 = "<span class='pull-right-container'><i class='fa fa-angle-left 	pull-right'></i></span>";
										$link4 = "#";
										$iconPanah3 = '';
										
									}else{ 
										$treeview4 = '';
										$iconTurun4 = "";
										$link4 = base_url().$dataMenuEmpat->LINK_MENU;
										$iconPanah3 = '<i class="fa fa-angle-right"></i> ';
									}
									
									if($dataActive->TINGKAT_MENU=='4' && $dataActive->ID_MENU==$dataMenuEmpat->ID_MENU){
										$active4="active";
									}else{
										$active4="";
									}
									
									$menuHtml .= "
									<li class=' $active4 ".$treeview4."'>
										<a href='".$link4."'>
											$iconPanah3
												<span>".$dataMenuEmpat->NAMA_MENU."</span>
												".$iconTurun4."
										</a>
									";
								}
								$menuHtml .= "</li></ul>";	
							}				
							
						}
						$menuHtml .= "</li></ul>";
					}
				}
					
				$menuHtml .= "</li></ul>";
			}			
			
			$menuHtml .= "</li>";
			$noMenuSatu++;
		}
        
        
        $data['tampil_menu'] = $menuHtml;       
        
        $data['header']     = $this->_ci->load->view('template/header_view', $data, TRUE);
        $data['content']    = $this->_ci->load->view($content, $data, TRUE);
        $data['footer']     = $this->_ci->load->view('template/footer_view', $data, TRUE);
        
        $this->_ci->load->view('template/index_view', $data);
        
    }

    function nama_menu($string){
        $queryMenu = $this->_ci->db->query("
        select 
            m_menu.ID_MENU,
            m_menu.TINGKAT_MENU,
            m_menu.JUDUL_MENU,
            m_menu.NAMA_MENU
        from 
            m_menu
        WHERE
            m_menu.LINK_MENU = '".$this->_ci->uri->segment(1)."'
        ");
        $dataMenu = $queryMenu->row();
      
		switch ($string) {
			case "judul_menu":
				return $dataMenu->JUDUL_MENU;
				break;
			case "nama_menu":
				return $dataMenu->NAMA_MENU;
				break;
		
			default:
				return "Kosong -> Perhatikan Database Menu";
		}
        
    }  
    
    function getAddButton(){
		if($this->_ci->session->userdata('id_kategori_karyawan')){
			$queryButton = $this->_ci->db->query("
			select 
				t_hak_akses.ADD_BUTTON
			from 
				m_menu,t_hak_akses
			WHERE
				m_menu.id_menu=t_hak_akses.id_menu 
				and t_hak_akses.id_kategori_user= '".$this->_ci->session->userdata('id_kategori_karyawan')."'
				and m_menu.link_menu = '".$this->_ci->uri->segment(1)."'
			");
			$dataButton = $queryButton->row();
			if($dataButton->ADD_BUTTON=='Y'){
				echo "<a href='".base_url().$this->_ci->uri->segment(1)."/add'><span class='btn btn-success'><i class='fa fa-plus'></i> Tambah Data</span></a>
				";
			}        
		}
       
    }
    function getEditButton($urlEdit){
		if($this->_ci->session->userdata('id_kategori_karyawan')){
			$queryButton = $this->_ci->db->query("
			select 
				t_hak_akses.EDIT_BUTTON
			from 
				m_menu,t_hak_akses
			WHERE
				m_menu.id_menu=t_hak_akses.id_menu 
				and t_hak_akses.id_kategori_user= '".$this->_ci->session->userdata('id_kategori_karyawan')."'
				and m_menu.link_menu = '".$this->_ci->uri->segment(1)."'
			");
			$dataButton = $queryButton->row();
			if($dataButton->EDIT_BUTTON=='Y'){
				
				echo "<a href='".$urlEdit."'><span class='btn btn-warning btn-xs'><i class='fa fa-edit'></i></span></a>";
			}   
		}     
    }
    function getDeleteButton($msgDelete,$urlDelete){
		if($this->_ci->session->userdata('id_kategori_karyawan')){
			$queryButton = $this->_ci->db->query("
			select 
				t_hak_akses.DELETE_BUTTON
			from 
				m_menu,t_hak_akses
			WHERE
				m_menu.id_menu=t_hak_akses.id_menu 
				and t_hak_akses.id_kategori_user= '".$this->_ci->session->userdata('id_kategori_karyawan')."'
				and m_menu.link_menu = '".$this->_ci->uri->segment(1)."'
			");
			$dataButton = $queryButton->row();
			if($dataButton->DELETE_BUTTON=='Y'){
				
				$msgDelete = '"'.$msgDelete.'"';
				$urlDelete = '"'.$urlDelete.'"';
				
				echo	"<span class='btn btn-danger btn-xs' onclick='tampil_pesan_hapus(".$msgDelete.",".$urlDelete.")'><i class='fa fa-trash'></i></span>";
			}  
		}      
    }

}
