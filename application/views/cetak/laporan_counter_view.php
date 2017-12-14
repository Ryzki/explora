<link rel="stylesheet" href="<?=base_url();?>assets/bootstrap/css/bootstrap.min.css">
<style>
	body{
		font-size:12px;
	}
	body table{
		font-size:12px;
	}
</style>
<body>

<table width="100%" cellpadding="0">
	
	<tr>
		
		<td align=""><center><h4>Laporan Counter tanggal : <b><?php echo $this->input->get('date'); ?></b></h4></center></td>
	</tr>

	
</table>
<hr>

			<?php
			if($this->input->get('date')){
			?>
		   
				<?php echo  $this->showLaporan; ?>
		   
			<?php
			}
			?>
</body>
<!-- /.content -->
<script>window.print();</script>

  
