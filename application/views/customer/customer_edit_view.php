
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
							<label class="control-label col-sm-2" for="email">Nama Customer :</label>
							<div class="col-sm-4">
								<input type="hidden" name="ID_CUSTOMER" value="<?php echo $this->oldData->ID_CUSTOMER; ?>">
								<input type="input" class="form-control required" id="NAMA_CUSTOMER" name="NAMA_CUSTOMER" value="<?php echo $this->oldData->NAMA_CUSTOMER; ?>">
							</div>
						</div>	
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">HP Customer :</label>
							<div class="col-sm-2">
								<input type="input" class="form-control required number" maxlength="18"  id="HP_CUSTOMER" name="HP_CUSTOMER" value="<?php echo $this->oldData->HP_CUSTOMER; ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Alamat Customer :</label>
							<div class="col-sm-8">
								<input type="input" class="form-control required" id="ALAMAT_CUSTOMER" name="ALAMAT_CUSTOMER" value="<?php echo $this->oldData->ALAMAT_CUSTOMER; ?>">
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
  
