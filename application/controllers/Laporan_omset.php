<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laporan_omset extends CI_Controller {
		
	public function __construct() {
		parent::__construct();
		
		$this->load->model('t_order_model');
		$this->load->model('t_barang_order_model');
		$this->load->model('t_log_order_model');
		$this->load->model('t_bayar_order_model');
	} 
	
	function format_rupiah($angka){
		$rupiah=number_format($angka,0,',','.');
		return "Rp ".$rupiah;
	}

	public function index(){		
		$this->template_view->load_view('laporan/laporan_omset_view');
	}
	
	
	public function create_file(){		
		error_reporting(0);
		$this->load->library('text_barang');
		
		if($this->input->post('mulai')){
			
			
			$queryProfil = $this->db->query("select * from m_profil ");		
			$this->dataProfil  = $queryProfil->row();	


			//Load email library

			$this->load->library('html2pdf');

			//Set folder to save PDF to
			$this->html2pdf->folder('./upload/attachment/');

			//Set the filename to save/download as
			$namaToko = str_replace(" ","_",$this->dataProfil->NAMA_TOKO);
			$nama_file = 'Laporan_omset_'.$namaToko.'_'.time().'.pdf';

			$this->html2pdf->filename($nama_file);
			$this->html2pdf->paper('a4', 'portrait');

			$data = array(
				'title' => 'PDF Created',
				'message' => 'Hello World!'
			);
		
			$datetime1 = new DateTime( date('Y-m-d', strtotime( $this->input->post('mulai'))));
			$datetime2 = new DateTime( date('Y-m-d', strtotime( $this->input->post('akhir'))));
			$difference = $datetime1->diff($datetime2);
			$jumlahHari = $difference->days;
		
				$queryLaporan 	= $this->db->query("select * from v_order where tgl_order_indo = '".$this->input->post('date')."' order by tgl_order , id_order");
				$this->showData = $queryLaporan->result();
				
				$this->showLaporan = "";
				
				$this->showLaporan .= "<center><h3>Laporan Omset Tgl : ".$this->input->post('mulai')." s/d ".$this->input->post('akhir')."</h3></center><hr>";
				
				//////////////////////////////////////////////////////////////
				/// arus kas 
				
				$querydataArusKasKlik	=	$this->db->query("
				select sum(Jml_KLIK) as JUM from v_barang_order_complete where   
				tgl_order BETWEEN '" . date('Y-m-d', strtotime( $this->input->post('mulai'))) . "'
				AND '" . date('Y-m-d', strtotime($this->input->post('akhir'))) . "' 
				");	
				$this->dataArusKasKlik = $querydataArusKasKlik->row();
				
				$querydataArusKasUang	=	$this->db->query("
				select sum(JUMLAH_KAS) as JUM from v_bayar where   
				tgl_bayar BETWEEN '" . date('Y-m-d', strtotime( $this->input->post('mulai'))) . "'
				AND '" . date('Y-m-d', strtotime($this->input->post('akhir'))) . "' 
				");	
				$this->dataArusKasUang = $querydataArusKasUang->row();
				
				$this->dataArusKasRata = $this->dataArusKasUang->JUM / $this->dataArusKasKlik->JUM;
				$this->showLaporan .= "<table width='100%'><tr><td>TOTAL ARUS KAS = <b>".$this->format_rupiah($this->dataArusKasUang->JUM)."</b></td></tr></table><br><hr>";
				
				//////////////////////////////////////////////////////////////
				$queryJumlahWO	=	$this->db->query("
				select count(*) as JUM from t_order where   
				tgl_order BETWEEN '" . date('Y-m-d', strtotime( $this->input->post('mulai'))) . "'
				AND '" . date('Y-m-d', strtotime($this->input->post('akhir'))) . "' 
				");	
				$this->dataJumlahWO = $queryJumlahWO->row();				
				
				$RataWO = round($this->dataArusKasUang->JUM / $jumlahHari);
				
				$this->showLaporan .= "<table width='100%'><tr><td>Jumlah WO = <b>".$this->dataJumlahWO->JUM."</b></td></tr><tr><td>Rata-Rata WO = <b>".$this->format_rupiah($this->dataArusKasUang->JUM)."</b> / ".$jumlahHari." Hari = <b>".$this->format_rupiah($RataWO)." </b>Per Hari.</td></tr></table><br><hr>";
				
				//////////////////////////////////////////////////////////////
				$queryJumlahWOBelumLunas	=	$this->db->query("
				select count(*) as JUM from t_order where   
				tgl_order BETWEEN '" . date('Y-m-d', strtotime( $this->input->post('mulai'))) . "'
				AND '" . date('Y-m-d', strtotime($this->input->post('akhir'))) . "' and STATUS_BAYAR='BL'
				");	
				$this->dataJumlahWOBelumLunas = $queryJumlahWOBelumLunas->row();				
				
				$queryJumlahUangWOBelumLunas	=	$this->db->query("
				select SUM(TOTAL_BAYAR) as JUM from t_order where   
				tgl_order BETWEEN '" . date('Y-m-d', strtotime( $this->input->post('mulai'))) . "'
				AND '" . date('Y-m-d', strtotime($this->input->post('akhir'))) . "' and STATUS_BAYAR='BL'
				");	
				$this->dataJumlahUangWOBelumLunas = $queryJumlahUangWOBelumLunas->row();	
				
				$this->showLaporan .= "<table width='100%'><tr><td>Jumlah WO Belum Lunas = <b>".$this->dataJumlahWOBelumLunas->JUM."</b></td></tr><tr><td>Jumlah Uang Belum Lunas = <b>".$this->format_rupiah($this->dataJumlahUangWOBelumLunas->JUM)."</b></td></tr></table><br><hr>";
			
				//////////////////////////////////////////////////////////////
				$queryJumlahKlikDigitalPrint	=	$this->db->query("
				select sum(JML_KLIK) as JUM from v_barang_order_complete where   
				tgl_order BETWEEN '" . date('Y-m-d', strtotime( $this->input->post('mulai'))) . "'
				AND '" . date('Y-m-d', strtotime($this->input->post('akhir'))) . "' and kategori_produk='1'
				");	
				$this->dataJumlahKlikDigitalPrint = $queryJumlahKlikDigitalPrint->row();				
				
				$queryJumlahUangKlikDigitalPrint	=	$this->db->query("
				select sum(TOTAL_HARGA) as JUM from v_barang_order_complete where   
				tgl_order BETWEEN '" . date('Y-m-d', strtotime( $this->input->post('mulai'))) . "'
				AND '" . date('Y-m-d', strtotime($this->input->post('akhir'))) . "' and kategori_produk='1'
				");	
				$this->dataJumlahUangKlikDigitalPrint = $queryJumlahUangKlikDigitalPrint->row();	
				
				$RataUangDigitalPrint = round($this->dataJumlahUangKlikDigitalPrint->JUM / $this->dataJumlahKlikDigitalPrint->JUM);
				
				$this->showLaporan .= "<table width='100%'><tr><td>Jumlah Klik Produk Digital Print = <b>".$this->dataJumlahKlikDigitalPrint->JUM."</b> Klik</td></tr><tr><td>Jumlah Omset Produk Digital Print = <b>".$this->format_rupiah($this->dataJumlahUangKlikDigitalPrint->JUM)."</b></td></tr><tr><td>Rata-Rata Omset Produk Digital Print = <b>".$this->format_rupiah($RataUangDigitalPrint)."</b></th></tr></table><br><hr>";
				
				//////////////////////////////////////////////////////////////
				$queryJumlahKlikDigitalPrintEmail	=	$this->db->query("
				select sum(JML_KLIK) as JUM from v_barang_order_complete where   
				tgl_order BETWEEN '" . date('Y-m-d', strtotime( $this->input->post('mulai'))) . "'
				AND '" . date('Y-m-d', strtotime($this->input->post('akhir'))) . "' and kategori_produk='1' and line='eMail Order'
				");	
				$this->dataJumlahKlikDigitalPrintEmail = $queryJumlahKlikDigitalPrintEmail->row();				
				
				$queryJumlahUangKlikDigitalPrintEmail	=	$this->db->query("
				select sum(TOTAL_HARGA) as JUM from v_barang_order_complete where   
				tgl_order BETWEEN '" . date('Y-m-d', strtotime( $this->input->post('mulai'))) . "'
				AND '" . date('Y-m-d', strtotime($this->input->post('akhir'))) . "' and kategori_produk='1' and line='eMail Order'
				");	
				$this->dataJumlahUangKlikDigitalPrintEmail = $queryJumlahUangKlikDigitalPrintEmail->row();	
				
				$RataUangDigitalPrintEmail = round($this->dataJumlahUangKlikDigitalPrintEmail->JUM / $this->dataJumlahKlikDigitalPrintEmail->JUM);
				
				$this->showLaporan .= "<table width='100%'><tr><td>Jumlah Klik Produk Digital Print (antrian eMail) = <b>".$this->dataJumlahKlikDigitalPrintEmail->JUM."</b> Klik</td></tr><tr><td>Jumlah Omset Produk Digital Print (antrian eMail) = <b>".$this->format_rupiah($this->dataJumlahUangKlikDigitalPrintEmail->JUM)."</b></td></tr></table><br><hr>";
				
				//////////////////////////////////////////////////////////////				
				$querydataArusKasUangEmail	=	$this->db->query("
				select sum(TOTAL_BAYAR) as JUM from v_order where   
				tgl_order BETWEEN '" . date('Y-m-d', strtotime( $this->input->post('mulai'))) . "'  
				AND '" . date('Y-m-d', strtotime($this->input->post('akhir'))) . "'  and line='eMail Order'
				");	
				$this->dataArusKasUangEmail = $querydataArusKasUangEmail->row();
				
				$this->showLaporan .= "<table width='100%'><tr><td>TOTAL ARUS KAS (antrian eMail) = <b>".$this->format_rupiah($this->dataArusKasUangEmail->JUM)."</b></td></tr></table><br><hr>";
				
				//////////////////////////////////////////////////////////////				
				$querydataArusKasUangSatuSampaiLima	=	$this->db->query("
				select JUMLAH_KLIK,TOTAL_HARGA from v_lap_klik_per_wo where   
				tgl_order BETWEEN '" . date('Y-m-d', strtotime( $this->input->post('mulai'))) . "'  
				AND '" . date('Y-m-d', strtotime($this->input->post('akhir'))) . "'  and jumlah_klik between 1 and  5 
				");	
				$this->dataArusKasUangSatuSampaiLima = $querydataArusKasUangSatuSampaiLima->row();
				if($this->dataArusKasUangSatuSampaiLima){
					$jumlahUangSatuSampaiLima 	= $this->dataArusKasUangSatuSampaiLima->TOTAL_HARGA;
					$jumlahKlikSatuSampaiLima 	= $this->dataArusKasUangSatuSampaiLima->JUMLAH_KLIK;
					$rataKlikSatuSampaiLima 	= $this->dataArusKasUangSatuSampaiLima->TOTAL_HARGA/$this->dataArusKasUangSatuSampaiLima->JUMLAH_KLIK;
				}
				else{
					$jumlahUangSatuSampaiLima 	= 0;
					$jumlahKlikSatuSampaiLima 	= 0;
					$rataKlikSatuSampaiLima 	= 0;
				}
				
				$this->showLaporan .= "<table width='100%' cellpadding='3' border='1' style='border-collapse:collapse'><tr><td align='center'>Range Jumlah Klik (Digital Print)</td><td align='center'>Jumlah Klik</td><td align='center'>Omset</td><td align='center'>Omset /  Klik</td></tr>";
				$this->showLaporan .= "<tr><td align='center'>1 s/d 5</td><td align=''>".$jumlahKlikSatuSampaiLima."</td><td align='right'>".$this->format_rupiah($jumlahUangSatuSampaiLima)."</td><td align='right'>".$this->format_rupiah($rataKlikSatuSampaiLima)."</td></tr>";
				
				////////
				$querydataArusKasUangEnamSampaiSepuluh	=	$this->db->query("
				select JUMLAH_KLIK,TOTAL_HARGA from v_lap_klik_per_wo where   
				tgl_order BETWEEN '" . date('Y-m-d', strtotime( $this->input->post('mulai'))) . "'  
				AND '" . date('Y-m-d', strtotime($this->input->post('akhir'))) . "'  and jumlah_klik between 6 and  10 
				");	
				$this->dataArusKasUangEnamSampaiSepuluh = $querydataArusKasUangEnamSampaiSepuluh->row();
				if($this->dataArusKasUangEnamSampaiSepuluh){
					$jumlahUangEnamSampaiSepuluh 	= $this->dataArusKasUangEnamSampaiSepuluh->TOTAL_HARGA;
					$jumlahKlikEnamSampaiSepuluh 	= $this->dataArusKasUangEnamSampaiSepuluh->JUMLAH_KLIK;
					$rataKlikEnamSampaiSepuluh 	= $this->dataArusKasUangEnamSampaiSepuluh->TOTAL_HARGA/$this->dataArusKasUangEnamSampaiSepuluh->JUMLAH_KLIK;
				}
				else{
					$jumlahUangEnamSampaiSepuluh 	= 0;
					$jumlahKlikEnamSampaiSepuluh 	= 0;
					$rataKlikEnamSampaiSepuluh 	= 0;
				}
				
				$this->showLaporan .= "<tr><td align='center'>6 s/d 10</td><td align=''>".$jumlahKlikEnamSampaiSepuluh."</td><td align='right'>".$this->format_rupiah($jumlahUangEnamSampaiSepuluh)."</td><td align='right'>".$this->format_rupiah($rataKlikEnamSampaiSepuluh)."</td></tr>";
				
				////////
				$querydataArusKasUangSebelasSampaiDuaLima	=	$this->db->query("
				select JUMLAH_KLIK,TOTAL_HARGA from v_lap_klik_per_wo where   
				tgl_order BETWEEN '" . date('Y-m-d', strtotime( $this->input->post('mulai'))) . "'  
				AND '" . date('Y-m-d', strtotime($this->input->post('akhir'))) . "'  and jumlah_klik between 11 and  25 
				");	
				$this->dataArusKasUangSebelasSampaiDuaLima = $querydataArusKasUangSebelasSampaiDuaLima->row();
				if($this->dataArusKasUangSebelasSampaiDuaLima){
					$jumlahUangSebelasSampaiDuaLima 	= $this->dataArusKasUangSebelasSampaiDuaLima->TOTAL_HARGA;
					$jumlahKlikSebelasSampaiDuaLima 	= $this->dataArusKasUangSebelasSampaiDuaLima->JUMLAH_KLIK;
					$rataKlikSebelasSampaiDuaLima 	= $this->dataArusKasUangSebelasSampaiDuaLima->TOTAL_HARGA/$this->dataArusKasUangSebelasSampaiDuaLima->JUMLAH_KLIK;
				}
				else{
					$jumlahUangSebelasSampaiDuaLima 	= 0;
					$jumlahKlikSebelasSampaiDuaLima 	= 0;
					$rataKlikSebelasSampaiDuaLima 	= 0;
				}
				
				$this->showLaporan .= "<tr><td align='center'>11 s/d 25</td><td align=''>".$jumlahKlikSebelasSampaiDuaLima."</td><td align='right'>".$this->format_rupiah($jumlahUangSebelasSampaiDuaLima)."</td><td align='right'>".$this->format_rupiah($rataKlikSebelasSampaiDuaLima)."</td></tr>";
				
				////////
				$querydataArusKasUangDuaEnamSampaiLimaPuluh	=	$this->db->query("
				select JUMLAH_KLIK,TOTAL_HARGA from v_lap_klik_per_wo where   
				tgl_order BETWEEN '" . date('Y-m-d', strtotime( $this->input->post('mulai'))) . "'  
				AND '" . date('Y-m-d', strtotime($this->input->post('akhir'))) . "'  and jumlah_klik between 26 and  50 
				");	
				$this->dataArusKasUangDuaEnamSampaiLimaPuluh = $querydataArusKasUangDuaEnamSampaiLimaPuluh->row();
				if($this->dataArusKasUangDuaEnamSampaiLimaPuluh){
					$jumlahUangDuaEnamSampaiLimaPuluh 	= $this->dataArusKasUangDuaEnamSampaiLimaPuluh->TOTAL_HARGA;
					$jumlahKlikDuaEnamSampaiLimaPuluh 	= $this->dataArusKasUangDuaEnamSampaiLimaPuluh->JUMLAH_KLIK;
					$rataKlikDuaEnamSampaiLimaPuluh 	= $this->dataArusKasUangDuaEnamSampaiLimaPuluh->TOTAL_HARGA/$this->dataArusKasUangDuaEnamSampaiLimaPuluh->JUMLAH_KLIK;
				}
				else{
					$jumlahUangDuaEnamSampaiLimaPuluh 	= 0;
					$jumlahKlikDuaEnamSampaiLimaPuluh 	= 0;
					$rataKlikDuaEnamSampaiLimaPuluh 	= 0;
				}
				
				$this->showLaporan .= "<tr><td align='center'>26 s/d 50</td><td align=''>".$jumlahKlikDuaEnamSampaiLimaPuluh."</td><td align='right'>".$this->format_rupiah($jumlahUangDuaEnamSampaiLimaPuluh)."</td><td align='right'>".$this->format_rupiah($rataKlikDuaEnamSampaiLimaPuluh)."</td></tr>";
				
				////////
				$querydataArusKasUangLimaSatuSampaiSeratus	=	$this->db->query("
				select JUMLAH_KLIK,TOTAL_HARGA from v_lap_klik_per_wo where   
				tgl_order BETWEEN '" . date('Y-m-d', strtotime( $this->input->post('mulai'))) . "'  
				AND '" . date('Y-m-d', strtotime($this->input->post('akhir'))) . "'  and jumlah_klik between 51 and  100
				");	
				$this->dataArusKasUangLimaSatuSampaiSeratus = $querydataArusKasUangLimaSatuSampaiSeratus->row();
				if($this->dataArusKasUangLimaSatuSampaiSeratus){
					$jumlahUangLimaSatuSampaiSeratus 	= $this->dataArusKasUangLimaSatuSampaiSeratus->TOTAL_HARGA;
					$jumlahKlikLimaSatuSampaiSeratus 	= $this->dataArusKasUangLimaSatuSampaiSeratus->JUMLAH_KLIK;
					$rataKlikLimaSatuSampaiSeratus 	= $this->dataArusKasUangLimaSatuSampaiSeratus->TOTAL_HARGA/$this->dataArusKasUangLimaSatuSampaiSeratus->JUMLAH_KLIK;
				}
				else{
					$jumlahUangLimaSatuSampaiSeratus 	= 0;
					$jumlahKlikLimaSatuSampaiSeratus 	= 0;
					$rataKlikLimaSatuSampaiSeratus 	= 0;
				}
				
				$this->showLaporan .= "<tr><td align='center'>51 s/d 100</td><td align=''>".$jumlahKlikLimaSatuSampaiSeratus."</td><td align='right'>".$this->format_rupiah($jumlahUangLimaSatuSampaiSeratus)."</td><td align='right'>".$this->format_rupiah($rataKlikLimaSatuSampaiSeratus)."</td></tr>";
				
				////////
				$querydataArusKasUangSeratusSatuSampaiDuaRatusSembilan	=	$this->db->query("
				select JUMLAH_KLIK,TOTAL_HARGA from v_lap_klik_per_wo where   
				tgl_order BETWEEN '" . date('Y-m-d', strtotime( $this->input->post('mulai'))) . "'  
				AND '" . date('Y-m-d', strtotime($this->input->post('akhir'))) . "'  and jumlah_klik between 101 and  249
				");	
				$this->dataArusKasUangSeratusSatuSampaiDuaRatusSembilan = $querydataArusKasUangSeratusSatuSampaiDuaRatusSembilan->row();
				if($this->dataArusKasUangSeratusSatuSampaiDuaRatusSembilan){
					$jumlahUangSeratusSatuSampaiDuaRatusSembilan 	= $this->dataArusKasUangSeratusSatuSampaiDuaRatusSembilan->TOTAL_HARGA;
					$jumlahKlikSeratusSatuSampaiDuaRatusSembilan 	= $this->dataArusKasUangSeratusSatuSampaiDuaRatusSembilan->JUMLAH_KLIK;
					$rataKlikSeratusSatuSampaiDuaRatusSembilan 	= $this->dataArusKasUangSeratusSatuSampaiDuaRatusSembilan->TOTAL_HARGA/$this->dataArusKasUangSeratusSatuSampaiDuaRatusSembilan->JUMLAH_KLIK;
				}
				else{
					$jumlahUangSeratusSatuSampaiDuaRatusSembilan 	= 0;
					$jumlahKlikSeratusSatuSampaiDuaRatusSembilan 	= 0;
					$rataKlikSeratusSatuSampaiDuaRatusSembilan 	= 0;
				}
				
				$this->showLaporan .= "<tr><td align='center'>101 s/d 249</td><td align=''>".$jumlahKlikSeratusSatuSampaiDuaRatusSembilan."</td><td align='right'>".$this->format_rupiah($jumlahUangSeratusSatuSampaiDuaRatusSembilan)."</td><td align='right'>".$this->format_rupiah($rataKlikSeratusSatuSampaiDuaRatusSembilan)."</td></tr>";
				
				////////
				$querydataArusKasUangDuaLimaPuluhSampaiEmpatSembilamSembilan	=	$this->db->query("
				select JUMLAH_KLIK,TOTAL_HARGA from v_lap_klik_per_wo where   
				tgl_order BETWEEN '" . date('Y-m-d', strtotime( $this->input->post('mulai'))) . "'  
				AND '" . date('Y-m-d', strtotime($this->input->post('akhir'))) . "'  and jumlah_klik between 250 and  499
				");	
				$this->dataArusKasUangDuaLimaPuluhSampaiEmpatSembilamSembilan = $querydataArusKasUangDuaLimaPuluhSampaiEmpatSembilamSembilan->row();
				if($this->dataArusKasUangDuaLimaPuluhSampaiEmpatSembilamSembilan){
					$jumlahUangDuaLimaPuluhSampaiEmpatSembilamSembilan 	= $this->dataArusKasUangDuaLimaPuluhSampaiEmpatSembilamSembilan->TOTAL_HARGA;
					$jumlahKlikDuaLimaPuluhSampaiEmpatSembilamSembilan 	= $this->dataArusKasUangDuaLimaPuluhSampaiEmpatSembilamSembilan->JUMLAH_KLIK;
					$rataKlikDuaLimaPuluhSampaiEmpatSembilamSembilan 	= $this->dataArusKasUangDuaLimaPuluhSampaiEmpatSembilamSembilan->TOTAL_HARGA/$this->dataArusKasUangDuaLimaPuluhSampaiEmpatSembilamSembilan->JUMLAH_KLIK;
				}
				else{
					$jumlahUangDuaLimaPuluhSampaiEmpatSembilamSembilan 	= 0;
					$jumlahKlikDuaLimaPuluhSampaiEmpatSembilamSembilan 	= 0;
					$rataKlikDuaLimaPuluhSampaiEmpatSembilamSembilan 	= 0;
				}
				
				$this->showLaporan .= "<tr><td align='center'>250 s/d 499</td><td align=''>".$jumlahKlikDuaLimaPuluhSampaiEmpatSembilamSembilan."</td><td align='right'>".$this->format_rupiah($jumlahUangDuaLimaPuluhSampaiEmpatSembilamSembilan)."</td><td align='right'>".$this->format_rupiah($rataKlikDuaLimaPuluhSampaiEmpatSembilamSembilan)."</td></tr>";
				
				////////
				$querydataArusKasUangLimaRatusSampaiTujuhSembialnSembilan	=	$this->db->query("
				select JUMLAH_KLIK,TOTAL_HARGA from v_lap_klik_per_wo where   
				tgl_order BETWEEN '" . date('Y-m-d', strtotime( $this->input->post('mulai'))) . "'  
				AND '" . date('Y-m-d', strtotime($this->input->post('akhir'))) . "'  and jumlah_klik between 500 and  799
				");	
				$this->dataArusKasUangLimaRatusSampaiTujuhSembialnSembilan = $querydataArusKasUangLimaRatusSampaiTujuhSembialnSembilan->row();
				if($this->dataArusKasUangLimaRatusSampaiTujuhSembialnSembilan){
					$jumlahUangLimaRatusSampaiTujuhSembialnSembilan 	= $this->dataArusKasUangLimaRatusSampaiTujuhSembialnSembilan->TOTAL_HARGA;
					$jumlahKlikLimaRatusSampaiTujuhSembialnSembilan 	= $this->dataArusKasUangLimaRatusSampaiTujuhSembialnSembilan->JUMLAH_KLIK;
					$rataKlikLimaRatusSampaiTujuhSembialnSembilan 	= $this->dataArusKasUangLimaRatusSampaiTujuhSembialnSembilan->TOTAL_HARGA/$this->dataArusKasUangLimaRatusSampaiTujuhSembialnSembilan->JUMLAH_KLIK;
				}
				else{
					$jumlahUangLimaRatusSampaiTujuhSembialnSembilan 	= 0;
					$jumlahKlikLimaRatusSampaiTujuhSembialnSembilan 	= 0;
					$rataKlikLimaRatusSampaiTujuhSembialnSembilan 	= 0;
				}
				
				$this->showLaporan .= "<tr><td align='center'>500 s/d 799</td><td align=''>".$jumlahKlikLimaRatusSampaiTujuhSembialnSembilan."</td><td align='right'>".$this->format_rupiah($jumlahUangLimaRatusSampaiTujuhSembialnSembilan)."</td><td align='right'>".$this->format_rupiah($rataKlikLimaRatusSampaiTujuhSembialnSembilan)."</td></tr>";
				
				////////
				$querydataArusKasUangTujuhLimaPuluhSampaiSeribu	=	$this->db->query("
				select JUMLAH_KLIK,TOTAL_HARGA from v_lap_klik_per_wo where   
				tgl_order BETWEEN '" . date('Y-m-d', strtotime( $this->input->post('mulai'))) . "'  
				AND '" . date('Y-m-d', strtotime($this->input->post('akhir'))) . "'  and jumlah_klik between 750 and  1000
				");	
				$this->dataArusKasUangTujuhLimaPuluhSampaiSeribu = $querydataArusKasUangTujuhLimaPuluhSampaiSeribu->row();
				if($this->dataArusKasUangTujuhLimaPuluhSampaiSeribu){
					$jumlahUangTujuhLimaPuluhSampaiSeribu 	= $this->dataArusKasUangTujuhLimaPuluhSampaiSeribu->TOTAL_HARGA;
					$jumlahKlikTujuhLimaPuluhSampaiSeribu 	= $this->dataArusKasUangTujuhLimaPuluhSampaiSeribu->JUMLAH_KLIK;
					$rataKlikTujuhLimaPuluhSampaiSeribu 	= $this->dataArusKasUangTujuhLimaPuluhSampaiSeribu->TOTAL_HARGA/$this->dataArusKasUangTujuhLimaPuluhSampaiSeribu->JUMLAH_KLIK;
				}
				else{
					$jumlahUangTujuhLimaPuluhSampaiSeribu 	= 0;
					$jumlahKlikTujuhLimaPuluhSampaiSeribu 	= 0;
					$rataKlikTujuhLimaPuluhSampaiSeribu 	= 0;
				}
				
				$this->showLaporan .= "<tr><td align='center'>750 s/d 1000</td><td align=''>".$jumlahKlikTujuhLimaPuluhSampaiSeribu."</td><td align='right'>".$this->format_rupiah($jumlahUangTujuhLimaPuluhSampaiSeribu)."</td><td align='right'>".$this->format_rupiah($rataKlikTujuhLimaPuluhSampaiSeribu)."</td></tr>";
				
				////////
				$querydataArusKasUangLebihSeribu	=	$this->db->query("
				select JUMLAH_KLIK,TOTAL_HARGA from v_lap_klik_per_wo where   
				tgl_order BETWEEN '" . date('Y-m-d', strtotime( $this->input->post('mulai'))) . "'  
				AND '" . date('Y-m-d', strtotime($this->input->post('akhir'))) . "'  and jumlah_klik  > 1000
				");	
				$this->dataArusKasUangLebihSeribu = $querydataArusKasUangLebihSeribu->row();
				if($this->dataArusKasUangLebihSeribu){
					$jumlahUangLebihSeribu 	= $this->dataArusKasUangLebihSeribu->TOTAL_HARGA;
					$jumlahKlikLebihSeribu 	= $this->dataArusKasUangLebihSeribu->JUMLAH_KLIK;
					$rataKlikLebihSeribu 	= $this->dataArusKasUangLebihSeribu->TOTAL_HARGA/$this->dataArusKasUangLebihSeribu->JUMLAH_KLIK;
				}
				else{
					$jumlahUangLebihSeribu 	= 0;
					$jumlahKlikLebihSeribu 	= 0;
					$rataKlikLebihSeribu 	= 0;
				}
				
				$this->showLaporan .= "<tr><td align='center'>> 1000</td><td align=''>".$jumlahKlikLebihSeribu."</td><td align='right'>".$this->format_rupiah($jumlahUangLebihSeribu)."</td><td align='right'>".$this->format_rupiah($rataKlikLebihSeribu)."</td></tr>";
				$this->showLaporan.="</table><hr>";
				
				//////////////////////////////////////////////////////////////
				$queryJumlahKlikPaketkartuNama	=	$this->db->query("
				select sum(JML_KLIK) as JUM from v_barang_order_complete where   
				tgl_order BETWEEN '" . date('Y-m-d', strtotime( $this->input->post('mulai'))) . "'
				AND '" . date('Y-m-d', strtotime($this->input->post('akhir'))) . "' and id_produk='10'
				");	
				$this->dataJumlahKlikPaketkartuNama = $queryJumlahKlikPaketkartuNama->row();				
				
				$queryJumlahBoxPaketkartuNama	=	$this->db->query("
				select sum(JUMLAH_BOX) as JUM from v_barang_order_complete where   
				tgl_order BETWEEN '" . date('Y-m-d', strtotime( $this->input->post('mulai'))) . "'
				AND '" . date('Y-m-d', strtotime($this->input->post('akhir'))) . "' and id_produk='10'
				");	
				$this->dataJumlahBoxPaketkartuNama = $queryJumlahBoxPaketkartuNama->row();		
				
				$queryJumlahUangPaketkartuNama	=	$this->db->query("
				select sum(TOTAL_HARGA) as JUM from v_barang_order_complete where   
				tgl_order BETWEEN '" . date('Y-m-d', strtotime( $this->input->post('mulai'))) . "'
				AND '" . date('Y-m-d', strtotime($this->input->post('akhir'))) . "' and id_produk='10'
				");	
				$this->dataJumlahUangPaketkartuNama = $queryJumlahUangPaketkartuNama->row();	
				
				$RataUangPaketKartuNama = round($this->dataJumlahUangPaketkartuNama->JUM / $this->dataJumlahBoxPaketkartuNama->JUM);
				
				$this->showLaporan .= "<table width='100%'><tr><td>Jumlah Box Paket Kartu Nama = <b>".$this->dataJumlahBoxPaketkartuNama->JUM."</b> Box</td></tr><tr><td>Jumlah Klik Produk Paket kartu Nama = <b>".$this->dataJumlahKlikPaketkartuNama->JUM."</b> Klik</td></tr><tr><td>Jumlah Omset  Produk Paket kartu Nama = <b>".$this->format_rupiah($this->dataJumlahUangPaketkartuNama->JUM)."</b></td></tr><tr><td>Rata-Rata Omset Produk Paket kartu Nama = <b>".$this->format_rupiah($this->dataJumlahUangPaketkartuNama->JUM)." / ".$this->dataJumlahBoxPaketkartuNama->JUM." = ".$this->format_rupiah($RataUangPaketKartuNama)."</b></td></tr></table><hr>";
				
				
				//////////////////////////////////////////////////////////////				
				$querydataArusKasUangSatuSampaiDuaLima	=	$this->db->query("
				select JUMLAH_KLIK,TOTAL_HARGA from v_lap_klik_per_wo where   
				tgl_order BETWEEN '" . date('Y-m-d', strtotime( $this->input->post('mulai'))) . "'  
				AND '" . date('Y-m-d', strtotime($this->input->post('akhir'))) . "'  and jumlah_klik between 1 and  25 and Log_member='Y'
				");	
				$this->dataArusKasUangSatuSampaiDuaLima = $querydataArusKasUangSatuSampaiDuaLima->row();
				if($this->dataArusKasUangSatuSampaiDuaLima){
					$jumlahUangSatuSampaiDuaLima 	= $this->dataArusKasUangSatuSampaiDuaLima->TOTAL_HARGA;
					$jumlahKlikSatuSampaiDuaLima 	= $this->dataArusKasUangSatuSampaiDuaLima->JUMLAH_KLIK;
					$rataKlikSatuSampaiDuaLima 	= $this->dataArusKasUangSatuSampaiDuaLima->TOTAL_HARGA/$this->dataArusKasUangSatuSampaiDuaLima->JUMLAH_KLIK;
				}
				else{
					$jumlahUangSatuSampaiDuaLima 	= 0;
					$jumlahKlikSatuSampaiDuaLima 	= 0;
					$rataKlikSatuSampaiDuaLima 	= 0;
				}
				
				$this->showLaporan .= "<table width='100%' cellpadding='3' border='1' style='border-collapse:collapse'><tr><td align='center'>Range Jumlah Klik (Digital Print dan Member)</td><td align='center'>Jumlah Klik</td><td align='center'>Omset</td><td align='center'>Omset /  Klik</td></tr>";
				$this->showLaporan .= "<tr><td align='center'>1 s/d 25</td><td align=''>".$jumlahKlikSatuSampaiDuaLima."</td><td align='right'>".$this->format_rupiah($jumlahUangSatuSampaiDuaLima)."</td><td align='right'>".$this->format_rupiah($rataKlikSatuSampaiDuaLima)."</td></tr>";
				
				//////////////////////////////////////////////////////////////				
				$querydataArusKasUangDuaEnamSampaiLimaPuluh	=	$this->db->query("
				select JUMLAH_KLIK,TOTAL_HARGA from v_lap_klik_per_wo where   
				tgl_order BETWEEN '" . date('Y-m-d', strtotime( $this->input->post('mulai'))) . "'  
				AND '" . date('Y-m-d', strtotime($this->input->post('akhir'))) . "'  and jumlah_klik between 26 and  50 and Log_member='Y'
				");	
				$this->dataArusKasUangDuaEnamSampaiLimaPuluh = $querydataArusKasUangDuaEnamSampaiLimaPuluh->row();
				if($this->dataArusKasUangDuaEnamSampaiLimaPuluh){
					$jumlahUangDuaEnamSampaiLimaPuluh 	= $this->dataArusKasUangDuaEnamSampaiLimaPuluh->TOTAL_HARGA;
					$jumlahKlikDuaEnamSampaiLimaPuluh 	= $this->dataArusKasUangDuaEnamSampaiLimaPuluh->JUMLAH_KLIK;
					$rataKlikDuaEnamSampaiLimaPuluh 	= $this->dataArusKasUangDuaEnamSampaiLimaPuluh->TOTAL_HARGA/$this->dataArusKasUangDuaEnamSampaiLimaPuluh->JUMLAH_KLIK;
				}
				else{
					$jumlahUangDuaEnamSampaiLimaPuluh 	= 0;
					$jumlahKlikDuaEnamSampaiLimaPuluh 	= 0;
					$rataKlikDuaEnamSampaiLimaPuluh 	= 0;
				}
				
				$this->showLaporan .= "<tr><td align='center'>25 s/d 50</td><td align=''>".$jumlahKlikDuaEnamSampaiLimaPuluh."</td><td align='right'>".$this->format_rupiah($jumlahUangDuaEnamSampaiLimaPuluh)."</td><td align='right'>".$this->format_rupiah($rataKlikDuaEnamSampaiLimaPuluh)."</td></tr>";
				
				//////////////////////////////////////////////////////////////				
				$querydataArusKasUangLimaPuluhSatuSampaiSeratus	=	$this->db->query("
				select JUMLAH_KLIK,TOTAL_HARGA from v_lap_klik_per_wo where   
				tgl_order BETWEEN '" . date('Y-m-d', strtotime( $this->input->post('mulai'))) . "'  
				AND '" . date('Y-m-d', strtotime($this->input->post('akhir'))) . "'  and jumlah_klik between 51 and  100 and Log_member='Y'
				");	
				$this->dataArusKasUangLimaPuluhSatuSampaiSeratus = $querydataArusKasUangLimaPuluhSatuSampaiSeratus->row();
				if($this->dataArusKasUangLimaPuluhSatuSampaiSeratus){
					$jumlahUangLimaPuluhSatuSampaiSeratus 	= $this->dataArusKasUangLimaPuluhSatuSampaiSeratus->TOTAL_HARGA;
					$jumlahKlikLimaPuluhSatuSampaiSeratus 	= $this->dataArusKasUangLimaPuluhSatuSampaiSeratus->JUMLAH_KLIK;
					$rataKlikLimaPuluhSatuSampaiSeratus 	= $this->dataArusKasUangLimaPuluhSatuSampaiSeratus->TOTAL_HARGA/$this->dataArusKasUangLimaPuluhSatuSampaiSeratus->JUMLAH_KLIK;
				}
				else{
					$jumlahUangLimaPuluhSatuSampaiSeratus 	= 0;
					$jumlahKlikLimaPuluhSatuSampaiSeratus 	= 0;
					$rataKlikLimaPuluhSatuSampaiSeratus 	= 0;
				}
				
				$this->showLaporan .= "<tr><td align='center'>51 s/d 100</td><td align=''>".$jumlahKlikLimaPuluhSatuSampaiSeratus."</td><td align='right'>".$this->format_rupiah($jumlahUangLimaPuluhSatuSampaiSeratus)."</td><td align='right'>".$this->format_rupiah($rataKlikLimaPuluhSatuSampaiSeratus)."</td></tr>";
				
					//////////////////////////////////////////////////////////////				
				$querydataArusKasUangLebihSeratus	=	$this->db->query("
				select JUMLAH_KLIK,TOTAL_HARGA from v_lap_klik_per_wo where   
				tgl_order BETWEEN '" . date('Y-m-d', strtotime( $this->input->post('mulai'))) . "'  
				AND '" . date('Y-m-d', strtotime($this->input->post('akhir'))) . "'  and jumlah_klik > 100 and Log_member='Y'
				");	
				$this->dataArusKasUangLebihSeratus = $querydataArusKasUangLebihSeratus->row();
				if($this->dataArusKasUangLebihSeratus){
					$jumlahUangLebihSeratus 	= $this->dataArusKasUangLebihSeratus->TOTAL_HARGA;
					$jumlahKlikLebihSeratus 	= $this->dataArusKasUangLebihSeratus->JUMLAH_KLIK;
					$rataKlikLebihSeratus 	= $this->dataArusKasUangLebihSeratus->TOTAL_HARGA/$this->dataArusKasUangLebihSeratus->JUMLAH_KLIK;
				}
				else{
					$jumlahUangLebihSeratus 	= 0;
					$jumlahKlikLebihSeratus 	= 0;
					$rataKlikLebihSeratus 	= 0;
				}
				
			
				$this->showLaporan .= "<tr><td align='center'>> 100</td><td align=''>".$jumlahKlikLebihSeratus."</td><td align='right'>".$this->format_rupiah($jumlahUangLebihSeratus)."</td><td align='right'>".$this->format_rupiah($rataKlikLebihSeratus)."</td></tr>";
				
				
			$this->showLaporan.="</table><br><hr>";
				
				
				
				
				//////
				$this->showLaporan .= "<table width='100%' cellpadding='3' border='1' style='border-collapse:collapse'><tr><td align='center'>Nama Produk</td><td align='center'>Omset </td></tr>";
				$querymasterBarang = $this->db->query("select * from m_produk order by nama_produk");				
				$querymasterBarang = $querymasterBarang->result();
				foreach($querymasterBarang  as $dataBarang){
					
					$queryOmsetBarang = $this->db->query(" select TOTAL_HARGA from v_barang_order_complete where   
						tgl_order BETWEEN '" . date('Y-m-d', strtotime( $this->input->post('mulai'))) . "'  
						AND '" . date('Y-m-d', strtotime($this->input->post('akhir'))) . "'  and  id_produk = '".$dataBarang->id_produk."' ");				
					$dataOmsetBarang = $queryOmsetBarang->row();
					
					if($dataOmsetBarang){						
						$omset = $dataOmsetBarang->TOTAL_HARGA;
					}
					else{
						$omset =0;
					}
					
					$this->showLaporan .= "<tr><td align=''>".$dataBarang->nama_produk."</td><td align='right'>".$this->format_rupiah($omset)." </td></tr>";
				}
				$this->showLaporan.="</table><br><hr>";
				
				
				//////
				$this->showLaporan .= "<table width='100%' cellpadding='3' border='1' style='border-collapse:collapse'><tr><td align='center'>Nama Karyawan (Pengerjaan Design)</td><td align='center'>Omset </td><td align='center'>Bonus (25%) </td></tr>";
				$queryNamaPegawaiDesain = $this->db->query("select distinct(ID_KARYAWAN) as ID_KARYAWAN ,NAMA_KARYAWAN from v_barang_order_complete where   
						tgl_order BETWEEN '" . date('Y-m-d', strtotime( $this->input->post('mulai'))) . "'  
						AND '" . date('Y-m-d', strtotime($this->input->post('akhir'))) . "'  and  id_produk = '1' and status_bayar='L'  ");				
				$dataNamaPegawaiDesain= $queryNamaPegawaiDesain->result();
				foreach($dataNamaPegawaiDesain  as $NamaPegawaiDesain){
					
					$queryOmsetPegawaiDesain = $this->db->query("select sum(TOTAL_HARGA) as JUM from v_barang_order_complete where   
						tgl_order BETWEEN '" . date('Y-m-d', strtotime( $this->input->post('mulai'))) . "'  
						AND '" . date('Y-m-d', strtotime($this->input->post('akhir'))) . "'  and  id_produk = '1'  and id_karyawan='".$NamaPegawaiDesain->ID_KARYAWAN."'  and status_bayar='L' ");				
					$dataOmsetPegawaiDesain= $queryOmsetPegawaiDesain->row();
				
					$bonus = ($dataOmsetPegawaiDesain->JUM * 25) /100;
					
					$this->showLaporan .= "<tr><td align=''>".$NamaPegawaiDesain->NAMA_KARYAWAN."</td><td align='right'>".$this->format_rupiah($dataOmsetPegawaiDesain->JUM)."</td><td align='right'>".$this->format_rupiah($bonus)."</td></tr>";
					
				}
				$this->showLaporan.="</table><br><hr>";
				
				
				
				//////
				$this->showLaporan .= "<table width='100%' cellpadding='3' border='1' style='border-collapse:collapse'><tr><td align='center'>Nama Karyawan (Ambil Order WO)</td><td align='center'>Jumlah WO </td><td align='center'>Omset</td><td align='center'>Omset / Jumlah WO</td></tr>";
				$queryNamaPegawaiAmbilWO = $this->db->query("select distinct(ID_KARYAWAN) as ID_KARYAWAN ,NAMA_KARYAWAN from v_karyawan_ambil_order where   
						tgl_order BETWEEN '" . date('Y-m-d', strtotime( $this->input->post('mulai'))) . "'  
						AND '" . date('Y-m-d', strtotime($this->input->post('akhir'))) . "'    ");				
				$dataNamaPegawaiAmbilWO= $queryNamaPegawaiAmbilWO->result();
				foreach($dataNamaPegawaiAmbilWO  as $NamaPegawaiAmbilWO){
					
					$queryOmsetPegawaiAmbilWO = $this->db->query("select sum(TOTAL_BAYAR) as JUM from v_karyawan_ambil_order where   
						tgl_order BETWEEN '" . date('Y-m-d', strtotime( $this->input->post('mulai'))) . "'  
						AND '" . date('Y-m-d', strtotime($this->input->post('akhir'))) . "'    and id_karyawan='".$NamaPegawaiAmbilWO->ID_KARYAWAN."'  ");				
					$dataOmsetPegawaiAmbilWO= $queryOmsetPegawaiAmbilWO->row();
					
					$queryJumlahWOPegawaiAmbilWO = $this->db->query("select count(*) as JUM from v_karyawan_ambil_order where   
						tgl_order BETWEEN '" . date('Y-m-d', strtotime( $this->input->post('mulai'))) . "'  
						AND '" . date('Y-m-d', strtotime($this->input->post('akhir'))) . "'    and id_karyawan='".$NamaPegawaiAmbilWO->ID_KARYAWAN."'  ");				
					$dataJumlahWOPegawaiAmbilWO= $queryJumlahWOPegawaiAmbilWO->row();
					
					if($dataJumlahWOPegawaiAmbilWO && $dataJumlahWOPegawaiAmbilWO){
						$rataRata = $dataOmsetPegawaiAmbilWO->JUM / $dataJumlahWOPegawaiAmbilWO->JUM;
						
					}
					else{
						$rataRata=0;
					}
					
					
					$this->showLaporan .= "<tr><td align=''>".$NamaPegawaiAmbilWO->NAMA_KARYAWAN."</td><td align=''>".$dataJumlahWOPegawaiAmbilWO->JUM."</td><td align='right'>".$this->format_rupiah($dataOmsetPegawaiAmbilWO->JUM)."</td><td align='right'>".$this->format_rupiah($rataRata)."</td></tr>";
					
				}
				$this->showLaporan.="</table><br><hr>";
				
				
				/////
				$this->showLaporan .= "<table width='100%' cellpadding='3' border='1' style='border-collapse:collapse'><tr><td align='center'>Nama Kertas</td><td align='center'>Jumlah Klik</td><td align='center'>Total Pembelian kertas</td><td align='center'>Omset kertas</td><td align='center'>Omset dibagi Jumlah Klik</td></tr>";
				
				$queryKertas = $this->db->query(" SELECT DISTINCT(m_kertas.ID_KERTAS) as ID_KERTAS,m_kertas.NAMA_KERTAS ,HARGA_KERTAS FROM m_kertas,t_harga_kertas,m_produk WHERE m_kertas.ID_KERTAS=t_harga_kertas.ID_KERTAS AND t_harga_kertas.ID_PRODUK=m_produk.id_produk AND m_produk.kategori='1'  order by m_kertas.nama_kertas ");				
				$dataKertas= $queryKertas->result();
				foreach($dataKertas  as $kertas){
					
					$queryOmsetKertas = $this->db->query("select sum(TOTAL_HARGA) as JUM from v_barang_order_complete  where   
						tgl_order BETWEEN '" . date('Y-m-d', strtotime( $this->input->post('mulai'))) . "'  
						AND '" . date('Y-m-d', strtotime($this->input->post('akhir'))) . "'    and  id_kertas='".$kertas->ID_KERTAS."'");				
					$dataOmsetKertas= $queryOmsetKertas->row();
					
					$queryKlikKertas = $this->db->query("select sum(JML_KLIK) as JUM from v_barang_order_complete where   
						tgl_order BETWEEN '" . date('Y-m-d', strtotime( $this->input->post('mulai'))) . "'  
						AND '" . date('Y-m-d', strtotime($this->input->post('akhir'))) . "'    and  id_kertas='".$kertas->ID_KERTAS."' ");				
					$dataKlikKertas= $queryKlikKertas->row();
					
					if($dataKlikKertas->JUM > 0){
						$pembelian= $dataKlikKertas->JUM * $kertas->HARGA_KERTAS;
						$jumlahKlik=$dataKlikKertas->JUM;
						
						$omset =$dataOmsetKertas->JUM / $dataKlikKertas->JUM ;
						$omsetSaja =$dataOmsetKertas->JUM;
					}
					else{
						$pembelian="0";
						$jumlahKlik="0";
						$omset ="0" ;
						$omsetSaja ="0" ;
					}
					
					$this->showLaporan .= "<tr><td align=''>".$kertas->NAMA_KERTAS."</td><td align=''>".	$jumlahKlik."</td><td align=''>".$jumlahKlik." Klik X ".$this->format_rupiah($kertas->HARGA_KERTAS)." = ".$this->format_rupiah($pembelian)."</td> <td align=''>".$this->format_rupiah($omsetSaja)."</td><td align=''>".$this->format_rupiah($omset)."</td></tr>";
					
				}
				$this->showLaporan.="</table><hr>";
				
				$this->html2pdf->html($this->load->view('pdf/laporan_omset_view', $data, true));

			if($path = $this->html2pdf->create('save')) {	
				$status = array('status' => true,'nama_file' => $nama_file);
			}
			else{				
				$status = array('status' => false , 'pesan' => "Maaf gagal membuat Laporan , silahkan ulangi beberapa saat lagi !");
			}
		
			echo(json_encode($status));
		}
	}	
	public function send_email_lap_omset(){
		
		$queryProfil = $this->db->query("select * from m_profil ");		
		$this->dataProfil  = $queryProfil->row();	
		
		$nama_file_attachment = $this->input->post('nama_file');
		
		$this->load->library('PHPMailerAutoload');
		
		$mail = new PHPMailer();
        

        // Konfigurasi SMTP
		$mail->isSMTP();
		$mail->Host = 'smtp.gmail.com';
		$mail->SMTPAuth = true;
		$mail->Username = $this->dataProfil->EMAIL_FROM;
		$mail->Password = $this->dataProfil->PASS_EMAIL_FROM;
		$mail->SMTPSecure = 'ssl';
		$mail->Port = 465;
		$mail->From = $this->dataProfil->EMAIL_FROM;
		$mail->FromName = "Laporan Omset ".$this->dataProfil->NAMA_TOKO;


		$mail->SMTPOptions = array(
			'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
			)
		);

		
		$mail->addAddress($this->dataProfil->EMAIL_OWNER);

		$mail->Subject = 'Laporan Omset Toko '.$this->dataProfil->NAMA_TOKO.', tanggal : '.$this->input->post('mulai') .' s/d '.$this->input->post('akhir');

		$mail->isHTML(true);
		
		$htmlContent = '<h4>Berikut ini kami sampaikan Laporan Omset Toko '.$this->dataProfil->NAMA_TOKO.' untuk tanggal : '.$this->input->post('mulai').' s.d '.$this->input->post('akhir').'</h4>';
		$htmlContent .= '<p>Proses kirim laporan ini dilakukan oleh : '. $this->session->userdata('nama_karyawan').'</p>';
		
		$mail->Body = $htmlContent;
		$mail->addAttachment("upload/attachment/".$nama_file_attachment);		
		
		if(!$mail->send()){
			
			$status = array('status' => false , 'pesan' => "Maaf gagal mengirim Laporan , silahkan ulangi beberapa saat lagi !");
		}
		else{				
			$this->db->query("
			insert into t_kirim_email
			(
				id_karyawan,jenis_laporan,file_attachment)
			values
			(
				'".$this->session->userdata('id_karyawan')."','Laporan Counter','".$nama_file_attachment."')			
			");
			
			$status = array('status' => true);
		}
		
		echo(json_encode($status));
	}
	


}
	
	
	

