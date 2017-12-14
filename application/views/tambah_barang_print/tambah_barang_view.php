
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
				<div class="col-sm-2">
					<?php 
					//// cara ambil button Add
					echo $this->template_view->getAddButton(); 
					?>
				</div>
				<div class="col-sm-2">
				</div>
				<div class="col-sm-8">
					<div class="row">
						<form method="get">
						<div class="col-sm-4 col-md-offset-2">
							<select class="form-control" name="field">
								<option <?php if($this->input->get('field')=='no_order') echo "selected"; ?> value="no_order">Berdasarkan No Order</option>
								<option <?php if($this->input->get('field')=='no_wo') echo "selected"; ?> value="no_wo">Berdasarkan No WO</option>
							</select>
						</div>
						<div class="col-sm-6">							
								<div class="input-group">
									<input type="text" class="form-control" name="keyword" placeholder="Masukkan Kata Kunci" value="<?php echo $this->input->get('keyword'); ?>">
									<div class="input-group-btn">
										<button class="btn btn-default" type="submit">
										<i class="glyphicon glyphicon-search"></i>
										</button>
										<?php if($this->input->get('field')){ ?>
										<a href="<?=base_url();?><?php echo $this->uri->segment(1);?>">
											<span class="btn btn-success"><i class="glyphicon glyphicon-refresh"></i></span>
										</a>
										<?php } ?>
									</div>
									
								</div>	
														
						</div>
						</form>
					</div>
				</div>
			</div>
		</div>
			
        <div class="box-body box-table">
        <table class="table table-bordered">
            <thead>
              <tr>
                <th colspan="2" width="15%" class="text-right">No.</th>
               <th class="text-center">Pelanggan</th>
                <th class="text-center">Member</th>
                <th width="10%" class="text-center">No Order</th>
                <th class="text-center">Tgl Order</th>
				<th class="text-center">Line</th>
              </tr>
            </thead>
            <tbody>
				<?php
				$no = $this->input->get('per_page')+ 1;
				foreach($this->showData as $showData ){
				
				?>
				<tr <?php echo ($showData->LOG_MEMBER != 'Y' ? 'style="background:#e4ffe2"' : ''); ?>>
					
					<td align="center">
						
						<a href="<?=base_url();?><?php echo $this->uri->segment('1');?>/proses/<?php echo $showData->ID_ORDER; ?>"><span class="btn btn-success btn-sm">Proses</span>
						
						
					</td>
					<td align="center"><?php echo $no; ?>.</td>
					<td >
					<?php
					echo  $showData->nama_pelanggan ;
					?>
					
					</td>
					<td >
					<?php
					echo ($showData->LOG_MEMBER == 'Y' ? 'Member' : 'Bukan');
					?>
					</td>
					<td >
						<?php 
							echo $showData->NO_ORDER; 
							echo ( $showData->NO_ORDER_LAIN == '' ? "" : "<br><sub>No Order Toko Lain : </sub>".$showData->NO_ORDER_LAIN);
						?>
						
					</td>
					<td ><?php echo $showData->TGL_ORDER."<br>".$showData->JAM_ORDER; ?></td>
					<td ><?php echo $showData->LINE; ?></td>
				</tr>
				<?php
				$no++;
				}
				if(!$this->showData){
					echo "<tr><td colspan='25' align='center'>Data tidak ada.</td></tr>";
				}
				?>
            </tbody>
        </table>
        <center>
			<?php echo $this->pagination->create_links();?>
			<br>
			<span class="btn btn-default">Jumlah Data : <b><?php echo $this->jumlahData;?></b></span>
		</center>
          
        </div>
    </div>
  </div>
</section>
<!-- /.content -->
  
