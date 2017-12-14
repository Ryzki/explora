<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laporan_kas extends CI_Controller {
		
	public function __construct() {
		parent::__construct();
		
		$this->load->model('t_tutup_kas_model');
	} 
	
	function format_rupiah($angka){
		$rupiah=number_format($angka,0,',','.');
		return "Rp. ".$rupiah;
	}

	public function index(){		
	
		$like 		= null;
		$urlSearch 	= null;
		
		if($this->input->get('field')){
			$like = array($_GET['field'] => $_GET['keyword']);
			$urlSearch = "?field=".$_GET['field']."&keyword=".$_GET['keyword'];
		}		
		
		$this->load->library('pagination');	
		
		$config['base_url'] 	= base_url().'laporan_kas/index'.$urlSearch;
		$this->jumlahData 		= $this->t_tutup_kas_model->getCount("",$like);		
		$config['total_rows'] 	= $this->jumlahData;		
		$config['per_page'] 	= 25;		
		
		$this->pagination->initialize($config);	
		$this->showData = $this->t_tutup_kas_model->showData("",$like,'',$config['per_page'],$this->input->get('per_page'));
		$this->pagination->initialize($config);
	//	echo $this->db->last_query();
	
		$this->template_view->load_view('laporan/laporan_kas_view');
	}
	
	public function tutup(){	
	
		$queryAkhir = $this->db->query("select max(id_t_bayar_order) as max from t_bayar_order");
		$dataAkhir = 	$queryAkhir->row();
		$akhir = $dataAkhir->max;
		
		$queryAwal = $this->db->query("select max(id_t_bayar_order_akhir) as max from t_tutup_kas");
		$dataAwal = 	$queryAwal->row();
		$mulai = $dataAwal->max + 1;
		
		$this->db->query("
		insert into
			t_tutup_kas
		(
		id_t_bayar_order_mulai,
		id_t_bayar_order_akhir,
		id_karyawan,
		shift,
		keterangan
		)
		values
		(
		'".$mulai."',
		'".$akhir."',
		'".$this->session->userdata('id_karyawan')."',
		'".$this->input->post('shift')."',
		'".$this->input->post('ket')."'
		)
		
		");
		
		redirect("laporan_kas");
	}
	
	public function detail(){		
		
		$this->load->library('text_barang');

		
		$queryCekTutup_kas 	= $this->db->query("select * from t_tutup_kas where id_tutup_kas='".$this->input->get('id')."'");
		$this->dataTutupKas = $queryCekTutup_kas->row();
		
		$awal = $this->dataTutupKas->ID_T_BAYAR_ORDER_MULAI;
		$akhir = $this->dataTutupKas->ID_T_BAYAR_ORDER_AKHIR;


		
		$this->showLaporan = "<table class='table table-bordered'>";
		
		$queryJenisBayar 	= $this->db->query("select distinct(JENIS_BAYAR) as JENIS_BAYAR from t_bayar_order  
		where  id_t_bayar_order BETWEEN   '".$awal."'   and '".$akhir."'  
		
		");
		$this->showJenisBayar = $queryJenisBayar->result();
		//echo $this->db->last_query();
		
		$this->showLaporan = "";
				

				
				
				$this->showLaporan.= " <table class='table table-bordered'>   <thead>  <tr>     <th >No.</th>  <th > Jam Bayar</th>   <th >Nomor WO</th>    <th>Nama Karyawan</th> <th >Jenis Bayar</th><th >Jumlah Bayar</th> </tr>    </thead>       <tbody>";	
				$i=1;
				foreach($this->showJenisBayar as $dataJenisBayar ){
					
					$queryLaporan 	= $this->db->query("select * from v_bayar where  id_t_bayar_order BETWEEN   '".$awal."'   and '".$akhir."'    and jenis_bayar='".$dataJenisBayar->JENIS_BAYAR."'");
					$this->showData = $queryLaporan->result();
			
					
					
					foreach($this->showData as $dataKas){
						
						
						$this->showLaporan.= "<tr><td align=center>".$i."</td><td>".$dataKas->TGL_BAYAR_INDO."</td><td>".$dataKas->NO_WO."</td><td> ".$dataKas->NAMA_KARYAWAN."</td><td>".$dataKas->JENIS_BAYAR."</td><td align=right> ".$this->format_rupiah($dataKas->JUMLAH_KAS)."</td></tr>";							
						$i++;
					}
					
				}
				
				$this->showLaporan.= "</tbody></table><hr>";	
				
				
				
				
				
				// pengkategorian bayar
				
				$jumlahKas= 0;
				$this->showLaporan.= " <table class='table table-bordered'>   <thead>  <tr>    <th >Jenis Bayar</th>    <th >Jumlah </th>   <th align='right'>Jumlah Bayar</th></tr>    </thead>       <tbody>";	
				foreach($this->showJenisBayar as $dataJenisBayar ){
					
						$queryJumlahSatuan 	= $this->db->query("select count(*) as JUM from v_bayar where  id_t_bayar_order BETWEEN   '".$awal."'   and '".$akhir."'   and jenis_bayar='".$dataJenisBayar->JENIS_BAYAR."'    ");
						$dataJumlahSatuan = $queryJumlahSatuan->row();
						
						$queryJumlahKas 	= $this->db->query("select sum(JUMLAH_KAS) as JUM from v_bayar where  id_t_bayar_order BETWEEN   '".$awal."'   and '".$akhir."'   and jenis_bayar='".$dataJenisBayar->JENIS_BAYAR."'    ");
						$dataJumlahKas = $queryJumlahKas->row();
						
						$this->showLaporan.= "<tr><td>".$dataJenisBayar->JENIS_BAYAR."</td><td>".$dataJumlahSatuan->JUM."</td><td>".$this->format_rupiah($dataJumlahKas->JUM)."</td></tr>";		
							
						$jumlahKas	+= $dataJumlahKas->JUM;
				}
					$this->showLaporan.= "<tr><td colspan='2' align='center'>Jumlah</td><td ><b>".$this->format_rupiah($jumlahKas)."</b></td></tr>";		
				$this->showLaporan.= "</tbody></table>";	
				
				
				$this->showLaporan.= "<hr>";	
				
				
				$queryCekMulaiAkhir = $this->db->query("
				select
					t_tutup_kas.id_tutup_kas,
					(select b.tgl_bayar from t_bayar_order b where b.id_t_bayar_order=t_tutup_kas.id_t_bayar_order_mulai) as tgl_mulai,
					(select b.tgl_bayar  from t_bayar_order b where b.id_t_bayar_order=t_tutup_kas.id_t_bayar_order_akhir) as tgl_akhir
				from
					t_tutup_kas
				where
					t_tutup_kas.id_tutup_kas='".$this->input->get('id')."'
				");
				$dataCekMulaiAkhir = $queryCekMulaiAkhir ->row();
				
				
				
				
				
				//var_dump($dataCekMulaiAkhir);
				

				/////////// barang yang dicancel				
				//$this->showDataCancelBarang = null;
				$queryCancelBarang	= $this->db->query("select * from v_barang_order_cancel where tgl_cancel between  '".$dataCekMulaiAkhir->tgl_mulai."'  and   '".$dataCekMulaiAkhir->tgl_akhir."' order by STATUS_BAYAR_CANCEL");
				$this->showDataCancelBarang = $queryCancelBarang->result();
				//echo $this->db->last_query();
				
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
				
				

		
		$this->template_view->load_view('laporan/laporan_kas_detail_view');
	}
	
}
