
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
								<option <?php if($this->input->get('field')=='nomor_telp') echo "selected"; ?> value="nomor_telp">Berdasarkan No HP</option>
								<option <?php if($this->input->get('field')=='nama_pelanggan') echo "selected"; ?> value="nama_pelanggan">Berdasarkan Nama</option>
								<option <?php if($this->input->get('field')=='email') echo "selected"; ?> value="email">Berdasarkan eMail</option>
								<option <?php if($this->input->get('field')=='alamat') echo "selected"; ?> value="alamat">Berdasarkan Alamat</option>
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
                <th colspan="2" width="15%">No.</th>
                <th>Nama Pelanggan</th>
                <th>No HP Pelanggan</th>
                <th>Email</th>
                <th>Alamat Pelanggan</th>
              </tr>
            </thead>
            <tbody>
				<?php
				$no = $this->input->get('per_page')+ 1;
				foreach($this->showData as $showData ){
				?>
				<tr>
					<td align="center">
						<?php 
						////// cara ambil Button Edit ( link edit )
						echo $this->template_view->getEditButton(base_url().$this->uri->segment(1)."/edit/".$showData->id_pelanggan); 
						?>
						&nbsp;
						<?php
						////// cara ambil Button Delete (pesan yang ingin ditampilkan, link Delete)
						echo $this->template_view->getDeleteButton($showData->nama_pelanggan,base_url().$this->uri->segment(1)."/delete/".$showData->id_pelanggan); 
						?>	
					</td>
					<td align="center"><?php echo $no; ?>.</td>
					<td ><?php echo $showData->nama_pelanggan; ?></td>
					<td ><?php echo $showData->nomor_telp; ?></td>
					<td ><?php echo $showData->email; ?></td>
					<td ><?php echo $showData->alamat; ?></td>
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
  
