
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
								<input type="hidden" class="form-control required" id="ID_BARANG" name="ID_BARANG" value="<?php echo $this->oldData->ID_BARANG; ?>">
								<input type="input" class="form-control required" id="NAMA_BARANG" name="NAMA_BARANG" value="<?php echo $this->oldData->NAMA_BARANG; ?>">
							</div>
						</div>	
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Satuan :</label>
							<div class="col-sm-2">
								<input type="input" class="form-control required" placeholder="Contoh : roll, lbr" maxlength="18" id="SATUAN" name="SATUAN" value="<?php echo $this->oldData->SATUAN; ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Jenis Harga :</label>
							<div class="col-sm-4">
								<select class="form-control required" onchange="jenis_harga()" id="JENIS_HARGA" name="JENIS_HARGA" >
									<option value="">Silahkan pilih</option>
									<option <?php if( $this->oldData->JENIS_HARGA == 'SAMA') echo "selected"; ?> value="SAMA">Harga sama dengan jumlah berapapun</option>
									<option <?php if( $this->oldData->JENIS_HARGA == 'BEDA') echo "selected"; ?> value="BEDA">Jumlah beli mempengaruhi Harga</option>
								</select>
							</div>
						</div>
						
						<div class="form-group" id="div_harga_satuan" style="display:<?php if( $this->oldData->JENIS_HARGA == 'BEDA') echo "none"; ?>">
							<label class="control-label col-sm-2" for="email">Harga Satuan :</label>
							<div class="col-sm-2">
								<input type="input" class="form-control" id="HARGA_SATUAN" name="HARGA_SATUAN" value="<?php echo $this->oldData->HARGA_SATUAN; ?>">
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
						<?php if( $this->oldData->JENIS_HARGA == 'BEDA'){ ?>
						<span id="div_form_harga">
						<hr>
						<br>
						<form class="form-horizontal" id="form_harga_barang">
							<input type="hidden" class="form-control required" id="ID_BARANG" name="ID_BARANG" value="<?php echo $this->oldData->ID_BARANG; ?>">
							<div class="form-group">
								<div class="col-sm-2"></div>
								<div class="col-sm-2">
									<input type="" class="form-control required number" id="MIN_BARANG" name="MIN_BARANG"  placeholder="Jumlah Minimal">
								</div>
								<div class="col-sm-2">
									<input type="" class="form-control required number" id="MAX_BARANG" name="MAX_BARANG"  placeholder="Jumlah Maximal">
								</div>
								<div class="col-sm-2">
									<input type="" class="form-control required number" id="HARGA" name="HARGA"  placeholder="Harga">
								</div>
								
								<div class="col-sm-4">
									<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Tambah </button>
									<img src="<?php echo base_url();?>assets/img/loading.gif" id="loading_harga_barang" style="display:none">
								</div>
							</div>	
							
							
						</form>	
						<table class="table table-bordered">
							<thead>
								<tr>
									<th  width="15%"></th>
									<th  width="25%">Jumlah Minimal</th>
									<th  width="25%">Jumlah Maksimal</th>
									<th>Harga</th>
								</tr>
							</thead>
							<tbody>
							<?php foreach($this->data_harga as $harga) { ?>
								<tr>
									<td>
										<span class='btn btn-danger btn-xs' onclick='tampil_pesan_hapus("harga barang dengan min barang : <?php echo $harga->MIN_BARANG; ?> dan max barang : <?php echo $harga->MAX_BARANG; ?> dengan harga : <?php echo $harga->HARGA; ?>","<?php echo base_url()."".$this->uri->segment(1)."/delete_harga_barang/".$harga->ID_T_HARGA_BARANG."/".$harga->ID_BARANG; ?>")'><i class='fa fa-trash'></i></span>
									</td>
									<td><?php echo $harga->MIN_BARANG; ?></td>
									<td><?php echo $harga->MAX_BARANG; ?></td>
									<td><?php echo $harga->HARGA; ?></td>
								</tr>
							<?php } ?>
							</tbody>
						</table>
						<?php } ?>
						</span>
						
				</div>
			</div>
		</div>
	</div>
</section>
<!-- /.content -->
  
