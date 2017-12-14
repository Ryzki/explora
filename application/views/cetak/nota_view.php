<title>Cetak Invoice </title>
<style>
	body{
		font-size:14px;
	}
	body table{
		font-size:14px;
	}
</style>
<body>
<br>
<br>
<br>
<br>
<br>
<br>


<center><h3>INVOICE</h3></center>


<table width="100%" >
	<tr>		
		<td colspan="2" align="">Kepada Yth.</td>
	</tr>
	<tr>		
		<td align=""><?php echo $this->oldData->nama_pelanggan; ?></td>
		<td align="right">Nomor Work Order : <?php echo $this->oldData->NO_WO; ?></b></h3></td>
	</tr>
	<tr>
		<td align=""><?php echo $this->oldData->nomor_telp; ?></td>
		<td align="right"><?php echo $this->oldData->TGL_ORDER; ?></td>
	</tr>
	
</table>


<table width="100%">
<tr>
		<td colspan="5"><hr></td>
	</tr>
	<tr>
		<th width="45%" align="center">Barang</th>
		<th width="15%" align="center">Quantity</th>
		<th width="20%" align="center">Harga Satuan</th>
		<th width="25%" align="center">Jumlah</th>
	</tr>
	<tr>
		<td colspan="5"><hr></td>
	</tr>
	<?php 
	
	//var_dump($this->dataBarang);
	$hargaTotal = 0;
	foreach ($this->dataBarang as $showBarang) {
	?>
	<tr>
		<td><?php echo $this->text_barang->getText($showBarang->ID_ORDER,$showBarang->COUNT_BARANG); ?></td>
		<td align="center"><?php echo $showBarang->JUMLAH_QTY; ?></td>
		<td align="right"><?php echo format_rupiah($showBarang->HARGA_SATUAN); ?></td>
		<td align="right"><?php echo format_rupiah($showBarang->TOTAL_HARGA); ?></td>
	</tr>

	<?php				
	$hargaTotal += $showBarang->TOTAL_HARGA;
	}
	
	
	function format_rupiah($angka){
		$rupiah=number_format($angka,0,',','.');
		return "Rp. ".$rupiah.",00";
	}
	?>
	<tr>
		<td colspan="5"><hr></td>
	</tr>
	<tr>
		<td colspan="3" align="right">Sub Total</td>
		<td  align="right"><?php echo format_rupiah($hargaTotal); ?></td>
	</tr>
	
	<tr>
		<td  align="right" colspan="3">Discount</td>
		<td  align="right"  ><?php echo format_rupiah($this->oldData->DISCOUNT); ?></td>
		
	</tr>					
	<tr>
		<td colspan="3" align="right">Total</td>
		<td align="right"><?php echo format_rupiah($this->oldData->TOTAL_BAYAR); ?></td>
	</tr>
	<tr>
		<td colspan="5"><hr></td>
	</tr>

</table>
			
<!------
<hr>
<?php
if($this->oldData->STATUS_BAYAR=='BL'){
?>
<table class="table table-bordered">
	<tr><th colspan="5"><center>List Pembayaran</center></th></tr>
	<tr>
		<th width="25%" align="center">Tgl Bayar</th>
		<th width="35%" align="center">Jenis Bayar</th>
		<th width="30%" align="center">Nominal</th>
	</tr>
	<?php 
	
	//var_dump($this->dataBarang);
	$bayarTotal = 0;
	foreach ($this->dataBayar as $showBayar) {
		
	?>
	<tr>
		<td><?php echo $showBayar->tgl_bayar_indo; ?></td>
		<td><?php echo $showBayar->JENIS_BAYAR; ?></td>
		<td><?php echo format_rupiah($showBayar->JUMLAH_BAYAR); ?></td>
	</tr>
	<?php				
	$bayarTotal += $showBayar->JUMLAH_BAYAR;
	}
	
	
	
	?>
	<tr>
		<td colspan="2" align="right">Sub Total</td>
		<td colspan="2" align="center"><?php echo format_rupiah($bayarTotal); ?></td>
	</tr>
	

	

</table>

<table class="table table-bordered">
	<tr>
		<td align="right">Kekurangan Bayar</td>
		<td width="30%" align="center">
		<?php 
		$kurangbayar = $this->oldData->TOTAL_BAYAR - $bayarTotal;
		echo format_rupiah($kurangbayar); 
		?>
		</td>
	</tr>

</table>	
<?php
}
?>	

---->


<table width="100%">
<tr>
		<td width="60%"></td>
		<td width="40%" align="center">
			<br>
			Hormat Kami
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			( <?php echo $this->session->userdata('nama_karyawan'); ?> )
		</td>
</tr>
</table>
</body>
  
<script>window.print();</script>
