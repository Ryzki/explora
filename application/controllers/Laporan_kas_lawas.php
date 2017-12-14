<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laporan_kas extends CI_Controller {
		
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

	/**public function index(){		
	
				$queryAkhir	= $this->db->query("
		select 
			t_kirim_email.ID_KARYAWAN,
			date_format(t_kirim_email.TGL_KIRIM, '%d-%m-%Y %h:%i') as TGL_EMAIL_INDO,
			m_karyawan.NAMA_KARYAWAN
		from	
			t_kirim_email,m_karyawan
		where
			t_kirim_email.id_karyawan=m_karyawan.id_karyawan and
			t_kirim_email.JENIS_LAPORAN='Laporan Kas'
		order by TGL_KIRIM desc
		");
		$this->dataAkhir = $queryAkhir->row();
	//	echo $this->db->last_query();
	
		$this->template_view->load_view('laporan/laporan_kas_view');
	}**/
	

	public function index(){		
		
		$this->load->library('text_barang');
		
		if($this->input->get('date')){
				$queryLaporan 	= $this->db->query("select * from v_order where tgl_order_indo = '".$this->input->get('date')."' order by tgl_order , id_order");
				$this->showData = $queryLaporan->result();
				
				$this->showLaporan = "<table class='table table-bordered'>";
				
				$queryJenisBayar 	= $this->db->query("select distinct(JENIS_BAYAR) as JENIS_BAYAR from t_bayar_order where 
				tgl_bayar like '" . date('Y-m-d', strtotime( $this->input->get('date'))) . "%'
				
				");
			$this->showJenisBayar = $queryJenisBayar->result();
		//echo $this->db->last_query();
		
		$this->showLaporan = "";
				
			if(!$this->showData){					
				$this->showLaporan.= "<table class='table table-bordered'><tr><td align='center'>Tidak ada data</td></tr></table>";					
				
				$this->button = '';
				
			}
			else{
				
				
				$this->showLaporan.= " <table class='table table-bordered'>   <thead>  <tr>     <th >No.</th>  <th > Jam Bayar</th>   <th >Nomor WO</th>    <th>Nama Karyawan</th> <th >Jenis Bayar</th><th >Jumlah Bayar</th> </tr>    </thead>       <tbody>";	
				$i=1;
				foreach($this->showJenisBayar as $dataJenisBayar ){
					
					$queryLaporan 	= $this->db->query("select * from v_bayar where  
					tgl_bayar like '" . date('Y-m-d', strtotime( $this->input->get('date'))) . "%'  and jenis_bayar='".$dataJenisBayar->JENIS_BAYAR."'");
					$this->showData = $queryLaporan->result();
			
					
					
					foreach($this->showData as $dataKas){
						
						
						$this->showLaporan.= "<tr><td align=center>".$i."</td><td>".$dataKas->JAM_BAYAR_INDO."</td><td>".$dataKas->NO_WO."</td><td> ".$dataKas->NAMA_KARYAWAN."</td><td>".$dataKas->JENIS_BAYAR."</td><td align=right> ".$this->format_rupiah($dataKas->JUMLAH_KAS)."</td></tr>";							
						$i++;
					}
					
				}
				
				$this->showLaporan.= "</tbody></table><hr>";	
				
				
				
				
				
				// pengkategorian bayar
				
				$jumlahKas= 0;
				$this->showLaporan.= " <table class='table table-bordered'>   <thead>  <tr>    <th >Jenis Bayar</th>    <th >Jumlah </th>   <th align='right'>Jumlah Bayar</th></tr>    </thead>       <tbody>";	
				foreach($this->showJenisBayar as $dataJenisBayar ){
					
						$queryJumlahSatuan 	= $this->db->query("select count(*) as JUM from v_bayar where  tgl_bayar like '" . date('Y-m-d', strtotime( $this->input->get('date'))) . "%'  and jenis_bayar='".$dataJenisBayar->JENIS_BAYAR."'    ");
						$dataJumlahSatuan = $queryJumlahSatuan->row();
						
						$queryJumlahKas 	= $this->db->query("select sum(JUMLAH_KAS) as JUM from v_bayar where  tgl_bayar like '" . date('Y-m-d', strtotime( $this->input->get('date'))) . "%'  and jenis_bayar='".$dataJenisBayar->JENIS_BAYAR."'    ");
						$dataJumlahKas = $queryJumlahKas->row();
						
						$this->showLaporan.= "<tr><td>".$dataJenisBayar->JENIS_BAYAR."</td><td>".$dataJumlahSatuan->JUM."</td><td>".$this->format_rupiah($dataJumlahKas->JUM)."</td></tr>";		
							
						$jumlahKas	+= $dataJumlahKas->JUM;
				}
					$this->showLaporan.= "<tr><td colspan='2' align='center'>Jumlah</td><td ><b>".$this->format_rupiah($jumlahKas)."</b></td></tr>";		
				$this->showLaporan.= "</tbody></table>";	
				
				
				
				
				
				
				
				
				
				
				
				$this->showLaporan.= "<hr>";	
				
							
				
				/////////// barang yang dicancel				
				//$this->showDataCancelBarang = null;
				$queryCancelBarang	= $this->db->query("select * from v_barang_order_cancel where tgl_cancel_indo = '".$this->input->get('date')."' order by STATUS_BAYAR_CANCEL");
				$this->showDataCancelBarang = $queryCancelBarang->result();
				
				if($this->showDataCancelBarang){
					$this->showLaporan.="<h4>Barang yang Void tanggal ".$this->input->get('date')."</h4><br>";
				}
				
				$this->showLaporan.= " <table class='table table-bordered'>   <thead>  <tr>     <th >No.</th> <th >Nomor WO</th>    <th >Tgl  Jam Cancel Barang</th>   <th >Status Bayar Saat Cancel </th> <th >Harga Barang </th></tr>    </thead>       <tbody>";	
				$ii=1;
				$jumlahUangVoid = 0;
				foreach($this->showDataCancelBarang as $dataCancelBarang ){
					
				
						
						$this->showLaporan.= "<tr><td align=center>".$ii."</td><td>".$dataCancelBarang->no_wo."</td><td>".$dataCancelBarang->TGL_CANCEL_INDO." ".$dataCancelBarang->JAM_CANCEL_INDO."</td><td>".$dataCancelBarang->STATUS_BAYAR_CANCEL."</td><td align=right> ".$this->format_rupiah($dataCancelBarang->TOTAL_HARGA)."</td></tr>";							
						$ii++;
						
						$jumlahUangVoid += $dataCancelBarang->TOTAL_HARGA;
				}
				$this->showLaporan.= "<tr><td align=center colspan='4'>Jumlah</td><td align=right> <b>".$this->format_rupiah($jumlahUangVoid )." </b></td></tr>";	
				$this->showLaporan.= "</tbody></table>";	
				
				
				

				if($this->showDataCancelBarang){
					$this->showLaporan.= "Keterangan : BB = Belum Bayar, BL = Belum Lunas, L = Lunas";
				}
				
				
				
				$this->button = '<div class="col-sm-2">
					<a href="'.base_url().'cetak/laporan_kas/?date='.$this->input->get('date').'" target="_blank"><span  class="btn btn-success"><i class="fa fa-print"></i> Cetak Laporan</span></a>
				</div>';
				
				
				
			}
			
				
		}
		else{
			$this->button = '';
		}
		
		$this->template_view->load_view('laporan/laporan_kas_view');
	}
	
	public function kirim_laporan_kas(){
		
		$queryProfil = $this->db->query("select * from m_profil ");		
		$this->dataProfil  = $queryProfil->row();	
	
		$queryFlag 	= $this->db->query("select FLAG_KAS_BAYAR from m_profil");
		$this->showFlag = $queryFlag->row();
	
	

		//Load email library
			
		$this->load->library('html2pdf');
	
		//Set folder to save PDF to
		$this->html2pdf->folder('./upload/attachment/');
		
		//Set the filename to save/download as
		
		$namaToko = str_replace(" ","_",$this->dataProfil->NAMA_TOKO);
		$nama_file = 'Laporan_Kas_Toko_'.$namaToko.'_'.date('d-m-Y').'_'.$this->showFlag->FLAG_KAS_BAYAR.'.pdf';
		
		//var_dump($nama_file);
		
		$this->html2pdf->filename($nama_file);
		
		//Set the paper defaults
		$this->html2pdf->paper('a4', 'portrait');
		
		
		$data = array(
				'title' => 'PDF Created',
				'message' => 'Hello World!'
			);
		
		
		
		$queryJenisBayar 	= $this->db->query("select distinct(JENIS_BAYAR) as JENIS_BAYAR from t_bayar_order where id_t_bayar_order > '".$this->showFlag->FLAG_KAS_BAYAR."'");
		$this->showJenisBayar = $queryJenisBayar->result();
		
		
		$this->showLaporan = "";
				
	
			foreach($this->showJenisBayar as $dataJenisBayar ){
				
				$queryLaporan 	= $this->db->query("select * from v_bayar where id_t_bayar_order > '".$this->showFlag->FLAG_KAS_BAYAR."'  and jenis_bayar='".$dataJenisBayar->JENIS_BAYAR."'");
				$this->showData = $queryLaporan->result();
		
				foreach($this->showData as $dataKas){
					$this->showLaporan.= "<table>";	
					
					$this->showLaporan.= "<tr><td>".$dataKas->JAM_BAYAR_INDO."</td><td>, WO : ".$dataKas->NO_WO."</td><td>, ".$dataKas->NAMA_KARYAWAN."</td></tr>";	
					$this->showLaporan.= "<tr><td colspan='2'>".$dataKas->JENIS_BAYAR."</td><td>, ".$this->format_rupiah($dataKas->JUMLAH_BAYAR)."</td></tr>";	
					
					$this->showLaporan.= "</table>";	
					
		
				}
				$this->showLaporan.= "<hr>";	
			}
		
		
			
			
		$this->html2pdf->html($this->load->view('pdf/laporan_kas_view', $data, true));
			
		if( $this->html2pdf->create('save')) {				
			$status = array('status' => true,'nama_file' => $nama_file);			
		}
		else{				
			$status = array('status' => false , 'pesan' => "Maaf gagal membuat Laporan , silahkan ulangi beberapa saat lagi !");
		}
		echo(json_encode($status));
	}
		
		
			public function send_email_lap_kas(){
		
			
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
					
					$this->email->subject('Laporan Kas Toko '.$this->dataProfil->NAMA_TOKO.', tanggal : '.$this->input->post('tgl_laporan'));
					
					$htmlContent = '<h4>Berikut ini kami sampaikan laporan Kas Toko '.$this->dataProfil->NAMA_TOKO.' untuk tanggal : '.$this->input->get('tgl_laporan').'</h4>';
					$htmlContent .= '<p>proses kirim laporan ini dilakukan oleh : '. $this->session->userdata('nama_karyawan').'</p>';
					$this->email->message($htmlContent);
					
					$this->email->attach(base_url()."upload/attachment/".$nama_file_attachment);
					
				$this->email->send();
					
			//	if($this->email->send()){
					
					$this->db->query("
								insert into t_kirim_email
							(
								id_karyawan,jenis_laporan,file_attachment)
							values
								('".$this->session->userdata('id_karyawan')."','Laporan Kas','".$nama_file_attachment."')			
						");
						
						//echo $this->email->print_debugger();
						
						$queryMax 	= $this->db->query("select max(ID_T_BAYAR_ORDER) as MAX  from t_bayar_order");
						$this->showMax = $queryMax->row();
						
						$this->db->query("
						update m_profil set FLAG_KAS_BAYAR='".$this->showMax->MAX."'
						");
					
					$status = array('status' => true);
			//	}
			//	else{				
				//	$status = array('status' => false , 'pesan' => "Maaf gagal mengirim Laporan , silahkan ulangi beberapa saat lagi !");
			//	}
				
				echo(json_encode($status));
			}
		
		
	
	
}
