
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
							<label class="control-label col-sm-2" for="email">Minimal Menit :</label>
							<div class="col-sm-4">
								<input type="hidden" name="ID_HARGA_GRAFIS" value="<?php echo $this->oldData->ID_HARGA_GRAFIS; ?>">
								<input type="input" class="form-control required number" id="MIN_MENIT" name="MIN_MENIT" value="<?php echo $this->oldData->MIN_MENIT; ?>">
							</div>
						</div>	
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Maksimal Menit :</label>
							<div class="col-sm-4">
								<input type="input" class="form-control required number" id="MAX_MENIT" name="MAX_MENIT" value="<?php echo $this->oldData->MAX_MENIT; ?>">
							</div>
						</div>	
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Harga Jasa Grafis :</label>
							<div class="col-sm-4">
								<input type="input" class="form-control required number" id="HARGA" name="HARGA" value="<?php echo $this->oldData->HARGA; ?>">
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
  
