
<!-- Content Header (Page header) -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
		
        <div class="box-header">
			<h4><?php echo $this->template_view->nama_menu('nama_menu'); ?></h4>
			<h5><?php echo $this->template_view->nama_menu('judul_menu'); ?></h5>
			<hr>
			<div class="row">
				<center>
						<form method="get">			
						<div class="col-sm-4 col-md-offset-4">
								
								<div class="input-group">
									<input type="text" class="form-control" name="no_wo" placeholder="Masukkan Nomor WO" value="<?php echo $this->input->get('no_wo'); ?>">
									<div class="input-group-btn">
										<button class="btn btn-default" type="submit">
										<i class="glyphicon glyphicon-search"></i> Cari Berdasarkan Nomor WO
										</button>
										
									</div>
									
								</div>	
														
						</div>
						</form>
					</center>
			</div>
		</div>
			<hr>
        <div class="box-body box-table">
			<?php
			if($this->input->get('no_wo')){
				if(!$this->showData ){
					echo "<center>Nomor WO tidak ada !</center>";
				}
				else{
			?>
				
				<table width="100%" >
						<tr>
							<td width="20%" align="right">No WO</td>
							<td width="5%" align="center">:</td>
							<td align=""><h4></b><?php echo $this->showData->NO_WO; ?></b></h4></td>
							
							<td width="15%" align="right">Nama Pembeli</td>
							<td align="center">:</td>
							<td ><h4><?php echo $this->showData->nama_pelanggan; ?></h4></td>
						</tr>
						<tr>
							<td align="right">Tgl Order</td>
							<td align="center">:</td>
							<td ><?php echo $this->showData->TGL_ORDER; ?></td>
							
							<td align="right">No HP</td>
							<td align="center">:</td>
							<td ><?php echo $this->showData->nomor_telp; ?></td>
						</tr>
						
					</table>
					<br>
					<hr>
				<table width="100%" >
						<tr>
							<td >
							<center>
							<a href="<?=base_url();?>cetak/struk/<?php echo  $this->showData->ID_ORDER;?>" target="_blank"><span class="btn btn-success">Cetak Struk</span></a>
						
							<a href="<?=base_url();?>cetak/nota/<?php echo  $this->showData->ID_ORDER;?>" target="_blank"><span class="btn btn-primary">Cetak Nota</span></a>
							
							<a href="<?=base_url();?>cetak/tanda_bayar/<?php echo  $this->showData->ID_ORDER;?>" target="_blank"><span class="btn btn-danger">Cetak Tanda Bayar</span></a>
							
							<a href="<?=base_url();?>cetak/job/<?php echo  $this->showData->ID_ORDER;?>" target="_blank"><span class="btn btn-warning">Cetak Work Order</span></a>
							
							<a href="<?=base_url();?>cetak/antrian/<?php echo  $this->showData->ID_ORDER;?>" target="_blank"><span class="btn btn-default">Cetak Antrian</span></a>
							
							
							</center>
							</td>
						</tr>
				</table>
			<?php
				}
			?>		
			<?php
			}
			?>
          
        </div>
    </div>
  </div>
</section>
<!-- /.content -->
  
