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
                <th class="text-center">No WO</th>
                <th class="text-center">Nama Barang</th>
                <th class="text-center">Harga</th>
              </tr>
            </thead>
            <tbody>
				<?php
				$i=1;
				$total="";
				foreach($this->showData as $showData ){
				?>
				<tr>
					
					<td align="center">
						<?php echo $i."."; ?>
					</td>
					<td ><?php echo $showData->no_wo; ?></td>
					<td >
						<?php echo $this->text_barang->getText($showData->ID_ORDER,$showData->COUNT_BARANG); ?>
								
					</td>
					<td align="right" ><?php echo format_rupiah($showData->TOTAL_HARGA); ?></td>
				</tr>
				<?php
				$i++;
				$total += $showData->TOTAL_HARGA;
				}
				if(!$this->showData){
					echo "<tr><td colspan='25' align='center'>Data tidak ada.</td></tr>";
				}
				else{
				?>
				<tr>
					
					<td colspan="3" align="right"><h4>Total</h4></td>
					<td align="right"><h4><?php echo format_rupiah($showData->TOTAL_HARGA); ?></h4></td>
				</tr>
				
				<?php
				}
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
  
