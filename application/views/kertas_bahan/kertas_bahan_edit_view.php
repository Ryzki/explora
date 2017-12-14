
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
						<input type="hidden" name="ID_KERTAS" value="<?php echo $this->oldData->ID_KERTAS; ?>">
						
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Nama Kertas :</label>
							<div class="col-sm-4">
								<input type="input" class="form-control required" id="NAMA_KERTAS" name="NAMA_KERTAS" value="<?php echo $this->oldData->NAMA_KERTAS; ?>">
							</div>
						</div>	
						
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Harga Kertas :</label>
							<div class="col-sm-2">
								<input type="input" class="form-control required number" id="HARGA_KERTAS" name="HARGA_KERTAS" value="<?php echo $this->oldData->HARGA_KERTAS; ?>">
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
				<!--<div class="box-body">
					<hr>
					<form class="form-horizontal" id="form_ukuran_kertas">
						<input type="hidden" class="form-control required" id="ID_KERTAS" name="ID_KERTAS" value="<?php echo $this->oldData->ID_KERTAS; ?>">
						<div class="form-group">
							<div class="col-sm-1">
							</div>
							<div class="col-sm-3">
								<select class="form-control required" id="ID_UKURAN_KERTAS" name="ID_UKURAN_KERTAS">
									<option value="">Pilih Ukuran Kertas</option>
									<?php
									foreach($this->kertasIndoorOutdoor as $ukuran){
									?>
									<option value="<?php echo $ukuran->ID_UKURAN_KERTAS;?>"><?php echo $ukuran->UKURAN_KERTAS;?></option>
									<?php
									}
									?>
								</select>
							</div>
							<div class="col-sm-2">
								<input type="" class="form-control required number" id="MINIMAL" name="MINIMAL"  placeholder="Jumlah Minimal">
							</div>
							<div class="col-sm-2">
								<input type="" class="form-control required number" id="MAXIMAL" name="MAXIMAL"  placeholder="Jumlah Maximal">
							</div>
							<div class="col-sm-2">
								<input type="" class="form-control required number" id="HARGA_SATU_SISI" name="HARGA_SATU_SISI"  placeholder="Harga Satu Sisi">
							</div>
							<div class="col-sm-2">
								<input type="" class="form-control required number" id="HARGA_DUA_SISI" name="HARGA_DUA_SISI"  placeholder="Harga Dua Sisi">
							</div>
						</div>
						<div class="form-group">	
							<div class="col-sm-4"></div>
							<div class="col-sm-3">
								<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Tambah </button>
								<img src="<?php echo base_url();?>assets/img/loading.gif" id="loading_harga_barang" style="display:none">
							</div>
						</div>	
						
						
					</form>	
					<hr>
					<table class="table table-bordered">
						<thead>
							<tr>
								<th  width="5%"></th>
								<th  width="35%">Ukuran Kertas</th>
								<th  width="15%">Jumlah Minimal</th>
								<th  width="15%">Jumlah Maksimal</th>
								<th>Harga Satu sisi</th>
								<th>Harga Dua Sisi</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach($this->ukuranHarga as $harga) { ?>
							<tr>
								<td>
									<span class='btn btn-danger btn-xs' onclick='tampil_pesan_hapus("data terpilih ..?","<?php echo base_url()."".$this->uri->segment(1)."/delete_harga_barang/".$harga->id_kertas."/".$harga->id_t_harga_barang; ?>")'><i class='fa fa-trash'></i></span>
								</td>
								<td><?php echo $harga->ukuran_kertas; ?></td>
								<td><?php echo $harga->minimal; ?></td>
								<td><?php echo $harga->maximal; ?></td>
								<td><?php echo $harga->harga_satu_sisi; ?></td>
								<td><?php echo $harga->harga_dua_sisi; ?></td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
				</div>-->
			</div>
		</div>
	</div>
</section>
<!-- /.content -->
  
