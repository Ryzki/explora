
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
							<label class="control-label col-sm-4" >Nama Karyawan :</label>
							<div class="col-sm-4">
								<input type="hidden" id="ID_KARYAWAN" name="ID_KARYAWAN" value="<?php echo $this->oldData->ID_KARYAWAN; ?>">
								<input type="input" class="form-control required" value="<?php echo $this->oldData->NAMA_KARYAWAN; ?>" id="NAMA_KARYAWAN_AUTOCOMPLETE" name="NAMA_KARYAWAN">
							</div>
						</div>	
						<div class="form-group">
							<label class="control-label col-sm-4" for="email">Kategori User :</label>
							<div class="col-sm-4">
								<select class="form-control"  name="ID_KATEGORI_USER">
									<option value="">Silahkan Pilih</option>
									<?php 
									foreach($this->dataKategoriUser as $kat_user){
									?>
									<option <?php if($this->oldData->ID_KATEGORI_USER == $kat_user->ID_KATEGORI_USER) echo "selected"; ?> value="<?php echo $kat_user->ID_KATEGORI_USER ?>"><?php echo $kat_user->NAMA_KATEGORI_USER ?></option>
									<?php
									}
									?>
								</select>
							</div>
						</div>	
						<div class="form-group">
							<label class="control-label col-sm-4" >Username :</label>
							<div class="col-sm-3">
								<input type="input" value="<?php echo $this->oldData->USERNAME; ?>" class="form-control required" id="USERNAME" name="USERNAME">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-4" >Password :</label>
							<div class="col-sm-2">
								<input type="password" value="<?php echo $this->oldData->PASSWORD; ?>" class="form-control required" id="PASSWORD" name="PASSWORD">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-4" >Ulangi Password :</label>
							<div class="col-sm-2">
								<input type="password" value="<?php echo $this->oldData->PASSWORD; ?>" class="form-control required" id="REPASS" name="REPASS">
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-4 col-sm-10">
								<img src="<?php echo base_url();?>assets/img/loading.gif" id="loading" style="display:none">
								<p id="pesan_error" style="display:none" class="text-warning" style="display:none"></p>
							</div>
						</div>			
						<div class="form-group">        
							<div class="col-sm-offset-4 col-sm-10">
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
  
