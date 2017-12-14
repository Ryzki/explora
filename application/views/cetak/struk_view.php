<style>
	@page{		
		margin:0px;
		font-size:16px;
	}
	body{
		margin:0px;
	}
</style>

<title>Cetak Struk</title>

<body>
<?php 
	
	function format_rupiah($angka){
		$rupiah=number_format($angka,0,',','.');
		return "Rp. ".$rupiah.",00";
	}

echo $this->cetak; 

?>


	

	<?php
	if($this->oldData->STATUS_BAYAR=='BL'){
	?>

		<table  width="100%" cellpadding="3" style="font-size:16px;">
			<tr>
				<td ><?php echo$this->dataJenisBayarBelumLunas->jenis_bayar; ?></td>
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

		<table  width="100%" cellpadding="3" style="font-size:16px;">
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

<table  width="100%" cellpadding="3" style="font-size:16px;">
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

<table width="100%" cellpadding="3" style="font-size:16px;">
	<?php
	foreach($this->dataKeterangan as $keterangan){
		echo "<tr  valign='top'><td width='1%' valign='top'>-</td><td>".$keterangan->KETERANGAN."</td></tr>";
	}
	?>
</table>
</body>
  
<script>window.print();</script>
