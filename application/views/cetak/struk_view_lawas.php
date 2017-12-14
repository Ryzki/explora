<style>
	@page{		
		margin:0px;
		font-size:20px;
	}
	body{
		margin:0px;
	}
</style>

<title>Cetak Struk</title>

<body>
<center ><b style="font-size:18px;">EXPLORA</b></center>
<center ><b style="font-size:20px;">Digital Printing</b></center>
<center ><?php echo $this->dataProfil->ALAMAT_TOKO ?></center>
<center >Telp : <?php echo $this->dataProfil->TELP_TOKO ?></center>
<center ><?php echo $this->dataProfil->WEBSITE ?></center>
<hr>
<table width="100%" cellpadding="3" style="font-size:20px;">	
	<tr>		
		<td align="">No WO : <b><?php echo $this->oldData->NO_WO; ?></b></td>
	</tr>
	<tr>		
		<td >Tanggal : <?php echo $this->oldData->TGL_ORDER; ?></td>
	</tr>	
</table>
<hr>

<table  width="100%" cellpadding="3" style="font-size:20px;">

	<?php 
	
	//var_dump($this->dataBarang);
	$hargaTotal = 0;
	foreach ($this->dataBarang as $showBarang) {
	?>
	<tr>
		<td colspan="2"><?php echo $this->text_barang->getTextStruk($showBarang->ID_ORDER,$showBarang->COUNT_BARANG); ?></td>
	</tr>
	<tr>
		<td><?php echo $showBarang->JUMLAH_QTY; ?> x <?php echo format_rupiah($showBarang->HARGA_SATUAN); ?></td>
		<td align="right" width="50%"><?php echo format_rupiah($showBarang->TOTAL_HARGA); ?></td>
	</tr>

	<?php				
	$hargaTotal += $showBarang->TOTAL_HARGA;
	}
	
	
	function format_rupiah($angka){
		$rupiah=number_format($angka,0,',','.');
		return "Rp. ".$rupiah.",00";
	}
	?>	
</table>
	
<hr>
<table  width="100%" cellpadding="3" style="font-size:20px;">		
	<tr>
		<td >Sub Total</td>
		<td  width="50%" align="right"><?php echo format_rupiah($hargaTotal); ?></td>
	</tr>	
	<tr>
		<td >Discount</td>
		<td  width="50%" align="right"  ><?php echo format_rupiah($this->oldData->DISCOUNT); ?></td>
		
	</tr>					
	<tr>
		<td >Total</td>
		<td  width="50%" align="right"><?php echo format_rupiah($this->oldData->TOTAL_BAYAR); ?></td>
	</tr>
</table>
	<?php
	if($this->oldData->STATUS_BAYAR=='BL'){
	?>

		<table  width="100%" cellpadding="3" style="font-size:20px;">
			<tr>
				<td >Sudah Dibayar </td>
				<td  width="50%" align="right"><?php echo format_rupiah($this->dataTotalBayarBelumLunas->JUMLAH); ?></td>
			</tr>		
			<tr>
				<td >Kekurangan Bayar</td>
				<td  width="50%" align="right">
				<?php 
				$kurang = $this->oldData->TOTAL_BAYAR - $this->dataTotalBayarBelumLunas->JUMLAH;
				echo format_rupiah($kurang); 
				?>
				</td>
			</tr>	
		</table>
	<?php
	}
	?>
	<?php
	if($this->oldData->STATUS_BAYAR=='L'){
	?>

		<table  width="100%" cellpadding="3" style="font-size:20px;">
			<tr>
				<td >Uang Bayar</td>
				<td  width="50%" align="right"><?php echo format_rupiah($this->dataUangBayar->JUMLAH_BAYAR); ?></td>
			</tr>		
			<tr>
				<td >Uang Kembali</td>
				<td  width="50%" align="right"><?php echo format_rupiah($this->dataUangBayar->JUMLAH_KEMBALI); ?></td>
			</tr>	
		</table>
	<?php
	}
	?>
<hr>
<?php echo date('d-m-Y h:i');?>, <?php echo $this->session->userdata('nama_karyawan');?>
<br>
<br>

<table  width="100%" cellpadding="3" style="font-size:20px;">
	<?php
	if($this->oldData->STATUS_BAYAR=='L'){
		echo "<tr><td align='center'>LUNAS, Terima Kasih</td></tr>";
	}
	?>     
	
	<?php
	foreach($this->dataKeterangan as $keterangan){
		//echo "<tr><td> - ".$keterangan->KETERANGAN."</td></tr>";
	}
	?>

</table>

<table width="100%" cellpadding="3" style="font-size:20px;">
	<?php
	foreach($this->dataKeterangan as $keterangan){
		echo "<tr><td width='1%'>-</td><td>".$keterangan->KETERANGAN."</td></tr>";
	}
	?>
</table>
</body>
  
<script>window.print();</script>
