<?php
function format_rupiah($angka){
	$rupiah=number_format($angka,0,',','.');
	return $rupiah;
}
?>		
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
								<input type="hidden" name="id_t_harga_barang" value="<?php echo $this->oldData->id_t_harga_barang; ?>">
							
						
						
						
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Pilih Produk :</label>
							<div class="col-sm-4">
								<select class="form-control required" id="id_produk" name="id_produk">
									<option value="">-</option>
									<?php
									foreach($this->dataProduk as $produk){
									?>
									<option <?php echo ( $produk->id_produk == $this->oldData->id_produk ? "selected" : ""); ?> value="<?php echo $produk->id_produk;?>"><?php echo $produk->nama_produk;?></option>
									<?php
									}
									?>
								</select>
							</div>
						</div>	
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Pilih Kertas/Bahan :</label>
							<div class="col-sm-4">
								<select class="form-control required" id="id_kertas" name="id_kertas">
									<option value="">-</option>
									<?php
									foreach($this->dataKertas as $kertas){
									?>
									<option <?php echo ( $kertas->ID_KERTAS == $this->oldData->id_kertas ? "selected" : ""); ?>  value="<?php echo $kertas->ID_KERTAS;?>"><?php echo $kertas->NAMA_KERTAS;?></option>
									<?php
									}
									?>
								</select>
							</div>
							<label class="control-label col-sm-2" for="email">Pilih Ukuran Kertas :</label>
							<div class="col-sm-3">
								<select class="form-control required" id="id_ukuran_kertas" name="id_ukuran_kertas">
									<option value="">-</option>
									<?php
									foreach($this->dataUkuranKertas as $ukuran){
									?>
									<option <?php echo ( $ukuran->ID_UKURAN_KERTAS == $this->oldData->id_ukuran_kertas ? "selected" : ""); ?>  value="<?php echo $ukuran->ID_UKURAN_KERTAS;?>"><?php echo $ukuran->UKURAN_KERTAS;?></option>
									<?php
									}
									?>
								</select>
							</div>
						</div>	
						
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Jumlah Minimal :</label>
							<div class="col-sm-2">
								<input type="input" class="form-control required " onkeyup="formatRibuan(this)" id="minimal" name="minimal"  value="<?php echo format_rupiah($this->oldData->minimal); ?>">
							</div>
							<label class="control-label col-sm-4" for="email">Jumlah Maksimal :</label>
							<div class="col-sm-2">
								<input type="input" class="form-control required" onkeyup="formatRibuan(this)" id="maximal" name="maximal"  value="<?php echo format_rupiah($this->oldData->maximal); ?>">
							</div>
						</div>	
						
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Harga Satu Sisi Member :</label>
							<div class="col-sm-3">
								<input type="input" class="form-control required " onkeyup="formatRibuan(this)" id="harga_satu_sisi_member" name="harga_satu_sisi_member"  value="<?php echo format_rupiah($this->oldData->harga_satu_sisi_member); ?>">
							</div>
							<label class="control-label col-sm-3" for="email">Harga Dua Sisi Member :</label>
							<div class="col-sm-3">
								<input type="input" class="form-control required " onkeyup="formatRibuan(this)" id="harga_dua_sisi_member" name="harga_dua_sisi_member"  value="<?php echo format_rupiah($this->oldData->harga_dua_sisi_member); ?>">
							</div>
						</div>	
						
						
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Harga Satu Sisi :</label>
							<div class="col-sm-3">
								<input type="input" class="form-control required " onkeyup="formatRibuan(this)" id="harga_satu_sisi" name="harga_satu_sisi"  value="<?php echo format_rupiah($this->oldData->harga_satu_sisi); ?>">
							</div>
							<label class="control-label col-sm-3" for="email">Harga Dua Sisi :</label>
							<div class="col-sm-3">
								<input type="input" class="form-control required " onkeyup="formatRibuan(this)" id="harga_dua_sisi" name="harga_dua_sisi"  value="<?php echo format_rupiah($this->oldData->harga_dua_sisi); ?>">
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
  
