		</div>
		  <!-- /.content-wrapper -->
		  <footer class="main-footer">
			<div class="pull-right hidden-xs">
			 <!-- <b>Version</b> 2.3.8 -->
			</div>
			<strong>Copyright &copy; 2017 <!--<a href="http://almsaeedstudio.com">Almsaeed Studio</a>.</strong> All rights
			reserved.-->
		  </footer>

		  
		  </aside>
		  <!-- /.control-sidebar -->
		  <!-- Add the sidebar's background. This div must be placed
			   immediately after the control sidebar -->
		  <div class="control-sidebar-bg"></div>
		</div>
		<!-- ./wrapper -->

		<div class="modal fade" id="modalLogin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="false">
			<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">
						Waktu anda telah habis, silahkan Login kembali 
					</h4>
				</div>
				<div class="modal-body">					
					<form class="form-horizontal" id="form_login">						
						<div class="form-group">
							<label class="control-label col-sm-4" >Username :</label>
							<div class="col-sm-5">
								<input type="input" class="form-control " required name="USERNAME_LOGIN">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-4" >Password :</label>
							<div class="col-sm-5">
								<input type="password" class="form-control " id="PASSWORD_LOGIN" required name="PASSWORD_LOGIN">
								<input type="hidden" id="forAction" value="disableModal">
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
								<button type="submit"  class="btn btn-primary">Login</button>
							</div>
						</div>							
					</form>					
					
				</div>
			</div>
			</div>
		</div>

		
		
		<!-- jQuery 2.2.3 -->
		<script src="<?=base_url();?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
		<!-- jQuery UI 1.11.4 -->
		<script src="<?=base_url();?>assets/js/jquery-ui.min.js"></script>
		<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
		<script>	
			var base_url = "<?php echo base_url();?>";
			var uri_1 = "<?php echo $this->uri->segment(1); ?>";
			var uri_2 = "<?php echo $this->uri->segment(2); ?>";
			var uri_3 = "<?php echo $this->uri->segment(3); ?>";
			var uri_4 = "<?php echo $this->uri->segment(4); ?>";			
			$.widget.bridge('uibutton', $.ui.button);
			$(document).ready(function(){
				$('[data-toggle="popover"]').popover(); 
			});
		</script>
		<!-- Bootstrap 3.3.6 -->
		<script src="<?=base_url();?>assets/bootstrap/js/bootstrap.min.js"></script>
		<!-- Morris.js charts -->
		<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
		<script src="<?=base_url();?>assets/plugins/morris/morris.min.js"></script>
		<!-- Sparkline -->
		<script src="<?=base_url();?>assets/plugins/sparkline/jquery.sparkline.min.js"></script>
		<!-- jvectormap -->
		<script src="<?=base_url();?>assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
		<script src="<?=base_url();?>assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
		<!-- jQuery Knob Chart -->
		<script src="<?=base_url();?>assets/plugins/knob/jquery.knob.js"></script>
		<!-- daterangepicker -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
		<script src="<?=base_url();?>assets/plugins/daterangepicker/daterangepicker.js"></script>
		<!-- datepicker -->
		<script src="<?=base_url();?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
		<!-- Bootstrap WYSIHTML5 -->
		<script src="<?=base_url();?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
		<!-- Slimscroll -->
		<script src="<?=base_url();?>assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
		<!-- FastClick -->
		<script src="<?=base_url();?>assets/plugins/fastclick/fastclick.js"></script>
		<!-- AdminLTE App -->
		<script src="<?=base_url();?>assets/dist/js/app.min.js"></script>
		<!-- AdminLTE dashboard demo (This is only for demo purposes) 
		<script src="<?=base_url();?>assets/dist/js/pages/dashboard.js"></script>
		<!-- AdminLTE for demo purposes -->
		<script src="<?php echo base_url();?>assets/js/validate.js"></script>		
		
		<!------ ------------------------------------------- Semua aksi Form ------>
		<script src="<?=base_url();?>assets/js/module.js"></script>		
		
		<script>
			<?php
			if( !$this->session->userdata('nama_karyawan') ){
				echo "$('.wrapper').hide();$('#modalLogin').modal('show');";
			}
			?>			
			
			var detik = <?php echo date('s'); ?>;
			var menit = <?php echo date('i'); ?>;
			var jam   = <?php echo date('H'); ?>;
			 
			function clock()
			{
				if (detik!=0 && detik%60==0) {
					menit++;
					detik=0;
				}
				second = detik;
				 
				if (menit!=0 && menit%60==0) {
					jam++;
					menit=0;
				}
				minute = menit;
				 
				if (jam!=0 && jam%24==0) {
					jam=0;
				}
				hour = jam;
				 
				if (detik<10){
					second='0'+detik;
				}
				if (menit<10){
					minute='0'+menit;
				}
				 
				if (jam<10){
					hour='0'+jam;
				}
				waktu = hour+':'+minute+':'+second;
				 
				document.getElementById("jam").innerHTML = waktu;
				detik++;
			}
 
			setInterval(clock,1000);
			
			
			$('#datepicker').datepicker({
				autoclose: true,
				
			});
			
			$('#datepicker2').datepicker({
				autoclose: true,
				
			});

	</script>
		
	</body>
</html>
