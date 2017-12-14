
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
							<label class="control-label col-sm-2" for="email">Nama Pelanggan :</label>
							<div class="col-sm-4">
								<input type="input" class="form-control required" id="nama_pelanggan" name="nama_pelanggan" >
							</div>
						</div>	
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">HP Pelanggan :</label>
							<div class="col-sm-2">
								<input type="input" class="form-control required number" maxlength="18" id="nomor_telp" name="nomor_telp">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">eMail :</label>
							<div class="col-sm-5">
								<input type="input" class="form-control email" maxlength="100" id="email" name="email">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Alamat Pelanggan :</label>
							<div class="col-sm-8">
								<input type="input" class="form-control required" id="alamat" name="alamat" >
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Kode POS :</label>
							<div class="col-sm-2">
								<input type="input" class="form-control" maxlength="8" id="kode_pos" name="kode_pos">
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Kantor :</label>
							<div class="col-sm-4">
								<input type="input" class="form-control" maxlength="" id="kantor" name="kantor">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Alamat Kantor :</label>
							<div class="col-sm-8">
								<input type="input" class="form-control" maxlength="" id="alamat_kantor" name="alamat_kantor">
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">No Telp Kantor :</label>
							<div class="col-sm-3">
								<input type="input" class="form-control number" maxlength="18" id="no_telp_kantor" name="no_telp_kantor">
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Tgl Mulai Member :</label>
							<div class="col-sm-3">
								<input type="input" class="form-control" maxlength="18" id="datepicker" name="tgl_mulai_member" data-date-format='dd-mm-yyyy'>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Tgl Akhir Member :</label>
							<div class="col-sm-3">
								<input type="input" class="form-control" maxlength="18" id="datepicker2" name="tgl_akhir_member" data-date-format='dd-mm-yyyy'>
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
  
