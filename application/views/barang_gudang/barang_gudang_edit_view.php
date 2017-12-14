
<!-- Content Header (Page header) -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">		
				<div class="box-header">
					<h4><?php echo $this->template_view->nama_menu('nama_menu'); ?></h4>
					<h5><?php echo $this->template_view->nama_menu('judul_menu'); ?></h5>
					<hr>			
				</div>
				<div class="box-body">
					
					
					
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="false">Edit Data Barang Gudang</a></li>
						<li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Barang Masuk</a></li>
						<li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="true">Barang Keluar</a></li>

					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="tab_1">
					
					
							<form class="form-horizontal" id="form_standar">
								<div class="form-group">
								<label class="control-label col-sm-2" for="email">Nama Barang :</label>
								<div class="col-sm-6">
								<input type="input" class="form-control required" value="<?php echo $this->oldData->NAMA_BARANG_GUDANG;?>" id="NAMA_BARANG_GUDANG" name="NAMA_BARANG_GUDANG" >
								<input type="hidden" class="form-control required" value="<?php echo $this->oldData->ID_BARANG_GUDANG;?>" id="ID_BARANG_GUDANG" name="ID_BARANG_GUDANG" >
								</div>
								</div>	
								<div class="form-group">
								<label class="control-label col-sm-2" for="email">Satuan :</label>
								<div class="col-sm-2">
								<input type="input" class="form-control required" placeholder="Contoh : roll, lbr"  value="<?php echo $this->oldData->SATUAN_BARANG_GUDANG;?>"  id="SATUAN_BARANG_GUDANG" name="SATUAN_BARANG_GUDANG">
								</div>
								</div>

								<div class="form-group" id="div_harga_satuan" >
								<label class="control-label col-sm-2" for="email">Keterangan :</label>
								<div class="col-sm-5">
								<textarea type="input" class="form-control" id="KETERANGAN" name="KETERANGAN"><?php echo $this->oldData->KETERANGAN;?></textarea>
								</div>
								</div>
								<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
								<img src="<?php echo base_url();?>assets/img/loading.gif" id="loading" style="display:none">
								<p id="pesan_error" style="display:none" class="text-warning" style="display:none"></p>
								</div>
								</div>			
								<div class="form-group">        
								<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
								<a href="<?=base_url()."".$this->uri->segment(1);?>">
								<span class="btn btn-warning"><i class="fa fa-remove"></i> Batal</span>
								</a>
								</div>
								</div>
							</form>	
					
						</div>
						<!-- /.tab-pane -->
						<div class="tab-pane" id="tab_2">
						
							<table class="table table-bordered">
								<thead>
									<tr>
									<th colspan="" width="5%">No.</th>
									<th width="15%">Karyawan Entry</th>
									<th>Nama Barang</th>
									<th width="10%">Jumlah Barang Masuk</th>
									<th width="10%">Tgl Entry</th>
									<th width="10%">Tgl Barang Masuk</th>
									<th>Keterangan</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$no = $this->input->get('per_page')+ 1;
									foreach($this->showDataMasuk  as $showData ){
									//VAR_DUMP( $showData);
									?>
									<tr>

									<td align="center"><?php echo $no; ?>.</td>
									<td ><?php echo $showData->NAMA_KARYAWAN; ?></td>
									<td ><?php echo $showData->NAMA_BARANG_GUDANG; ?></td>
									<td ><?php echo $showData->JUMLAH_MASUK; ?></td>
									<td ><?php echo $showData->TGL_ENTRY_INDO; ?></td>
									<td ><?php echo $showData->TGL_BARANG_MASUK_INDO ?></td>
									<td ><?php echo $showData->TRANS_KETERANGAN; ?></td>

									</tr>
									<?php
									$no++;
									}
									if(!$this->showDataMasuk){
									echo "<tr><td colspan='25' align='center'>Data tidak ada.</td></tr>";
									}
									?>
								</tbody>
							</table>
						
						</div>
						<!-- /.tab-pane -->
						<div class="tab-pane " id="tab_3">
							<table class="table table-bordered">
								<thead>
									<tr>
									<th colspan="" width="5%">No.</th>
									<th width="15%">Karyawan Entry</th>
									<th>Nama Barang</th>
									<th width="10%">Jumlah Barang Keluar</th>
									<th width="10%">Tgl Entry</th>
									<th width="10%">Tgl Barang Keluar</th>
									<th>Keterangan</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$no = $this->input->get('per_page')+ 1;
									foreach($this->showDataKeluar as $showData ){
									//VAR_DUMP( $showData);
									?>
									<tr>

									<td align="center"><?php echo $no; ?>.</td>
									<td ><?php echo $showData->NAMA_KARYAWAN; ?></td>
									<td ><?php echo $showData->NAMA_BARANG_GUDANG; ?></td>
									<td ><?php echo $showData->JUMLAH_KELUAR; ?></td>
									<td ><?php echo $showData->TGL_ENTRY_INDO; ?></td>
									<td ><?php echo $showData->TGL_BARANG_KELUAR_INDO ?></td>
									<td ><?php echo $showData->TRANS_KETERANGAN; ?></td>

									</tr>
									<?php
									$no++;
									}
									if(!$this->showDataKeluar){
									echo "<tr><td colspan='25' align='center'>Data tidak ada.</td></tr>";
									}
									?>
								</tbody>
							</table>
						</div>
					<!-- /.tab-pane -->
					</div>
				<!-- /.tab-content -->
				</div>
					
						
				</div>
			</div>
		</div>
	</div>
</section>
<!-- /.content -->
  
