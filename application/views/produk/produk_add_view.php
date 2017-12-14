
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
							<label class="control-label col-sm-2" for="email">Perusahaan / Toko :</label>
							<div class="col-sm-4">
								<select class="form-control required" id="id_profil" name="id_profil">
									<option value="">Silahkan Pilih</option>
									<?php
									foreach($this->dataToko as $toko){
									?>
									<option value="<?php echo $toko->ID_PROFIL ?>"><?php echo $toko->NAMA_TOKO ?></option>									
									<?php
									}
									?>
									
								</select>
							</div>
						</div>	
						
						
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Kategori Produk :</label>
							<div class="col-sm-4">
								<select class="form-control required" id="kategori" name="kategori">
									<option value="">Silahkan Pilih</option>
									<option value="1">A3+</option>
									<option value="2">Indoor/Outdoor</option>
									<option value="3">Lain-Lain</option>
								</select>
							</div>
						</div>	
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Nama Produk :</label>
							<div class="col-sm-4">
								<input type="input" class="form-control required" id="nama_produk" name="nama_produk" >
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
  
