
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
								<option <?php if($this->input->get('field')=='m_barang_gudang.nama_barang_gudang') echo "selected"; ?> value="m_barang_gudang.nama_barang_gudang">Berdasarkan Nama barang</option>
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
                <th colspan="" width="5%">No.</th>
                <th width="15%">Karyawan Entry</th>
                <th>Nama Barang</th>
                <th width="10%">Jumlah Barang Masuk</th>
                <th width="10%">Tgl Entry</th>
                <th width="10%">Tgl Barang Masuk</th>
                <th>Keterangan</th>
              </tr>
            </thead>
            <tbody>
				<?php
				$no = $this->input->get('per_page')+ 1;
				foreach($this->showData as $showData ){
					//VAR_DUMP( $showData);
				?>
				<tr>
				
					<td align="center"><?php echo $no; ?>.</td>
					<td ><?php echo $showData->NAMA_KARYAWAN; ?></td>
					<td ><?php echo $showData->NAMA_BARANG_GUDANG; ?></td>
					<td ><?php echo $showData->JUMLAH_MASUK; ?></td>
					<td ><?php echo $showData->TGL_ENTRY_INDO; ?></td>
					<td ><?php echo $showData->TGL_BARANG_MASUK_INDO ?></td>
					<td ><?php echo $showData->TRANS_KETERANGAN; ?></td>
					
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
  
