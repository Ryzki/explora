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
			
				
				
			</div>
				<hr>
			<div class="row">
				<div class="col-sm-10 col-sm-offset-1 ">

				<?php echo  $this->showLaporan; ?>
		   
				<br>
				<br>
				<a href="<?=base_url();?>cetak/laporan_kas/?id=<?php echo $this->input->get("id"); ?>" target="_blank">
					<span class="btn btn-success">Cetak Laporan kas</span>
				</a>
				</div>
			</div>
    </div>
  </div>
</section>
<!-- /.content -->
  
