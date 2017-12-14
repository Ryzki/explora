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
		return "Rp. ".$rupiah;
	}

	public function index(){		
		
		$this->load->library('text_barang');
		
		if($this->input->get('mulai')){
				$queryLaporan 	= $this->db->query("select * from v_order where tgl_order_indo = '".$this->input->get('date')."' order by tgl_order , id_order");
				$this->showData = $queryLaporan->result();
				
				$this->showLaporan = "<table class='table table-bordered'>";
				$this->showLaporan .= "<thead><tr><th>Keterangan</th><th>Jumlah Klik</th><th>Jumlah Uang</th><th>Rata-Rata Harga</th><th>Keterangan</th></tr></thead><tbody>";
				
				
				//////////////////////////////////////////////////////////////
				/// arus kas 
				
				$querydataArusKasKlik	=	$this->db->query("
				select sum(Jml_KLIK) as JUM from v_barang_order_complete where   
				tgl_order BETWEEN '" . date('Y-m-d', strtotime( $this->input->get('mulai'))) . "'
				AND '" . date('Y-m-d', strtotime($this->input->get('akhir'))) . "' 
				");	
				$this->dataArusKasKlik = $querydataArusKasKlik->row();
				
				$querydataArusKasUang	=	$this->db->query("
				select sum(TOTAL_HARGA) as JUM from v_barang_order_complete where   
				tgl_order BETWEEN '" . date('Y-m-d', strtotime( $this->input->get('mulai'))) . "'
				AND '" . date('Y-m-d', strtotime($this->input->get('akhir'))) . "' 
				");	
				$this->dataArusKasUang = $querydataArusKasUang->row();
				
				$this->dataArusKasRata = $this->dataArusKasUang->JUM / $this->dataArusKasKlik->JUM;
				
				$this->showLaporan .= "<tr><td>TOTAL ARUS KAS</td>";
				$this->showLaporan .= "<td>Total Klik :".$this->dataArusKasKlik->JUM."</td>";
				$this->showLaporan .= "<td>".$this->format_rupiah($this->dataArusKasUang->JUM)."</td>";
				$this->showLaporan .= "<td>".$this->format_rupiah(	$this->dataArusKasRata)."</td>";
				$this->showLaporan .= "<td></td>";
				$this->showLaporan .= "</tr>";
				
				//////////////////////////////////////////////////////////////////////////////
				
				$this->dataNotaPendingRat ="0";
				$this->dataNotaPendingUang ="0";
				$this->dataNotaPendingRata ="0";
				
				$querydataNotaPendingKlik	=	$this->db->query("
				select sum(Jml_KLIK) as JUM from v_barang_order_complete where   
				tgl_order BETWEEN '" . date('Y-m-d', strtotime( $this->input->get('mulai'))) . "'
				AND '" . date('Y-m-d', strtotime($this->input->get('akhir'))) . "'  and  status_bayar='BL'
				");	
				$this->dataNotaPendingKlik = $querydataNotaPendingKlik->row();
				
				$querydataNotaPendingUang	=	$this->db->query("
				select sum(TOTAL_HARGA) as JUM from v_barang_order_complete where   
				tgl_order BETWEEN '" . date('Y-m-d', strtotime( $this->input->get('mulai'))) . "'
				AND '" . date('Y-m-d', strtotime($this->input->get('akhir'))) . "' and  status_bayar='BL'
				");	
				$this->dataNotaPendingUang = $querydataNotaPendingUang->row();
				
				if($this->dataNotaPendingUang->JUM > 0){
						$this->dataNotaPendingRata = $this->dataNotaPendingUang->JUM / $this->dataNotaPendingKlik->JUM;
				}
				
			
				
				$this->showLaporan .= "<tr><td>NOTA PENDING PEMBAYARAN</td>";
				$this->showLaporan .= "<td>Total Klik :".$this->dataNotaPendingKlik->JUM."</td>";
				$this->showLaporan .= "<td>".$this->format_rupiah($this->dataNotaPendingUang->JUM)."</td>";
				$this->showLaporan .= "<td>".$this->format_rupiah(	$this->dataNotaPendingRata)."</td>";
				$this->showLaporan .= "<td></td>";
				$this->showLaporan .= "</tr>";
				
				//////////////////////////////////////////////////////////////////////////////
				
				
				$querydataTotalDigitalPrintKlik	=	$this->db->query("
				select sum(Jml_KLIK) as JUM from v_barang_order_complete where   
				tgl_order BETWEEN '" . date('Y-m-d', strtotime( $this->input->get('mulai'))) . "'
				AND '" . date('Y-m-d', strtotime($this->input->get('akhir'))) . "'  and  kategori_produk='1'
				");	
				$this->dataTotalDigitalPrintKlik = $querydataTotalDigitalPrintKlik->row();
				
				$querydataTotalDigitalPrintUang	=	$this->db->query("
				select sum(TOTAL_HARGA) as JUM from v_barang_order_complete where   
				tgl_order BETWEEN '" . date('Y-m-d', strtotime( $this->input->get('mulai'))) . "'
				AND '" . date('Y-m-d', strtotime($this->input->get('akhir'))) . "' and  kategori_produk='1'
				");	
				$this->dataTotalDigitalPrintUang = $querydataTotalDigitalPrintUang->row();
				
				$this->dataTotalDigitalPrintRata = $this->dataTotalDigitalPrintUang->JUM / $this->dataTotalDigitalPrintKlik->JUM;
				
				$this->showLaporan .= "<tr><td>TOTAL DIGITAL PRINT</td>";
				$this->showLaporan .= "<td>Total Klik :".$this->dataTotalDigitalPrintKlik->JUM."</td>";
				$this->showLaporan .= "<td>".$this->format_rupiah($this->dataTotalDigitalPrintUang->JUM)."</td>";
				$this->showLaporan .= "<td>".$this->format_rupiah(	$this->dataTotalDigitalPrintRata)."</td>";
				$this->showLaporan .= "<td></td>";
				$this->showLaporan .= "</tr>";
				
				//////////////////////////////////////////////////////////////////////////////
				
				
				$queryArusKasEmailKlik	=	$this->db->query("
				select sum(Jml_KLIK) as JUM from v_barang_order_complete where   
				tgl_order BETWEEN '" . date('Y-m-d', strtotime( $this->input->get('mulai'))) . "'
				AND '" . date('Y-m-d', strtotime($this->input->get('akhir'))) . "'  and  line='eMail Order'
				");	
				$this->ArusKasEmailKlik = $queryArusKasEmailKlik->row();
				
				$queryArusKasEmailUang	=	$this->db->query("
				select sum(TOTAL_HARGA) as JUM from v_barang_order_complete where   
				tgl_order BETWEEN '" . date('Y-m-d', strtotime( $this->input->get('mulai'))) . "'
				AND '" . date('Y-m-d', strtotime($this->input->get('akhir'))) . "' and  line='eMail Order'
				");	
				$this->ArusKasEmailUang = $queryArusKasEmailUang->row();
				
				$this->ArusKasEmailRata = $this->ArusKasEmailUang->JUM / $this->ArusKasEmailKlik->JUM;
				
				$this->showLaporan .= "<tr><td>ARUS KAS EMAIL</td>";
				$this->showLaporan .= "<td>Total Klik : ".$this->ArusKasEmailKlik->JUM."</td>";
				$this->showLaporan .= "<td>".$this->format_rupiah($this->ArusKasEmailUang->JUM)."</td>";
				$this->showLaporan .= "<td>".$this->format_rupiah(	$this->ArusKasEmailRata)."</td>";
				$this->showLaporan .= "<td></td>";
				$this->showLaporan .= "</tr>";
				
				$this->showLaporan .= "<tr><td align='center' colspan='5'>Kontribusi per Produk</td></tr>";
				
				$queryProduk	=	$this->db->query("
				select 
					m_produk.nama_produk ,
					(select sum(jumlah_qty) as JUM from v_barang_order_complete where   
					tgl_order BETWEEN '" . date('Y-m-d', strtotime( $this->input->get('mulai'))) . "'
					AND '" . date('Y-m-d', strtotime($this->input->get('akhir'))) . "'  and  v_barang_order_complete.id_produk=m_produk.id_produk) as JUMLAH_QTY,
					(select sum(TOTAL_HARGA) as JUM from v_barang_order_complete where   
					tgl_order BETWEEN '" . date('Y-m-d', strtotime( $this->input->get('mulai'))) . "'
					AND '" . date('Y-m-d', strtotime($this->input->get('akhir'))) . "'  and  v_barang_order_complete.id_produk=m_produk.id_produk) as TOTAL_HARGA
				from 
					m_produk where m_produk.id_produk !=0 
				order by 
					m_produk.nama_produk
				");	
			//	echo $this->db->last_query();
				$this->DataProduk = $queryProduk->result();
				
				foreach($this->DataProduk as $DataProduk){
					$rata="-";
					$persenBulat="";
					if($DataProduk->JUMLAH_QTY > 0){
						$rata=$DataProduk->TOTAL_HARGA / $DataProduk->JUMLAH_QTY;
						$rata=$this->format_rupiah($rata);
						
						$persen 	= ($DataProduk->TOTAL_HARGA / $this->dataArusKasUang->JUM ) * 100;
						$persenBulat = round($persen) ."%";
					}

					
					$this->showLaporan .= "<tr><td>".$DataProduk->nama_produk."</td>";
					$this->showLaporan .= "<td>Qty : ".$DataProduk->JUMLAH_QTY."</td>";
					$this->showLaporan .= "<td>".$this->format_rupiah($DataProduk->TOTAL_HARGA )."</td>";
					$this->showLaporan .= "<td>".$rata."</td>";
					$this->showLaporan .= "<td>".$persenBulat."</td>";
					$this->showLaporan .= "</tr>";
				}
				
				
				$this->showLaporan .= "<tr><td align='center' colspan='5'>Desain Karyawan</td></tr>";
				$this->showLaporan .= "<tr><td align='center' colspan='1'>Nama Karyawan</td><td align='center' colspan='2'>Jumlah Uang</td><td align='center' colspan='2'>Jumlah Bonus (25%)</td></tr>";
				
				$queryKaryawan	=	$this->db->query("
				select 
					m_karyawan.NAMA_KARYAWAN,
					(select sum(TOTAL_HARGA) as JUM from v_barang_order_complete where   
					tgl_order BETWEEN '" . date('Y-m-d', strtotime( $this->input->get('mulai'))) . "'
					AND '" . date('Y-m-d', strtotime($this->input->get('akhir'))) . "'  and  v_barang_order_complete.id_produk='1' and m_karyawan.id_karyawan=v_barang_order_complete.id_karyawan and status_bayar='L') as TOTAL_HARGA
				from 
					m_karyawan 
				where
					id_kategori_user='6' 
				order by 
					m_karyawan.NAMA_KARYAWAN
				");	
			//	echo $this->db->last_query();
				$this->DataKaryawan = $queryKaryawan->result();
				$bonus = "0";
				
				
				foreach($this->DataKaryawan as $DataKaryawan){
					if($DataKaryawan->TOTAL_HARGA > 0){					
						$bonus= ($DataKaryawan->TOTAL_HARGA *  25) / 100;					
					}
					
					$this->showLaporan .= "<tr><td>".$DataKaryawan->NAMA_KARYAWAN."</td>";
					$this->showLaporan .= "<td colspan='2'>".$this->format_rupiah($DataKaryawan->TOTAL_HARGA)."</td>";
					$this->showLaporan .= "<td colspan='2'>".$this->format_rupiah($bonus)."</td>";
					$this->showLaporan .= "</tr>";
				}
				
				
				////////////////////////////////////////////////////////////
				$this->showLaporan .= "<tr><td align='center' colspan='5'>Jumlah WO Operator Grafis</td></tr>";
				
				$this->showLaporan .= "<tr><td align='center'  colspan='2'>Nama Karyawan</td><td align='center'>Jumlah WO</td><td align='center'>Total Nota</td><td align='center'>Rata-Rata </td></tr>";
				
				$queryGrafis	=	$this->db->query("
				select 
					m_karyawan.NAMA_KARYAWAN,
					(select count(*) as JUM from t_order where   
					tgl_order BETWEEN '" . date('Y-m-d', strtotime( $this->input->get('mulai'))) . "'
					AND '" . date('Y-m-d', strtotime($this->input->get('akhir'))) . "'  and m_karyawan.id_karyawan=t_order.id_karyawan and status_bayar='L') as TOTAL_WO,
					(select sum(TOTAL_BAYAR) as JUM from t_order where   
					tgl_order BETWEEN '" . date('Y-m-d', strtotime( $this->input->get('mulai'))) . "'
					AND '" . date('Y-m-d', strtotime($this->input->get('akhir'))) . "'  and m_karyawan.id_karyawan=t_order.id_karyawan and status_bayar='L') as TOTAL_NOTA
				from 
					m_karyawan 
				where
					id_kategori_user='3' 
				order by 
					m_karyawan.NAMA_KARYAWAN
				");	
			//	echo $this->db->last_query();
				$this->DataGrafis = $queryGrafis->result();
				$bonus = "0";
				
				$rata="-";
				foreach($this->DataGrafis as $DataGrafis){
					
					if($DataGrafis->TOTAL_WO > 0){					
						$rata= $DataGrafis->TOTAL_NOTA / $DataGrafis->TOTAL_WO;
						$rata=$this->format_rupiah($rata);
					}
					
					$this->showLaporan .= "<tr> <td colspan='2'>".$DataGrafis->NAMA_KARYAWAN."</td>";
					$this->showLaporan .= "<td >".$DataGrafis->TOTAL_WO."</td>";
					$this->showLaporan .= "<td >".$this->format_rupiah($DataGrafis->TOTAL_NOTA)."</td>";
					$this->showLaporan .= "<td >".$rata."</td>";
					$this->showLaporan .= "</tr>";
				}
				
				
				////////////////////////////////////////////////////////////
				$this->showLaporan .= "<tr><td align='center' colspan='5'>Counter Kertas</td></tr>";
				
				$this->showLaporan .= "<tr><td align='center'  colspan='2'>Nama Karyawan</td><td align='center'>Jumlah WO</td><td align='center'>Total Nota</td><td align='center'>Rata-Rata </td></tr>";
				
				$queryKertas	=	$this->db->query("
				select 
					m_kertas.NAMA_KERTAS
				from 
					m_kertas 
				order by 
					m_kertas.NAMA_KERTAS
				");	
			//	echo $this->db->last_query();
				$this->DataKertas = $queryKertas->result();
				$bonus = "0";
				
				$rata="-";
				foreach($this->DataKertas as $DataKertas){
					
				
					$this->showLaporan .= "<tr> <td colspan='2'>".$DataKertas->NAMA_KERTAS."</td>";
					$this->showLaporan .= "<td colspan='3'>Belum tau hitungannya</td>";
					$this->showLaporan .= "</tr>";
				}
				
					////////////////////////////////////////////////////////////
				$this->showLaporan .= "<tr><td align='center' colspan='5'>Kecepatan Layanan</td></tr>";
				
			
				
					$this->showLaporan .= "<tr> <td colspan='5'align='center' >Belum tau maksdu (Fast, extrem ,Desain ...?)</td>";
					$this->showLaporan .= "</tr>";
				
				
			
				$this->showLaporan.= "</tbody></table>";
		}
		$this->template_view->load_view('laporan/laporan_omset_view');
	}
	
	public function kirim_lap_counter(){
		
		$queryProfil = $this->db->query("select * from m_profil ");		
		$this->dataProfil  = $queryProfil->row();	
	
	
			//Load email library
			
		$this->load->library('html2pdf');
	
		//Set folder to save PDF to
		$this->html2pdf->folder('./upload/attachment/');
		
		//Set the filename to save/download as
		$namaToko = str_replace(" ","_",$this->dataProfil->NAMA_TOKO);
		$nama_file = 'Laporan_Counter_'.$namaToko.'_'.time().'.pdf';
		
		//var_dump($nama_file);
		
		$this->html2pdf->filename($nama_file);
		
		//Set the paper defaults
		$this->html2pdf->paper('a4', 'portrait');
		
		
		$data = array(
				'title' => 'PDF Created',
				'message' => 'Hello World!'
			);
		
				$this->load->library('text_barang');
		
				$queryLaporan 	= $this->db->query("select * from v_order where tgl_order_indo = '".$this->input->post('tgl_laporan')."' order by tgl_order , id_order");
				$this->showData = $queryLaporan->result();
				
				$this->showLaporan = "<table class='table table-bordered'>";
				
				if(!$this->showData){					
					$this->showLaporan.= "<tr><td align='center'>Tidak ada data</td></tr>";					
				}
				else{
					foreach($this->showData as $dataOrder){
						$this->showLaporan.= "<tr><td>";
						$this->showLaporan.= "<b>".$dataOrder->JAM_ORDER_INDO;
						
						if($dataOrder->LOG_MEMBER == 'Y'){
							$this->showLaporan.= ", Member";
						}						
						
						$this->showLaporan.= ", WO : ".$dataOrder->NO_WO;
						$this->showLaporan.= ", ".$dataOrder->NAMA_PELANGGAN;
						$this->showLaporan.= ", Status : ".$dataOrder->POSISI_ORDER;
						$this->showLaporan.= ", Total Nota : ".$this->format_rupiah($dataOrder->TOTAL_BAYAR);
						$this->showLaporan.= ", Total Bayar : ".$this->format_rupiah($dataOrder->JUMLAH_BAYAR);
						
						if($dataOrder->STATUS_BAYAR == 'L'){
							$this->showLaporan.= ", LUNAS  </b>";
						}
						else{
							$this->showLaporan.= ", Belum Lunas </b>";
							
						}
						$this->showLaporan.= "<br>";
						$queryBarang 	= $this->db->query("select * from v_barang_order where id_order='".$dataOrder->ID_ORDER."' order by count_barang");
						$this->showDataBarang = $queryBarang->result();
						
						foreach($this->showDataBarang as $dataBarang){
							$this->showLaporan.=$this->text_barang->getTextLaporanCounter($dataBarang->ID_ORDER,$dataBarang->COUNT_BARANG)."<br>";
						}
						
						
						$this->showLaporan.= "<hr></td></tr>";
					}
				}
				
				$this->showLaporan.= "</table>";		
			
		$this->html2pdf->html($this->load->view('pdf/laporan_counter_view', $data, true));

		if($path = $this->html2pdf->create('save')) {	

			
				
			
			 $status = array('status' => true,'nama_file' => $nama_file);
		}
		else{				
			$status = array('status' => false , 'pesan' => "Maaf gagal membuat Laporan , silahkan ulangi beberapa saat lagi !");
		}
		
		echo(json_encode($status));
	
	}
	
	
	public function send_email_lap_counter(){
		
		$queryProfil = $this->db->query("select * from m_profil ");		
		$this->dataProfil  = $queryProfil->row();	
		
			$nama_file_attachment = $this->input->get('nama_file');
		//var_dump($nama_file_attachment);
				$this->load->library('email');	
			
			$config['protocol'] = 'smtp';
			$config['smtp_host'] = 'ssl://smtp.gmail.com'; //change this
			$config['smtp_port'] = '465';
			$config['smtp_user'] = $this->dataProfil->EMAIL_FROM;
			$config['smtp_pass'] = $this->dataProfil->PASS_EMAIL_FROM;
			$config['mailtype'] = 'html';
			$config['charset'] = 'iso-8859-1';
			$config['wordwrap'] = TRUE;
			$config['newline'] = "\r\n";
			
			$this->email->initialize($config);
			$this->email->set_mailtype("html");
			$this->email->set_newline("\r\n");
					
					$this->email->from( $this->dataProfil->EMAIL_FROM,'Laporan Kas');
					
					$emailTujuan = $this->dataProfil->EMAIL_OWNER;
					$this->email->to($emailTujuan);
			
			$this->email->subject('Laporan Counter Toko '.$this->dataProfil->NAMA_TOKO.', tanggal : '.$this->input->post('tgl_laporan'));
			
			$htmlContent = '<h4>Berikut ini kami sampaikan laporan counter Toko '.$this->dataProfil->NAMA_TOKO.' untuk tanggal : '.date('d-m-Y').'</h4>';
			$htmlContent .= '<p>proses kirim laporan ini dilakukan oleh : '. $this->session->userdata('nama_karyawan').'</p>';
			$this->email->message($htmlContent);
			
			$this->email->attach(base_url()."upload/attachment/".$nama_file_attachment);
			
			$this->db->query("
			insert into t_kirim_email
			(
			id_karyawan,jenis_laporan,file_attachment)
			values
			('".$this->session->userdata('id_karyawan')."','Laporan Counter','".$nama_file_attachment."')			
			");
			
		if($this->email->send()){
			$status = array('status' => true);
		}
		else{				
			$status = array('status' => false , 'pesan' => "Maaf gagal mengirim Laporan , silahkan ulangi beberapa saat lagi !");
		}
		
		echo(json_encode($status));
	}
	
	public function cek(){
		$max_time = ini_get("max_execution_time");
echo $max_time;
	}

}
	
	
	

