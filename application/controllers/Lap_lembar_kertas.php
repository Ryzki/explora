<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lap_lembar_kertas extends CI_Controller {
		
	public function __construct() {
		parent::__construct();
		
		$this->load->model('t_order_model');
		$this->load->model('t_barang_order_model');
		$this->load->model('t_log_order_model');
		$this->load->model('t_bayar_order_model');
	} 

	public function index(){		
		
		$this->load->library('text_barang');
		
		if($this->input->get('date')){
				$queryLaporan 	= $this->db->query("select distinct(a.id_kertas) as ID_KERTAS,a.NAMA_KERTAS from v_barang_order a where a.tgl_order_indo = '".$this->input->get('date')."' order by a.id_kertas");
				$this->laporan="";
				
				$no=1;
				foreach( $queryLaporan->result() as $lap ) {
					$this->laporan .= "<tr><td align='center'>".$no.".</td><td>".$lap->NAMA_KERTAS."</td>";
					
					$querySatuSisi 	= $this->db->query("select sum(a.JML_KLIK) as JUM from v_barang_order a where a.tgl_order_indo = '".$this->input->get('date')."' and id_kertas = '".$lap->ID_KERTAS."' and JML_SISI='1' ");
					$dataSatuSisi = $querySatuSisi->row();
					
					$queryDuaSisi 	= $this->db->query("select sum(a.JML_KLIK) as JUM from v_barang_order a where a.tgl_order_indo = '".$this->input->get('date')."' and id_kertas = '".$lap->ID_KERTAS."' and JML_SISI='2' ");
					$dataDuaSisi = $queryDuaSisi->row();
					
					$jumlahDua = ceil( $dataDuaSisi->JUM/2 );
					$jumlah = $dataSatuSisi->JUM + $jumlahDua;
					
					
					$this->laporan .= "<td >".$jumlah." Lembar</td></tr>";
					$no++;
				}	
				
				if(!$queryLaporan->result()){
					$this->laporan .= "<tr><td align='center' colspan='5'>Tidak ada Data.</td></tr>";
					
				}
				

		}
		
		
		//var_dump($this->laporan);
		$this->template_view->load_view('laporan/laporan_lembar_kertas_view');
	}
	
	
	
}
