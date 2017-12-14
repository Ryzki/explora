<style>
	@page{		
		margin:0px;
		font-size:14px;
	}
	body{
		margin:0px;
		font-size:14px;
	}
	table{
		font-size:14px;
	}
</style>
<title>Cetak Antrian</title>
<body>
<center><h4>EXPLORA</h4></center>
<center>Selamat Datang</center>
<center>No. Antrian Anda</center>
<center><h3><?php echo $this->oldData->NO_ORDER; ?></h3></center>
<center><?php echo ($this->oldData->LOG_MEMBER  =='Y'  ? 'Member' : 'Non Member' ); ?></center>
<center><?php echo $this->oldData->TGL_JAM_ORDER  ; ?></center>
<br>
<center>Terima Kasih</center>
<center>Anda Telah Menunggu</center>


</body>
  
<script>window.print();</script>
