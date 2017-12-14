<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cetak extends CI_Controller {
		
	public function __construct() {
		parent::__construct();
		
		$this->load->model('t_order_model');
		$this->load->model('t_barang_order_model');
		$this->load->model('t_log_order_model');
		$this->load->model('t_bayar_order_model');
	} 
	public function format_rupiah($angka){
		$rupiah=number_format($angka,0,',','.');
		return "Rp. ".$rupiah;
	}
	
	public function nota($IdPrimaryKey){		
		
		$this->load->library('text_barang');
		
		$where = array('id_order' => $IdPrimaryKey);
		$this->oldData = $this->t_order_model->getData($where);		
		
		$queryBarang = $this->db->query("select * from v_barang_order where id_order = '".$IdPrimaryKey."' order by count_barang");		
		$this->dataBarang  = $queryBarang->result();	
		
		$queryBayar = $this->db->query("select a.*,DATE_FORMAT(a.tgl_bayar, '%d-%m-%Y %H:%i') as tgl_bayar_indo from t_bayar_order a where a.id_order = '".$IdPrimaryKey."' order by a.id_t_bayar_order");		
		$this->dataBayar  = $queryBayar->result();	

		$queryKeterangan = $this->db->query("select * from keterangan_nota order by id_keterangan");		
		$this->dataKeterangan  = $queryKeterangan->result();			
					
		$this->logAlur  = $this->t_log_order_model->showData($where);	
		
		$queryUangBayar = $this->db->query("select * from t_bayar_order a where a.id_order = '".$IdPrimaryKey."' order by a.id_t_bayar_order desc");		
		$this->dataUangBayar  = $queryUangBayar->row();
		
		
		if($this->oldData){
			$this->load->view('cetak/nota_view');
		}
		else{
			redirect($this->uri->segment('1'));
		}		
	
	}
	
	public function struk($IdPrimaryKey){
		
		
		$this->load->library('text_barang');
		
		$where = array('id_order' => $IdPrimaryKey);
		$this->oldData = $this->t_order_model->getData($where);		
		
		$queryKeterangan = $this->db->query("select * from keterangan_nota order by id_keterangan");		
		$this->dataKeterangan  = $queryKeterangan->result();			
		
		
		
		
		
		
		
		
		$queryBayar = $this->db->query("select a.*,DATE_FORMAT(a.tgl_bayar, '%d-%m-%Y %H:%i') as tgl_bayar_indo from t_bayar_order a where a.id_order = '".$IdPrimaryKey."' order by a.id_t_bayar_order");		
		$this->dataBayar  = $queryBayar->result();		
					
		$this->logAlur  = $this->t_log_order_model->showData($where);	
		
		$queryUangBayar = $this->db->query("select * from t_bayar_order a where a.id_order = '".$IdPrimaryKey."' order by a.id_t_bayar_order desc");		
		$this->dataUangBayar  = $queryUangBayar->row();
		
		$queryTotalBayarBelumLunas = $this->db->query("select sum(a.JUMLAH_BAYAR) as JUMLAH from t_bayar_order a where a.id_order = '".$IdPrimaryKey."' ");	
		$this->dataTotalBayarBelumLunas  = $queryTotalBayarBelumLunas->row();
		
		$queryJenisBayarBelumLunas = $this->db->query("select a.jenis_bayar  from t_bayar_order a where a.id_order = '".$IdPrimaryKey."'  order by id_t_bayar_order desc");	
		$this->dataJenisBayarBelumLunas  = $queryJenisBayarBelumLunas->row();
		
		$queryUangBarang = $this->db->query("select sum(a.TOTAL_HARGA) as JUMLAH from t_barang_order a where a.id_order = '".$IdPrimaryKey."' and id_karyawan_cancel='0'");	
		$this->dataUangBarang  = $queryUangBarang->row();
		
		$this->cetak="";
		
		
		$queryDisticntBarang = $this->db->query("select distinct(ID_PROFIL) as ID_PROFIL from v_barang_order where id_order = '".$IdPrimaryKey."' order by count_barang");		
		$this->dataDisticntBarang  = $queryDisticntBarang->result();	
		
		$totalHarga= 0;
		foreach($this->dataDisticntBarang as $dataDistinct){
			
			$queryProfil = $this->db->query("select * from m_profil where id_profil='".$dataDistinct->ID_PROFIL."'");	
			$this->dataProfil  = $queryProfil->row();
			
			$this->cetak .='
			<center ><b style="font-size:11px;">'.$this->dataProfil->NAMA_TOKO .'</b></center>
			<center >'.$this->dataProfil->ALAMAT_TOKO .'</center>
			<center >Telp : '. $this->dataProfil->TELP_TOKO.'</center>
			<center >'.$this->dataProfil->WEBSITE .'</center>
			<hr>
			<table width="100%" cellpadding="3" style="font-size:11px;">	
				<tr>		
					<td align="">No WO : <b>'.$this->oldData->NO_WO.'</b></td>
				</tr>
				<tr>		
					<td >Tanggal : '. $this->oldData->TGL_ORDER.'</td>
				</tr>	
			</table>
			<hr>';
			
			$queryBarang = $this->db->query("select * from v_barang_order where id_order = '".$IdPrimaryKey."'  and  id_profil='".$dataDistinct->ID_PROFIL."' order by count_barang");		
			$this->dataBarang  = $queryBarang->result();	
			
			$subTotal = 0;
			$totalHarga=0;
			
			$this->cetak .='<table  width="100%" cellpadding="3" style="font-size:11px;">';
			foreach(	$this->dataBarang as $showBarang){
				$this->cetak .= '<tr>
				<td colspan="2">'. $this->text_barang->getTextStruk($showBarang->ID_ORDER,$showBarang->COUNT_BARANG).'</td>
				</tr>
				<tr>
				<td>'. $showBarang->JUMLAH_QTY.' x '. $this->format_rupiah($showBarang->HARGA_SATUAN).'</td>
				<td align="right" width="50%">'. $this->format_rupiah($showBarang->TOTAL_HARGA).'</td>
				</tr>';
			
				$subTotal += $showBarang->TOTAL_HARGA;
			}
			
				$this->cetak .='</table>';
			
			$this->cetak .= '<hr>
			<table  width="100%" cellpadding="3" style="font-size:11px;">		
				<tr>
					<td >Sub Total</td>
					<td  width="50%" align="right">'.$this->format_rupiah($subTotal).'</td>
				</tr>	
	
			</table><hr>';
			$totalHarga += $subTotal;
		}
		
		
		$this->cetak .= '
			<table  width="100%" cellpadding="3" style="font-size:11px;">		
				<tr>
					<td >Total</td>
					<td  width="50%" align="right"  >'.$this->format_rupiah($this->dataUangBarang->JUMLAH).'</td>
					
				</tr>	
				<tr>
					<td >Discount</td>
					<td  width="50%" align="right"  >'.$this->format_rupiah($this->oldData->DISCOUNT).'</td>
					
				</tr>					
				<tr>
					<td >Grand Total</td>
					<td  width="50%" align="right">'. $this->format_rupiah($this->oldData->TOTAL_BAYAR).'</td>
				</tr>
			</table>';
			
			
		if($this->oldData){
			$this->load->view('cetak/struk_view');
		}
		else{
			redirect($this->uri->segment('1'));
		}		
	
	}
	
	
	public function tanda_bayar($IdPrimaryKey){
		
		
		$this->load->library('text_barang');
		
		$where = array('id_order' => $IdPrimaryKey);
		$this->oldData = $this->t_order_model->getData($where);		
		
		$queryKeterangan = $this->db->query("select * from keterangan_nota order by id_keterangan");		
		$this->dataKeterangan  = $queryKeterangan->result();			
		
		
		$queryBarang = $this->db->query("select * from v_barang_order where id_order = '".$IdPrimaryKey."' order by count_barang");		
		$this->dataBarang  = $queryBarang->result();	
		
		$queryBayar = $this->db->query("select a.*,DATE_FORMAT(a.tgl_bayar, '%d-%m-%Y %H:%i') as tgl_bayar_indo from t_bayar_order a where a.id_order = '".$IdPrimaryKey."' order by a.id_t_bayar_order");		
		$this->dataBayar  = $queryBayar->result();		
					
		$this->logAlur  = $this->t_log_order_model->showData($where);	
		
		$queryUangBayar = $this->db->query("select * from t_bayar_order a where a.id_order = '".$IdPrimaryKey."' order by a.id_t_bayar_order desc");		
		$this->dataUangBayar  = $queryUangBayar->row();
		
		$queryTotalBayarBelumLunas = $this->db->query("select sum(a.JUMLAH_BAYAR) as JUMLAH from t_bayar_order a where a.id_order = '".$IdPrimaryKey."' ");	
		$this->dataTotalBayarBelumLunas  = $queryTotalBayarBelumLunas->row();
		
		$queryProfil = $this->db->query("select * from m_profil");	
		$this->dataProfil  = $queryProfil->row();
		
		$queryBayar = $this->db->query("select * from v_bayar where id_order='".$IdPrimaryKey."' order by tgl_bayar");
		$this->dataBayar  = $queryBayar->result();
		
		$queryUangBarang = $this->db->query("select sum(a.TOTAL_HARGA) as JUMLAH from t_barang_order a where a.id_order = '".$IdPrimaryKey."' and id_karyawan_cancel='0'");	
		$this->dataUangBarang  = $queryUangBarang->row();
		
				$this->cetak="";
		
		
		$queryDisticntBarang = $this->db->query("select distinct(ID_PROFIL) as ID_PROFIL from v_barang_order where id_order = '".$IdPrimaryKey."' order by count_barang");		
		$this->dataDisticntBarang  = $queryDisticntBarang->result();	
		foreach($this->dataDisticntBarang as $dataDistinct){
			
			$queryProfil = $this->db->query("select * from m_profil where id_profil='".$dataDistinct->ID_PROFIL."'");	
			$this->dataProfil  = $queryProfil->row();
			
			$this->cetak .='
			<center ><b style="font-size:11px;">'.$this->dataProfil->NAMA_TOKO .'</b></center>
			<center >'.$this->dataProfil->ALAMAT_TOKO .'<br></center>
			<center >Telp : '. $this->dataProfil->TELP_TOKO.'<br></center>
			<center >'.$this->dataProfil->WEBSITE .'<br></center>
			<hr>
			<table width="100%" cellpadding="3" style="font-size:11px;">	
				<tr>		
					<td align="">No WO : <b>'.$this->oldData->NO_WO.'</b></td>
				</tr>
				<tr>		
					<td >Tanggal : '. $this->oldData->TGL_ORDER.'</td>
				</tr>	
			</table>
			<hr>';
			
			$queryBarang = $this->db->query("select * from v_barang_order where id_order = '".$IdPrimaryKey."'  and  id_profil='".$dataDistinct->ID_PROFIL."' order by count_barang");		
			$this->dataBarang  = $queryBarang->result();	
			
			$subTotal = 0;
			$totalHarga=0;
			
			$this->cetak .='<table  width="100%" cellpadding="3" style="font-size:11px;">';
			foreach(	$this->dataBarang as $showBarang){
				$this->cetak .= '<tr>
				<td colspan="2">'. $this->text_barang->getTextStruk($showBarang->ID_ORDER,$showBarang->COUNT_BARANG).'</td>
				</tr>
				<tr>
				<td>'. $showBarang->JUMLAH_QTY.' x '. $this->format_rupiah($showBarang->HARGA_SATUAN).'</td>
				<td align="right" width="50%">'. $this->format_rupiah($showBarang->TOTAL_HARGA).'</td>
				</tr>';
			
				$subTotal += $showBarang->TOTAL_HARGA;
			}
			
				$this->cetak .='</table>';
			
			$this->cetak .= '<hr>
			<table  width="100%" cellpadding="3" style="font-size:11px;">		
				<tr>
					<td >Sub Total</td>
					<td  width="50%" align="right">'.$this->format_rupiah($subTotal).'</td>
				</tr>	
	
			</table><hr>';
		}
		
		
		$this->cetak .= '
			<table  width="100%" cellpadding="3" style="font-size:11px;">		
				<tr>
					<td >Total</td>
					<td  width="50%" align="right"  >'.$this->format_rupiah($this->dataUangBarang->JUMLAH).'</td>
					
				</tr>	
				<tr>
					<td >Discount</td>
					<td  width="50%" align="right"  >'.$this->format_rupiah($this->oldData->DISCOUNT).'</td>
					
				</tr>					
				<tr>
					<td >Grand Total</td>
					<td  width="50%" align="right">'. $this->format_rupiah($this->oldData->TOTAL_BAYAR).'</td>
				</tr>
			</table>';
		
		if($this->oldData){
			$this->load->view('cetak/tanda_bayar_view');
		}
		else{
			redirect($this->uri->segment('1'));
		}		
	
	}
	
	public function antrian($IdPrimaryKey){
		
		
		$where = array('id_order' => $IdPrimaryKey);
		$this->oldData = $this->t_order_model->getData($where);		
		
		
		
		if($this->oldData){
			$this->load->view('cetak/antrian_view');
		}
		else{
			redirect($this->uri->segment('1'));
		}		
	
	}
	
	public function job($IdPrimaryKey){
		
		$this->load->library('text_job');
		
		$where = array('id_order' => $IdPrimaryKey);
		$this->oldData = $this->t_order_model->getData($where);		
		
		//var_dump($this->oldData );
		$queryKeterangan = $this->db->query("select * from keterangan_wo order by id_keterangan");		
		$this->dataKeterangan  = $queryKeterangan->result();			
		
		$dataOperator = $this->db->query( "
		select 
			a.ID_ORDER,
			date_format(a.TGL_LOG_ORDER,'%d-%m-%Y') as TGL_LOG_ORDER,
			date_format(a.TGL_LOG_ORDER,'%h:%i') as JAM_LOG_ORDER,
			b.NAMA_KARYAWAN
			
		from
			t_log_order a,m_karyawan b
		where
			a.id_karyawan=b.id_karyawan and 
			a.id_order='".$IdPrimaryKey."' and
			a.ke='KASIR'
		");	
		$this->dataOperator = $dataOperator->row();
		
		//var_dump($this->oldData);
		
		$queryBarang = $this->db->query("select * from v_barang_order where id_order = '".$IdPrimaryKey."' and id_produk!='1' order by count_barang");		
		$this->dataBarang  = $queryBarang->result();	
		
		
		$this->ringkasan="";
		
		$queryRingkasanOudoortIndoor =  $this->db->query("select distinct(id_kertas) as id_kertas,nama_kertas from v_barang_order_complete where id_order = '".$IdPrimaryKey."' and kategori_produk='2' order by count_barang")	;
		$this->dataRingkasanOudoortIndoor = $queryRingkasanOudoortIndoor->result();
		
		foreach($this->dataRingkasanOudoortIndoor as $dataRingkasOudoortIndoor){
			$queryQty =  $this->db->query("select sum(JUMLAH_QTY) as JUMLAH from v_barang_order_complete where id_order = '".$IdPrimaryKey."' and id_kertas = '". $dataRingkasOudoortIndoor->id_kertas."' ")	;
			$this->dataQty= $queryQty->row();
			
			$queryNamaProduk =  $this->db->query("select NAMA_PRODUK from v_barang_order_complete where id_order = '".$IdPrimaryKey."' and id_kertas = '". $dataRingkasOudoortIndoor->id_kertas."' ")	;
			$this->dataNamaProduk= $queryNamaProduk->row();
			
			$this->ringkasan .= "<b>".$this->dataNamaProduk->NAMA_PRODUK ." / " .$dataRingkasOudoortIndoor->nama_kertas." = ".$this->dataQty->JUMLAH."</b><br>";
		}
		
		
		
		$queryRingkasanDigitalPrint =  $this->db->query("select distinct(id_kertas) as id_kertas,nama_kertas from v_barang_order_complete where id_order = '".$IdPrimaryKey."' and kategori_produk='1' order by count_barang")	;
		$this->dataRingkasanDigitalPrint = $queryRingkasanDigitalPrint->result();
		
		foreach($this->dataRingkasanDigitalPrint as $dataRingkasDigitalPrint){
			
			$queryJumlahKlik =  $this->db->query("select sum(jml_klik ) as JUMLAH from v_barang_order_complete where id_order = '".$IdPrimaryKey."' and id_kertas = '". $dataRingkasDigitalPrint->id_kertas."' ")	;
			$this->dataJumlahKlik= $queryJumlahKlik->row();			
			
			$this->ringkasan .=  "<b>".$dataRingkasDigitalPrint->nama_kertas." = ".$this->dataJumlahKlik->JUMLAH." Klik <b><br>";
		}
				
					
		$this->logAlur  = $this->t_log_order_model->showData($where);	
		
		if($this->oldData){
			$this->load->view('cetak/job_view');
		}
		else{
			redirect($this->uri->segment('1'));
		}		
	}
	
	public function laporan_counter(){		
		
		$this->load->library('text_barang');
		
				$queryLaporan 	= $this->db->query("select * from v_order where tgl_order_indo = '".$this->input->get('date')."' order by tgl_order , id_order");
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
						
						
						$this->showLaporan.= "</td></tr>";
					}
				}
				
				$this->showLaporan.= "</table>";
		
		$this->load->view('cetak/laporan_counter_view');
	}
	
	public function laporan_kas(){
		
		$queryCekTutup_kas 	= $this->db->query("select  t_tutup_kas.ID_TUTUP_KAS, t_tutup_kas.ID_T_BAYAR_ORDER_MULAI,t_tutup_kas.ID_T_BAYAR_ORDER_AKHIR,t_tutup_kas.SHIFT,t_tutup_kas.KETERANGAN,date_format(t_tutup_kas.TGL_TUTUP_KAS,'%d-%m-%Y %H:%i')  as TGL_TUTUP_KAS from t_tutup_kas where t_tutup_kas.id_tutup_kas='".$this->input->get('id')."'");
		$this->dataTutupKas = $queryCekTutup_kas->row();
		
		$awal = $this->dataTutupKas->ID_T_BAYAR_ORDER_MULAI;
		$akhir = $this->dataTutupKas->ID_T_BAYAR_ORDER_AKHIR;

		
		
		
		
		
		
		$queryJenisBayar 	= $this->db->query("select distinct(JENIS_BAYAR) as JENIS_BAYAR from t_bayar_order  
		where  id_t_bayar_order BETWEEN   '".$awal."'   and '".$akhir."'  
		
		");
		$this->showJenisBayar = $queryJenisBayar->result();
		//echo $this->db->last_query();
		
		$this->showLaporan = "";	
				
		$this->showLaporan.= " <table width='100%' cellpadding='0' >";	
		$i=1;
		foreach($this->showJenisBayar as $dataJenisBayar ){
					
			$queryLaporan 	= $this->db->query("select * from v_bayar where  id_t_bayar_order BETWEEN   '".$awal."'   and '".$akhir."'    and jenis_bayar='".$dataJenisBayar->JENIS_BAYAR."'");
			$this->showData = $queryLaporan->result();				
			
			foreach($this->showData as $dataKas){
				
				
				$this->showLaporan.= "<tr><td>".$dataKas->JAM_BAYAR_INDO."</td><td>NO WO : ".$dataKas->NO_WO."</td><td> ".$dataKas->NAMA_KARYAWAN."</td>
				</tr><tr><td colspan='2'>".$dataKas->JENIS_BAYAR."</td><td align=right> ".$this->format_rupiah($dataKas->JUMLAH_KAS)."</td></tr>";				
			}
			$this->showLaporan.= " <tr><td colspan='3'><hr><td></tr>";	
		}
		$this->showLaporan.= " </table >";	
		$jumlahKas= 0;
		$this->showLaporan.= " <table width='100%'  cellpadding='0'>       <tbody>";	
		foreach($this->showJenisBayar as $dataJenisBayar ){
			
				$queryJumlahSatuan 	= $this->db->query("select count(*) as JUM from v_bayar where jenis_bayar='".$dataJenisBayar->JENIS_BAYAR."'   and  id_t_bayar_order BETWEEN   '".$awal."'   and '".$akhir."'      ");
				$dataJumlahSatuan = $queryJumlahSatuan->row();
				
				$queryJumlahKas 	= $this->db->query("select sum(JUMLAH_KAS) as JUM from v_bayar where   jenis_bayar='".$dataJenisBayar->JENIS_BAYAR."'     and id_t_bayar_order BETWEEN   '".$awal."'   and '".$akhir."'     ");
				$dataJumlahKas = $queryJumlahKas->row();
				
				$this->showLaporan.= "<tr><td>".$dataJenisBayar->JENIS_BAYAR."</td><td>".$dataJumlahSatuan->JUM."</td><td align=right>".$this->format_rupiah($dataJumlahKas->JUM)."</td></tr>";		
					
				$jumlahKas	+= $dataJumlahKas->JUM;
		}
		$this->showLaporan.= "<tr><td colspan='2' align=''>Jumlah</td><td  align=right><b>".$this->format_rupiah($jumlahKas)."</b></td></tr>";		
		$this->showLaporan.= "</tbody></table>";	
		
		$this->showLaporan.= "</table><hr>";	
				
							
				
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
				
				
				
				$queryCancelBarang	= $this->db->query("select * from v_barang_order_cancel where tgl_cancel between  '".$dataCekMulaiAkhir->tgl_mulai."'  and   '".$dataCekMulaiAkhir->tgl_akhir."' order by STATUS_BAYAR_CANCEL");
				$this->showDataCancelBarang = $queryCancelBarang->result();
			
			$this->showLaporan.= " <table width='100%'  cellpadding='0'>   <thead>  <tr valign='top'>      <th >Nomor WO</th>    <th >  Jam Cancel Barang</th>   <th >Status Bayar Saat Cancel </th> <th >Harga Barang </th></tr>    </thead>       <tbody>";	
			$ii=1;
			$jumlahUangVoid = 0;
			foreach($this->showDataCancelBarang as $dataCancelBarang ){
				
			
					
					$this->showLaporan.= "<tr><td align='center'>".$dataCancelBarang->no_wo."</td><td align='center'>".$dataCancelBarang->JAM_CANCEL_INDO."</td><td align='center'>".$dataCancelBarang->STATUS_BAYAR_CANCEL."</td><td align=right> ".$this->format_rupiah($dataCancelBarang->TOTAL_HARGA)."</td></tr>";							
					$ii++;
					
					$jumlahUangVoid += $dataCancelBarang->TOTAL_HARGA;
			}
			$this->showLaporan.= "<tr><td  colspan='3' align=right><b>Jumlah</td><td align=right> <b>".$this->format_rupiah($jumlahUangVoid )." </b></td></tr>";	
			$this->showLaporan.= "</tbody></table>";	
		
		$this->load->view('cetak/laporan_kas_view');
		
	}
	
}
