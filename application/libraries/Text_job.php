<?php
class Text_job extends CI_Controller {
    protected $_ci;
    
    function __construct(){
        $this->_ci = &get_instance();

    }
    
   
    function getText($id_order,$count_barang){
		
			$queryBarang = $this->_ci->db->query("
			select 
				*
			from
				v_barang_order
			where
				id_order='".$id_order."'
				and count_barang='".$count_barang."'
			");
			
			//echo $this->_ci->db->last_query();
			
			$dataBarang = $queryBarang->row();
			switch ($dataBarang->ID_KERTAS) {
				case "20":
					$gambar= "<img src='".base_url()."assets/img/gambar_job/Ivory 230gr.bmp' height='25px'>";
					 break;
				case "6":
					$gambar= "<img src='".base_url()."assets/img/gambar_job/Art Paper 120gr.bmp' height='25px'>";
					 break;
				case "7":
					$gambar= "<img src='".base_url()."assets/img/gambar_job/Art Paper 150gr.bmp' height='25px'>";
					 break;
				case "21":
					$gambar= "<img src='".base_url()."assets/img/gambar_job/Ivory 260gr.bmp' height='25px'>";
					 break;
				case "24":
					$gambar= "<img src='".base_url()."assets/img/gambar_job/Stiker Chromo.bmp' height='25px'>";
					 break;
				case "48":
					$gambar= "<img src='".base_url()."assets/img/gambar_job/Stiker Transparant.bmp' height='25px'>";
					 break;
				case "71":
					$gambar= "<img src='".base_url()."assets/img/gambar_job/Stiker Vinyl.bmp' height='25px'>";
					 break;
				case "49":
					$gambar= "<img src='".base_url()."assets/img/gambar_job/Stiker Vinyl.bmp' height='25px'>";
					 break;
				
				default:
					$gambar= "";
			}

			//var_dump($dataBarang->ID_KERTAS);
			
			
			 //var_dump($dataBarang->ID_PRODUK);
			if($dataBarang->ID_PRODUK == '8'){
				
				$text = "
				<table width='100%' >
				<tr><td>
				<table width='100%' >
					<tr>
					<td  width='70%'>
						<table width=''  border='0'>
						<tr>
							<td ><b>Digital Print</b></td>
						</tr>
						<tr>
							<td >".$dataBarang->NAMA_FILE_PEKERJAAN."</td>
						</tr>
						<tr>
							<td >Jenis Kertas : ".$dataBarang->NAMA_KERTAS."</td>
						</tr>
						<tr>
							<td >Ukuran Kertas : ".$dataBarang->UKURAN_KERTAS."</td>
						</tr>
						<tr>
							<td >Page Img : ".$dataBarang->PAGE_IMG."</td>
						</tr>
						<tr>
							<td >Jumlah Sisi : ".$dataBarang->JML_SISI."</td>
						</tr>
						<tr>
							<td >Layout : ".$dataBarang->UP." UP / ".$dataBarang->PAGE_ON_SITE_SIDE."</td>
						</tr>
						<tr>
							<td>Jumlah Copy : ".$dataBarang->JML_COPY." ,  Total : ".$dataBarang->JML_KLIK." Klik</td>
							
						</tr>
						<tr>
							<td>Keterangan : ".$dataBarang->KETERANGAN."</td>
						</tr>
						
						</table>
					</td>
					<td >
						<table width='' border='0'>
							<tr>
								<td>".$gambar."</td>
							</tr>
						</table>
					</td>
					</tr>
					
				</table>
				</td></tr>
				</table>
				<hr>
				";
				
			}
			
			elseif($dataBarang->ID_PRODUK == '12'){
				
				$text = "
				<table width='100%' >
				<tr><td>
				<table width='100%' >
					<tr>
					<td  width='70%'>
						<table width=''  border='0'>
						<tr>
							<td ><b>Finishing Digital Print</b></td>
						</tr>
						<tr>
							<td >".$dataBarang->NAMA_FILE_PEKERJAAN."</td>
						</tr>
						<tr>
							<td >Jenis Kertas : ".$dataBarang->NAMA_KERTAS."</td>
						</tr>
						<tr>
							<td >Ukuran Kertas : ".$dataBarang->UKURAN_KERTAS."</td>
						</tr>
						<tr>
							<td >Page Img : ".$dataBarang->PAGE_IMG."</td>
						</tr>
						<tr>
							<td >Jumlah Sisi : ".$dataBarang->JML_SISI."</td>
						</tr>
						<tr>
							<td >Layout : ".$dataBarang->UP." UP</td>
						</tr>
						<tr>
							<td>Jumlah Copy : ".$dataBarang->JML_COPY." ,  Total : ".$dataBarang->JML_KLIK." Klik</td>
							
						</tr>
						<tr>
							<td>Keterangan : ".$dataBarang->KETERANGAN."</td>
						</tr>
						
						</table>
					</td>
					<td >
						<table width='' border='0'>
							<tr>
								<td>".$gambar."</td>
							</tr>
						</table>
					</td>
					</tr>
					
				</table>
				</td></tr>
				</table>
				<hr>
				";
				
			}
			elseif($dataBarang->ID_PRODUK == '16'){
				$box = $dataBarang->JML_COPY * $dataBarang->PAGE_IMG;
				$jmlPrint  = $box * 4;
				$text = "
				<table width='100%'>
				<tr><td>
				<table width='100%' >
					<tr>
					<td  width='100%'>
						<table width=''  border='0'>
						<tr>
							<td ><b>Paket Banner</b></td>
						</tr>
						<tr>
							<td >".$dataBarang->NAMA_FILE_PEKERJAAN."</td>
						</tr>
						<tr>
							<td >Jenis Kertas/Bahan : ".$dataBarang->NAMA_KERTAS."</td>
						</tr>
						<tr>
							<td >Ukuran Kertas/Bahan : ".$dataBarang->UKURAN_KERTAS."</td>
						</tr>
						<tr>
							<td >Panjang cm : ".$dataBarang->PANJANG."</td>
						</tr>
						<tr>
							<td >Lebar cm : ".$dataBarang->LEBAR."</td>
						</tr>
						<tr>
							<td>Jumlah Copy : ".$dataBarang->JML_COPY."</td>
							
						</tr>
						<tr>
							<td>Keterangan : ".$dataBarang->KETERANGAN."</td>
						</tr>
						<tr>
							<td>Quantity Print : ".$box ." Box X 4 = ".$jmlPrint."</td>
						</tr>
						</table>
					</td>
				
					</tr>
					
				</table>
				</td></tr>
				</table>
				<hr>
				";
				
			}
			
			elseif($dataBarang->ID_PRODUK == '15'){
				
				$text = "
				<table width='100%'>
				<tr><td>
				<table width='100%' >
					<tr>
					<td  width='100%'>
						<table width=''  border='0'>
						<tr>
							<td ><b>Indoor Poster</b></td>
						</tr>
						<tr>
							<td >".$dataBarang->NAMA_FILE_PEKERJAAN."</td>
						</tr>
						<tr>
							<td >Jenis Kertas/Bahan : ".$dataBarang->NAMA_KERTAS."</td>
						</tr>
						<tr>
							<td >Ukuran Kertas/Bahan : ".$dataBarang->UKURAN_KERTAS."</td>
						</tr>
						<tr>
							<td >Panjang cm : ".$dataBarang->PANJANG."</td>
						</tr>
						<tr>
							<td >Lebar cm : ".$dataBarang->LEBAR."</td>
						</tr>
						<tr>
							<td>Jumlah Copy : ".$dataBarang->JML_COPY."</td>
							
						</tr>
						<tr>
							<td>Keterangan : ".$dataBarang->KETERANGAN."</td>
						</tr>
						
						</table>
					</td>
				
					</tr>
					
				</table>
				</td></tr>
				</table>
				<hr>
				";
				
			}
			
			elseif($dataBarang->ID_PRODUK == '5' || $dataBarang->ID_PRODUK == '6'){
				
				$text = "
				<table width='100%' >
				<tr><td>
				<table width='100%' >
					<tr>
					<td  width='100%'>
						<table width=''  border='0'>
						<tr>
							<td ><b>Outdoor Print</b></td>
						</tr>
						<tr>
							<td >".$dataBarang->NAMA_FILE_PEKERJAAN."</td>
						</tr>
						<tr>
							<td >Jenis Kertas/Bahan : ".$dataBarang->NAMA_KERTAS."</td>
						</tr>
						<tr>
							<td >Ukuran Kertas/Bahan : ".$dataBarang->UKURAN_KERTAS."</td>
						</tr>
						<tr>
							<td >Panjang cm : ".$dataBarang->PANJANG."</td>
						</tr>
						<tr>
							<td >Lebar cm : ".$dataBarang->LEBAR."</td>
						</tr>
						<tr>
							<td>Jumlah Copy : ".$dataBarang->JML_COPY."</td>
							
						</tr>
						<tr>
							<td>Keterangan : ".$dataBarang->KETERANGAN."</td>
						</tr>
					
						</table>
					</td>
				
					</tr>
					
				</table>
				</td></tr>
				</table>
				<hr>
				";
				
			}
			elseif($dataBarang->ID_PRODUK == '10'  || $dataBarang->ID_PRODUK == '11'){
				
				if($dataBarang->ID_PRODUK == '10'){
					$paket="Paket Kartu Nama";
				}
				if($dataBarang->ID_PRODUK == '11'){
					$paket="Finishing Kartu Nama";
				}
				
				$text = "
				<table width='100%' >
				<tr><td>
				<table width='100%' >
					<tr>
					<td  width='70%'>
						<table width=''  border='0'>
						<tr>
							<td ><b>".$paket."</b></td>
						</tr>
						<tr>
							<td >".$dataBarang->NAMA_FILE_PEKERJAAN."</td>
						</tr>
						<tr>
							<td >Jenis Kertas : ".$dataBarang->NAMA_KERTAS."</td>
						</tr>
						<tr>
							<td >Ukuran Kertas : ".$dataBarang->UKURAN_KERTAS."</td>
						</tr>
						<tr>
							<td >Page Img : ".$dataBarang->PAGE_IMG."</td>
						</tr>
						<tr>
							<td >Jumlah Sisi : ".$dataBarang->JML_SISI."</td>
						</tr>
						<tr>
							<td >Layout : ".$dataBarang->UP." UP</td>
						</tr>
						<tr>
							<td>Jumlah Copy : ".$dataBarang->JML_COPY." ,  Total : ".$dataBarang->JML_KLIK." Klik</td>
							
						</tr>
						<tr>
							<td>Keterangan : ".$dataBarang->KETERANGAN."</td>
						</tr>
						
						</table>
					</td>
					<td >
						<table width='' border='0'>
							<tr>
								<td>".$gambar."</td>
							</tr>
						</table>
					</td>
					</tr>
					
				</table>
				</td></tr>
				</table>
				<hr>
				";
				
			}
			else{
				$text = "
				<table>
				<tr><td>".$dataBarang->NAMA_PRODUK."</td></tr>
				</table>
				<hr>";
			}
			
			return  $text;
    }

}
