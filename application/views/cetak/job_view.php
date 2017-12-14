<style>
	@page{		
		margin:0px;
		font-size:11px;
	}
	body{
		margin:0px;
		font-size:11px;
	}
	table{
		font-size:11px;
	}
</style>
<title>Cetak Work Order</title>
<body>
<table width="100%" cellpadding="0">
	<tr>			
		<td align="center"><h3>Explora</h3></td>
	</tr>
	<tr>		
		<td align=""><strong>No WO : <?php echo $this->oldData->NO_WO; ?></strong><br>
		<?php echo $this->oldData->TGL_ORDER; ?> <?php echo $this->oldData->JAM_ORDER; ?>, <?php echo $this->oldData->NAMA_KARYAWAN; ?><br>
		Jam Operator Komputer : <?php echo $this->dataOperator->TGL_LOG_ORDER; ?> <?php echo $this->dataOperator->JAM_LOG_ORDER; ?><br>
		Nama Operator komputer : <?php echo $this->dataOperator->NAMA_KARYAWAN; ?>
		
		<br>
		<br>
		
		</td>
	</tr>
	
	<tr>		
		<td align="">Nama : <?php echo $this->oldData->nama_pelanggan; ?></td>
	</tr>
	<tr>
		<td align="">No Telp : <?php echo $this->oldData->nomor_telp; ?> | <?php echo ($this->oldData->LOG_MEMBER=='M' ? 'MEMBER' : 'NON MEMBER' ) ?></td>
	</tr>
		
</table>
<hr>
	<?php
	foreach ($this->dataBarang as $showBarang) {
		echo $this->text_job->getText($showBarang->ID_ORDER,$showBarang->COUNT_BARANG); 	
	}
	?>

	<?php echo $this->ringkasan; ?>
<hr>
<table width="100%" cellpadding="0">
	<tr>			
		<td ><b>Keterangan Finishing / Potong</b><br></td>
	</tr>
</table>
<table width="100%" cellpadding="0">
	<tr>			
		<td width="50%">[ &nbsp;]Potong Cross/Image</td>
		<td width="50%">[ &nbsp;]Laminasi Doff/Glossy</td>
	</tr>
	<tr>			
		<td width="50%">[ &nbsp;]Soft/Hard Cover</td>
		<td width="50%">[ &nbsp;]Staples/Spiral</td>
	</tr>
</table>
<br>
<br>
<br>
<hr>
<table width="100%" cellpadding="0">
	<tr>			
		<td colspan="2"><b>Menyetujui Hasil Cetak</b></td>
	</tr>
	<tr>			
		<td width="50%"></td>
		<td width="50%">[ &nbsp;] Ditunggu</td>
	</tr>
	<tr>			
		<td width="50%"></td>
		<td width="50%">[ &nbsp;] Diambil Tgl/Jam</td>
	</tr>
</table>
<hr>
<table width="100%" cellpadding="0">
	<?php
	foreach($this->dataKeterangan as $keterangan){
		echo "<tr><td width='1%'>-</td><td>".$keterangan->KETERANGAN."</td></tr>";
	}
	?>
</table>
</body>

  
<script>window.print();</script>
