
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
							<div class="col-sm-6">
								<input type="input" class="form-control required" id="NAMA_BARANG_GUDANG" name="NAMA_BARANG_GUDANG" >
							</div>
						</div>	
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Satuan :</label>
							<div class="col-sm-2">
								<input type="input" class="form-control required" placeholder="Contoh : roll, lbr"  id="SATUAN_BARANG_GUDANG" name="SATUAN_BARANG_GUDANG">
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
  
