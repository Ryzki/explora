<?php
class Text_barang extends CI_Controller {
    protected $_ci;
    
    function __construct(){
        $this->_ci = &get_instance();

    }
    
   
    function getText($id_order,$count_barang){
		
			$queryBarang = $this->_ci->db->query("
			select 
				*
			from
				v_barang_order_all
			where
				id_order='".$id_order."'
				and count_barang='".$count_barang."'
			");
			
			//echo $this->_ci->db->last_query();
			
			$dataBarang = $queryBarang->row();
			 //var_dump($dataBarang->ID_PRODUK);
			if($dataBarang->ID_PRODUK == '1'){
				$text = $dataBarang->KETERANGAN;
				
			}
			elseif($dataBarang->ID_PRODUK == '8' || $dataBarang->ID_PRODUK == '12'){
				$page_img = null;
				$jml_sisi = null;
				$up = null;
				$jml_copy = null;
				$page_on_site_side = null;
			
				if( $dataBarang->PAGE_IMG != ''){			
					$page_img = $dataBarang->PAGE_IMG.' img,';
				}
				if( $dataBarang->JML_SISI != ''){			
					$jml_sisi = $dataBarang->JML_SISI.' sisi,';
				}
				if( $dataBarang->UP != ''){			
					$up = $dataBarang->UP.' UP,';
				}
				if( $dataBarang->PAGE_ON_SITE_SIDE != ''){			
					$page_on_site_side = $dataBarang->PAGE_ON_SITE_SIDE;
				}
				
				if( $dataBarang->JML_COPY != ''){			
					$copy = $dataBarang->JML_COPY.' Copy,';
				}
				
			
				$text_produk 		= 	 $dataBarang->NAMA_PRODUK;
				$text_kertas 		= 	 $dataBarang->NAMA_KERTAS;
				$text_ukuran_kertas 	= 	 $dataBarang->UKURAN_KERTAS;
			
				
				$text = $text_produk.' / '.$text_kertas.', '.$text_ukuran_kertas.', '.$page_img.' '.$jml_sisi.' '.$copy.' '.$up.' '.$page_on_site_side.','.$dataBarang->NAMA_FILE_PEKERJAAN.','.$dataBarang->KETERANGAN;
				
			}
			
			elseif($dataBarang->ID_PRODUK == '10' || $dataBarang->ID_PRODUK == '11'){
				$page_img = null;
				$jml_sisi = null;
				$up = null;
				$jml_copy = null;
				$page_on_site_side = null;
			
				if( $dataBarang->PAGE_IMG != ''){			
					$page_img = $dataBarang->PAGE_IMG.' img,';
				}
				if( $dataBarang->JML_SISI != ''){			
					$jml_sisi = $dataBarang->JML_SISI.' sisi,';
				}
			
				$jmlBox = ( $dataBarang->PAGE_IMG / $dataBarang->JML_SISI ) * $dataBarang->JML_COPY;
				
				if( $dataBarang->JML_COPY != ''){			
					$copy = $dataBarang->JML_COPY.' Copy,';
				}
				
			
				$text_produk 		= 	 $dataBarang->NAMA_PRODUK;
				$text_kertas 		= 	 $dataBarang->NAMA_KERTAS;
				$box 	= 	 $jmlBox." ".$dataBarang->UKURAN_KERTAS;
			
				
				$text = $text_produk.' / '.$text_kertas.', '.$box.', '.$page_img.' '.$jml_sisi.' '.$copy.','.$dataBarang->NAMA_FILE_PEKERJAAN.','.$dataBarang->KETERANGAN;
				
			}
			
			elseif($dataBarang->ID_PRODUK == '6'){
			
				$jml_copy = null;
			
				
				
				if( $dataBarang->JML_COPY != ''){			
					$copy = $dataBarang->JML_COPY.' Copy';
				}
				
			
				$text_produk 		= 	 $dataBarang->NAMA_PRODUK;
				$text_kertas 		= 	 $dataBarang->NAMA_KERTAS;
				$text_ukuran_kertas 		= 	 $dataBarang->UKURAN_KERTAS;
				$panjang 	= 	 "Panjang : ".$dataBarang->PANJANG." cm, ";
				$lebar 	= 	"Lebar : ". $dataBarang->LEBAR." cm, ";
			
				
				$text = $text_produk.' / '.$text_kertas.', '.$text_ukuran_kertas.', '.$panjang.' '.$lebar.' '.$copy.','.$dataBarang->NAMA_FILE_PEKERJAAN.','.$dataBarang->KETERANGAN_FINISHING.','.$dataBarang->KETERANGAN;
				
			}
			
			elseif($dataBarang->ID_PRODUK == '16'){
			
				$jml_copy = null;
			
				
				
				if( $dataBarang->JML_COPY != ''){			
					$copy = $dataBarang->JML_COPY.' Copy';
				}
				
			
				$text_produk 		= 	 $dataBarang->NAMA_PRODUK;
				$text_kertas 		= 	 $dataBarang->NAMA_KERTAS;
				$text_ukuran_kertas 		= 	 $dataBarang->UKURAN_KERTAS;
				$panjang 	= 	 "Panjang : ".$dataBarang->PANJANG." cm, ";
				$lebar 	= 	"Lebar : ". $dataBarang->LEBAR." cm, ";
			
				
				$text = $text_produk.' / '.$text_kertas.', '.$text_ukuran_kertas.', '.$panjang.' '.$lebar.' '.$copy.','.$dataBarang->NAMA_FILE_PEKERJAAN.','.$dataBarang->KETERANGAN_FINISHING.','.$dataBarang->KETERANGAN;
				
			}
			elseif($dataBarang->ID_PRODUK == '15'){
			
				$jml_copy = null;
			
				
				
				if( $dataBarang->JML_COPY != ''){			
					$copy = $dataBarang->JML_COPY.' Copy';
				}
				
			
				$text_produk 		= 	 $dataBarang->NAMA_PRODUK;
				$text_kertas 		= 	 $dataBarang->NAMA_KERTAS;
				$text_ukuran_kertas 		= 	 $dataBarang->UKURAN_KERTAS;
				$panjang 	= 	 "Panjang : ".$dataBarang->PANJANG." cm, ";
				$lebar 	= 	"Lebar : ". $dataBarang->LEBAR." cm, ";
			
				
				$text = $text_produk.' / '.$text_kertas.', '.$text_ukuran_kertas.', '.$panjang.' '.$lebar.' '.$copy.','.$dataBarang->NAMA_FILE_PEKERJAAN.','.$dataBarang->KETERANGAN_FINISHING.','.$dataBarang->KETERANGAN;
				
			}
			elseif($dataBarang->ID_PRODUK == '5'){
			
				$jml_copy = null;
			
				
				
				if( $dataBarang->JML_COPY != ''){			
					$copy = $dataBarang->JML_COPY.' Copy';
				}
				
			
				$text_produk 		= 	 $dataBarang->NAMA_PRODUK;
				$text_kertas 		= 	 $dataBarang->NAMA_KERTAS;
				$panjang 	= 	 "Panjang : ".$dataBarang->PANJANG." cm, ";
				$lebar 	= 	"Lebar : ". $dataBarang->LEBAR." cm, ";
			
				
				$text = $text_produk.' / '.$text_kertas.', '.$panjang.' '.$lebar.' '.$copy.','.$dataBarang->NAMA_FILE_PEKERJAAN.','.$dataBarang->KETERANGAN_FINISHING.','.$dataBarang->KETERANGAN;
				
			}
			
			elseif($dataBarang->ID_PRODUK == '13'){
			
				
				$text = $dataBarang->NAMA_PRODUK.','.$dataBarang->KETERANGAN;
				
			}
			elseif($dataBarang->ID_PRODUK == '14'){
			
				
				$text = $dataBarang->NAMA_PRODUK.','.$dataBarang->KETERANGAN;
				
			}
			else{
				$text = "Wrong";
			}
			
			return  $text;
    }
	
	function getTextStruk($id_order,$count_barang){
		
			$queryBarang = $this->_ci->db->query("
			select 
				*
			from
				v_barang_order_all
			where
				id_order='".$id_order."'
				and count_barang='".$count_barang."'
			");
			
			//echo $this->_ci->db->last_query();
			
			$dataBarang = $queryBarang->row();
			 //var_dump($dataBarang->ID_PRODUK);
			if($dataBarang->ID_PRODUK == '1'){
				$text = $dataBarang->KETERANGAN;
				
			}
			elseif($dataBarang->ID_PRODUK == '8' || $dataBarang->ID_PRODUK =='12'){
				$page_img = null;
				$jml_sisi = null;
				$up = null;
				$jml_copy = null;
				$page_on_site_side = null;
			
				if( $dataBarang->PAGE_IMG != ''){			
					$page_img = $dataBarang->PAGE_IMG.' img,';
				}
				if( $dataBarang->JML_SISI != ''){			
					$jml_sisi = $dataBarang->JML_SISI.' sisi,';
				}
				if( $dataBarang->UP != ''){			
					$up = $dataBarang->UP.' UP,';
				}
				if( $dataBarang->PAGE_ON_SITE_SIDE != ''){			
					$page_on_site_side = $dataBarang->PAGE_ON_SITE_SIDE;
				}
				
				if( $dataBarang->JML_COPY != ''){			
					$copy = $dataBarang->JML_COPY.' Copy,';
				}
				
			
				$text_produk 		= 	 $dataBarang->NAMA_PRODUK;
				$text_kertas 		= 	 $dataBarang->NAMA_KERTAS;
				$text_ukuran_kertas 	= 	 $dataBarang->UKURAN_KERTAS;
			
				
				$text = $text_produk.' / '.$text_kertas.', '.$text_ukuran_kertas.', '.$page_img.' '.$jml_sisi.' '.$copy.' '.$up.' '.$page_on_site_side.','.$dataBarang->KETERANGAN;
				
			}
			
			elseif($dataBarang->ID_PRODUK == '10' || $dataBarang->ID_PRODUK == '11'){
				$page_img = null;
				$jml_sisi = null;
				$up = null;
				$jml_copy = null;
				$page_on_site_side = null;
			
				if( $dataBarang->PAGE_IMG != ''){			
					$page_img = $dataBarang->PAGE_IMG.' img,';
				}
				if( $dataBarang->JML_SISI != ''){			
					$jml_sisi = $dataBarang->JML_SISI.' sisi,';
				}
			
				$jmlBox = ( $dataBarang->PAGE_IMG / $dataBarang->JML_SISI ) * $dataBarang->JML_COPY;
				
				if( $dataBarang->JML_COPY != ''){			
					$copy = $dataBarang->JML_COPY.' Copy,';
				}
				
			
				$text_produk 		= 	 $dataBarang->NAMA_PRODUK;
				$text_kertas 		= 	 $dataBarang->NAMA_KERTAS;
				$box 	= 	 $jmlBox." ".$dataBarang->UKURAN_KERTAS;
			
				
				$text = $text_produk.' / '.$text_kertas.', '.$box.', '.$page_img.' '.$jml_sisi.' '.$copy.' '.$dataBarang->KETERANGAN;
				
			}
			
			elseif($dataBarang->ID_PRODUK == '6'){
			
				$jml_copy = null;
			
				
				
				if( $dataBarang->JML_COPY != ''){			
					$copy = $dataBarang->JML_COPY.' Copy';
				}
				
			
				$text_produk 		= 	 $dataBarang->NAMA_PRODUK;
				$text_kertas 		= 	 $dataBarang->NAMA_KERTAS;
				$text_ukuran_kertas 		= 	 $dataBarang->UKURAN_KERTAS;
				$panjang 	= 	 "Panjang : ".$dataBarang->PANJANG." cm, ";
				$lebar 	= 	"Lebar : ". $dataBarang->LEBAR." cm, ";
			
				
				$text = $text_produk.' / '.$text_kertas.', '.$text_ukuran_kertas.', '.$panjang.' '.$lebar.' '.$copy.','.$dataBarang->KETERANGAN_FINISHING.','.$dataBarang->KETERANGAN;
				
			}
			
			elseif($dataBarang->ID_PRODUK == '16'){
			
				$jml_copy = null;
			
				
				
				if( $dataBarang->JML_COPY != ''){			
					$copy = $dataBarang->JML_COPY.' Copy';
				}
				
			
				$text_produk 		= 	 $dataBarang->NAMA_PRODUK;
				$text_kertas 		= 	 $dataBarang->NAMA_KERTAS;
				$text_ukuran_kertas 		= 	 $dataBarang->UKURAN_KERTAS;
				$panjang 	= 	 "Panjang : ".$dataBarang->PANJANG." cm, ";
				$lebar 	= 	"Lebar : ". $dataBarang->LEBAR." cm, ";
			
				
				$text = $text_produk.' / '.$text_kertas.', '.$text_ukuran_kertas.', '.$panjang.' '.$lebar.' '.$copy.','.$dataBarang->KETERANGAN_FINISHING.','.$dataBarang->KETERANGAN;
				
			}
			elseif($dataBarang->ID_PRODUK == '15'){
			
				$jml_copy = null;
			
				
				
				if( $dataBarang->JML_COPY != ''){			
					$copy = $dataBarang->JML_COPY.' Copy';
				}
				
			
				$text_produk 		= 	 $dataBarang->NAMA_PRODUK;
				$text_kertas 		= 	 $dataBarang->NAMA_KERTAS;
				$text_ukuran_kertas 		= 	 $dataBarang->UKURAN_KERTAS;
				$panjang 	= 	 "Panjang : ".$dataBarang->PANJANG." cm, ";
				$lebar 	= 	"Lebar : ". $dataBarang->LEBAR." cm, ";
			
				
				$text = $text_produk.' / '.$text_kertas.', '.$text_ukuran_kertas.', '.$panjang.' '.$lebar.' '.$copy.','.$dataBarang->KETERANGAN_FINISHING.','.$dataBarang->KETERANGAN;
				
			}
			elseif($dataBarang->ID_PRODUK == '5'){
			
				$jml_copy = null;
			
				
				
				if( $dataBarang->JML_COPY != ''){			
					$copy = $dataBarang->JML_COPY.' Copy';
				}
				
			
				$text_produk 		= 	 $dataBarang->NAMA_PRODUK;
				$text_kertas 		= 	 $dataBarang->NAMA_KERTAS;
				$panjang 	= 	 "Panjang : ".$dataBarang->PANJANG." cm, ";
				$lebar 	= 	"Lebar : ". $dataBarang->LEBAR." cm, ";
			
				
				$text = $text_produk.' / '.$text_kertas.', '.$panjang.' '.$lebar.' '.$copy.','.$dataBarang->KETERANGAN_FINISHING.','.$dataBarang->KETERANGAN;
				
			}
			
			elseif($dataBarang->ID_PRODUK == '13'){
			
				
				$text = $dataBarang->NAMA_PRODUK.','.$dataBarang->KETERANGAN;
				
			}
			elseif($dataBarang->ID_PRODUK == '14'){
			
				
				$text = $dataBarang->NAMA_PRODUK.','.$dataBarang->KETERANGAN;
				
			}
			else{
				$text =  $dataBarang->NAMA_PRODUK;
			}
			
			return  $text;
    }
	
	
	
	function format_rupiah($angka){
		$rupiah=number_format($angka,0,',','.');
		return "Rp. ".$rupiah;
	}

	
	 function getTextLaporanCounter($id_order,$count_barang){
		
			$queryBarang = $this->_ci->db->query("
			select 
				*
			from
				v_barang_order_complete
			where
				id_order='".$id_order."'
				and count_barang='".$count_barang."'
			");
			
			//echo $this->_ci->db->last_query();
			
			$dataBarang = $queryBarang->row();
			
			$harga		=			 $dataBarang->JUMLAH_QTY . " X ". $this->format_rupiah( $dataBarang->HARGA_SATUAN) ." = ".  $this->format_rupiah( $dataBarang->TOTAL_HARGA);
			
			
			
			 //var_dump($dataBarang->ID_PRODUK);
			if($dataBarang->ID_PRODUK == '1'){
				$text = $dataBarang->KETERANGAN.", ".$harga;
				
			}
			elseif($dataBarang->ID_PRODUK == '8' || $dataBarang->ID_PRODUK == '12'){
				$page_img = null;
				$jml_sisi = null;
				$up = null;
				$jml_copy = null;
				$page_on_site_side = null;
			
				if( $dataBarang->PAGE_IMG != ''){			
					$page_img = $dataBarang->PAGE_IMG.' img,';
				}
				if( $dataBarang->JML_SISI != ''){			
					$jml_sisi = $dataBarang->JML_SISI.' sisi,';
				}
				if( $dataBarang->UP != ''){			
					$up = $dataBarang->UP.' UP,';
				}
				if( $dataBarang->PAGE_ON_SITE_SIDE != ''){			
					$page_on_site_side = $dataBarang->PAGE_ON_SITE_SIDE;
				}
				
				if( $dataBarang->JML_COPY != ''){			
					$copy = $dataBarang->JML_COPY.' Copy,';
				}
				
			
				$text_produk 		= 	 $dataBarang->NAMA_PRODUK;
				$text_kertas 		= 	 $dataBarang->NAMA_KERTAS;
				$text_ukuran_kertas 	= 	 $dataBarang->UKURAN_KERTAS;
			
				
				
				$text = $text_produk.' / '.$text_kertas.', '.$text_ukuran_kertas.',  '.$page_img.' '.$jml_sisi.' '.$copy.' '.$up.' '.$page_on_site_side.", ".$harga;
				
			}
			
			elseif($dataBarang->ID_PRODUK == '10' || $dataBarang->ID_PRODUK == '11'){
				$page_img = null;
				$jml_sisi = null;
				$up = null;
				$jml_copy = null;
				$page_on_site_side = null;
			
				if( $dataBarang->PAGE_IMG != ''){			
					$page_img = $dataBarang->PAGE_IMG.' img,';
				}
				if( $dataBarang->JML_SISI != ''){			
					$jml_sisi = $dataBarang->JML_SISI.' sisi,';
				}
			
				$jmlBox = ( $dataBarang->PAGE_IMG / $dataBarang->JML_SISI ) * $dataBarang->JML_COPY;
				
				if( $dataBarang->JML_COPY != ''){			
					$copy = $dataBarang->JML_COPY.' Copy,';
				}
				
			
				$text_produk 		= 	 $dataBarang->NAMA_PRODUK;
				$text_kertas 		= 	 $dataBarang->NAMA_KERTAS;
				$box 	= 	 $jmlBox." ".$dataBarang->UKURAN_KERTAS;
			
				
				$text = $text_produk.' / '.$text_kertas.', '.$box.', '.$page_img.' '.$jml_sisi.' '.$copy.', '.$harga;
				
			}
			
			elseif($dataBarang->ID_PRODUK == '6'){
			
				$jml_copy = null;
			
				
				
				if( $dataBarang->JML_COPY != ''){			
					$copy = $dataBarang->JML_COPY.' Copy';
				}
				
			
				$text_produk 		= 	 $dataBarang->NAMA_PRODUK;
				$text_kertas 		= 	 $dataBarang->NAMA_KERTAS;
				$text_ukuran_kertas 		= 	 $dataBarang->UKURAN_KERTAS;
				$panjang 	= 	 "Panjang : ".$dataBarang->PANJANG." cm, ";
				$lebar 	= 	"Lebar : ". $dataBarang->LEBAR." cm, ";
			
				
				$text = $text_produk.' / '.$text_kertas.', '.$text_ukuran_kertas.', '.$panjang.' '.$lebar.' '.$copy.', '.$harga;
				
			}
			
			elseif($dataBarang->ID_PRODUK == '16'){
			
				$jml_copy = null;
			
				
				
				if( $dataBarang->JML_COPY != ''){			
					$copy = $dataBarang->JML_COPY.' Copy';
				}
				
			
				$text_produk 		= 	 $dataBarang->NAMA_PRODUK;
				$text_kertas 		= 	 $dataBarang->NAMA_KERTAS;
				$text_ukuran_kertas 		= 	 $dataBarang->UKURAN_KERTAS;
				$panjang 	= 	 "Panjang : ".$dataBarang->PANJANG." cm, ";
				$lebar 	= 	"Lebar : ". $dataBarang->LEBAR." cm, ";
			
				
				$text = $text_produk.' / '.$text_kertas.', '.$text_ukuran_kertas.', '.$panjang.' '.$lebar.' '.$copy.', '.$harga;
				
			}
			elseif($dataBarang->ID_PRODUK == '15'){
			
				$jml_copy = null;
			
				
				
				if( $dataBarang->JML_COPY != ''){			
					$copy = $dataBarang->JML_COPY.' Copy';
				}
				
			
				$text_produk 		= 	 $dataBarang->NAMA_PRODUK;
				$text_kertas 		= 	 $dataBarang->NAMA_KERTAS;
				$text_ukuran_kertas 		= 	 $dataBarang->UKURAN_KERTAS;
				$panjang 	= 	 "Panjang : ".$dataBarang->PANJANG." cm, ";
				$lebar 	= 	"Lebar : ". $dataBarang->LEBAR." cm, ";
			
				
				$text = $text_produk.' / '.$text_kertas.', '.$text_ukuran_kertas.', '.$panjang.' '.$lebar.' '.$copy.', '.$harga;
				
			}
			elseif($dataBarang->ID_PRODUK == '5'){
			
				$jml_copy = null;
			
				
				
				if( $dataBarang->JML_COPY != ''){			
					$copy = $dataBarang->JML_COPY.' Copy';
				}
				
			
				$text_produk 		= 	 $dataBarang->NAMA_PRODUK;
				$text_kertas 		= 	 $dataBarang->NAMA_KERTAS;
				$panjang 	= 	 "Panjang : ".$dataBarang->PANJANG." cm, ";
				$lebar 	= 	"Lebar : ". $dataBarang->LEBAR." cm, ";
			
				
				$text = $text_produk.' / '.$text_kertas.', '.$panjang.' '.$lebar.' '.$copy.', '.$harga;
				
			}
			
			elseif($dataBarang->ID_PRODUK == '13'){
			
				
				$text = $dataBarang->NAMA_PRODUK.','.$dataBarang->KETERANGAN.', '.$harga;
				
			}
			elseif($dataBarang->ID_PRODUK == '14'){
			
				
				$text = $dataBarang->NAMA_PRODUK.','.$dataBarang->KETERANGAN.', '.$harga;
				
			}
			else{
				$text = $dataBarang->NAMA_PRODUK.', '.$harga;
			}
			
			return  $text;
    }

}
