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
				
				<div class="col-sm-4">
					<button class="btn btn-primary"><i class="fa fa-file"></i> Tampilkan</button>
				</div>
				
				</form>
				<hr>
			</div>
				
		
		<?php
		if($this->input->get('date')){
		?>
        <div class="box-body box-table">
        <table class="table table-bordered">
            <thead>
              <tr>
                <th>No.</th>
                <th class="text-center">Nama Kertas</th>
                <th class="text-center">Jumlah ( Lembar )</th>
              </tr>
            </thead>
            <tbody>
				<?php
				echo $this->laporan;
				?>
            </tbody>
        </table>
     
        </div>
		<?php
		}
		?>
    </div>
  </div>
</section>
<!-- /.content -->
  

