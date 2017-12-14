
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
							<label class="control-label col-sm-2" for="email">Nama Toko :</label>
							<div class="col-sm-5">
								<input type="hidden" id="ID_PROFIL" name="ID_PROFIL" value="<?php echo $this->oldData->ID_PROFIL ; ?>">
								<input type="input" class="form-control required" id="NAMA_TOKO" name="NAMA_TOKO" value="<?php echo $this->oldData->NAMA_TOKO ; ?>">
							</div>
						</div>	
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">No Telp Toko :</label>
							<div class="col-sm-2">
								<input type="input" class="form-control required number" id="TELP_TOKO" name="TELP_TOKO" value="<?php echo $this->oldData->TELP_TOKO; ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Website :</label>
							<div class="col-sm-5">
								<input type="input" class="form-control required" id="WEBSITE" name="WEBSITE" value="<?php echo $this->oldData->WEBSITE; ?>">
							</div>
						</div>
						
						
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Alamat Toko :</label>
							<div class="col-sm-5">
								<textarea type="input" class="form-control required" id="ALAMAT_TOKO" name="ALAMAT_TOKO" ><?php echo $this->oldData->ALAMAT_TOKO; ?></textarea>
							</div>
						</div>
							<hr>
						
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">eMail Pengirim :</label>
							<div class="col-sm-4">
								<input type="input" class="form-control required email" id="EMAIL_FROM" name="EMAIL_FROM" value="<?php echo $this->oldData->EMAIL_FROM; ?>">
								<sub>Untuk proses kirim laporan</sub>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Password Pengirim :</label>
							<div class="col-sm-2">
								<input type="input" class="form-control required" id="PASS_EMAIL_FROM" name="PASS_EMAIL_FROM" value="<?php echo $this->oldData->PASS_EMAIL_FROM; ?>">
								<sub>Untuk proses kirim laporan</sub>
							</div>
						</div>
						<hr>
						
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">eMail Owner :</label>
							<div class="col-sm-4">
								<input type="input" class="form-control required email" id="EMAIL_OWNER" name="EMAIL_OWNER" value="<?php echo $this->oldData->EMAIL_OWNER; ?>">
								<sub>Untuk proses kirim laporan</sub>
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
  
