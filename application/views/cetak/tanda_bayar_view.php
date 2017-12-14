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

<title>Cetak tanda Bayar</title>

<body>



	<?php
		function format_rupiah($angka){
		$rupiah=number_format($angka,0,',','.');
		return "Rp. ".$rupiah.",00";
	}
echo $this->cetak; 

?>
	<?php
//	if($this->oldData->STATUS_BAYAR=='BL'){
	?>
	<hr>
		<table  width="100%" cellpadding="0">
			<?php 
			$totalBayar= 0 ;
			foreach($this->dataBayar as $dataBayar){
			?>			
			<tr>
				<td><?php echo $dataBayar->TGL_BAYAR_INDO; ?></td>
				<td><?php echo $dataBayar->JENIS_BAYAR; ?></td>
				<td  align="right"><?php echo format_rupiah($dataBayar->JUMLAH_KAS); ?></td>
			</tr>	
			<?php
			$totalBayar +=$dataBayar->JUMLAH_KAS;
			}
			?>
			<tr>
				<td  colspan='2'>Total Dibayar </td>
				<td  width="50%" align="right"><?php echo format_rupiah($totalBayar); ?></td>
			</tr>		
			<tr>
				<td colspan='2'>Kekurangan Bayar</td>
				<td  width="50%" align="right">
				<?php 
				$kurang = $this->oldData->TOTAL_BAYAR - $totalBayar;
				if($kurang == '0'){
					echo "LUNAS";
				}
				else{
					echo format_rupiah($kurang);
				}
				 
				?>
				</td>
			</tr>	
		</table>
	<?php
	//}
	?>
	<?php
	if($this->oldData->STATUS_BAYAR=='L'){
	?>

	<!--	<table  width="100%" cellpadding="3" style="font-size:16px;">
			<tr>
				<td >Uang Bayar</td>
				<td  width="50%" align="right"><?php echo format_rupiah($this->dataUangBayar->JUMLAH_BAYAR); ?></td>
			</tr>		
			<tr>
				<td >Uang Kembali</td>
				<td  width="50%" align="right"><?php echo format_rupiah($this->dataUangBayar->JUMLAH_KEMBALI); ?></td>
			</tr>	
		</table> -->
	<?php
	}
	?>
<hr>
<?php echo date('d-m-Y h:i');?>, <?php echo $this->session->userdata('nama_karyawan');?>
<br>
<br>

<table  width="100%" cellpadding="0">
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

<table width="100%" cellpadding="0">
	<?php
	foreach($this->dataKeterangan as $keterangan){
		echo "<tr  valign='top'><td width='1%'  valign='top'>-</td><td>".$keterangan->KETERANGAN."</td></tr>";
	}
	?>
</table>
</body>
  
<script>window.print();</script>
