
<!-- Content Header (Page header) -->
<section class="content">

	<div class="row">
	<div class="col-xs-12">
	<div class="nav-tabs-custom">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Daftar Listing WO</a></li>
			<li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Antrian Order Operator Grafis</a></li>
			<li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">Antrian Order Operator Print</a></li>
			
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="tab_1">
			
				<div class="box-header">
					

					<table class="table table-bordered">
					<thead>
						<tr>
						<th width="15%" class="text-center">No WO</th>
						<th class="text-center">Pelanggan</th>
						<th class="text-center">Tgl Order</th>
						<th class="text-center">Operator</th>
						<th class="text-center">Line</th>
						<th class="text-center">Status</th>
						</tr>
					</thead>
					<tbody>
						<?php echo $this->IsiTabel; ?>
					</tbody>
					</table>

				</div> 
			
			</div>
			<!-- /.tab-pane -->
			<div class="tab-pane" id="tab_2">
		
				<div class="box-header">
					
					<table class="table table-bordered">

						<thead>
							<tr>
							<th  width="15%" class="text-center">No. Order</th>
							<th class="text-center">Nama Pelanggan</th>
							<th class="text-center">Tgl Order</th>
							<th class="text-center">Line</th>

							</tr>
						</thead>
						<tbody>
							<?php
							$no = $this->input->get('per_page')+ 1;
							foreach($this->showDataAntriGrafis as $showData ){
							?>
							<tr>


							<td align="center"><?php echo $showData->NO_ORDER; ?></td>
							<td >
							<?php echo $showData->nama_pelanggan."<br>"; 
							echo ($showData->LOG_MEMBER == 'Y' ? '( Member )' : '( Bukan Member )');
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

				</div> 
		
			</div>
			<!-- /.tab-pane -->
			<div class="tab-pane" id="tab_3">
			
				<div class="box-header">
					
					<table class="table table-bordered">

						<thead>
							<tr>
							<th  width="15%" class="text-center">No. Order</th>
							<th class="text-center">Nama Pelanggan</th>
							<th class="text-center">Tgl Order</th>
							<th class="text-center">Line</th>

							</tr>
						</thead>
						<tbody>
							<?php
							$no = $this->input->get('per_page')+ 1;
							foreach($this->showDataAntriPrint as $showData ){
							?>
							<tr>


							<td align="center"><?php echo $showData->NO_ORDER; ?></td>
							<td >
							<?php echo $showData->nama_pelanggan."<br>"; 
							echo ($showData->LOG_MEMBER == 'Y' ? '( Member )' : '( Bukan Member )');
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

				</div> 
			
			</div>
		<!-- /.tab-pane -->
		</div>
	<!-- /.tab-content -->
	</div>
	</div>
    
  </div>
</section>
<!-- /.content -->
  
