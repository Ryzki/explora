
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
							<label class="control-label col-sm-2" for="email">No Hp :</label>
							<div class="col-sm-2">
								<input type="input" class="form-control required number" minlength="6" onkeyup="search_member()" id="HP_CUSTOMER" name="HP_CUSTOMER" >
								<input type="hidden" id="ID_CUSTOMER" name="ID_CUSTOMER" >
							</div>
							<div class="col-sm-2" id="div_pesan_member">
								
							</div>
						</div>	
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Nama :</label>
							<div class="col-sm-3">
								<input type="input" class="form-control required" id="NAMA_CUSTOMER" name="NAMA_CUSTOMER">
							</div>
							
							<label class="control-label col-sm-2" for="email">Alamat :</label>
							<div class="col-sm-5">
								<input type="input" class="form-control"  id="ALAMAT_CUSTOMER" name="ALAMAT_CUSTOMER">
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Tgl Order :</label>
							<div class="col-sm-2">
								<input type="input" class="form-control required" readonly value="<?php echo date('d-m-Y'); ?>" id="TGL_ORDER" name="TGL_ORDER">
							</div>
							
							<!--<label class="control-label col-sm-2" for="email">Tgl Ambil :</label>
							<div class="col-sm-2">
								<input type="input" class="form-control required"  id="TGL_AMBIL" name="TGL_AMBIL">
							</div>-->
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Alur Order :</label>
							<div class="col-sm-4">
								<select class="form-control required" id="JENIS_ORDER" name="JENIS_ORDER" >
									<option value="">Silahkan pilih</option>
									<option value="1">OP Grafis &#10132; OP Print &#10132; Kasir</option>
									<option value="2">OP Grafis &#10132; Kasir</option>
									<option value="3">OP Print &#10132; Kasir</option>
									<option value="4">Kasir</option>
								</select>
								
							</div>
							<div class="col-sm-4">
								<a href="#" onclick="keterangan_alur_order();">Klik untuk Keterangan Alur Order</a>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Catatan :</label>
							<div class="col-sm-6">
								<textarea class="form-control" id="CATATAN" name="CATATAN" ></textarea>
									
							</div>
						</div>
						<hr>
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Nama Barang :</label>
							<div class="col-sm-8">
								<input type="input"  class="form-control" id="NAMA_BARANG_AUTOCOMPLETE" name="NAMA_BARANG_FORM">
								<input type="hidden"  id="ID_BARANG_FORM" name="ID_BARANG_FORM">
								<input type="hidden"  id="HARGA_SATUAN_FORM" >
								<input type="hidden"  id="TOTAL_HARGA_FORM" >
								
								<input type="hidden"  id="INPUT_SATUAN_BARANG">
							</div>
							
						</div>
						
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Jumlah :</label>
							<div class="col-sm-1">
								<input type="number" onkeyup="hitung_harga_barang()" class="form-control" id="JUMLAH_QTY_FORM" >
							</div>
							<div class="col-sm-1"  id="satuan_barang">
							
							</div>
							<div class="col-sm-5" id="harga_barang">
							
							</div>
							<div class="col-sm-2">
								<span class="btn btn-success" onclick="tambah_barang()"><i class="fa fa-plus"></i> Tambah</span>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-1"></div>
							<div class="col-sm-10">
								<hr>
							</div>
							<div class="col-sm-1"></div>
						</div>
						<div class="form-group">
							<div class="col-sm-1"></div>
							<div class="col-sm-10">
								<table class="table table-bordered">
									<thead>
									<tr>
										<th width="40%">Nama Barang</th>
										<th width="15%">Quantity</th>
										<th width="15%">Harga</th>
										<th width="20%">Jumlah</th>
										<th width="5%"></th>
									</tr>
									</thead>
									<tbody id="tabel_barang"></tbody>
									<tbody >
									
										
										<th colspan="2" class="text-right"><h4>Total Bayar</h4>
											<input type="hidden" id="total_bayar" value="0">
										</th>
										<th colspan="3" class="text-center" id="rp_total_bayar" name="TOTAL_BAYAR">											
											<h4>Rp. 0,00</h4>
										</th>
									</tbody>
								</table>
							</div>
							<div class="col-sm-1"></div>
							
						</div>
						
						<hr>
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
  
