
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
					<form class="form-horizontal"method="get">
						<div class="form-group">
							<label class="control-label col-sm-3" for="email">No Hp :</label>
							<div class="col-sm-3">
								<input type="input" class="form-control required number" value="<?php echo $this->input->get('HP_CUSTOMER'); ?>" placeholder="Ketikkan nomor HP atau Nama Member" autofocus minlength="3" id="HP_CUSTOMER" name="HP_CUSTOMER" >
								<input type="hidden" id="ID_CUSTOMER" name="ID_CUSTOMER" >
								<input type="hidden" id="LOG_MEMBER" name="LOG_MEMBER" >
							</div>
							<div class="col-sm-6" id="div_pesan_member">
								
							</div>
						</div>	
						<div class="form-group">
							<label class="control-label col-sm-3" for="email">Nama Customer :</label>
							<div class="col-sm-4">
								<input type="input" readonly class="form-control " value="<?php echo $this->input->get('NAMA_CUSTOMER'); ?>"  id="NAMA_CUSTOMER" name="NAMA_CUSTOMER">
							</div>
						</div>
								
						<div class="form-group">        
							<div class="col-sm-offset-3 col-sm-9">
								<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Cari Data Pembelian</button>
								
							</div>
						</div>
					</form>
					
					<?php
					if($this->input->get('HP_CUSTOMER')!=""){
						if(!$this->showData){
							echo "<hr><center>Tidak ada Data Pembelian</center><br>";
						}
						else{
					?>	
					
						<div class="box-body box-table">
							<table class="table table-bordered">
								<thead>
								  <tr>
									<th width="5%">No.</th>
									<th width="">No WO</th>
									<th width="">Tgl Order</th>
									<th width="">Jumlah Beli</th>
								  </tr>
								</thead>
								<tbody>
									<?php
									function format_rupiah($angka){
										$rupiah=number_format($angka,0,',','.');
										return "Rp. ".$rupiah;
									}
									$no = $this->input->get('per_page')+ 1;
									foreach($this->showData as $showData ){
									?>
									<tr>
									
										<td align="center"><?php echo $no; ?>.</td>
										<td ><?php echo $showData->NO_WO ; ?></td>
										<td ><?php echo $showData->TGL_ORDER ; ?></td>
										<td align=right><?php echo format_rupiah($showData->TOTAL_BAYAR) ; ?></td>
										<td align=center>
											<div class="btn-group">
											  <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												Aksi
											  </button>
											  <div class="dropdown-menu">
												<a href="<?=base_url();?>cetak/struk/<?php echo  $showData->ID_ORDER;?>" target="_blank"><span class="btn btn-default btn-sm">Cetak Struk</span></a>
						
												<a href="<?=base_url();?>cetak/nota/<?php echo  $showData->ID_ORDER;?>" target="_blank"><span class="btn btn-default btn-sm">Cetak Nota</span></a>
												
												<a href="<?=base_url();?>cetak/tanda_bayar/<?php echo  $showData->ID_ORDER;?>" target="_blank"><span class="btn btn-default btn-sm">Cetak Tanda Bayar</span></a>
												
												<a href="<?=base_url();?>cetak/job/<?php echo  $showData->ID_ORDER;?>" target="_blank"><span class="btn btn-default btn-sm">Cetak Work Order</span></a>
												
												<a href="<?=base_url();?>cetak/antrian/<?php echo  $showData->ID_ORDER;?>" target="_blank"><span class="btn btn-default btn-sm">Cetak Antrian</span></a>
												
												<?php
												//var_dump($showData->STATUS_BAYAR);
												//var_dump($showData->TOTAL_BAYAR);
												if($showData->STATUS_BAYAR!='L' && $showData->TOTAL_BAYAR!=''){
												?>
												<a href="<?=base_url();?>pelunasan/proses/<?php echo  $showData->ID_ORDER;?>" target="_blank"><span class="btn btn-warning btn-sm">Bayar Cicilan</span></a>
												<?php
												}
												?>
											  </div>
											</div>
										</td>
									</tr>
									<?php
									$no++;
									}
									
									?>
								</tbody>
							</table>
							
							  
							</div>
					
					
					<?php
						}
					}
					?>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- /.content -->
  
