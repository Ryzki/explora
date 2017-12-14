
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
								<option <?php if($this->input->get('field')=='nama_produk') echo "selected"; ?> value="nama_produk">Berdasarkan Produk</option>
								<option <?php if($this->input->get('field')=='nama_kertas') echo "selected"; ?> value="nama_kertas">Berdasarkan Kertas</option>
								<option <?php if($this->input->get('field')=='ukuran_kertas') echo "selected"; ?> value="ukuran_kertas">Berdasarkan Ukuran Kertas</option>
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
                <th>Produk</th>
                <th>Kertas/Bahan</th>
                <th>Ukuran Kertas</th>
                <th>Minimal</th>
                <th>Maximal</th>
                <th>Harga Satu Sisi Member</th>
                <th>Harga Dua Sisi Member</th> 
				
				<th>Harga Satu Sisi</th>
                <th>Harga Dua Sisi</th>
              </tr>
            </thead>
            <tbody>
				<?php
				function format_rupiah($angka){
					$rupiah=number_format($angka,0,',','.');
					return "Rp. ".$rupiah.",00";
				}
				
				$no = $this->input->get('per_page')+ 1;
				foreach($this->showData as $showData ){
				?>
				<tr>
					<td align="center">
						<?php 
						////// cara ambil Button Edit ( link edit )
						echo $this->template_view->getEditButton(base_url().$this->uri->segment(1)."/edit/".$showData->id_t_harga_barang); 
						?>
						&nbsp;
						<?php
						////// cara ambil Button Delete (pesan yang ingin ditampilkan, link Delete)
						echo $this->template_view->getDeleteButton('data terpilih ..?',base_url().$this->uri->segment(1)."/delete/".$showData->id_t_harga_barang); 
						?>	
					</td>
					<td align="center"><?php echo $no; ?>.</td>
					<td ><?php echo $showData->nama_produk ; ?></td>
					<td ><?php echo $showData->nama_kertas ; ?></td>
					<td ><?php echo $showData->ukuran_kertas ; ?></td>
					<td ><?php echo $showData->minimal ; ?></td>
					<td ><?php echo $showData->maximal ; ?></td>
					<td ><?php echo format_rupiah($showData->harga_satu_sisi ); ?></td>
					<td ><?php echo format_rupiah($showData->harga_dua_sisi ); ?>
					
					</td><td ><?php echo format_rupiah($showData->harga_satu_sisi_member ); ?></td>
					<td ><?php echo format_rupiah($showData->harga_dua_sisi_member ); ?></td>
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
  
