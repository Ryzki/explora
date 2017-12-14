<?php
function format_rupiah($angka){
	$rupiah=number_format($angka,0,',','.');
	return "Rp. ".$rupiah;
}
function format_rupiah_tanpa_rp($angka){
	$rupiah=number_format($angka,0,',','.');
	return $rupiah;
}
?>
<!-- Content Header (Page header) -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">		
				<div class="box-header">
					<h4><?php echo $this->template_view->nama_menu('nama_menu'); ?></h4>
					<h5><?php echo $this->template_view->nama_menu('judul_menu'); ?></h5>
					<hr>			
				</div>
				<div class="box-body">
					<div class="row">
					<div class="col-xs-12">
					<div class="box">		
					
					
					
					<div class="box-body">
					<div class="row">
					<div class="col-xs-4">
					<table width="100%" >
						<tr>
							<td width="20%" align="right">No WO</td>
							<td width="5%" align="center">:</td>
							<td align=""><h4></b><?php echo $this->oldData->NO_WO; ?></b></h4></td>
						</tr>
						<tr>
							<td align="right">Tgl Order</td>
							<td align="center">:</td>
							<td ><?php echo $this->oldData->TGL_ORDER; ?></td>
						</tr>
						
					</table>
					</div>
					<div class="col-xs-8">
					
					<table width="100%">
					
						<tr>
							<td width="15%" align="right">Nama Pembeli</td>
							<td align="center">:</td>
							<td ><h4><?php echo $this->oldData->nama_pelanggan; ?></h4></td>
						</tr>
						<tr>
							<td align="right">Alamat</td>
							<td align="center">:</td>
							<td ><?php echo $this->oldData->alamat; ?></td>
						</tr>
						<tr>
							<td align="right">No HP</td>
							<td align="center">:</td>
							<td ><?php echo $this->oldData->nomor_telp; ?></td>
						</tr>
					</table>
					</div>
					</div>
					<hr>
					<input type="hidden" value="<?php echo $this->jumlahBarang; ?>" id="id_barang_grafis">
					<!--<table class="table table-striped table-bordered">
						<tr>
							<td>
								<input class="form-control" id="NAMA_BARANG_AUTOCOMPLETE" 
                                placeholder="ketikkan nama barang">
								<input type="hidden" value="<?php echo $this->jumlahBarang; ?>" id="id_barang_grafis">
								<input type="hidden" id="ID_BARANG_FORM">
							</td>
							<td width="10%">
								<input class="form-control" type="number" id="JUMLAH_QTY_FORM" onkeyup="hitung_harga_barang()"  placeholder="jumlah Qty">
                                
								<input type="hidden" id="HARGA_QTY_FORM">
								<input type="hidden" id="TOTAL_QTY_FORM">
							</td>
							<td width="15%">
								<input class="form-control" id="SATUAN_BARANG_FORM" 
                                placeholder="Satuan">
							</td>
							<td width="5%"><span class="btn btn-success btn-sm" onclick="tambah_barang_kasir()">Tambah Barang</span></td>
						<tr>
					</table>
					<br>-->
					<br>
					<table class="table table-bordered">
						<tr>
							<th width="50%" align="center">Barang</th>
							<th width="10%" align="center">Jumlah Qty</th>
							<th width="15%" align="center">Harga Qty <br><!--<sub style="color:rgb(224, 226, 114)">Harga sudah berdasarkan database barang</sub>--></th>
							<th width="25%" align="center">Total</th>
						</tr>
						<tbody id="barang_kasir">
						<?php 
						
						//var_dump($this->dataBarang);
						$hargaTotal = 0;
						foreach ($this->dataBarang as $showBarang) {
						?>
						
						<tr>
							<td>
								<?php
								echo $this->text_barang->getText($showBarang->ID_ORDER,$showBarang->COUNT_BARANG);
								
								?>
							</td>
							<td>
								<?php echo $showBarang->JUMLAH_QTY; ?>
							</td>
							
							<td>
								<?php echo format_rupiah($showBarang->HARGA_SATUAN); ?>
							</td>
							<td>
								<?php echo format_rupiah($showBarang->TOTAL_HARGA); ?>
							</td>
						</tr>


						<?php
							
						
						$hargaTotal += $showBarang->TOTAL_HARGA;
						}
						
						
					
						?>
						</tbody>
						<tr>
							<td colspan="3" align="right"><h4>Harga Total</h4></td>
							<td colspan="2" align="center">
							<h4 id="text_harga_total"><?php echo format_rupiah($hargaTotal); ?></h4></td>
						</tr>
						
						
						
						
							
						
						<tr>
							<td  align="right" colspan="3">Discount (Rp.) </td>
							<td colspan="2" align="center">
								<?php echo ($this->oldData->DISCOUNT == '' ? '0' : format_rupiah($this->oldData->DISCOUNT)) ?>
							</td>
						</tr>					
						<tr>
							<td >
								<!--<?php //echo $this->oldData->TGL_AMBIL; ?>
								<select name="TGL_AMBIL" class="form-control required" readonly>
									<option value="">silahkan pilih </option>
									<option <?php echo ($this->oldData->TGL_AMBIL != '' ? "" : "selected") ?> value="S">Barang Sudah diambil</option>
									<option <?php echo ($this->oldData->TGL_AMBIL == '' ? "" : "selected") ?> value="B">Barang Belum diambil</option>
								</select>
										
							-->
							</td>
							
							<td colspan="2" align="right"><h4>Total Bayar</h4></td>
							<td colspan="2" align="center"><h4 id="total_bayar_rp"><?php echo ($this->oldData->DISCOUNT == '' ? format_rupiah($hargaTotal) : format_rupiah($this->oldData->TOTAL_BAYAR)) ?></h4>
							</td>
						</tr>
						<tr>
							<td colspan="10">
							
								
							</td>
						</tr>			
						
					</table>
					
					</div>
					</div>
					</div>
					
				
					</div>
					
					
					
					
					<div class="row">
					<div class="col-xs-12">
					<div class="box">		
					
					<div class="box-body">
					
					<table class="table table-striped table-bordered">
						<tr>
							<th width="20%" align="center">Karyawan Penerima Bayar</th>
							<th width="20%" align="center">Tgl Bayar</th>
							<th width="20%" align="center">Jenis Bayar</th>
							<th width="15%" align="center">Jumlah Bayar</th>
							<th width="15%" align="center">Jumlah Kembalian</th>
						</tr>
						<?php 
						
						//var_dump($this->dataBarang);
						$totalCicilan  = 0;
						foreach ($this->dataBayar as $showLog) {
						?>
						<tr>
							<td><?php echo $showLog->NAMA_KARYAWAN; ?></td>
							<td><?php echo $showLog->TGL_JAM_BAYAR; ?></td>
							<td><?php echo $showLog->JENIS_BAYAR; ?></td>
							<td align="right"><?php echo format_rupiah($showLog->JUMLAH_BAYAR); ?></td>
							<td align="right"><?php echo format_rupiah($showLog->JUMLAH_KEMBALI); ?></td>
						</tr>
						<?php		
							$totalCicilan +=$showLog->JUMLAH_BAYAR;
						}
						
						$kurangBayar = $this->oldData->TOTAL_BAYAR - $totalCicilan;
						?>
						
						<tr>
							<td colspan="4" align="right"><h4>Kekurangan Bayar</h4></td>
							<td align="center"><h4><?php echo ( $this->oldData->STATUS_BAYAR == 'L' ? "LUNAS" : format_rupiah($kurangBayar));?></h4></td>
						</tr>
						
						
						<tr>
							<td colspan="5" align="right">
								<a href="<?=base_url();?>cetak/tanda_bayar/<?php echo $this->oldData->ID_ORDER; ?>" target="_blank"><span class="btn btn-success">Cetak tanda Pembayaran</span></a>
							</td>
						</tr>
					</table>
					<br>
					<hr>
					<br>
					<?php
					if($this->oldData->STATUS_BAYAR == 'BL'){
					?>
					<form class="form-horizontal" id="form_standar">
					<table width="100%" class="table">
						<input type="hidden" value="<?php echo $this->oldData->ID_ORDER; ?>" name="ID_ORDER">
						<input type="hidden" value="<?php echo $this->oldData->TOTAL_BAYAR; ?>" name="TOTAL_BAYAR" id="TOTAL_BAYAR">
						<input type="hidden" value="<?php echo $totalCicilan; ?>" name="TOTAL_CICILAN" id="TOTAL_CICILAN">
						<input type="hidden" value="<?php echo $kurangBayar; ?>" name="KURANG_BAYAR" id="KURANG_BAYAR" >
						<tr>
							<td  width="20%">
								
							</td>
							<td  width="23%">
								<input class="form-control number required"  id="JUMLAH_BAYAR_SEKARANG" onkeyup="hitung_uang_kembalian_cicilan()" placeholder="Masukkan Nominal Cicilan Bayar"  name="JUMLAH_BAYAR_SEKARANG" >
							</td>
							<td  width="33%">
								<select name="JENIS_BAYAR" class="form-control required" >
									<option value="">silahkan pilih Jenis Bayar</option>
									<option selected value="CASH">Cash</option>
									<option value="TRANSFER">Transfer</option>
									<option value="Debit BCA">Debit BCA</option>
									<option value="Debit Mandiri">Debit Mandiri</option>
									<option value="Debit Bank Lain">Debit Bank Lain</option>
									<option value="Credit Card">Credit Card</option>
									<option value="Email Transfer">Email Transfer</option>
									<option value="Voucher">Voucher</option>
									<option value="Surat Jalan">Surat Jalan</option>
									<option value="Invoice">Invoice</option>
									<option value="Faktu Penjualan">Faktu Penjualan</option>
									<option value="ACC (Compliment dari Owner)">ACC (Compliment dari Owner)</option>
								</select>
							</td>
							<td>
								<span id="kelebihan_cicilan"></span>
								<input type="hidden" name="KELEBIHAN_CICILAN" id="KELEBIHAN_CICILAN">
							</td>
						</tr>
						<tr>
							<td></td>
							<td  align="" colspan='2'>
								<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Tambah Pembayaran</button>
								<img src="<?php echo base_url();?>assets/img/loading.gif" id="loading" style="display:none">
								<p id="pesan_error" style="display:none" class="text-warning" style="display:none"></p>
							</td>
							<td></td>
						</tr>
					</table>
					</form>
					<?php
					}
					?>
					</div>
					</div>
					</div>
					
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- /.content -->
  
