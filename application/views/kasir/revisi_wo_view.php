
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
        <table class="table table-bordered">
            <thead>
              <tr>
                <th width="15%" class="text-right"></th>
                <th class="text-center">No WO</th>
                <th class="text-center">Tgl Order</th>
                <th class="text-center">Nama Pembeli</th>
              </tr>
            </thead>
            <tbody>
				<?php
				if($this->showData){
				?>
				<tr>
					
					<td align="center">
						<a href="<?=base_url();?><?php echo $this->uri->segment('1');?>/proses/<?php echo $this->showData->ID_ORDER; ?>"><span class="btn btn-success btn-sm">Proses</span>
					</td>
					<td ><?php echo $this->showData->NO_WO; ?></td>
					<td ><?php echo $this->showData->TGL_ORDER; ?></td>
					<td ><?php echo $this->showData->nama_pelanggan; ?></td>
				</tr>
				<?php
				}
				if(!$this->showData){
					echo "<tr><td colspan='25' align='center'>Data tidak ada.</td></tr>";
				}
				?>
            </tbody>
        </table>

          
        </div>
    </div>
  </div>
</section>
<!-- /.content -->
  
