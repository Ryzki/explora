
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
					<form class="form-horizontal" id="form_standar">
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Nama Barang :</label>
							<div class="col-sm-5">
								
								<select class="form-control required"  name="ID_BARANG_GUDANG">
									<option value="">Silahkan Pilih </option>
									<?php
									
									foreach($this->dataBarang  as $dataBarang ){
									?>
									<option value="<?php echo $dataBarang ->ID_BARANG_GUDANG ;?>"><?php echo $dataBarang ->NAMA_BARANG_GUDANG ;?> / <?php echo $dataBarang ->SATUAN_BARANG_GUDANG ;?> </option>
									<?php
									}
									?>
								</select>
								
							</div>
						</div>	
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Jumlah Barang Masuk :</label>
							<div class="col-sm-2">
								<input type="input" class="form-control required number"   name="JUMLAH_MASUK" >
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Tanggal Barang Masuk :</label>
							<div class="col-sm-2">
								<input type="input" class="form-control required" id="datepicker"  name="TGL_BARANG_MASUK" data-date-format='dd-mm-yyyy'>
							</div>
						</div>
						
						<div class="form-group" id="div_harga_satuan" >
							<label class="control-label col-sm-2" for="email">Keterangan :</label>
							<div class="col-sm-5">
								<textarea type="input" class="form-control" id="KETERANGAN" name="KETERANGAN"></textarea>
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
			</div>
		</div>
	</div>
</section>
<!-- /.content -->
  
