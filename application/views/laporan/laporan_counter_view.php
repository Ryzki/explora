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
				<form method="get" class="form-horizontal">
				<label class="control-label col-sm-2 col-md-offset-2" for="email">Pilih Tanggal :</label>
				<div class="col-sm-2 ">
					<input class="form-control" name="date" id="datepicker" value="<?php echo  $this->input->get('date'); ?>" data-date-format='dd-mm-yyyy'   > 
				</div>
				
				<div class="col-sm-2">
					<button class="btn btn-primary"><i class="fa fa-search"></i> Tampilkan</button>
				</div>
				<?php
					echo $this->button ;
				?>
				<!--<br>
				<br>
				<br>
				<div class="col-sm-8 col-md-offset-4">
				
					<?php
			if($this->input->get('date')){
			?>
				
					<span class="btn btn-success" onclick="kirim_lap_counter()"><i class="fa fa-mail"></i> Kirim Laporan ke Owner</span>
						<?php
			}
			?>
					<img src="<?php echo base_url();?>assets/img/loading.gif" id="loading" style="display:none">
					<br>
					<p id="pesan_error" style="display:none" class="text-warning" ></p>
				</div>-->
				
				</form>
				
			</div>
				<hr>
			<div class="row">
				<div class="col-sm-10 col-sm-offset-1 ">
			<?php
			if($this->input->get('date')){
			?>
		   
				<?php echo  $this->showLaporan; ?>
		   
			<?php
			}
			?>
			</div>
			</div>
    </div>
  </div>
</section>
<!-- /.content -->
  
