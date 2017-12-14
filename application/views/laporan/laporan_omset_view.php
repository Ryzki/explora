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
				<label class="control-label col-sm-2 col-md-offset-2" for="email">Pilih Tanggal :</label>
				<div class="col-sm-2 ">
					<input class="form-control" name="mulai"  placeholder="Tgl Mulai" id="datepicker" value="<?php echo  $this->input->get('mulai'); ?>" data-date-format='dd-mm-yyyy'   > 
				</div>
				<div class="col-sm-2 ">
					<input class="form-control" name="akhir"  placeholder="Tgl Akhir" id="datepicker2" value="<?php echo  $this->input->get('akhir'); ?>" data-date-format='dd-mm-yyyy'   > 
				</div>
				<div class="col-sm-2">
					<span class="btn btn-primary" onclick="sendLaporanOmset()"><i class="fa fa-search"></i> Kirim Laporan ke eMail Owner</span>
				</div>
				
			</div>
				<hr>
			<div class="row">
				<div class="col-sm-10  col-md-offset-2">
				<img src="<?php echo base_url();?>assets/img/loading.gif" id="loading" style="display:none">
					<br>
					<p id="pesan_error" style="display:none" class="text-warning" ></p>
				</div>
			</div>
    </div>
  </div>
</section>
<!-- /.content -->
  
