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
<title>Cetak Laporan Kas</title>
<body>
		<center><b>Laporan kas</b><br>
		SHIFT <?php echo $this->dataTutupKas->SHIFT; ?><br>
		Tgl Penutupan Kas : <?php echo $this->dataTutupKas->TGL_TUTUP_KAS; ?><br>
		<?php echo $this->dataTutupKas->KETERANGAN; ?><br>
		</	center>
		<hr>
		
		   
				<?php echo  $this->showLaporan; ?>
		   
		
</body>
<!-- /.content -->
<script>window.print();</script>

  
