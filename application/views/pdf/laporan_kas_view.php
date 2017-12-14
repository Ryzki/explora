
<style>
	body{
		font-size:12px;
	}
	body table{
		font-size:12px;
	}
	.table-bordered {
    border: 1px solid #f4f4f4;
}
.table-bordered {
    border: 1px solid #ddd;
}
.table {
    width: 100%;
    max-width: 100%;
    margin-bottom: 20px;
}
table {
    background-color: transparent;
}
table {
    border-spacing: 0;
    border-collapse: collapse;
}
.table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {
    border: 1px solid #f4f4f4;
}
</style>
<center><h3>Laporan Kas Toko <?php echo $this->dataProfil->NAMA_TOKO; ?> untuk tanggal <?php echo date('d-m-Y h:i:s');?></h3></center>
<hr>
<?php

	echo $this->showLaporan;

?>