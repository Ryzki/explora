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
					
					<form class="form-horizontal" id="form_kasir">
					<input type="hidden" name="ID_ORDER" value="<?php echo $this->oldData->ID_ORDER; ?>">
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
					
					<br>
					
					<input id="jumlah_barang" type="hidden" value="<?php echo $this->jumlahBarang; ?>">
					<table class="table table-bordered">
						<tr>
							<th width="50%" align="center">Barang</th>
							<th width="10%" align="center">Jumlah Qty</th>
							<!--<th width="10%" align="center">Satuan</th> -->
							<th width="15%" align="center">Harga Qty <br><sub style="color:rgb(224, 226, 114)">Harga sudah berdasarkan database barang</sub></th>
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
								
								//echo $showBarang->ID_PRODUK;
							?>
								
							<input type="hidden" name="COUNT_BARANG[]" value="<?php echo $showBarang->COUNT_BARANG; ?>"> 
							</td>
							<td>
								<input onkeyup="ganti_jumlah_kasir('<?php echo $showBarang->COUNT_BARANG; ?>','<?php echo $this->jumlahBarang; ?>','JUMLAH_QTY')" id="JUMLAH_QTY_<?php echo $showBarang->COUNT_BARANG; ?>" name="JUMLAH_QTY_<?php echo $showBarang->COUNT_BARANG; ?>" value="<?php echo $showBarang->JUMLAH_QTY; ?>" class="form-control"> 
							</td>
							<td>
								<input onkeyup="ganti_harga_kasir('<?php echo $showBarang->COUNT_BARANG; ?>','<?php echo $this->jumlahBarang; ?>','HARGA_SATUAN')" id="HARGA_SATUAN_<?php echo $showBarang->COUNT_BARANG; ?>" name="HARGA_SATUAN_<?php echo $showBarang->COUNT_BARANG; ?>" <?php if($showBarang->ID_PRODUK == '1') echo "readonly"; ?>  value="<?php echo format_rupiah_tanpa_rp($showBarang->HARGA_SATUAN); ?>" class="form-control">
							</td>
							<td>
								<input id="TOTAL_HARGA_<?php echo $showBarang->COUNT_BARANG; ?>" name="TOTAL_HARGA_<?php echo $showBarang->COUNT_BARANG; ?>" readonly <?php if($showBarang->ID_PRODUK == '1') echo "readonly"; ?> value="<?php echo format_rupiah_tanpa_rp($showBarang->TOTAL_HARGA); ?>" class="form-control">
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
							
							<input type="hidden" name="harga_total" id="harga_total" value="<?php echo $hargaTotal; ?>">
							<h4 id="text_harga_total"><?php echo format_rupiah($hargaTotal); ?></h4></td>
						</tr>
						
						
						
						
							
						
						<tr>
							<td  align="right" colspan="3">Discount (Rp.) </td>
							<td  align="center" colspan=2><input type="text" class="form-control" value="<?php echo ($this->oldData->DISCOUNT == '' ? '0' : $this->oldData->DISCOUNT) ?>" onkeyup="hitung_discount()" id="DISCOUNT" name="DISCOUNT" placeholder="discount (Rp.)"></td>
						</tr>					
						<tr>
							<td >
								<?php //echo $this->oldData->TGL_AMBIL; ?>
							<!--<select name="TGL_AMBIL" class="form-control required">
									<option value="">silahkan pilih </option>
									<option <?php echo ($this->oldData->TGL_AMBIL != '' ? "" : "selected") ?> value="S">Barang Sudah diambil</option>
									<option <?php echo ($this->oldData->TGL_AMBIL == '' ? "" : "selected") ?> value="B">Barang Belum diambil</option>
								</select>-->
										
							
							</td>
							<td colspan="2" align="right"><h4>Total Bayar</h4></td>
							<td colspan="2" align="center"><h4 id="total_bayar_rp"><?php echo ($this->oldData->DISCOUNT == '' ? format_rupiah($hargaTotal) : format_rupiah($this->oldData->TOTAL_BAYAR)) ?></h4>
							<input type="hidden" name="TOTAL_BAYAR" id="TOTAL_BAYAR" value="<?php echo ($this->oldData->DISCOUNT == '' ? $hargaTotal : $this->oldData->TOTAL_BAYAR) ?>">
							</td>
						</tr>
									<tr>
										
										
								
										<td  width="33%">
											<select name="JENIS_BAYAR" class="form-control required">
												<option <?php echo  ($this->caraBayar=='CASH' ? "selected" : "") ?> value="CASH">Cash</option>
												<option <?php echo  ($this->caraBayar=='TRANSFER' ? "selected" : "") ?> value="TRANSFER">Transfer</option>
												<option <?php echo  ($this->caraBayar=='Debit BCA' ? "selected" : "") ?> value="Debit BCA">Debit BCA</option>
												<option <?php echo  ($this->caraBayar=='Debit Mandiri' ? "selected" : "") ?> value="Debit Mandiri">Debit Mandiri</option>
												<option <?php echo  ($this->caraBayar=='Debit Bank Lain' ? "selected" : "") ?> value="Debit Bank Lain">Debit Bank Lain</option>
												<option <?php echo  ($this->caraBayar=='Credit Card' ? "selected" : "") ?> value="Credit Card">Credit Card</option>
												<option <?php echo  ($this->caraBayar=='Email Transfer' ? "selected" : "") ?> value="Email Transfer">Email Transfer</option>
												<option <?php echo  ($this->caraBayar=='Voucher' ? "selected" : "") ?> value="Voucher">Voucher</option>
												<option <?php echo  ($this->caraBayar=='Surat Jalan' ? "selected" : "") ?> value="Surat Jalan">Surat Jalan</option>
												<option <?php echo  ($this->caraBayar=='Invoice' ? "selected" : "") ?> value="Invoice">Invoice</option>
												<option <?php echo  ($this->caraBayar=='Faktu Penjualan' ? "selected" : "") ?> value="Faktu Penjualan">Faktu Penjualan</option>
												<option <?php echo  ($this->caraBayar=='ACC (Compliment dari Owner)' ? "selected" : "") ?> value="ACC (Compliment dari Owner)">ACC (Compliment dari Owner)</option>
											</select>
										</td>
										<td colspan="2" align="right">
											Jumlah Uang Bayar
										</td>
										<td>
											<input class="form-control" onkeyup="hitung_uang_customer()" value="0" id="uang_customer" name="JUMLAH_BAYAR">
											<input id="JUMLAH_KEMBALI" name="JUMLAH_KEMBALI" type="hidden">
										</td>
										
						</tr>					
						<tr>
							
							<td  align="center">
								<?php
								if($this->oldData->TOTAL_BAYAR != ''){
								?>
									<!--   <a href="<?=base_url();?>/cetak/nota/<?php echo $this->oldData->ID_ORDER; ?>" target="_blank"><span type="submit" class="btn btn-success btn-lg"> Cetak Nota</span></a>  -->
								<?php
								}
								?>
							
							</td>
							<td colspan="2" align="right">
								<span id="pesan_bayar">Kekurangan bayar : <h4 class="text-warning"><?php echo format_rupiah($hargaTotal); ?></h4></span>
								
							<td colspan="2" align="right" valign="middle">
							
							
								<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
								<img src="<?php echo base_url();?>assets/img/loading.gif" id="loading" style="display:none">
								<p id="pesan_error" style="display:none" class="text-warning" style="display:none"></p>
								
								
								
								
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
							<th width="20%" align="center">Nama Karyawan</th>
							<th width="20%" align="center">Dari - Ke</th>
							<th width="15%" align="center">Waktu</th>
							<th width="45%" align="center">Catatan</th>
						</tr>
						<?php 
						
						//var_dump($this->dataBarang);
						
						foreach ($this->logAlur as $showLog) {
						?>
						<tr>
							<td><?php echo $showLog->NAMA_KARYAWAN; ?></td>
							<td><?php echo $showLog->DARI; ?> &#10132; <?php echo $showLog->KE; ?></td>
							<td><?php echo $showLog->TGL_LOG_ORDER ; ?></td>
							<td><?php echo $showLog->CATATAN_LOG_ORDER ; ?></td>
						</tr>
						<?php							
						}
						?>
					</table>
                   
					</div>
					</div>
					</div>
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</section>
<!-- /.content -->
  
