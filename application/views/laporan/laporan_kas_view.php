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
				<form class="form-horizontal" method="post" action="laporan_kas/tutup" onSubmit="if(!confirm('Anda yakin akan menutup Laporan Kas ..?')){return false;}">
				<label class="control-label col-sm-2" for="email">Shift :</label>
				<div class="col-sm-2 ">
					<select class="form-control"  name="shift" required>
						<option value="">Pilih Shift</option>
						<option value="1">Shift 1</option>
						<option value="2">Shift 2</option>
					</select>
				</div>
				<div class="col-sm-4 ">
					<input type="text" name="ket" required placeholder="Keterangan" class="form-control">
				</div>
				<div class="col-sm-2">
					<button class="btn btn-warning">Penutupan Kas</button>
				</div>

				
				</form>
				
			</div>
				<hr>
			
			 <div class="box-body box-table">
        <table class="table table-bordered">
            <thead>
              <tr>
                <th >No.</th>
                <th>Tgl Penutupan Kas</th>
                <th>Karyawan Penutupan Kas</th>
                <th>Shift</th>
                <th>Keterangan</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
				<?php
				$no = $this->input->get('per_page')+ 1;
				foreach($this->showData as $showData ){
				?>
				<tr>
				
					<td align="center"><?php echo $no; ?>.</td>
					<td ><?php echo $showData->TGL_TUTUP_KAS; ?></td>
					<td ><?php echo $showData->NAMA_KARYAWAN; ?></td>
					<td ><?php echo $showData->SHIFT; ?></td>
					<td ><?php echo $showData->KETERANGAN; ?></td>
					<td align="center">
						<a href="<?=base_url();?>laporan_kas/detail/?id=<?php echo $showData->ID_TUTUP_KAS; ?>">
							<span class="btn btn-success">Detail Laporan Kas</span>
						</a>
					</td>
				</tr>
				<?php
				$no++;
				}
				if(!$this->showData){
					echo "<tr><td colspan='25' align='center'>Data tidak ada.</td></tr>";
				}
				?>
            </tbody>
        </table>
        <center>
			<?php echo $this->pagination->create_links();?>
			<br>
			<span class="btn btn-default">Jumlah Data : <b><?php echo $this->jumlahData;?></b></span>
		</center>
          
        </div>
			
    </div>
  </div>
</section>
<!-- /.content -->
  
