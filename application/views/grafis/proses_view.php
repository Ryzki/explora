





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
					<div class="row">
					<div class="col-xs-12">
					<div class="box">		
					
					<div class="box-body">
					
					
					<table class="table table-striped table-bordered">
						<tr>
							<th width="20%" align="center">Nama Karyawan</th>
							<th width="20%" align="center">Dari - Ke</th>
							<th width="15%" align="center">Waktu</th>
							<th width="45%" align="center">Catatan</th>
						</tr>
						<?php 
						
						//var_dump($this->dataBarang);
						
						foreach ($this->logAlur as $showLog) {
						?>
						<tr>
							<td><?php echo $showLog->NAMA_KARYAWAN; ?></td>
							<td><?php echo $showLog->DARI; ?> &#10132; <?php echo $showLog->KE; ?></td>
							<td><?php echo $showLog->TGL_LOG_ORDER ; ?></td>
							<td><?php echo $showLog->CATATAN_LOG_ORDER ; ?></td>
						</tr>
						<?php							
						}
						?>
					</table>
				</div>
			</div>
			</div>
			
			
			</div>
                    <?php
                    if( $this->oldData->POSISI_ORDER=='FINISH-DESIGN'){
					?>

					<div class="row">
					
                   
					<div class="col-xs-12">
					<div class="box">		
					<div class="box-header">
						
					</div>
					<div class="box-body">
					<table width="100%">
						<tr>
							<td align="right" width="20%">Tgl Order</td>
							<td align="center">:</td>
							<td ><?php echo $this->oldData->TGL_JAM_ORDER; ?></td>
						</tr>
						<tr>
							<td align="right">Jenis Member</td>
							<td align="center">:</td>
							<td ><?php echo ($this->oldData->LOG_MEMBER == 'Y' ? 'Member' : 'Bukan Member' ) ?></td>
						</tr>
					</table>
					<hr>
					
					<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#a3">A3+</a></li>
						<li><a data-toggle="tab" href="#indoor">Indoor / Outdoor</a></li>
						<li><a data-toggle="tab" href="#lain">Lain-Lain</a></li>
					</ul>

					<div class="tab-content">
						<div id="a3" class="tab-pane fade in active">
							<form class="form-horizontal" id="">
								<input type="hidden" name="id_barang_grafis" id="id_barang_grafis" value="1">
								<div class="form-group">
									<label class="control-label col-sm-2" for="email">Produk :</label>
									<div class="col-sm-4">
										<select class="form-control" id="id_produk" name="id_produk" onchange="ganti_produk_a3()">
											<option value="">-</option>
											<?php
											foreach($this->dataProduk as $produk){
											?>
											<option value="<?php echo $produk->id_produk; ?>"><?php echo $produk->nama_produk; ?></option>
											<?php
											}
											?>
										</select>
									</div>
								</div>
							</form>
							<form class="form-horizontal" id="form_8" style="display:none">
								<div class="form-group">
									<label class="control-label col-sm-2" for="email">Nama File / Pekerjaan :</label>
									<div class="col-sm-4">
										<input type="file" class="form-control" id="nama_file_pekerjaan"  name="nama_file_pekerjaan">
										<p id="loading_upload">File Harus .pdf</p>
										
									</div>
									<div class="col-sm-4">
										<input readonly placeholder="Nama File / Pekerjaan (setelah Upload)" class="form-control" id="nama_file_setelah_upload"  name="nama_file_setelah_upload">
										
									</div>
								</div>	
								<div class="form-group">
									
									<label class="control-label col-sm-2" for="email">Jenis Kertas / Bahan :</label>
									<div class="col-sm-4">
										<select class="form-control" id="id_kertas" name="id_kertas" onchange="cari_ukuran_kertas()">
											<option value="">Silahkan pilih Produk terlebih dahulu</option>
											<?php
											foreach($this->kertasIndoorOutdoor as $ukuran){
											?>
											<option value="<?php echo $ukuran->nama_kertas_bahan;?>"><?php echo $ukuran->nama_kertas_bahan;?></option>
											<?php
											}
											?>
										</select>
									</div>
									</div>
									<div class="form-group">
									
									<label class="control-label col-sm-2" for="email">Ukuran Kertas :</label>
									<div class="col-sm-4">
										<select class="form-control" id="id_ukuran_kertas" name="id_ukuran_kertas">
											<option value="">Silahkan pilih Produk terlebih dahulu</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									
									<label class="control-label col-sm-2" for="email">Page Img :</label>
									<div class="col-sm-2">
										<input type="number" readonly class="form-control" id="page_img"  onkeyup="hitung_jumlah_klik()" name="page_img">
									</div>
									<label class="control-label col-sm-2" for="email">Jml Sisi :</label>
									<div class="col-sm-2">
										<select class="form-control" id="jml_sisi"  onchange="hitung_jumlah_klik()" name="jml_sisi">
											<option value="1">1</option>
											<option value="2">2</option>
										</select>
									</div>
									<label class="control-label col-sm-2" for="email">Jml Copy :</label>
									<div class="col-sm-2">
										<input type="number" class="form-control"  onkeyup="hitung_jumlah_klik()" id="jml_copy"  name="jml_copy">
									</div>
								</div>
									
								<div class="form-group">
									
									<label class="control-label col-sm-2" for="email">UP :</label>
									<div class="col-sm-2">
										<select class="form-control" onchange="ganti_up()" id="up"  name="up">
											<option value="1">1</option>
											<?php
											for ($i=1; $i <= 100; $i++){
												if($i % 2== 0){
											?>
												<option value="<?= $i ?>"><?= $i ?></option>
											<?php 
												}
											}
											?>
											
										</select>
									</div>
									<label class="control-label col-sm-2" for="email">Page on Sheet Side :</label>
									<div class="col-sm-2">
										<select class="form-control" id="page_on_site_side" onchange="hitung_jumlah_klik()" name="page_on_site_side">
											<option value="-">-</option>
											<option value="Repeated">Repeated</option>
											<option value="Sequential">Sequential</option>
											<option value="Cut & Stack">Cut & Stack</option>
											<option value="Alternating">Alternating</option>
										</select>
									</div>
									<label class="control-label col-sm-2" for="email">Klik :</label>
									<div class="col-sm-2">
										<input type="number" class="form-control" id="klik" readonly  name="klik"> 
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2" for="email">Keterangan :</label>
									<div class="col-sm-6">
										<textarea  class="form-control" id="keterangan" name="keterangan"></textarea>
									</div>
								</div>
									
								<div class="form-group">
									<label class="control-label col-sm-2" for="email"></label>
									<div class="col-sm-6">
										<span class="btn btn-success" onclick="tambah_data_produk_digital_printing()"><i class="fa fa-plus"></i> Tambah Barang</span>
									</div>
									
								</div>
							</form>	
							
							
							<!----- Kartu Nama ---->
							<form class="form-horizontal" id="form_10" style="display:none">
								<div class="form-group">
									<label class="control-label col-sm-2" for="email">Nama File / Pekerjaan :</label>
									<div class="col-sm-4">
										<input type="file" class="form-control" id="nama_file_pekerjaan_kartu_nama"  name="nama_file_pekerjaan_kartu_nama">
										<p id="loading_upload_kartu_nama">File Harus .pdf</p>
										
									</div>
									<div class="col-sm-4">
										<input readonly placeholder="Nama File / Pekerjaan (setelah Upload)" class="form-control" id="nama_file_setelah_upload_kartu_nama"  name="nama_file_setelah_upload_kartu_nama">
										
									</div>
								</div>	
								<div class="form-group">
									
									<label class="control-label col-sm-2" for="email">Jenis Kertas / Bahan :</label>
									<div class="col-sm-4">
										<select class="form-control" id="id_kertas_kartu_nama" name="id_kertas_kartu_nama" onchange="cari_ukuran_kertas_kartu_nama()">
											<option value="">Silahkan pilih Produk terlebih dahulu</option>
											<?php
											foreach($this->kertasIndoorOutdoor as $ukuran){
											?>
											<option value="<?php echo $ukuran->nama_kertas_bahan;?>"><?php echo $ukuran->nama_kertas_bahan;?></option>
											<?php
											}
											?>
										</select>
									</div>
									</div>
									<div class="form-group">
									
									<label class="control-label col-sm-2" for="email">Ukuran Kertas :</label>
									<div class="col-sm-4">
										<select class="form-control" id="id_ukuran_kertas_kartu_nama" name="id_ukuran_kertas_kartu_nama">
											<option value="">Silahkan pilih Produk terlebih dahulu</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									
									<label class="control-label col-sm-2" for="email">Page Img :</label>
									<div class="col-sm-2">
										<input type="text" readonly class="form-control" id="page_img_kartu_nama"  onkeyup="hitung_jumlah_klik_kartu_nama()" name="page_img_kartu_nama">
									</div>
									<label class="control-label col-sm-2" for="email">Jml Sisi :</label>
									<div class="col-sm-2">
										<select class="form-control" id="jml_sisi_kartu_nama"  onchange="hitung_jumlah_klik_kartu_nama()" name="jml_sisi_kartu_nama">
											<option value="1">1</option>
											<option value="2">2</option>
										</select>
									</div>
									
								
									<input  type="hidden" value="1" id="up_kartu_nama"  name="up_kartu_nama">
									<label class="control-label col-sm-2" for="email">Jml Copy :</label>
									<div class="col-sm-2">
										<input type="text" class="form-control"  onkeyup="hitung_jumlah_klik_kartu_nama()" id="jml_copy_kartu_nama"  name="jml_copy_kartu_nama">
									</div>
								</div>
									
								<div class="form-group">
									<label class="control-label col-sm-2" for="email">UP :</label>
									<div class="col-sm-2">
										<select class="form-control" onchange="" id="up_kartu_nama"  name="up_kartu_nama">
											<option value="1">1</option>
											
																		
										</select>
									</div>
									<label class="control-label col-sm-2" for="email">Page on Sheet Side :</label>
									<div class="col-sm-2">
										<select class="form-control" id="page_on_site_side_kartu_nama" onchange="" name="page_on_site_side_kartu_nama">
											<option value="-">-</option>
										</select>
									</div>
									<label class="control-label col-sm-2" for="email">Klik :</label>
									<div class="col-sm-2">
										<input type="number" class="form-control" id="klik_kartu_nama" readonly  name="klik_kartu_nama"> 
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2" for="email">Box :</label>
									<div class="col-sm-2">
										<input type="number" class="form-control" id="box_kartu_nama" readonly  name="box_kartu_nama"> 
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2" for="email">Keterangan :</label>
									<div class="col-sm-6">
										<textarea  class="form-control" id="keterangan_kartu_nama"></textarea>
									</div>
								</div>
									
								<div class="form-group">
									<label class="control-label col-sm-2" for="email"></label>
									<div class="col-sm-6">
										<span class="btn btn-success" onclick="tambah_data_produk_kartu_nama()"><i class="fa fa-plus"></i> Tambah Barang</span>
									</div>
									
								</div>
							</form>	
						</div>
								
								
								
								
								
							
										
								
						<div id="indoor" class="tab-pane fade">
							
							
							<!---
							/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
							/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
							--->
							<div id="a3" class="tab-pane fade in">
							<form class="form-horizontal" id="">
								<div class="form-group">
									<label class="control-label col-sm-2" for="email">Produk :</label>
									<div class="col-sm-4">
										<select class="form-control" id="id_produk_indoor_outdoor" name="id_produk_indoor_outdoor" onchange="produk_indoor_outdoor()">
											<option value="">-</option>
											<?php
											foreach($this->dataProdukIndoorOutdoor as $produk){
											?>
											<option value="<?php echo $produk->id_produk; ?>"><?php echo $produk->nama_produk; ?></option>
											<?php
											}
											?>
										</select>
									</div>
								</div>	
							</form>
							
							
							
							
							<!-----------    Outdooooor -------------->
							<form class="form-horizontal" id="form_5" style="display:none">
								<div class="form-group">
									
									<label class="control-label col-sm-2" for="email">Nama File :</label>
									<div class="col-sm-4">
										<input type="file" class="form-control" id="browse_nama_file_pekerjaan_outdoor" >
										<p id="">File Harus .pdf</p>
										<input class="form-control" type="hidden" id="nama_file_pekerjaan_outdoor" >
									</div>
								</div>
								<div class="form-group">
									
									<label class="control-label col-sm-2" for="email">Jenis Kertas / Bahan :</label>
									<div class="col-sm-4">
										<select class="form-control" id="id_kertas_outdoor" onchange="$('#panjang_outdoor').focus();" name="id_kertas_outdoor">
											<option value="">-</option>
											
										</select>
									</div>
								</div>
								<div class="form-group">
									
									<label class="control-label col-sm-2" for="email">Panjang (cm) :</label>
									<div class="col-sm-2">
										<input type="input" class="form-control" onkeyup="formatRibuan(this)" id="panjang_outdoor" name="panjang_outdoor">
									</div>
									<label class="control-label col-sm-2" for="email">Lebar (cm) :</label>
									<div class="col-sm-2">
										<input type="input" class="form-control"  onkeyup="formatRibuan(this)" id="lebar_outdoor" name="lebar_outdoor">
									</div>
									
								</div>
									
							
								<div class="form-group">
									
									<label class="control-label col-sm-2" for="email">Jml Copy :</label>
									<div class="col-sm-2">
										<input type="input" class="form-control"  onkeyup="formatRibuan(this)" id="jml_copy_outdoor"  name="jml_copy_outdoor">
									</div>
									<label class="control-label col-sm-2" for="email">Keterangan Finishing:</label>
									<div class="col-sm-4">
										<select class="form-control" id="keterangan_finishing_outdoor"  name="keterangan_finishing_outdoor">
											<option value="">-</option>
											
											<option value="Keling Dalam Gambar">Keling Dalam Gambar</option>
											<option value="Keling Luar Gambar">Keling Luar Gambar</option>											
											<option value="Lipat Sesuai Bahan">Lipat Sesuai Bahan</option>
											<option value="Lipat Sesuai Gambar">Lipat Sesuai Gambar</option>
											<option value="Potong Sisa Bahan">Potong Sisa Bahan</option>
											<option value="Potong Sesuai Gambar">Potong Sesuai Gambar</option>
											
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2" for="email">Keterangan :</label>
									<div class="col-sm-6">
										<textarea  class="form-control" id="keterangan_outdoor" name="keterangan_outdoor"></textarea>
									</div>	
								</div>
								
								<div class="form-group">
									<label class="control-label col-sm-2" for="email"></label>
									<div class="col-sm-4">
										<span class="btn btn-success" onclick="tambah_data_produk_outdoor()"><i class="fa fa-plus"></i> Tambah Barang</span>
									</div>
								</div>
							</form>	
							
							
							<!-----------    indooooor -------------->
							<form class="form-horizontal" id="form_6" style="display:none">
								<div class="form-group">
									
									<label class="control-label col-sm-2" for="email">Nama File :</label>
								
									<div class="col-sm-4">
										<input type="file" class="form-control" id="browse_nama_file_pekerjaan_indoor" >
										<p id="">File Harus .pdf</p>
										<input class="form-control" type="hidden" id="nama_file_pekerjaan_indoor" >
									</div>
								</div>
								<div class="form-group">
									
									<label class="control-label col-sm-2" for="email">Jenis Kertas / Bahan :</label>
									<div class="col-sm-4">
										<select class="form-control" id="id_kertas_indoor" onchange="cariUkuranKertasIndoor();" name="id_kertas_indoor">
											<option value="">-</option>
											
										</select>
									</div>
								</div>
								
								<div class="form-group">
									
									<label class="control-label col-sm-2" for="email">Ukuran Kertas / Bahan :</label>
									<div class="col-sm-4">
										<select class="form-control" id="id_ukuran_kertas_indoor" onchange="ganti_ukuran_kertas_indoor()" name="id_ukuran_kertas_indoor">
											<option value="">Silahkan pilih Jenis Kertas / Bahan terlebih dahulu</option>
											
										</select>
									</div>
								</div>
								
								<div class="form-group">
									
									<label class="control-label col-sm-2" for="email">Panjang (cm) :</label>
									<div class="col-sm-2">
										<input type="input" class="form-control" onkeyup="formatRibuan(this)" id="panjang_indoor" name="panjang_indoor">
									</div>
									<label class="control-label col-sm-2" for="email">Lebar (cm) :</label>
									<div class="col-sm-2">
										<input type="input" class="form-control" readonly onkeyup="formatRibuan(this)" id="lebar_indoor" name="lebar_indoor">
									</div>
									
								</div>
									
							
								<div class="form-group">
									
									<label class="control-label col-sm-2" for="email">Jml Copy :</label>
									<div class="col-sm-2">
										<input type="input" class="form-control"  onkeyup="formatRibuan(this)" id="jml_copy_indoor"  name="jml_copy_indoor">
									</div>
									<label class="control-label col-sm-2" for="email">Keterangan Finishing:</label>
									<div class="col-sm-4">
										<select class="form-control" id="keterangan_finishing_indoor"  name="keterangan_finishing_indoor">
											<option value="">-</option>
											
											<option value="Keling Dalam Gambar">Keling Dalam Gambar</option>
											<option value="Keling Luar Gambar">Keling Luar Gambar</option>											
											<option value="Lipat Sesuai Bahan">Lipat Sesuai Bahan</option>
											<option value="Lipat Sesuai Gambar">Lipat Sesuai Gambar</option>
											<option value="Potong Sisa Bahan">Potong Sisa Bahan</option>
											<option value="Potong Sesuai Gambar">Potong Sesuai Gambar</option>
											
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2" for="email">Keterangan :</label>
									<div class="col-sm-6">
										<textarea  class="form-control" id="keterangan_indoor" name="keterangan_indoor"></textarea>
									</div>	
								</div>
								
								<div class="form-group">
									<label class="control-label col-sm-2" for="email"></label>
									<div class="col-sm-4">
										<span class="btn btn-success" onclick="tambah_data_produk_indoor()"><i class="fa fa-plus"></i> Tambah Barang</span>
									</div>
								</div>
							</form>	
							
							
							<!-----------    indooooor Poster -------------->
							<form class="form-horizontal" id="form_15" style="display:none">
								<div class="form-group">
									
									<label class="control-label col-sm-2" for="email">Nama File :</label>
									
									<div class="col-sm-4">
										<input type="file" class="form-control" id="browse_nama_file_pekerjaan_indoor_poster" >
										<p id="">File Harus .pdf</p>
										<input class="form-control" type="hidden" id="nama_file_pekerjaan_indoor_poster" >
									</div>
								</div>
								<div class="form-group">
									
									<label class="control-label col-sm-2" for="email">Jenis Kertas / Bahan :</label>
									<div class="col-sm-4">
										<select class="form-control" id="id_kertas_indoor_poster" onchange="cariUkuranKertasIndoorPoster();" name="id_kertas_indoor_poster">
											<option value="">-</option>
											
										</select>
									</div>
								</div>
								
								<div class="form-group">
									
									<label class="control-label col-sm-2" for="email">Ukuran Kertas / Bahan :</label>
									<div class="col-sm-4">
										<select class="form-control" id="id_ukuran_kertas_indoor_poster" onchange="ganti_ukuran_kertas_indoor_poster()" name="id_ukuran_kertas_indoor_poster">
											<option value="">Silahkan pilih Jenis Kertas / Bahan terlebih dahulu</option>
											
										</select>
									</div>
								</div>
								
								<div class="form-group">
									
									<label class="control-label col-sm-2" for="email">Panjang (cm) :</label>
									<div class="col-sm-2">
										<input type="input" class="form-control"   onkeyup="formatRibuan(this)" id="panjang_indoor_poster" name="panjang_indoor_poster" value="1">
									</div>
									<label class="control-label col-sm-2" for="email">Lebar (cm) :</label>
									<div class="col-sm-2">
										<input type="input" class="form-control"  onkeyup="formatRibuan(this)" id="lebar_indoor_poster" name="lebar_indoor_poster" value="1">
									</div>
									
								</div>
									
							
								<div class="form-group">
									
									<label class="control-label col-sm-2" for="email">Jml Copy :</label>
									<div class="col-sm-2">
										<input type="input" class="form-control"  onkeyup="formatRibuan(this)" id="jml_copy_indoor_poster"  name="jml_copy_indoor_poster">
									</div>
									<label class="control-label col-sm-2" for="email">Keterangan Finishing:</label>
									<div class="col-sm-4">
										<select class="form-control" id="keterangan_finishing_indoor_poster"  name="keterangan_finishing_indoor">
											<option value="">-</option>
											
											<option value="Keling Dalam Gambar">Keling Dalam Gambar</option>
											<option value="Keling Luar Gambar">Keling Luar Gambar</option>											
											<option value="Lipat Sesuai Bahan">Lipat Sesuai Bahan</option>
											<option value="Lipat Sesuai Gambar">Lipat Sesuai Gambar</option>
											<option value="Potong Sisa Bahan">Potong Sisa Bahan</option>
											<option value="Potong Sesuai Gambar">Potong Sesuai Gambar</option>
											
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2" for="email">Keterangan :</label>
									<div class="col-sm-6">
										<textarea  class="form-control" id="keterangan_indoor_poster" name="keterangan_indoor_poster"></textarea>
									</div>	
								</div>
								
								<div class="form-group">
									<label class="control-label col-sm-2" for="email"></label>
									<div class="col-sm-4">
										<span class="btn btn-success" onclick="tambah_data_produk_indoor_poster()"><i class="fa fa-plus"></i> Tambah Barang</span>
									</div>
								</div>
							</form>	
							
							
							<!-----------    Paket Banner -------------->
							<form class="form-horizontal" id="form_16" style="display:none">
								<div class="form-group">
									
									<label class="control-label col-sm-2" for="email">Nama File :</label>
								
									<div class="col-sm-4">
										<input type="file" class="form-control" id="browse_nama_file_pekerjaan_paket_banner" >
										<p id="">File Harus .pdf</p>
										<input class="form-control" type="hidden" id="nama_file_pekerjaan_paket_banner" >
									</div>
								</div>
								<div class="form-group">
									
									<label class="control-label col-sm-2" for="email">Jenis Kertas / Bahan :</label>
									<div class="col-sm-4">
										<select class="form-control" id="id_kertas_paket_banner" onchange="cariUkuranKertasPaketBanner();" name="id_kertas_paket_banner">
											<option value="">-</option>
											
										</select>
									</div>
								</div>
								
								<div class="form-group">
									
									<label class="control-label col-sm-2" for="email">Ukuran Kertas / Bahan :</label>
									<div class="col-sm-4">
										<select class="form-control" id="id_ukuran_kertas_paket_banner" onchange="ganti_ukuran_kertas_paket_banner()" name="id_ukuran_kertas_paket_banner">
											<option value="">Silahkan pilih Jenis Kertas / Bahan terlebih dahulu</option>
											
										</select>
									</div>
								</div>
								
								<div class="form-group">
									
									<label class="control-label col-sm-2" for="email">Panjang (cm) :</label>
									<div class="col-sm-2">
										<input type="input" class="form-control"   onkeyup="formatRibuan(this)" id="panjang_paket_banner" name="panjang_paket_banner" value="1">
									</div>
									<label class="control-label col-sm-2" for="email">Lebar (cm) :</label>
									<div class="col-sm-2">
										<input type="input" class="form-control"  onkeyup="formatRibuan(this)" id="lebar_paket_banner" name="lebar_paket_banner" value="1">
									</div>
									
								</div>
									
							
								<div class="form-group">
									
									<label class="control-label col-sm-2" for="email">Jml Copy :</label>
									<div class="col-sm-2">
										<input type="input" class="form-control"  onkeyup="formatRibuan(this)" id="jml_copy_paket_banner"  name="jml_copy_paket_banner">
									</div>
									<label class="control-label col-sm-2" for="email">Keterangan Finishing:</label>
									<div class="col-sm-4">
										<select class="form-control" id="keterangan_finishing_paket_banner"  name="keterangan_paket_banner">
											<option value="">-</option>
											
											<option value="Keling Dalam Gambar">Keling Dalam Gambar</option>
											<option value="Keling Luar Gambar">Keling Luar Gambar</option>											
											<option value="Lipat Sesuai Bahan">Lipat Sesuai Bahan</option>
											<option value="Lipat Sesuai Gambar">Lipat Sesuai Gambar</option>
											<option value="Potong Sisa Bahan">Potong Sisa Bahan</option>
											<option value="Potong Sesuai Gambar">Potong Sesuai Gambar</option>
											
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2" for="email">Keterangan :</label>
									<div class="col-sm-6">
										<textarea  class="form-control" id="keterangan_paket_banner" name="keterangan_paket_banner"></textarea>
									</div>	
								</div>
								
								<div class="form-group">
									<label class="control-label col-sm-2" for="email"></label>
									<div class="col-sm-4">
										<span class="btn btn-success" onclick="tambah_data_produk_paket_banner()"><i class="fa fa-plus"></i> Tambah Barang</span>
									</div>
								</div>
							</form>	
							
						</div>
							
						</div>
						<div id="lain" class="tab-pane fade">
							<!----- Produk Lain --->
							<form class="form-horizontal" id="form_lain" >
								<div class="form-group">
									<label class="control-label col-sm-2" for="email">Produk :</label>
									<div class="col-sm-6">
										<select class="form-control" id="id_produk_lain" name="id_produk_lain" >
											<option value="">-</option>
											<?php
											foreach($this->dataProdukLain as $produk){
											?>
											<option value="<?php echo $produk->id_produk; ?>"><?php echo $produk->nama_produk; ?></option>
											<?php
											}
											?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2" for="email">Quantity :</label>
									<div class="col-sm-2">
										<input type="input" class="form-control"  onkeyup="formatRibuan(this)" id="quantity_lain" name="quantity_lain" >
									</div>
								</div>									
								<div class="form-group">
									<label class="control-label col-sm-2" for="email">Keterangan :</label>
									<div class="col-sm-6">
										<textarea  class="form-control" id="keterangan_produk_lain" name="keterangan_produk_lain"></textarea>
									</div>	
								</div>
								
								<div class="form-group">
									<label class="control-label col-sm-2" for="email"></label>
									<div class="col-sm-4">
										<span class="btn btn-success" onclick="tambah_data_produk_lain()"><i class="fa fa-plus"></i> Tambah Barang</span>
									</div>
								</div>
							</form>	
							
							
							
						</div>
					</div>
						
						
					<!---- end tab content -->	
					
					
					
					</div>
					
					<hr>
					<hr>
					<form id="form_standar">
						<input type="hidden"  name="ID_ORDER" value="<?php echo $this->oldData->ID_ORDER; ?>">
						<input type="hidden" name="NO_ORDER" value="<?php echo $this->oldData->NO_ORDER; ?>">
						
							<table class="table table-striped table-bordered">
								<thead>
								<tr>
									<th width="" align="center">Nama Barang</th>
									<th width="5%" align="center"></th>
								</tr>
								</thead>
								<tbody id="tabel_op_grafis">
								
								</tbody>
								
							</table>
					
					
                    <br>
                    <br>
					<table border="0" width="100%">
						<tr>
							<td align="right">
                                
                                <p id="pesan_error" style="display:none" class="text-warning" style="display:none"></p>
                                 <img src="<?php echo base_url();?>assets/img/loading.gif" id="loading" style="display:none"><br>
                                <button class="btn btn-primary btn-lg">Simpan Work Order ( WO )</button>
							</td>
						</tr>
						
					</table>
					</div>
					</div>
					</div>
					
					
					</form>
					</div>

					<?php
					}
                    else{
                        ?>
					<!--<br>
					<table border="0" width="100%">
						<tr>
							<td align="right">
							<span class="btn btn-warning btn-sm" data-toggle="modal" 
                            data-target="#modal_selesai_desain">Klik 
                            Disini untuk Finish tahap Design</span>
							</td>
						</tr>
						
					</table>-->
					
					
					
					
					
					
					<div class="row">
					<form class="form-horizontal" id="form_standar">
                    <input type="hidden"  name="ID_ORDER" value="<?php echo $this->oldData->ID_ORDER; ?>">
                    <input type="hidden" name="NO_ORDER" value="<?php echo $this->oldData->NO_ORDER; ?>">
					<div class="col-xs-12">
					<div class="box">		
					<div class="box-header">
						
					</div>
					<div class="box-body">
					<table width="100%">
						<tr>
							<td align="right" width="20%">Tgl Order</td>
							<td align="center">:</td>
							<td ><?php echo $this->oldData->TGL_JAM_ORDER; ?></td>
						</tr>
						<tr>
							<td align="right">Jenis Member</td>
							<td align="center">:</td>
							<td ><?php echo ($this->oldData->LOG_MEMBER == 'Y' ? 'Member' : 'Bukan Member' ) ?></td>
						</tr>
					</table>
					<hr>
					
									
						<div class="form-group">
							<label class="control-label col-sm-4" >Catatan :</label>
							<div class="col-sm-5">
								<textarea type="input" class="form-control " required name="CATATAN_LOG_ORDER"></textarea>
							</div>
						</div>				
						<div class="form-group">
							<div class="col-sm-offset-4 col-sm-8">
								<img src="<?php echo base_url();?>assets/img/loading.gif" id="loading_login" style="display:none">
								<p id="pesan_error_login" style="display:none" class="text-warning" style="display:none"></p>
							</div>
						</div>			
						<div class="form-group">
							<div class="col-sm-offset-4 col-sm-10">
								<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan untuk mengukur Waktu Pengerjaan</button>
								<a href="<?=base_url()."".$this->uri->segment(1);?>">
									<span class="btn btn-warning"><i class="fa fa-remove"></i> Batal</span>
								</a>
							</div>
						</div>							
							
					
					
					</div>
					</div>
					</div>
					
					
					</form>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- /.content -->


<div class="modal fade" id="modal_selesai_desain" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="false">
    <form class="form-horizontal" id="form_finish_design">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Form Finish 
                tahap Design</h4>
               
			</div>
			<div class="modal-body">
                
                    <div class="form-group">
                         <div class="col-sm-10"><b>CS-GRAFIS  &#10132; FINISH-DESIGN</b></div>
                    </div>	
                    <div class="form-group">
                       
                        <div class="col-sm-12">
                            <textarea class="form-control" 
                            id="keterangan_finish_design" name="keterangan_finish_design" required
                            placeholder="Catatan untuk tahap Design" ></textarea>
                            <input type="hidden" id="id_order_finish_design" name="id_order_finish_design"
                            value="<?php echo $this->oldData->ID_ORDER; ?>">
                        </div>
                    </div>	
                
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <img src="<?php echo base_url();?>assets/img/loading.gif" id="loading_finish_design" style="display:none">
                            <p id="pesan_error_finish_design" style="display:none" class="text-warning" style="display:none"></p>
                        </div>
                    </div>	
             
            </div>
			<div class="modal-footer">
                <span  class="btn btn-warning" data-dismiss="modal">Batal</span>
				<button type="submit"  class="btn btn-primary">Simpan</button>
			</div>
		</div>
	</div>
    </form>
</div>
  
