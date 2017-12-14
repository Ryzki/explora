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
			<div class="row">
				<center>
						<form method="get">			
						<div class="col-sm-5 col-md-offset-4">
								
								<div class="input-group">
									<input type="text" class="form-control" name="no_wo" placeholder="Masukkan Nomor WO" value="<?php echo $this->input->get('no_wo'); ?>">
									<div class="input-group-btn">
										<button class="btn btn-default" type="submit">
										<i class="glyphicon glyphicon-search"></i> Cari Berdasarkan Nomor WO
										</button>
										
									</div>
									
								</div>	
														
						</div>
						</form>
					</center>
			</div>
		</div>
			<hr>
			
			<?php
			if($this->showData){
		?>
				<div class="box-body">
					<div class="row">
					<div class="col-xs-12">
					<div class="box">		
					
					<form class="form-horizontal" id="form_standar">
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
							<th width="10%" align="center">
								
							</th>
							<th width="40%" align="center">Barang</th>
							<th width="10%" align="center">Jumlah Qty</th>
							<!--<th width="10%" align="center">Satuan</th> -->
							<th width="15%" align="center">Harga Qty <br><sub style="color:rgb(224, 226, 114)">Harga sudah berdasarkan database barang</sub></th>
							<th width="15%" align="center">Total</th>
						</tr>
						<tbody id="barang_kasir">
						<?php 
						
						//var_dump($this->dataBarang);
						$subTotal = 0;
						foreach ($this->dataBarang as $showBarang) {
						
						?>
						
						
						<tr>
							<td>
							<span class="btn btn-warning" onclick="tampil_pesan_cancel_barang('<?php	echo $this->text_barang->getText($showBarang->ID_ORDER,$showBarang->COUNT_BARANG);?>','<?php echo $showBarang->ID_ORDER; ?>','<?php echo $showBarang->COUNT_BARANG; ?>')"><i class="fa fa-trash"></i> Cancel Barang</span>
							</td>
							<td>
								
							<?php
								echo $this->text_barang->getText($showBarang->ID_ORDER,$showBarang->COUNT_BARANG);
								
								//echo $showBarang->ID_PRODUK;
							?>
								
							<input type="hidden" name="COUNT_BARANG[]" value="<?php echo $showBarang->COUNT_BARANG; ?>"> 
							</td>
							<td>
								<input readonly id="JUMLAH_QTY_<?php echo $showBarang->COUNT_BARANG; ?>" name="JUMLAH_QTY_<?php echo $showBarang->COUNT_BARANG; ?>" value="<?php echo $showBarang->JUMLAH_QTY; ?>" class="form-control"> 
							</td>
							<td>
								<input readonly id="HARGA_SATUAN_<?php echo $showBarang->COUNT_BARANG; ?>" name="HARGA_SATUAN_<?php echo $showBarang->COUNT_BARANG; ?>" <?php if($showBarang->ID_PRODUK == '1') echo "readonly"; ?>  value="<?php echo format_rupiah_tanpa_rp($showBarang->HARGA_SATUAN); ?>" class="form-control">
							</td>
							<td>
								<input id="TOTAL_HARGA_<?php echo $showBarang->COUNT_BARANG; ?>" name="TOTAL_HARGA_<?php echo $showBarang->COUNT_BARANG; ?>" readonly <?php if($showBarang->ID_PRODUK == '1') echo "readonly"; ?> value="<?php echo format_rupiah_tanpa_rp($showBarang->TOTAL_HARGA); ?>" class="form-control">
							</td>
						</tr>


						<?php
							
						
						
						$subTotal += $showBarang->TOTAL_HARGA;
						}
						
						
						?>
						</tbody>
						<tr>
							<td colspan="3" align="right"><h4>Sub Total</h4></td>
							<td colspan="2" align="center">
							
							<input type="hidden" name="harga_total" id="harga_total" value="<?php echo $subTotal; ?>">
							<h4 id="text_harga_total"><?php echo format_rupiah($subTotal); ?></h4></td>
						</tr>
						<tr>
							<td  align="right" colspan="3">Discount (Rp.) </td>
							<td  align="center" colspan=2><?php echo ($this->oldData->DISCOUNT == '' ? format_rupiah(0) :  format_rupiah($this->oldData->DISCOUNT)) ; ?></td>
						</tr>		
						<tr>
							<td colspan="3" align="right"><h4>Harga Total</h4></td>
							<td colspan="2" align="center">
							
							
							<h4 id="text_harga_total"><?php $hargaTotal  =  $subTotal  - $this->oldData->DISCOUNT ; echo format_rupiah($hargaTotal); ?></h4></td>
							<input type="hidden" name="harga_total" id="harga_total" value="<?php echo $hargaTotal; ?>">
						</tr>
						</table>
					
					<?php
						if($this->dataBarangCancel ){
					?>
					<br>	
					<hr>
					Barang yang sudah dibatalkan
					
					<hr>
					<table class="table table-bordered">
						<tr>
							<th width="40%" align="center">Barang</th>
							<th width="10%" align="center">Jumlah Qty</th>
							<!--<th width="10%" align="center">Satuan</th> -->
							<th width="15%" align="center">Harga Qty <br><sub style="color:rgb(224, 226, 114)">Harga sudah berdasarkan database barang</sub></th>
							<th width="15%" align="center">Total</th>
						</tr>
						<tbody id="barang_kasir">
						<?php 
						
						//var_dump($this->dataBarang);
						$hargaTotalCancel = 0;
						foreach ($this->dataBarangCancel as $showBarangCancel) {
						
						?>
						
						
						<tr>
						
							<td>
								
							<?php
								//echo $showBarangCancel->ID_ORDER."==".$showBarangCancel->COUNT_BARANG;
								echo $this->text_barang->getText($showBarangCancel->ID_ORDER,$showBarangCancel->COUNT_BARANG);
								
								//echo $showBarang->ID_PRODUK;
							?>
								
							</td>
							<td>
								<input readonly id="JUMLAH_QTY_<?php echo $showBarangCancel->COUNT_BARANG; ?>" name="JUMLAH_QTY_<?php echo $showBarangCancel->COUNT_BARANG; ?>" value="<?php echo format_rupiah_tanpa_rp($showBarangCancel->JUMLAH_QTY); ?>" class="form-control"> 
							</td>
							<td>
								<input readonly id="HARGA_SATUAN_<?php echo $showBarangCancel->COUNT_BARANG; ?>" name="HARGA_SATUAN_<?php echo $showBarangCancel->COUNT_BARANG; ?>" <?php if($showBarangCancel->ID_PRODUK == '1') echo "readonly"; ?>  value="<?php echo format_rupiah_tanpa_rp($showBarangCancel->HARGA_SATUAN); ?>" class="form-control">
							</td>
							<td>
								<input id="TOTAL_HARGA_<?php echo $showBarangCancel->COUNT_BARANG; ?>" name="TOTAL_HARGA_<?php echo $showBarangCancel->COUNT_BARANG; ?>" readonly <?php if($showBarangCancel->ID_PRODUK == '1') echo "readonly"; ?> value="<?php echo format_rupiah_tanpa_rp($showBarangCancel->TOTAL_HARGA); ?>" class="form-control">
							</td>
						</tr>


						<?php
							
						
						
						$hargaTotalCancel += $showBarangCancel->TOTAL_HARGA;
						}
						
						
						?>
						</tbody>
						<tr>
							<td colspan="3" align="right"><h4>Jumlah Uang yang dibatalkan</h4></td>
							<td colspan="2" align="center">
							
							<h4 id="text_harga_total"><?php echo format_rupiah($hargaTotalCancel); ?></h4></td>
						</tr>
						
						</table>
						<?php
						}
						?>
				</form>
			</div>
		</div>
		<?php
		}
		?>
	</div>
</section>
<!-- /.content -->
  
