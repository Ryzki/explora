<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lap_counter extends CI_Controller {
		
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
		
		if($this->input->get('date')){
				$queryLaporan 	= $this->db->query("select * from v_order where tgl_order_indo = '".$this->input->get('date')."' order by tgl_order , id_order");
				$this->showData = $queryLaporan->result();
				
				$this->showLaporan = "<table class='table table-bordered'>";
				
				if(!$this->showData){					
					$this->showLaporan.= "<tr><td align='center'>Tidak ada data</td></tr>";		
					$this->button = '';					
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
						
						
						$this->showLaporan.= "</td></tr>";
					}
					
					
						$this->button = '<div class="col-sm-2">
						<a href="'.base_url().'cetak/laporan_counter/?date='.$this->input->get('date').'" target="_blank"><span  class="btn btn-success"><i class="fa fa-print"></i> Cetak Laporan</span></a>
					</div>';
				}
				
				$this->showLaporan.= "</table>";
		}
		else{
			$this->button = '';
		}
		$this->template_view->load_view('laporan/laporan_counter_view');
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
	
	
	

