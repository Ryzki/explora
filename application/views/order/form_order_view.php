
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
					<form class="form-horizontal" id="form_order">
						<div class="form-group">
							<label class="control-label col-sm-3" for="email">No Hp :</label>
							<div class="col-sm-3">
								<input type="input" class="form-control required number" placeholder="Ketikkan nomor HP atau Nama Member" autofocus minlength="3" id="HP_CUSTOMER" name="HP_CUSTOMER" >
								<input type="hidden" id="ID_CUSTOMER" name="ID_CUSTOMER" >
								<input type="hidden" id="LOG_MEMBER" name="LOG_MEMBER" >
							</div>
							<div class="col-sm-6" id="div_pesan_member">
								
							</div>
						</div>	
						<div class="form-group">
							<label class="control-label col-sm-3" for="email">Nama Customer :</label>
							<div class="col-sm-4">
								<input type="input" class="form-control required" id="NAMA_CUSTOMER" name="NAMA_CUSTOMER">
							</div>
						</div>
						<div class="form-group">	
							<label class="control-label col-sm-3" for="email">Alamat Customer :</label>
							<div class="col-sm-6">
								<input class="form-control"  id="ALAMAT_CUSTOMER" name="ALAMAT_CUSTOMER">
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-sm-3" for="email">Tgl Order :</label>
							<div class="col-sm-3">
								<input type="input" class="form-control required" readonly value="<?php echo date('d-m-Y'); ?>" id="TGL_ORDER" name="TGL_ORDER">
							</div>
						</div>
						<div class="form-group">	
							<!--<label class="control-label col-sm-3" for="email">Tgl Ambil :</label>
							<div class="col-sm-3">
								<input type="input" class="form-control required"  id="TGL_AMBIL" name="TGL_AMBIL">
							</div>-->
							<label class="control-label col-sm-3" for="">No Order dari Toko Lain :</label>
							<div class="col-sm-3">
								<input class="form-control" id="NO_ORDER_LAIN" name="NO_ORDER_LAIN" >
								
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-sm-3" for="email">Alur Order :</label>
							<div class="col-sm-4">
								<select class="form-control required" id="JENIS_ORDER" name="JENIS_ORDER" >
									<option value="">Silahkan pilih</option>
									<!--<option value="1">OP Grafis &#10132; OP Print &#10132; Kasir</option>-->
									<option value="2">OP Grafis &#10132; Kasir</option>
									<option value="3">OP Print &#10132; Kasir</option>
									<!--<option value="4">Kasir</option>-->
								</select>
								
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-3" for="">Line :</label>
							<div class="col-sm-4">
								<select class="form-control required" id="LINE" name="LINE" >
									<option value="">Silahkan pilih</option>
									<option value="eMail Order">eMail Order</option>
									<option value="FAST">FAST</option>
									<option value="Lainnya">Lainnya</option>
								</select>
								
							</div>
							
						</div>
						
						<!--<div class="form-group">
							<label class="control-label col-sm-3" for="email"></label>
							<div class="col-sm-4">
								<a href="#" onclick="keterangan_alur_order();">Klik untuk Keterangan Alur Order</a>
							</div>
							
						</div>-->
						<div class="form-group">
							<label class="control-label col-sm-3" for="email">Catatan :</label>
							<div class="col-sm-6">
								<textarea class="form-control" id="CATATAN" name="CATATAN_LOG_ORDER" "required" placeholder="Anda dapat memasukkan keterangan disini, ditujukan pada Operator Grafis atau Kasir sebagai catatan keinginan dari Customer."></textarea>
									
							</div>
						</div>
						
						
						<hr>
						<div class="form-group">
							<div class="col-sm-offset-3 col-sm-9">
								<img src="<?php echo base_url();?>assets/img/loading.gif" id="loading" style="display:none">
								<p id="pesan_error" style="display:none" class="text-warning" style="display:none"></p>
							</div>
						</div>			
						<div class="form-group">        
							<div class="col-sm-offset-3 col-sm-9">
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
  
