function toRp(angka){
    var rev     = parseInt(angka, 10).toString().split('').reverse().join('');
    var rev2    = '';
    for(var i = 0; i < rev.length; i++){
        rev2  += rev[i];
        if((i + 1) % 3 === 0 && i !== (rev.length - 1)){
            rev2 += '.';
        }
    }
    return 'Rp. ' + rev2.split('').reverse().join('') ;
}

function toRibuan(angka){
    var rev     = parseInt(angka, 10).toString().split('').reverse().join('');
    var rev2    = '';
    for(var i = 0; i < rev.length; i++){
        rev2  += rev[i];
        if((i + 1) % 3 === 0 && i !== (rev.length - 1)){
            rev2 += '.';
        }
    }
    return  rev2.split('').reverse().join('');
}

function formatRibuan(objek) {
   a = objek.value;
   b = a.replace(/[^\d]/g,"");
   c = "";
   panjang = b.length;
   j = 0;
   for (i = panjang; i > 0; i--) {
     j = j + 1;
     if (((j % 3) == 1) && (j != 1)) {
       c = b.substr(i-1,1) + "." + c;
     } else {
       c = b.substr(i-1,1) + c;
     }
   }
   objek.value = c;
}


// Standard Form
$('#form_standar').validate({
	rules: {
		PASSWORD: "required",
		REPASS: {
		  equalTo: "#PASSWORD"
		}
	},
	submitHandler: function(form) {	
		
		
		$.ajax({
			url: base_url+''+uri_1+'/'+uri_2+'_data',
			type:'POST',
			dataType:'json',
			data: $('#form_standar').serialize(),
			beforeSend: function(){	
				$('#loading').show();
				$('#pesan_error').hide();
			},
			success: function(data){
				if( data.status ){	
					if(data.kasir){
						$('.main-footer').append('<div class="modal fade" id="container-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="false"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><h4 class="modal-title" id="myModalLabel">Pesan Pemberitahuan</h4></div><div class="modal-body">Silahkan Cetak Nota dengan klik <br><br><a target="_blank" href="'+base_url+'cetak/nota/'+data.id_order+'"><span class="btn btn-success">Cetak Nota</span></a></div><div class="modal-footer"><a href="'+base_url+''+uri_1+'"><span class="btn btn-primary" >Selesai</span></a></div></div></div></div>');
						$('#container-modal').modal('show');
					}
					else if(data.print_job){
						
					//	window.open(base_url+'cetak/job/'+uri_3,'_blank');
						
						$('.main-footer').append('<div class="modal fade" id="container-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="false"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><h4 class="modal-title" id="myModalLabel">Pesan Pemberitahuan</h4></div><div class="modal-body">Input Wo berhasil disimpan, silahkan Cetak Work Order <br><br><a href="'+base_url+'cetak/job/'+uri_3+'" target="_blank"><span class="btn btn-success" >Cetak Work Order</span></a></div><div class="modal-footer"><a href="'+base_url+''+uri_1+'"><span class="btn btn-primary" >Selesai</span></a></div></div></div></div>');
						$('#container-modal').modal('show');
						
					}
					else if(data.pesan_modal){
						$('.main-footer').append('<div class="modal fade" id="container-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="false"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><h4 class="modal-title" id="myModalLabel">Pesan Pemberitahuan</h4></div><div class="modal-body">'+data.pesan_modal+'</div><div class="modal-footer"><a href="'+data.redirect_link+'"> <button type="button" class="btn btn-primary">Ok</button></a></div></div></div></div>');
						$('#container-modal').modal('show');
					}
					else{
						$('.main-footer').append('<div class="modal fade" id="container-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="false"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><h4 class="modal-title" id="myModalLabel">Pesan Pemberitahuan</h4></div><div class="modal-body"><b>Data berhasil disimpan.</b></div><div class="modal-footer"><a href="'+data.redirect_link+'"> <button type="button" class="btn btn-primary">Ok</button></a></div></div></div></div>');
						$('#container-modal').modal('show');
					}
				}
				else{				
					$('#loading').hide(); $('#pesan_error').show(); $('#pesan_error').html(data.pesan);					 
				}
			},
			error : function(data) {
				$('#pesan_error').html('maaf telah terjadi kesalahan dalam program, silahkan anda mengakses halaman lainnya.'); $('#pesan_error').show(); $('#loading').hide();
				//$('#pesan_error').html( '<h3>Error Response : </h3><br>'+JSON.stringify( data ));
			}
		})
	}
});


$('#form_order').validate({
	submitHandler: function(form) {			
		$.ajax({
			url: base_url+''+uri_1+'/'+uri_2+'_data',
			type:'POST',
			dataType:'json',
			data: $('#form_order').serialize(),
			beforeSend: function(){	
				$('#loading').show();
				$('#pesan_error').hide();
			},
			success: function(data){
				if( data.status ){	
					
						$('.main-footer').append('<div class="modal fade" id="container-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="false"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><h4 class="modal-title" id="myModalLabel">Pesan Pemberitahuan</h4></div><div class="modal-body"><b>Data berhasil disimpan.</b></div><div class="modal-footer"><span class="pull-left"><a href="'+base_url+'cetak/antrian/'+data.id_order+'" target="_blank"> <button type="button" class="btn btn-success">Cetak Nomor Antrian</button></a></span><span class="pull-right"><a href="'+data.redirect_link+'"> <button type="button" class="btn btn-primary">Ok</button></a></span></div></div></div></div>');
						$('#container-modal').modal('show');
					
				}
				else{				
					$('#loading').hide(); $('#pesan_error').show(); $('#pesan_error').html(data.pesan);					 
				}
			},
			error : function(data) {
				$('#pesan_error').html('maaf telah terjadi kesalahan dalam program, silahkan anda mengakses halaman lainnya.'); $('#pesan_error').show(); $('#loading').hide();
				//$('#pesan_error').html( '<h3>Error Response : </h3><br>'+JSON.stringify( data ));
			}
		})
	}
});


$('#form_kasir').validate({
	submitHandler: function(form) {			
		$.ajax({
			url: base_url+''+uri_1+'/'+uri_2+'_data',
			type:'POST',
			dataType:'json',
			data: $('#form_kasir').serialize(),
			beforeSend: function(){	
				$('#loading').show();
				$('#pesan_error').hide();
			},
			success: function(data){
				if( data.status ){	
					
						$('.main-footer').append('<div class="modal fade" id="container-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="false"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><h4 class="modal-title" id="myModalLabel">Pesan Pemberitahuan</h4></div><div class="modal-body"><b>Data berhasil disimpan. </b></div><div class="modal-footer"><span class="pull-left"><a href="'+base_url+'cetak/struk/'+data.id_order+'" target="_blank"> <button type="button" class="btn btn-primary">Cetak Struk</button></a><a href="'+base_url+'cetak/nota/'+data.id_order+'" target="_blank"> <button type="button" class="btn btn-warning">Cetak Invoice</button></a></span><span class="pull-right"><a href="'+data.redirect_link+'"> <button type="button" class="btn btn-primary">Ok</button></a></span></div></div></div></div>');
						$('#container-modal').modal('show');
					
				}
				else{				
					$('#loading').hide(); $('#pesan_error').show(); $('#pesan_error').html(data.pesan);					 
				}
			},
			error : function(data) {
				$('#pesan_error').html('maaf telah terjadi kesalahan dalam program, silahkan anda mengakses halaman lainnya.'); $('#pesan_error').show(); $('#loading').hide();
				//$('#pesan_error').html( '<h3>Error Response : </h3><br>'+JSON.stringify( data ));
			}
		})
	}
});

$('#PASSWORD_LOGIN').keydown(function(event){ 
    var keyCode = (event.keyCode ? event.keyCode : event.which);   
    if (keyCode == 13) {
        $('#startSearch').trigger('click');
    }
});

$('#form_login').validate({
	submitHandler: function(form) {	
		$.ajax({
			url: base_url+'login/login_data',
			type:'POST',
			dataType:'json',
			data: $('#form_login').serialize(),
			beforeSend: function(){	
				$('#loading_login').show();
				$('#pesan_error_login').hide();
			},
			success: function(data){
				if( data.status ){		
					if($('#forAction').val()=='disableModal'){
						$('#modalLogin').hide('scale',function(){
							location.reload();
						});					
					}
					else{
						$('#modalLogin').slideUp('scale',function(){
							location.href= data.redirect_link;
						});						
					}
				}
				else{				
					$('#loading_login').hide(); $('#pesan_error_login').show(); $('#pesan_error_login').html(data.pesan);					 
				}
			},
			error : function(data) {
				$('#pesan_error_login').html('maaf telah terjadi kesalahan dalam program, silahkan anda mengakses halaman lainnya.'); $('#pesan_error_login').show(); $('#loading_login').hide();
				//$('#pesan_error').html( '<h3>Error Response : </h3><br>'+JSON.stringify( data ));
			}
		})
	}
});


$('#form_finish_design').validate({
	submitHandler: function(form) {	
	
		$.ajax({
			url: base_url+''+uri_1+'/add_data_finish_design',
			type:'POST',
			dataType:'json',
			data: $('#form_finish_design').serialize(),
			beforeSend: function(){	
				$('#loading_finish_design').show();
			},
			success: function(data){
				location.reload();
			},
			error : function(data) {
				alert(data);
				$('#loading_finish_design').hide();
				$('#pesan_error_finish_design').html('maaf telah terjadi kesalahan dalam program, silahkan anda mengakses halaman lainnya.');
			}
		})
	}	
});


function search_member(){
	var hp = $('#HP_CUSTOMER').val();
	if(hp.length > 2){
		$.ajax({
			url: base_url+'pelanggan/search_pelangan',
			type:'POST',
			dataType:'json',
			data: { no_hp : hp },	
			success: function(data){
				if(data.status){
					if(data.pelanggan){
						$('#div_pesan_member').html('<p class="text-success"><i class="fa fa-exclamation-triangle "></i>&nbsp; Member<br>masa aktif member = '+data.tgl_mulai_member+' s/d '+data.tgl_akhir_member+'</p>');
						$('#NAMA_CUSTOMER').val(data.nama);
						$('#ALAMAT_CUSTOMER').val(data.alamat);
						
						$('#ID_CUSTOMER').val(data.id_pelanggan);
						$('#LOG_MEMBER').val('Y');
						
						$('#NAMA_CUSTOMER').prop('readonly', true);
						$('#ALAMAT_CUSTOMER').prop('readonly', true);
					}
					else{
						$('#div_pesan_member').html(' <p class="text-warning"><i class="fa fa-exclamation-triangle "></i>&nbsp; Pelanggan sudah pernah transaksi, tetapi Bukan Member</p>');
						$('#NAMA_CUSTOMER').val(data.nama);
						$('#ALAMAT_CUSTOMER').val(data.alamat);
						
						$('#ID_CUSTOMER').val(data.id_pelanggan);
						$('#LOG_MEMBER').val('N');
						
						$('#NAMA_CUSTOMER').prop('readonly', true);
						$('#ALAMAT_CUSTOMER').prop('readonly', true);
					}
					
				}
				
				else{
					$('#div_pesan_member').html(' <p class="text-danger"><i class="fa fa-exclamation-triangle "></i>&nbsp; Pelanggan belum pernah transaksi</p>');
					$('#NAMA_CUSTOMER').val('');
					$('#ALAMAT_CUSTOMER').val('');
					$('#NAMA_CUSTOMER').prop('readonly', false);
					$('#ALAMAT_CUSTOMER').prop('readonly', false);
					$('#ID_CUSTOMER').val('');
					$('#LOG_MEMBER').val('N');
				}
			}
		})
		
	}

}



$('#form_ukuran_kertas').validate({
	submitHandler: function(form) {	
	
		if(parseInt($('#MIN_BARANG').val()) > parseInt($('#MAX_BARANG').val())){
			alert('Jumlah maximal harus lebih besar');
		}
		else{
	
			$.ajax({
				url: base_url+''+uri_1+'/add_data_ukuran_kertas',
				type:'POST',
				dataType:'json',
				data: $('#form_ukuran_kertas').serialize(),
				beforeSend: function(){	
					$('#loading_harga_barang').show();
				},
				success: function(data){
					if( data.status ){		
						location.reload();
					}
					else{				
						alert(data.pesan);	
						$('#loading_harga_barang').hide();
					}
				},
				error : function(data) {
					alert(data);
					$('#loading_harga_barang').hide();
				}
			})
		}
	}
	
});

function keterangan_alur_order(){
	$('.main-footer').append('<div class="modal fade" id="container-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="false"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><h4 class="modal-title" id="myModalLabel">Pesan Konfirmasi</h4></div><div class="modal-body"><ul>Jika anda memilih Kasir, maka WO akan dilanjutkan langsung menuju halaman menu kasir.<br>Contoh jika customer membeli Alat Banner saja.</ul><ol>Jika anda memilih OP Print &#10132; Kasir, maka WO akan dilanjutkan ke menu Operator Print. Setelah itu dari menu Operator Print dapat diteruskan menuju halaman menu kasir.<br>contoh : jika customer/pelanggan hanya membeli jasa Cetak tanpa proses Desain.</ol><ol>Jika anda memilih OP Grafis &#10132; Kasir, maka WO akan dilanjutkan ke menu Operator Grafis. Setelah itu dari menu Operator Grafis dapat diteruskan menuju halaman menu kasir.<br>contoh : jika customer/pelanggan hanya membeli jasa Desain tanpa proses printing.</ol><ol>Jika anda memilih OP Grafis &#10132; OP Print &#10132; Kasir, maka WO akan dilanjutkan ke menu Operator Grafis. Setelah itu dari menu Operator Grafis dapat diteruskan menuju halaman menu Operator Print.  Dari Operator Print dapat Diteruskan ke Kasir jika WO sudah di Print. </ol></div><div class="modal-footer"><div class="pull-left"><button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button></div></div></div></div></div>');
	$('#container-modal').modal('show');
}


function tampil_pesan_hapus(pesan_hapus,link_hapus){
	$('.main-footer').append('<div class="modal fade" id="container-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="false"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><h4 class="modal-title" id="myModalLabel">Pesan Konfirmasi</h4></div><div class="modal-body">Apakah anda yakin akan menghapus data <b>'+pesan_hapus+'</b> ..?</div><div class="modal-footer"><div class="pull-left"><button type="button" class="btn btn-warning" data-dismiss="modal">Tidak</button></div><a href="'+link_hapus+'"> <button type="button" class="btn btn-primary">Ya</button></a></div></div></div></div>');
	$('#container-modal').modal('show');

}

function showModalLogOut(link){
	$('.main-footer').append('<div class="modal fade" id="modalLogout" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="false"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><h4 class="modal-title" id="myModalLabel">Pesan Konfirmasi</h4></div><div class="modal-body">Apakah anda yakin akan keluar  ..?</div><div class="modal-footer"><div class="pull-left"><button type="button" class="btn btn-warning" data-dismiss="modal">Tidak</button></div><a href="'+link+'"> <button type="button" class="btn btn-primary">Ya</button></a></div></div></div></div>');
	$('#modalLogout').modal('show');

}

function checkAllDeleteButton(){
	if ($('#checkAllDelete').is(':checked')) {
		$('input:checkbox').prop('checked', true);
	}
	else{
		$('input:checkbox').prop('checked', false);
	}
}

$("#NAMA_KARYAWAN_AUTOCOMPLETE").autocomplete({
	source:base_url+'karyawan/search_karyawan/',
	select: function (e, ui) {
		$("#ID_KARYAWAN").val(ui.item.id_karyawan);
	}
});

$("#NAMA_BARANG_AUTOCOMPLETE").autocomplete({
	source:base_url+'barang/search_barang/',
	select: function (e, ui) {
		hilang_jumlah_barang_form();
		
		$("#JUMLAH_QTY_FORM").focus();
		$("#ID_BARANG_FORM").val(ui.item.id_barang);
		$("#SATUAN_BARANG_FORM").val(ui.item.satuan_barang);
	}
});


function hitung_harga_barang(){
	
	$.ajax({
		url: base_url+'barang/get_data_harga',
		type:'POST',
		dataType:'json',
		data: { id_barang : $('#ID_BARANG_FORM').val() , jumlah : $('#JUMLAH_QTY_FORM').val() },	
		success: function(data){
			if(data.status){
				
				var total = parseInt($('#JUMLAH_QTY_FORM').val()) *  parseInt(data.harga_qty);				
				
				$('#HARGA_QTY_FORM').val(data.harga_qty);
				$('#TOTAL_QTY_FORM').val(total);
				
			}
			else{
				alert('Not Found !');
			}
		}
	})	
}

function hilang_jumlah_barang_form(){
	$('#JUMLAH_QTY_FORM').val('') ;
	$('#ID_BARANG_FORM').val('') ;
	$('#HARGA_SATUAN_FORM').val('') ;
	$('#TOTAL_HARGA_FORM').val('') ;
	$('#harga_barang').html('');
	$("#satuan_barang").html("");
	
}



function modalStartGrafis(id_order,no_order,tgl_order){
	$('#input_id_order_start_grafis').val(id_order);
	$('#tglorder').html('<b>'+tgl_order+'</b>');
	$('#nomororder').html('<b>'+no_order+'</b>');
	$('#modal_start_grafis').modal('show');
	
}

function startGrafis(){
	$.ajax({
		url: base_url+'grafis/start_grafis/',
		type:'POST',
		dataType:'json',
		data: { input_id_order_start_grafis : $('#input_id_order_start_grafis').val()},	
		success: function(data){
			if(data.status){
				
				$('#pesan_start_grafis').html('<p>Proses pengerjaan Design Grafis dimulai.</p>');
				location.reload();
				
			}
			else{
				alert('Gagal !');
			}
		}
	})
}

function hapus_barang(id){
	$("#tr_barang_" + id).remove();
}


//////////////////////////////////
///// <!--------------------- Digital printing 


function ganti_produk_a3(){

	if($('#id_produk').val()=='8' || $('#id_produk').val()=='12'){
		$('#form_8').slideDown();
		
		$('#form_10').hide();
		$('#form_10')[0].reset();
		
		$.ajax({
			url: base_url+''+uri_1+'/cari_kertas_berdasar_produk',
			type:'POST',
			dataType:'html',
			data:	{	id_produk: $('#id_produk').val()	},
			success: function(data){
				$('#id_kertas').html(data);
			}
		}) 
		
	}
	else if($('#id_produk').val()=='10' || $('#id_produk').val()=='11'){
		$('#form_10').slideDown();
		
		$('#form_8').hide();
		$('#form_8')[0].reset();
		
		$.ajax({
			url: base_url+''+uri_1+'/cari_kertas_berdasar_produk',
			type:'POST',
			dataType:'html',
			data:	{	id_produk: $('#id_produk').val()	},
			success: function(data){
				$('#id_kertas_kartu_nama').html(data);
			}
		}) 
	}
	else{
		$('#form_8').hide();
		$('#form_8')[0].reset();
		
		$('#form_10').hide();
		$('#form_10')[0].reset();
	}
	
	
	
	
	
}

function tambah_data_produk_digital_printing(){

	if($("#id_produk").val()==''){
		alert('Silahkan pilih Produk !');
		
	}
	else	if($("#page_img").val()==''){
		alert('Page image belum ditentukan !');
		
	}
	else if($("#id_kertas").val()==''){
		alert('Silahkan pilih Kertas Bahan !');
		
	}
	else if($("#id_ukuran_kertas").val()==''){
		alert('Silahkan pilih Ukuran Kertas Bahan !');
		
	}
	else if($("#jml_copy").val()==''){
		alert('Silahkan masukkan jumlah copy !');
		
	}
	else if($("#klik").val()==''){
		alert('Total Klik belum ditentukan !');
		
	}
	else{
		var page_img = null;
		var jml_sisi = null;
		var up = null;
		var copy = null;
		var page_on_site_side = null;
	
		if($('#page_img').val() != ''){			
			page_img = $('#page_img').val() +' img,';
		}
		if($('#jml_sisi').val() != ''){			
			jml_sisi = $('#jml_sisi').val() +' Sisi,';
		}
		if($('#up').val() != ''){			
			up = $('#up').val() +' UP,';
		}
		if($('#jml_copy').val() != ''){			
			jml_copy = $('#jml_copy').val() +' Copy,';
		}
		if($('#page_on_site_side').val() != ''){			
			page_on_site_side = $('#page_on_site_side').val();
		}
	
	
	
	
		var text_produk 		= 	$("#id_produk option:selected").text();
		var text_kertas 		= 	$("#id_kertas option:selected").text();
		var text_ukuran_kertas 	= 	$("#id_ukuran_kertas option:selected").text();
	
		var nama_semua_barang = text_produk+' '+text_kertas+' '+text_ukuran_kertas+' '+page_img+' '+jml_sisi+' '+jml_copy+' '+up+' '+page_on_site_side ;
		
		var nama_semua_barang_plus = text_produk+' '+text_kertas+' '+text_ukuran_kertas+' '+page_img+' '+jml_sisi+' '+jml_copy+' '+up+' '+page_on_site_side+'<br>'+$('#nama_file_setelah_upload').val()+'<br>'+$('#keterangan').val();
	
		$('#tabel_op_grafis').append('<tr id="tr_barang_'+$('#id_barang_grafis').val()+'">	<td> <input type="hidden" name="ID_BARANG_GRAFIS[]" value="'+$('#id_barang_grafis').val()+'"> <input type="hidden" name="klik_'+$('#id_barang_grafis').val()+'" value="'+$('#klik').val()+'"> <input type="hidden" name="id_produk_'+$('#id_barang_grafis').val()+'" value="'+$('#id_produk').val()+'"> <input type="hidden" name="nama_file_pekerjaan_'+$('#id_barang_grafis').val()+'" value="'+$('#nama_file_setelah_upload').val()+'">	<input type="hidden" name="id_kertas_'+$('#id_barang_grafis').val()+'" value="'+$('#id_kertas').val()+'">	<input type="hidden" name="id_ukuran_kertas_'+$('#id_barang_grafis').val()+'" value="'+$('#id_ukuran_kertas').val()+'"> <input type="hidden" name="page_img_'+$('#id_barang_grafis').val()+'" value="'+$('#page_img').val()+'"> <input type="hidden" name="jml_sisi_'+$('#id_barang_grafis').val()+'" value="'+$('#jml_sisi').val()+'"> <input type="hidden" name="jml_copy_'+$('#id_barang_grafis').val()+'" value="'+$('#jml_copy').val()+'"> <input type="hidden" name="up_'+$('#id_barang_grafis').val()+'" value="'+$('#up').val()+'"> <input type="hidden" name="page_on_site_side_'+$('#id_barang_grafis').val()+'" value="'+$('#page_on_site_side').val()+'">	<input type="hidden" name="keterangan_'+$('#id_barang_grafis').val()+'" value="'+$('#keterangan').val()+'"> '+nama_semua_barang_plus+' 	</td> <td  class="text-center" ><i class="fa fa-trash text-danger" onclick="hapus_barang('+$('#id_barang_grafis').val()+')"></i></td></tr>');
		
		
		var newId = parseInt($('#id_barang_grafis').val()) + 1;
		$('#id_barang_grafis').val(newId);
		
		$('#NAMA_BARANG_AUTOCOMPLETE').val('');
		$('#JUMLAH_QTY_FORM').val('');
		$('#SATUAN_BARANG_FORM').val('');
		
		
		$('#id_produk').val('');
		$('#nama_file_pekerjaan').val('');
		$('#nama_file_setelah_upload').val('');
		$('#mesin').val('');
		$('#id_kertas').val('');
		$('#id_ukuran_kertas').val('');
		$('#page_img').val('');
		$('#jml_sisi').val('');
		$('#jml_copy').val('');
		$('#up').val('');
		$('#page_on_site_side').val('');
		$('#nama_barang_all').val('');
		$('#keterangan').val('');
		$('#klik').val('');
		
		$('#form_8').hide();
	}
		
}


function tambah_data_produk_kartu_nama(){
	
	if($("#id_produk").val()==''){
		alert('Silahkan pilih Produk !');
		
	}
	else if($("#id_kertas_kartu_nama").val()==''){
		alert('Silahkan pilih Kertas Bahan !');
		
	}
	else if($("#id_ukuran_kertas_kartu_nama").val()==''){
		alert('Silahkan pilih Ukuran Kertas Bahan !');
		
	}
	else if($("#page_img_kartu_nama").val()==''){
		alert('Page Image belum ditentukan !');
		
	}
	else if($("#jml_sisi_kartu_nama").val()==''){
		alert('Jumlah Sisi belum ditentukan !');
		
	}
	else if($("#klik_kartu_nama").val()==''){
		alert('Total Klik belum ditentukan !');
		
	}
	else if($("#box_kartu_nama").val()==''){
		alert('Total Box belum ditentukan !');
		
	}
	else{

		var text_produk 		= 	$("#id_produk option:selected").text()+' / ';
		var text_kertas 		= 	$("#id_kertas_kartu_nama option:selected").text()+'';
		var text_ukuran_kertas 	= 	$("#id_ukuran_kertas_kartu_nama option:selected").text()+', ';
		var page_img 			= 	$("#page_img_kartu_nama").val()+' Img,';
		var box 			= 	$("#box_kartu_nama").val()+' Box ,';
		
		var jml_sisi 			= 	$("#jml_sisi_kartu_nama").val()+' Sisi,';
		var jml_copy 			= 	$("#jml_copy_kartu_nama").val()+ ' Copy';
		
		var nama_semua_barang_plus = text_produk+' '+text_kertas+'<br> '+box+' '+page_img+' '+jml_sisi+' '+jml_copy+'<br>'+$('#nama_file_setelah_upload_kartu_nama').val()+'<br>'+$('#keterangan_kartu_nama').val();
	
		$('#tabel_op_grafis').append('<tr id="tr_barang_'+$('#id_barang_grafis').val()+'">	<td> <input type="hidden" name="ID_BARANG_KARTU_NAMA[]" value="'+$('#id_barang_grafis').val()+'"> <input type="hidden" name="box_kartu_nama_'+$('#id_barang_grafis').val()+'" value="'+$('#box_kartu_nama').val()+'"> 	<input type="hidden" name="klik_kartu_nama_'+$('#id_barang_grafis').val()+'" value="'+$('#klik_kartu_nama').val()+'"> <input type="hidden" name="id_produk" value="'+$('#id_produk').val()+'"> <input type="hidden" name="nama_file_setelah_upload_kartu_nama_'+$('#id_barang_grafis').val()+'" value="'+$('#nama_file_setelah_upload_kartu_nama').val()+'">	<input type="hidden" name="id_kertas_kartu_nama_'+$('#id_barang_grafis').val()+'" value="'+$('#id_kertas_kartu_nama').val()+'">	<input type="hidden" name="id_ukuran_kertas_kartu_nama_'+$('#id_barang_grafis').val()+'" value="'+$('#id_ukuran_kertas_kartu_nama').val()+'"> <input type="hidden" name="page_img_kartu_nama_'+$('#id_barang_grafis').val()+'" value="'+$('#page_img_kartu_nama').val()+'"> <input type="hidden" name="jml_sisi_kartu_nama_'+$('#id_barang_grafis').val()+'" value="'+$('#jml_sisi_kartu_nama').val()+'"> <input type="hidden" name="jml_copy_kartu_nama_'+$('#id_barang_grafis').val()+'" value="'+$('#jml_copy_kartu_nama').val()+'">	<input type="hidden" name="keterangan_kartu_nama_'+$('#id_barang_grafis').val()+'" value="'+$('#keterangan_kartu_nama').val()+'"> '+nama_semua_barang_plus+' </td> <td  class="text-center" ><i class="fa fa-trash text-danger" onclick="hapus_barang('+$('#id_barang_grafis').val()+')"></i></td></tr>');
		
		
		var newId = parseInt($('#id_barang_grafis').val()) + 1;
		$('#id_barang_grafis').val(newId);

		$('#form_10')[0].reset();
		$('#id_produk').val('');
		$('#form_10').hide();
		
		
		
	
		
		
	}
	

}



$('#nama_file_pekerjaan').change(function(evt) {
	$('#loading_upload').html('Proses Upload File ...');
    var file_data = $('#nama_file_pekerjaan').prop('files')[0];   
	var form_data = new FormData();                  
	form_data.append('userfile', file_data);
	//alert(form_data);   
	
	
	$.ajax({
		url: base_url+''+uri_1+'/upload/',
		dataType: 'text',  // what to expect back from the PHP script, if anything
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(php_script_response){
		  //  alert(php_script_response); // display response from the PHP script, if any
				//$('#nama_file_setelah_upload').val(completeName);
				
				
				var nama = $("#nama_file_pekerjaan").val();
				var newFile = nama.split(String.fromCharCode(92)).join("|")

				$('#nama_file_setelah_upload').val(newFile);
				
				$.ajax({
					url: base_url+''+uri_1+'/cek_jumlah_halaman_pdf/',
					type:'POST',
					dataType:'json',
					data: {path: php_script_response },
					success: function(data){
						alert("Jumlah Halaman adalah : "+ data.jumlah_halaman);
						$('#page_img').val(data.jumlah_halaman);
						
						$('#nama_file_pekerjaan').val();
						
						hitung_jumlah_klik();
					},
					error : function(data) {
						//alert('Maaf, Sistem tidak dapat menghitung Jumlah Page. Silahkan inputkan Jumlah Page secara manual.');
						$('#page_img').focus();
						$("#page_img").removeAttr("readonly"); 
						//$("#page_img").attr("placeholder", "inputkan Jumlah Page");
					}
				}) 
		 
			//});
			$('#loading_upload').html('Proses Upload File selesai.');
			
		   
		}
	});
});


function ganti_up(){
	if($('#up').val()=='1'){
		
		$('#page_on_site_side').html('<option value="-">-</option><option value="Repeated">Repeated</option><option value="Sequential">Sequential</option><option value="Cut & Stack">Cut & Stack</option><option value="Alternating">Alternating</option>')
	}
	else{
		$('#page_on_site_side').html('<option value="Repeated">Repeated</option><option value="Sequential">Sequential</option><option value="Cut & Stack">Cut & Stack</option><option value="Alternating">Alternating</option>')
	}
	
	hitung_jumlah_klik();
}


function hitung_jumlah_klik(){	

	if( $('#jml_sisi').val() == '2' ){
	
		var GenapGanjil = parseInt($('#page_img').val() % 2);
		
		if(GenapGanjil == '1'){
			var pageImageTanpaTitik 	=	$('#page_img').val();
			var pageImageTanpaTitik		=	pageImageTanpaTitik.split('.').join('');	
			
			var tambahPageImage			=	parseInt(pageImageTanpaTitik) + 1;
			$('#page_img').val(tambahPageImage);
		}
	}
	
	pageImageA = $('#page_img').val();
	pageImageB = pageImageA.replace(/[^\d]/g,"");
	pageImageC = "";
	panjangPageImage = pageImageB.length;
	j = 0;
	for (i = panjangPageImage; i > 0; i--) {
		j = j + 1;
		if (((j % 3) == 1) && (j != 1)) {
			pageImageC = pageImageB.substr(i-1,1) + "." + pageImageC;
		} else {
			pageImageC = pageImageB.substr(i-1,1) + pageImageC;
		}
	}
	$('#page_img').val(pageImageC) ;	
	var pageImageTanpaTitik 	=	$('#page_img').val();
	var pageImageTanpaTitik		=	pageImageTanpaTitik.split('.').join('');	
	
	
	copyA 		= $('#jml_copy').val();
	copyB 		= copyA.replace(/[^\d]/g,"");
	copyC 	= "";
	copy = copyB.length;
	j = 0;
	for (i = copy; i > 0; i--) {
		j = j + 1;
		if (((j % 3) == 1) && (j != 1)) {
			copyC = copyB.substr(i-1,1) + "." + copyC;
		} else {
			copyC = copyB.substr(i-1,1) + copyC;
		}
	}
	$('#jml_copy').val(copyC) ;
	
	var copyTanpaTitik 		=	$('#jml_copy').val();
	var copyTanpaTitik		=	copyTanpaTitik.split('.').join('');		
	
	
	if( $('#jml_sisi').val() == '2' ){
	
		
	
		var bulatKeatas = Math.ceil(  pageImageTanpaTitik / parseInt($('#up').val() )  );
	
		if( $('#page_on_site_side').val() == 'Sequential' || $('#page_on_site_side').val() == 'Cut & Stack' || $('#page_on_site_side').val() == 'Alternating'){
			
			var bulatKeatas = bulatKeatas + parseInt(bulatKeatas % 2);
			
			var jumlahKlik = bulatKeatas * parseInt(copyTanpaTitik) ;
			$('#klik').val(jumlahKlik);
			
		}
		else{
			//var jumlahKlik = bulatKeatas * parseInt(copyTanpaTitik) ;
			var jumlahKlik = parseInt (pageImageTanpaTitik * copyTanpaTitik);
			$('#klik').val(jumlahKlik);
		}
		//
		
	}
	else {
	
		//alert($('#jml_sisi').val());
	
		if( $('#page_on_site_side').val() == 'Repeated' ||  $('#page_on_site_side').val() == '-' ){
			var jumlahKlik = parseInt (pageImageTanpaTitik * copyTanpaTitik);
			//alert($('#jml_sisi').val());
			$('#klik').val(jumlahKlik);
		}
		else{
			var bulatKeatas = Math.ceil(  pageImageTanpaTitik / parseInt($('#up').val() )  );
			var bulatKeatas	=	bulatKeatas *  copyTanpaTitik;
			$('#klik').val(bulatKeatas);
		}
		
	}
	
	
	
	
	
	
	
	/*****
	
	////////////////// Rumus
	 
	jika jumlah sisi 2 
	   jika page on sheet side = "cut & stack" atau "alternating" atau "sequential" maka
			jumlah total klik = pembulatan ke atas hasil (page img / up)   +   (pembulatan ke atas hasil (page img / up)) mod 2 #dibulatkan_keatas_lalu_mod_2    X  formula klik   X  jumlah copy 
	   else
			jumlah total klik = pembulatan ke atas hasil (page img / up)   X  formula klik  X  jumlah Copy
	-------------
	jika 1 sisi 
		jika page on sheet side = 'repeated' 
			jumlah total klik = page img  X  formula klik  X  jumlah copy
		else
			jumlah total klik = pembulatan ke atas hasil (page img / up)
	
	******/
	
	/****
	
	var GenapGanjil = parseInt($('#page_img').val() % 2);
	////// jika Ganjil
	
	
	if(GenapGanjil == '1'){
		
		if($('#page_on_site_side').val() == 'Repeated' || $('#page_on_site_side').val() == '-'){
			var klik = parseInt( parseInt($('#page_img').val()) * parseInt($('#jml_copy').val()));
			var klik = parseInt(klik) + 1;
			$('#klik').val(klik);
		}
		else{
			
			//alert( parseFloat( parseInt($('#page_img').val()) / parseInt($('#up').val())  ));
			
			
			var jumlahKlikAwal = parseInt( parseInt($('#page_img').val()) / parseInt($('#up').val())  );
			var jumlahKlikAwal = parseInt(jumlahKlikAwal) + 2;
			
			var jumlahKlik  = parseInt(jumlahKlikAwal) * parseInt($('#jml_copy').val());
			$('#klik').val(jumlahKlik);
		}
	}
	
	//// jika Genap
	else{
		if($('#page_on_site_side').val() == 'Repeated' || $('#page_on_site_side').val() == '-'){
			var klik = parseInt( parseInt($('#page_img').val()) * parseInt($('#jml_copy').val()));
			$('#klik').val(klik);
		}
		if($('#page_on_site_side').val() == 'Cut & Stack'){
			var klik = parseInt((parseInt($('#page_img').val()) / parseInt($('#up').val())) * parseInt($('#jml_copy').val()) );
			$('#klik').val(klik);
		}
		if($('#page_on_site_side').val() == 'Sequential' || $('#page_on_site_side').val() == 'Alternating' ){
			var klik = parseInt((parseInt($('#page_img').val()) / parseInt($('#up').val())) * parseInt($('#jml_copy').val())) ;
			$('#klik').val(klik);
		}
	}
	***/
	
	
}
function hitung_jumlah_klik_kartu_nama(){
	/*****
	//alert();
	
	var jmlCopy = parseInt($('#jml_copy_kartu_nama').val());
	var jmlImg 	= parseInt($('#page_img_kartu_nama').val());
	var jmlSisi = parseInt($('#jml_sisi_kartu_nama').val());
	
	//var jumlahBox 	= 	parseInt( jmlImg  / jmlSisi )  ;
	
	//alert(jumlahBox +' x '+ jmlCopy +' = '+ jumlahBox2);
	
	
		var totalKlik	=	4 * jmlImg *  jmlCopy ;
		$('#klik_kartu_nama').val(totalKlik);
		
		var jumlahBox 	= 	parseInt( jmlImg  / jmlSisi ) *  jmlCopy;
		//alert(jumlahBox);
		$('#box_kartu_nama').val(jumlahBox);
		
		
	jika jumlah sisi 2 
	   jika page on sheet side = "cut & stack" atau "alternating" atau "sequential" maka
			jumlah total klik = pembulatan ke atas hasil (page img / up)   +   (pembulatan ke atas hasil (page img / up)) mod 2 #dibulatkan_keatas_lalu_mod_2    X  formula klik   X  jumlah copy 
	   else
			jumlah total klik = pembulatan ke atas hasil (page img / up)   X  formula klik  X  jumlah Copy
	-------------
	jika 1 sisi 
		jika page on sheet side = 'repeated' 
			jumlah total klik = page img  X  formula klik  X  jumlah copy
		else
			jumlah total klik = pembulatan ke atas hasil (page img / up)	
		
	************/
	
	if( $('#jml_sisi_kartu_nama').val() == '2' ){
	
		var GenapGanjil = parseInt($('#page_img_kartu_nama').val() % 2);
		
		if(GenapGanjil == '1'){
			var pageImageTanpaTitik 	=	$('#page_img_kartu_nama').val();
			var pageImageTanpaTitik		=	pageImageTanpaTitik.split('.').join('');	
			
			var tambahPageImage			=	parseInt(pageImageTanpaTitik) + 1;
			$('#page_img_kartu_nama').val(tambahPageImage);
		}
	}
	
	pageImageA = $('#page_img_kartu_nama').val();
	pageImageB = pageImageA.replace(/[^\d]/g,"");
	pageImageC = "";
	panjangPageImage = pageImageB.length;
	j = 0;
	for (i = panjangPageImage; i > 0; i--) {
		j = j + 1;
		if (((j % 3) == 1) && (j != 1)) {
			pageImageC = pageImageB.substr(i-1,1) + "." + pageImageC;
		} else {
			pageImageC = pageImageB.substr(i-1,1) + pageImageC;
		}
	}
	$('#page_img_kartu_nama').val(pageImageC) ;
	
	var pageImageTanpaTitik 	=	$('#page_img_kartu_nama').val();
	var pageImageTanpaTitik		=	pageImageTanpaTitik.split('.').join('');	
	
	copyA 		= $('#jml_copy_kartu_nama').val();
	copyB 		= copyA.replace(/[^\d]/g,"");
	copyC 	= "";
	copy = copyB.length;
	j = 0;
	for (i = copy; i > 0; i--) {
		j = j + 1;
		if (((j % 3) == 1) && (j != 1)) {
			copyC = copyB.substr(i-1,1) + "." + copyC;
		} else {
			copyC = copyB.substr(i-1,1) + copyC;
		}
	}
	$('#jml_copy_kartu_nama').val(copyC) ;
	
	var copyTanpaTitik 		=	$('#jml_copy_kartu_nama').val();
	var copyTanpaTitik		=	copyTanpaTitik.split('.').join('');	
	
	var bulatKeatas = Math.ceil(  pageImageTanpaTitik / parseInt($('#up_kartu_nama').val() )  );	
	
	var jumlahKlik = bulatKeatas * 4 * copyTanpaTitik ;
	$('#klik_kartu_nama').val(jumlahKlik);	
	
	var jumlahBox 	= 	parseInt( pageImageTanpaTitik  / $('#jml_sisi_kartu_nama').val() ) *  copyTanpaTitik;
	$('#box_kartu_nama').val(jumlahBox);
	
}


function jenis_harga(){
	if($('#JENIS_HARGA').val()=='SAMA'){		
		$('#div_harga_satuan').show();
		$('#div_form_harga').hide();
		$('#HARGA_SATUAN').addClass('required');
	}
	else{
		$('#div_harga_satuan').hide();
		$('#div_form_harga').show();
		$('#HARGA_SATUAN').removeClass('required');
		$('#HARGA_SATUAN').val('');
	}
}




function cari_ukuran_kertas(){
	
	$.ajax({
		url: base_url+''+uri_1+'/ukuran_kertas/',
		type:'POST',
		dataType:'html',
		data: {id_kertas: $('#id_kertas').val(), id_produk: $('#id_produk').val()},
		success: function(data){
			
			$('#id_ukuran_kertas').html(data);
		}
	}) 
	
}

function cari_ukuran_kertas_kartu_nama(){
	
	$.ajax({
		url: base_url+''+uri_1+'/ukuran_kertas/',
		type:'POST',
		dataType:'html',
		data: {id_kertas: $('#id_kertas_kartu_nama').val(), id_produk: $('#id_produk').val()},
		success: function(data){
			
			$('#id_ukuran_kertas_kartu_nama').html(data);
		}
	}) 
	
}

function hilang_value_id_kertas_id_ukuran(){
	
	$('#id_kertas').html('');
	$('#id_ukuran_kertas').html('<option value="">Silahkan pilih Jenis Kertas terlebih dahulu</option>');
	
}


function hilang_value_page_sheet_klik(){
	
	$('#page_on_site_side').val('');
	$('#klik').val('');
	$('#jml_copy').val('');
	
}




$('#nama_file_pekerjaan_kartu_nama').change(function(evt) {
	$('#loading_upload').html('Proses Upload File ...');
    var file_data = $('#nama_file_pekerjaan_kartu_nama').prop('files')[0];   
	var form_data = new FormData();                  
	form_data.append('userfile', file_data);
	//alert(form_data);   
	
	var Form = document.forms['form_10'];
	var inputName2 = document.getElementById("nama_file_pekerjaan_kartu_nama").value;
	var inputName=inputName2.split('\\').pop();	
	var ipComputer = $("#ClienComputerName").val();
	var completeName = ipComputer+' - '+inputName;
	
	$.ajax({
		url: base_url+''+uri_1+'/upload/',
		dataType: 'text',  // what to expect back from the PHP script, if anything
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		success: function(php_script_response){
		  //  alert(php_script_response); // display response from the PHP script, if any
				//$('#nama_file_setelah_upload_kartu_nama').val(completeName);
				var nama = $("#nama_file_pekerjaan_kartu_nama").val();
				var newFile = nama.split(String.fromCharCode(92)).join("|")

				$('#nama_file_setelah_upload_kartu_nama').val(newFile);
				
				$.ajax({
					url: base_url+''+uri_1+'/cek_jumlah_halaman_pdf/',
					type:'POST',
					dataType:'json',
					data: {path: php_script_response },
					success: function(data){
						alert("Jumlah Halaman adalah : "+ data.jumlah_halaman);
						$('#page_img_kartu_nama').val(data.jumlah_halaman);
						
						$('#nama_file_pekerjaan_kartu_nama').val();
					},
					error : function(data) {
						alert('Maaf, Sistem tidak dapat menghitung Jumlah Page.');
						$('#page_img_kartu_nama').focus();
						$("#page_img_kartu_nama").removeAttr("readonly"); 
					}
				}) 
		 
			//});
			$('#loading_upload_kartu_nama').html('Proses Upload File selesai.');
			
		   
		}
	});
});








////////////////////////////////////////////

	/////     Indoor / Outdoor
////////////////////////////////////////////

function produk_indoor_outdoor(){
	
	
	if($('#id_produk_indoor_outdoor').val()==''){
		$('#form_5').hide();
		$('#form_5')[0].reset();
		
		$('#form_6').hide();
		$('#form_6')[0].reset();
		
		$('#form_16').hide();
		$('#form_16')[0].reset();
		
		$('#form_15').hide();
		$('#form_15')[0].reset();
	}
	
	
	///////////////    Outdoor
	else if($('#id_produk_indoor_outdoor').val()=='5'){
		$('#form_5').slideDown();
		$('#form_6').hide();
		$('#form_6')[0].reset();
		$('#form_15').hide();
		$('#form_15')[0].reset();
		$('#form_16').hide();
		$('#form_16')[0].reset();
		
		$.ajax({
			url: base_url+'kertas_bahan/option_for_kertas/',
			type:'POST',
			dataType:'html',
			data: {id_produk: $('#id_produk_indoor_outdoor').val() },
			success: function(data){				
				$('#id_kertas_outdoor').html(data);
				
				
			}
		}) 
		
	}
	
	///////////////    Indoor
	else if($('#id_produk_indoor_outdoor').val()=='6'){
		$('#form_6').slideDown();
		$('#form_5').hide();
		$('#form_5')[0].reset();
		$('#form_15').hide();
		$('#form_15')[0].reset();
		$('#form_16').hide();
		$('#form_16')[0].reset();
		
		$.ajax({
			url: base_url+'kertas_bahan/option_for_kertas/',
			type:'POST',
			dataType:'html',
			data: {id_produk: $('#id_produk_indoor_outdoor').val() },
			success: function(data){				
				$('#id_kertas_indoor').html(data);
				
				
			}
		}) 
		
	}
	///////////////    Indoor Poster
	else if($('#id_produk_indoor_outdoor').val()=='15'){
		$('#form_15').slideDown();
		$('#form_5').hide();
		$('#form_5')[0].reset();
		$('#form_6').hide();
		$('#form_6')[0].reset();
		$('#form_16').hide();
		$('#form_16')[0].reset();
		
		$.ajax({
			url: base_url+'kertas_bahan/option_for_kertas/',
			type:'POST',
			dataType:'html',
			data: {id_produk: $('#id_produk_indoor_outdoor').val() },
			success: function(data){				
				$('#id_kertas_indoor_poster').html(data);
				
				
			}
		}) 
		
	}
	/////////// paket Banner
	else if($('#id_produk_indoor_outdoor').val()=='16'){
		$('#form_16').slideDown();
		$('#form_5').hide();
		$('#form_5')[0].reset();
		$('#form_6').hide();
		$('#form_6')[0].reset();
		$('#form_15').hide();
		$('#form_15')[0].reset();
		
		$.ajax({
			url: base_url+'kertas_bahan/option_for_kertas/',
			type:'POST',
			dataType:'html',
			data: {id_produk: $('#id_produk_indoor_outdoor').val() },
			success: function(data){				
				$('#id_kertas_paket_banner').html(data);
				
				
			}
		}) 
		
	}
	else{
		
		$('#form_5').hide();
		$('#form_5')[0].reset();
		
		$('#form_6').hide();
		$('#form_6')[0].reset();
		
		$('#form_15').hide();
		$('#form_15')[0].reset();
		
		$('#form_16').hide();
		$('#form_16')[0].reset();
	}
	
}

function cari_ukuran_kertas_indoor_outdoor(){
	
	$.ajax({
		url: base_url+''+uri_1+'/ukuran_kertas/',
		type:'POST',
		dataType:'html',
		data: {nama_kertas_bahan: $('#jenis_kertas_bahan_indoor_outdoor').val() },
		success: function(data){
			
			$('#ukuran_kertas_indoor_outdoor').html(data);
		}
	}) 
	
}

function tambah_data_produk_outdoor(){
	
	if(	$("#id_kertas_outdoor").val() == ''){
		alert('Pilih Jenis Kertas');
	}
	else if(	$("#lebar_outdoor").val() == ''){
		alert('masukkan lebar ');
	}
	else if(	$("#panjang_outdoor").val() == ''){
		alert('masukkan panjang ');
	}
	else if(	$("#jml_copy_outdoor").val() == ''){
		alert('masukkan jumlah copy ');
	}
	else{
		var text_kertas_outdoor 	= 	$("#id_kertas_outdoor option:selected").text();
		var text_produk 			= 	$("#id_produk_indoor_outdoor option:selected").text();
		
		var str_lebar				=	$('#lebar_outdoor').val();
		var lebar_tanpa_titik		=	str_lebar.replace(".", "");
		
		var str_panjang				=	$('#panjang_outdoor').val();
		var panjang_tanpa_titik		=	str_panjang.replace(".", "");
		
		var str_copy				=	$('#jml_copy_outdoor').val();
		var copy_tanpa_titik		=	str_copy.replace(".", "");
		
		var nama_file_outdoor		=	$('#nama_file_pekerjaan_outdoor').val();
		
		var nama_barang = text_produk+' <br>'+nama_file_outdoor+'<br>'+text_kertas_outdoor+'<br>Panjang : '+$('#panjang_outdoor').val()+' cm, Lebar : '+$('#lebar_outdoor').val()+' cm, '+$('#jml_copy_outdoor').val()+' copy <br> Finishing : '+$('#keterangan_finishing_outdoor').val()+' <br>'+$('#keterangan_outdoor').val();

		$('#tabel_op_grafis').append('<tr id="tr_barang_'+$('#id_barang_grafis').val()+'">	<td> '+nama_barang+'<input type="hidden" name="ID_BARANG_OUTDOOR[]" value="'+$('#id_barang_grafis').val()+'"> <input type="hidden" name="id_produk_outdoor_'+$('#id_barang_grafis').val()+'" value="'+$('#id_produk_indoor_outdoor').val()+'"> <input type="hidden" name="id_kertas_outdoor_'+$('#id_barang_grafis').val()+'" value="'+$('#id_kertas_outdoor').val()+'"> <input type="hidden" name="nama_file_pekerjaan_outdoor_'+$('#id_barang_grafis').val()+'" value="'+$('#nama_file_pekerjaan_outdoor').val()+'"> <input type="hidden" name="panjang_outdoor_'+$('#id_barang_grafis').val()+'" value="'+panjang_tanpa_titik+'"> <input type="hidden" name="lebar_outdoor_'+$('#id_barang_grafis').val()+'" value="'+lebar_tanpa_titik+'"> <input type="hidden" name="jml_copy_outdoor_'+$('#id_barang_grafis').val()+'" value="'+copy_tanpa_titik+'"> <input type="hidden" name="keterangan_outdoor_'+$('#id_barang_grafis').val()+'" value="'+$('#keterangan_outdoor').val()+'"> <input type="hidden" name="keterangan_finishing_outdoor_'+$('#id_barang_grafis').val()+'" value="'+$('#keterangan_finishing_outdoor').val()+'"> </td> <td  class="text-center" ><i class="fa fa-trash text-danger" onclick="hapus_barang('+$('#id_barang_grafis').val()+')"></i></td></tr>');
		
		
		var newId = parseInt($('#id_barang_grafis').val()) + 1;
		$('#id_barang_grafis').val(newId);
		
		$('#form_5')[0].reset();
		$('#id_produk_indoor_outdoor').val('');
		$('#form_5').slideUp();
	}
}



function tambah_data_produk_indoor(){
	
	if($("#id_kertas_indoor").val()==''){
		alert('Silahkan pilih Kertas Bahan !');
		
	}
	else if($("#lebar_indoor").val()==''){
		alert('Silahkan masukkan Lebar !');
		
	}
	else if($("#panjang_indoor").val()==''){
		alert('Silahkan masukkan panjang !');
		
	}
	else if($("#jml_copy_indoor").val()==''){
		alert('Silahkan masukkan jumlah copy ! !');
		
	}
	else{
	
		var text_kertas_indoor		= 	$("#id_kertas_indoor option:selected").text();
		var text_produk 			= 	$("#id_produk_indoor_outdoor option:selected").text();
		
		var str_lebar				=	$('#lebar_indoor').val();
		var lebar_tanpa_titik		=	str_lebar.replace(".", "");
		
		var str_panjang				=	$('#panjang_indoor').val();
		var panjang_tanpa_titik		=	str_panjang.replace(".", "");
		
		var str_copy				=	$('#jml_copy_indoor').val();
		var copy_tanpa_titik		=	str_copy.replace(".", "");
		
		var nama_file_indoor		=	$('#nama_file_pekerjaan_indoor').val();
		
		var nama_barang = text_produk+' <br>'+nama_file_indoor+' <br>'+text_kertas_indoor+'<br>Panjang : '+$('#panjang_indoor').val()+' cm, Lebar : '+$('#lebar_indoor').val()+' cm, '+$('#jml_copy_indoor').val()+' copy <br> Finishing : '+$('#keterangan_finishing_indoor').val()+' <br>'+$('#keterangan_indoor').val();

		$('#tabel_op_grafis').append('<tr id="tr_barang_'+$('#id_barang_grafis').val()+'">	<td> '+nama_barang+'<input type="hidden" name="ID_BARANG_INDOOR[]" value="'+$('#id_barang_grafis').val()+'"> <input type="hidden" name="id_produk_indoor_'+$('#id_barang_grafis').val()+'" value="'+$('#id_produk_indoor_outdoor').val()+'"> <input type="hidden" name="nama_file_pekerjaan_indoor_'+$('#id_barang_grafis').val()+'" value="'+$('#nama_file_pekerjaan_indoor').val()+'"> <input type="hidden" name="id_ukuran_kertas_indoor_'+$('#id_barang_grafis').val()+'" value="'+$('#id_ukuran_kertas_indoor').val()+'"> <input type="hidden" name="id_kertas_indoor_'+$('#id_barang_grafis').val()+'" value="'+$('#id_kertas_indoor').val()+'"> <input type="hidden" name="panjang_indoor_'+$('#id_barang_grafis').val()+'" value="'+panjang_tanpa_titik+'"> <input type="hidden" name="lebar_indoor_'+$('#id_barang_grafis').val()+'" value="'+lebar_tanpa_titik+'"> <input type="hidden" name="jml_copy_indoor_'+$('#id_barang_grafis').val()+'" value="'+copy_tanpa_titik+'"> <input type="hidden" name="keterangan_indoor_'+$('#id_barang_grafis').val()+'" value="'+$('#keterangan_indoor').val()+'"> <input type="hidden" name="keterangan_finishing_indoor_'+$('#id_barang_grafis').val()+'" value="'+$('#keterangan_finishing_indoor').val()+'"> </td> <td  class="text-center" ><i class="fa fa-trash text-danger" onclick="return confirm(hapus_barang('+$('#id_barang_grafis').val()+'))"></i></td></tr>');
		
		
		var newId = parseInt($('#id_barang_grafis').val()) + 1;
		$('#id_barang_grafis').val(newId);
		
		$('#form_6')[0].reset();
		$('#id_produk_indoor_outdoor').val('');
		$('#form_6').slideUp();
	}
}

function cariUkuranKertasIndoor(){
	
	$.ajax({
		url: base_url+'ukuran_kertas/option_for_ukuran_kertas/',
		type:'POST',
		dataType:'html',
		data: {id_produk: $('#id_produk_indoor_outdoor').val(),id_kertas: $('#id_kertas_indoor').val() },
		success: function(data){				
			$('#id_ukuran_kertas_indoor').html(data);		
		}
	}) 
	
}


function ganti_ukuran_kertas_indoor(){
	var ukuran_kertas 	= 	$("#id_ukuran_kertas_indoor option:selected").text();
	var lebar_outdoor	=	ukuran_kertas.split(' ');	
	
	$('#lebar_indoor').val(lebar_outdoor[0]);
	$('#panjang_indoor').focus();
	
}



function tambah_data_produk_indoor_poster(){
	
	if($("#id_kertas_indoor_poster").val()==''){
		alert('Silahkan pilih Kertas Bahan !');
		
	}
	else if($("#lebar_indoor_poster").val()==''){
		alert('Silahkan masukkan Lebar !');
		
	}
	else if($("#panjang_indoor_poster").val()==''){
		alert('Silahkan masukkan panjang !');
		
	}
	else if($("#jml_copy_indoor_poster").val()==''){
	alert('Silahkan masukkan jumlah copy ! !');
		
	}
	else{
	
		var text_kertas_indoor_poster		= 	$("#id_kertas_indoor_poster option:selected").text();
		var text_produk 			= 	$("#id_produk_indoor_outdoor option:selected").text();
		
		var str_lebar				=	$('#lebar_indoor_poster').val();
		var lebar_tanpa_titik		=	str_lebar.replace(".", "");
		
		var str_panjang				=	$('#panjang_indoor_poster').val();
		var panjang_tanpa_titik		=	str_panjang.replace(".", "");
		
		var str_copy				=	$('#jml_copy_indoor_poster').val();
		var copy_tanpa_titik		=	str_copy.replace(".", "");
		
		var nama_file_indoor_poster	=	$('#nama_file_pekerjaan_indoor_poster').val();
		
		var nama_barang = text_produk+' <br>'+ nama_file_indoor_poster+'<br>'+text_kertas_indoor_poster+'<br>Panjang : '+$('#panjang_indoor_poster').val()+' cm, Lebar : '+$('#lebar_indoor_poster').val()+' cm, '+$('#jml_copy_indoor_poster').val()+' copy <br> Finishing : '+$('#keterangan_finishing_indoor_poster').val()+' <br>'+$('#keterangan_indoor_poster').val();

		$('#tabel_op_grafis').append('<tr id="tr_barang_'+$('#id_barang_grafis').val()+'">	<td> '+nama_barang+'<input type="hidden" name="ID_BARANG_INDOOR_POSTER[]" value="'+$('#id_barang_grafis').val()+'"> <input type="hidden" name="nama_file_pekerjaan_indoor_poster_'+$('#id_barang_grafis').val()+'" value="'+$('#nama_file_pekerjaan_indoor_poster').val()+'"> <input type="hidden" name="id_produk_indoor_poster_'+$('#id_barang_grafis').val()+'" value="'+$('#id_produk_indoor_outdoor').val()+'"> <input type="hidden" name="id_ukuran_kertas_indoor_poster_'+$('#id_barang_grafis').val()+'" value="'+$('#id_ukuran_kertas_indoor_poster').val()+'"> <input type="hidden" name="id_kertas_indoor_poster_'+$('#id_barang_grafis').val()+'" value="'+$('#id_kertas_indoor_poster').val()+'"> <input type="hidden" name="panjang_indoor_poster_'+$('#id_barang_grafis').val()+'" value="'+panjang_tanpa_titik+'"> <input type="hidden" name="lebar_indoor_poster_'+$('#id_barang_grafis').val()+'" value="'+lebar_tanpa_titik+'"> <input type="hidden" name="jml_copy_indoor_poster_'+$('#id_barang_grafis').val()+'" value="'+copy_tanpa_titik+'"> <input type="hidden" name="keterangan_indoor_poster_'+$('#id_barang_grafis').val()+'" value="'+$('#keterangan_indoor_poster').val()+'"> <input type="hidden" name="keterangan_finishing_indoor_poster_'+$('#id_barang_grafis').val()+'" value="'+$('#keterangan_finishing_indoor_poster').val()+'"> </td> <td  class="text-center" ><i class="fa fa-trash text-danger" onclick="return confirm(hapus_barang('+$('#id_barang_grafis').val()+'))"></i></td></tr>');
		
		
		var newId = parseInt($('#id_barang_grafis').val()) + 1;
		$('#id_barang_grafis').val(newId);
		
		$('#form_15')[0].reset();
		$('#id_produk_indoor_outdoor').val('');
		$('#form_15').slideUp();
	}
}

function cariUkuranKertasIndoorPoster(){
	
	$.ajax({
		url: base_url+'ukuran_kertas/option_for_ukuran_kertas/',
		type:'POST',
		dataType:'html',
		data: {id_produk: $('#id_produk_indoor_outdoor').val(),id_kertas: $('#id_kertas_indoor_poster').val() },
		success: function(data){				
			$('#id_ukuran_kertas_indoor_poster').html(data);		
		}
	}) 
	
}



function tambah_data_produk_paket_banner(){
	if($("#id_kertas_paket_banner").val()==''){
		alert('Silahkan pilih Kertas Bahan !');
		
	}
	else if($("#lebar_paket_banner").val()==''){
		alert('Silahkan masukkan Lebar !');
		
	}
	else if($("#panjang_paket_banner").val()==''){
		alert('Silahkan masukkan panjang !');
		
	}
	else if($("#jml_copy_paket_banner").val()==''){
	alert('Silahkan masukkan jumlah copy ! !');
		
	}
	else{
	
		var text_kertas_paket_banner		= 	$("#id_kertas_paket_banner option:selected").text();
		var text_produk 			= 	$("#id_produk_indoor_outdoor option:selected").text();
		
		var str_lebar				=	$('#lebar_paket_banner').val();
		var lebar_tanpa_titik		=	str_lebar.replace(".", "");
		
		var str_panjang				=	$('#panjang_paket_banner').val();
		var panjang_tanpa_titik		=	str_panjang.replace(".", "");
		
		var str_copy				=	$('#jml_copy_paket_banner').val();
		var copy_tanpa_titik		=	str_copy.replace(".", "");
		
		var nama_file_paket_banner	=	$('#nama_file_pekerjaan_paket_banner').val();
		
		
		var nama_barang = text_produk+' <br>'+nama_file_paket_banner+' <br>'+text_kertas_paket_banner+'<br>Panjang : '+$('#panjang_paket_banner').val()+' cm, Lebar : '+$('#lebar_paket_banner').val()+' cm, '+$('#jml_copy_paket_banner').val()+' copy <br> Finishing : '+$('#keterangan_finishing_paket_banner').val()+' <br>'+$('#keterangan_paket_banner').val();

		$('#tabel_op_grafis').append('<tr id="tr_barang_'+$('#id_barang_grafis').val()+'">	<td> '+nama_barang+'<input type="hidden" name="ID_BARANG_PAKET_BANNER[]" value="'+$('#id_barang_grafis').val()+'"> <input type="hidden" name="nama_file_pekerjaan_paket_banner_'+$('#id_barang_grafis').val()+'" value="'+$('#nama_file_pekerjaan_paket_banner').val()+'"> <input type="hidden" name="id_produk_paket_banner_'+$('#id_barang_grafis').val()+'" value="'+$('#id_produk_indoor_outdoor').val()+'"> <input type="hidden" name="id_ukuran_kertas_paket_banner_'+$('#id_barang_grafis').val()+'" value="'+$('#id_ukuran_kertas_paket_banner').val()+'"> <input type="hidden" name="id_kertas_paket_banner_'+$('#id_barang_grafis').val()+'" value="'+$('#id_kertas_paket_banner').val()+'"> <input type="hidden" name="panjang_paket_banner_'+$('#id_barang_grafis').val()+'" value="'+panjang_tanpa_titik+'"> <input type="hidden" name="lebar_paket_banner_'+$('#id_barang_grafis').val()+'" value="'+lebar_tanpa_titik+'"> <input type="hidden" name="jml_copy_paket_banner_'+$('#id_barang_grafis').val()+'" value="'+copy_tanpa_titik+'"> <input type="hidden" name="keterangan_paket_banner_'+$('#id_barang_grafis').val()+'" value="'+$('#keterangan_paket_banner').val()+'"> <input type="hidden" name="keterangan_finishing_paket_banner_'+$('#id_barang_grafis').val()+'" value="'+$('#keterangan_finishing_paket_banner').val()+'"> </td> <td  class="text-center" ><i class="fa fa-trash text-danger" onclick="return confirm(hapus_barang('+$('#id_barang_grafis').val()+'))"></i></td></tr>');
		
		
		var newId = parseInt($('#id_barang_grafis').val()) + 1;
		$('#id_barang_grafis').val(newId);
		
		$('#form_16')[0].reset();
		$('#id_produk_indoor_outdoor').val('');
		$('#form_16').slideUp();
	}
}

function cariUkuranKertasPaketBanner(){
	
	$.ajax({
		url: base_url+'ukuran_kertas/option_for_ukuran_kertas/',
		type:'POST',
		dataType:'html',
		data: {id_produk: $('#id_produk_indoor_outdoor').val(),id_kertas: $('#id_kertas_paket_banner').val() },
		success: function(data){				
			$('#id_ukuran_kertas_paket_banner').html(data);		
		}
	}) 
	
}

//////////////////////////////////////////
// <!---------------------------------- Kasir ---->
////////////////////////////////////////


function ganti_jumlah_kasir(id,jumlah_barang,id_inputan){ 

/* 	a = $('#'+id_inputan+'_'+id).val();
	b = a.replace(/[^\d]/g,"");
	c = "";
	panjang = b.length;
	j = 0;
	for (i = panjang; i > 0; i--) {
		j = j + 1;
		if (((j % 3) == 1) && (j != 1)) {
			c = b.substr(i-1,1) + "." + c;
		} else {
			c = b.substr(i-1,1) + c;
		}
	}
	$('#'+id_inputan+'_'+id).val(c) ; */


	//alert(jumlah_barang);
	var jumlahQty	=	$('#JUMLAH_QTY_'+id).val();
	//var jumlahQty	= jumlahQty.split('.').join('');
	
	
	
	var 	hargaSatuan =	$('#HARGA_SATUAN_'+id).val();
	var hargaSatuan	=	hargaSatuan.split('.').join('')
	
	var total = jumlahQty * parseInt(hargaSatuan);	
	var total=	toRibuan(total);
	
	$('#TOTAL_HARGA_'+id).val(total);
	
	
	var JumlahBarangSemua = $('#jumlah_barang').val();
	
	var total_harga =  0 ;
	for (i = 1; i <= JumlahBarangSemua; i++) {	

		var totalHarga =	$('#TOTAL_HARGA_'+i).val();
		var totalHarga =	 totalHarga.split('.').join('');
		
	//alert(totalHarga);
		var harga = parseInt(totalHarga);	
	
		total_harga +=  harga;		
		
		//alert(total_harga);
	} 
	
	
	
	$('#harga_total').val(total_harga);
	$('#text_harga_total').html(toRp(total_harga));
	
	
	$('#TOTAL_BAYAR').val(total_harga);
	$('#total_bayar_rp').html(toRp(total_harga));
	
	hitung_discount();
	hitung_uang_customer();
	
}

function ganti_harga_kasir(id,jumlah_barang,id_inputan){ 

 	a = $('#'+id_inputan+'_'+id).val();
	b = a.replace(/[^\d]/g,"");
	c = "";
	panjang = b.length;
	j = 0;
	for (i = panjang; i > 0; i--) {
		j = j + 1;
		if (((j % 3) == 1) && (j != 1)) {
			c = b.substr(i-1,1) + "." + c;
		} else {
			c = b.substr(i-1,1) + c;
		}
	}
	$('#'+id_inputan+'_'+id).val(c) ; 


	//alert(jumlah_barang);
	var jumlahQty	=	$('#JUMLAH_QTY_'+id).val();
	//var jumlahQty	= jumlahQty.split('.').join('');
	
	
	
	var 	hargaSatuan =	$('#HARGA_SATUAN_'+id).val();
	var hargaSatuan	=	hargaSatuan.split('.').join('')
	
	var total = jumlahQty * parseInt(hargaSatuan);	
	var total=	toRibuan(total);
	
	$('#TOTAL_HARGA_'+id).val(total);
	
	
	var JumlahBarangSemua = $('#jumlah_barang').val();
	
	var total_harga =  0 ;
	for (i = 1; i <= JumlahBarangSemua; i++) {	

		var totalHarga =	$('#TOTAL_HARGA_'+i).val();
		var totalHarga =	 totalHarga.split('.').join('');
		
	//alert(totalHarga);
		var harga = parseInt(totalHarga);	
	
		total_harga +=  harga;		
		
		//alert(total_harga);
	} 
	
	
	
	$('#harga_total').val(total_harga);
	$('#text_harga_total').html(toRp(total_harga));
	
	
	$('#TOTAL_BAYAR').val(total_harga);
	$('#total_bayar_rp').html(toRp(total_harga));
	
	hitung_discount();
	hitung_uang_customer();
	
}

function hitung_discount(){
	
	a = $('#DISCOUNT').val();
	b = a.replace(/[^\d]/g,"");
	c = "";
	panjang = b.length;
	j = 0;
	for (i = panjang; i > 0; i--) {
		j = j + 1;
		if (((j % 3) == 1) && (j != 1)) {
			c = b.substr(i-1,1) + "." + c;
		} else {
			c = b.substr(i-1,1) + c;
		}
	}
	$('#DISCOUNT').val(c) ;
	
	var diskon =	$('#DISCOUNT').val();
	var diskon	=	diskon.split('.').join('')
	
	var totalBayar = parseInt($('#harga_total').val()) - parseInt(diskon);
	
	$('#TOTAL_BAYAR').val(totalBayar);
	$('#total_bayar_rp').html(toRp(totalBayar));
	
	
	hitung_uang_customer();
}


function hitung_uang_customer(){
	a = $('#uang_customer').val();
	b = a.replace(/[^\d]/g,"");
	c = "";
	panjang = b.length;
	j = 0;
	for (i = panjang; i > 0; i--) {
		j = j + 1;
		if (((j % 3) == 1) && (j != 1)) {
			c = b.substr(i-1,1) + "." + c;
		} else {
			c = b.substr(i-1,1) + c;
		}
	}
	$('#uang_customer').val(c) ;
	
	var uang	=	$('#uang_customer').val();
	var uang	= 	uang.split('.').join('');
	var uang	= 	parseInt(uang);
	var total	= 	parseInt($('#TOTAL_BAYAR').val());
	
	if(uang < total){
		var kurang =total -	uang;
	
		$('#pesan_bayar').html('Kekurangan bayar : <h4 class="text-warning">'+toRp(kurang)+'</h4>');
	}
	else{
		var lebih = 	uang - total;
		$('#pesan_bayar').html('Uang kembali : <h4 class="text-success">'+toRp(lebih)+'</h4>');
		$('#JUMLAH_KEMBALI').val(lebih);
	}
	
}




/////////////////////////////////////////////////////////////////////////
////////////////////   Produk Lain
/////////////////////////////////////////////////////////////////////////

function tambah_data_produk_lain(){

	if($("#id_produk_lain").val() == ''){
		alert('Silahkan Pilih Produk !')
	}
	else if($("#quantity_lain").val() == ''){
		alert('Silahkan inputan Quantity !')
	}
	else{
		var text_produk 			= 	$("#id_produk_lain option:selected").text();
		
		
		$('#tabel_op_grafis').append('<tr id="tr_barang_'+$('#id_barang_grafis').val()+'">	<td> '+text_produk+'<br>'+$('#keterangan_produk_lain').val()+'<input type="hidden" name="ID_BARANG_LAIN[]" value="'+$('#id_barang_grafis').val()+'"> <input type="hidden" name="id_produk_lain_'+$('#id_barang_grafis').val()+'" value="'+$('#id_produk_lain').val()+'"> <input type="hidden" name="quantity_lain_'+$('#id_barang_grafis').val()+'" value="'+$('#quantity_lain').val()+'"> <input type="hidden" name="keterangan_produk_lain_'+$('#id_barang_grafis').val()+'" value="'+$('#keterangan_produk_lain').val()+'"> </td> <td  class="text-center" ><i class="fa fa-trash text-danger" onclick="return confirm(hapus_barang('+$('#id_barang_grafis').val()+'))"></i></td></tr>');
		
		
		var newId = parseInt($('#id_barang_grafis').val()) + 1;
		$('#id_barang_grafis').val(newId);
		
		$('#form_lain')[0].reset();
	}


}



function sendLaporanOmset(){
	if($('#datepicker').val() == '' || $('#datepicker2').val() == ""){
		alert("Pastikan telah memilih Tanggal Mulai dan Akhir");
	}
	else{
			$('#loading').show();
			$('#pesan_error').show(); $('#pesan_error').html('proses create File');	
			$.ajax({
				url: base_url+'laporan_omset/create_file?',
				type:'POST',
				dataType:'json',
				data: { mulai : $('#datepicker').val() ,  akhir : $('#datepicker2').val()},	
				success: function(data){
					if(data.status){
						
						$('#loading').show();
						$('#pesan_error').show(); $('#pesan_error').html('Harap tunggu ..  proses kirim email Laporan');	
						 
						$.ajax({
							url: base_url+'laporan_omset/send_email_lap_omset/?nama_file='+data.nama_file,
							type:'POST',
							dataType:'json',
							data: { mulai : $('#datepicker').val() ,  akhir : $('#datepicker2').val() , nama_file : data.nama_file},	
							success: function(data){
								if(data.status){
									
									$('#pesan_error').html('proses kirim email berhasil.');	
									
									$('.main-footer').append('<div class="modal fade" id="container-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="false"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><h4 class="modal-title" id="myModalLabel">Pesan Pemberitahuan</h4></div><div class="modal-body">Proses kirim Laporan Counter tanggal : <b>'+$('#datepicker').val()+'</b> s/d <b>'+$('#datepicker2').val()+'</b> berhasil.</div><div class="modal-footer"><a href="#" onclick="location.reload()"><span class="btn btn-primary" >Selesai</span></a></div></div></div></div>');
									$('#container-modal').modal('show');
									
								}
								else{
									$('#loading').hide(); $('#pesan_error').show(); $('#pesan_error').html(data.pesan);					 
								}
							}
						})	
						
					}
					else{
						$('#loading').hide(); $('#pesan_error').show(); $('#pesan_error').html(data.pesan);					 
					}
				}
			})	
	}
}


function kirim_lap_kas(){
	$('#loading').show();
	$('#pesan_error').show(); $('#pesan_error').html('proses create File');	
	$.ajax({
		url: base_url+'laporan_kas/kirim_laporan_kas',
		type:'POST',
		dataType:'json',
		data: { tgl_laporan : $('#datepicker').val() },	
		success: function(data){
			if(data.status){
				
				$('#loading').show();
				$('#pesan_error').show(); $('#pesan_error').html('Harap tunggu ..  proses kirim email Laporan');	
				 
				$.ajax({
					url: base_url+'laporan_kas/send_email_lap_kas/?nama_file='+data.nama_file,
					type:'POST',
					dataType:'json',
					data: { tgl_laporan : $('#datepicker').val() },	
					success: function(data){
						if(data.status){
							
							$('#pesan_error').html('proses kirim email berhasil.');	
							
							$('.main-footer').append('<div class="modal fade" id="container-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="false"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><h4 class="modal-title" id="myModalLabel">Pesan Pemberitahuan</h4></div><div class="modal-body">Proses kirim Laporan Kas berhasil.</div><div class="modal-footer"><a href="#" onclick="location.reload()"><span class="btn btn-primary" >Selesai</span></a></div></div></div></div>');
							$('#container-modal').modal('show');
							
						}
						else{
							$('#loading').hide(); $('#pesan_error').show(); $('#pesan_error').html(data.pesan);					 
						}
					}
				})	
				
			}
			else{
				$('#loading').hide(); $('#pesan_error').show(); $('#pesan_error').html(data.pesan);					 
			}
		}
	})	
}


function tampil_pesan_cancel_barang(nama_barang,id_order,count_barang){

	
	$('.main-footer').append('<div class="modal fade" id="modal_cancel_barang" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="false"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><h4 class="modal-title" id="myModalLabel">Pesan Pemberitahuan</h4></div><div class="modal-body">Apakah anda yakin akan menghapus barang <br><b>'+nama_barang+'</b></div><div class="modal-footer"><div class="pull-left"><span data-dismiss="modal" class="btn btn-warning" >Batal</span></div><span onclick="cancel_barang('+id_order+','+count_barang+')" class="btn btn-primary" >Ya</span></div></div></div></div>');
	$('#modal_cancel_barang').modal('show');

}
function cancel_barang(id_order,count_barang){

	$.ajax({
		url: base_url+'kasir/cancel_barang/',
		type:'POST',
		dataType:'json',
		data: { 'id_order' :id_order, 'count_barang':count_barang},	
		success: function(data){
			location.reload();
		}
	})	

}



$("#HP_CUSTOMER").autocomplete({
	source:base_url+'pelanggan/pelanggan_search',
	select: function (e, ui) {
		
		
		
		if(ui.item.id_pelanggan ){
			$("#ID_CUSTOMER").val(ui.item.id_pelanggan);
			$("#NAMA_CUSTOMER").val(ui.item.nama_pelanggan);
			$("#ALAMAT_CUSTOMER").val(ui.item.alamat_pelanggan);
			$("#HP_CUSTOMER").val(ui.item.nomor_telp);
			
		}
		else{
			$('#LOG_MEMBER').val('Y');						
			$('#NAMA_CUSTOMER').prop('readonly', true);
			$('#NAMA_CUSTOMER').focus();
			$('#ALAMAT_CUSTOMER').prop('readonly', true);
		}
		
		search_member(ui.item.nomor_telp);
	}
}).autocomplete( "instance" )._renderItem = function( ul, item ) {
	
	
	
	
		if(item.id_pelanggan ){
			var inner_html = '<div class="list_item_container"><p>No Telp/HP : <strong>' + item.label + '</strong>  <br>Nama Pelanggan : '+item.nama_pelanggan+'</div>';
			
		}
		else{
			var inner_html = '<div class="list_item_container"><b>Jika pelanggan baru, silahkan klik disini</b></div>';
		}
	
	return $( "<li></li>" )
	.data( "item.autocomplete", item )
	.append(inner_html)
	.appendTo( ul );
};



function hitung_uang_kembalian_cicilan(){
	a = $('#JUMLAH_BAYAR_SEKARANG').val();
	b = a.replace(/[^\d]/g,"");
	c = "";
	panjang = b.length;
	j = 0;
	for (i = panjang; i > 0; i--) {
		j = j + 1;
		if (((j % 3) == 1) && (j != 1)) {
			c = b.substr(i-1,1) + "." + c;
		} else {
			c = b.substr(i-1,1) + c;
		}
	}
	$('#JUMLAH_BAYAR_SEKARANG').val(c) ;
	
	var uang	=	$('#JUMLAH_BAYAR_SEKARANG').val();	
	var uang	= 	uang.split('.').join('');	
	var uang	= 	parseInt(uang);
	
	var totalKekurangan = $('#KURANG_BAYAR').val();
	
	if(uang < totalKekurangan){
		
		var kurang = parseInt(totalKekurangan) -	parseInt(uang);
		$('#KELEBIHAN_CICILAN').val('0');
		$('#kelebihan_cicilan').html('Kekurangan bayar : <h4 class="text-warning">'+toRp(kurang)+'</h4>');
	}
	else{
			
		var lebih = parseInt(uang) -	parseInt(totalKekurangan);
		$('#KELEBIHAN_CICILAN').val(lebih);
		$('#kelebihan_cicilan').html('Uang kembali : <h4 class="text-success">'+toRp(lebih)+'</h4>');
	}
	
}



$('#browse_nama_file_pekerjaan_outdoor').change(function(evt) {
	var nama = $("#browse_nama_file_pekerjaan_outdoor").val();
	var newFile = nama.split(String.fromCharCode(92)).join("|")
	
	$('#nama_file_pekerjaan_outdoor').val(newFile);
	/**
	var Form = document.forms['form_5'];
	var inputName2 = document.getElementById("browse_nama_file_pekerjaan_outdoor").value;
	var inputName=inputName2.split('\\').pop();	
	var ipComputer = $("#ClienComputerName").val();
	var completeName = ipComputer+' - '+inputName;
	
	$('#nama_file_pekerjaan_outdoor').val(inputName2);
	**/
});



$("#browse_nama_file_pekerjaan_paket_banner").change(function(){
	var nama = $("#browse_nama_file_pekerjaan_paket_banner").val();
	var newFile = nama.split(String.fromCharCode(92)).join("|")
	
	$('#nama_file_pekerjaan_paket_banner').val(newFile);
})



$('#browse_nama_file_pekerjaan_indoor_poster').change(function(evt) {
	
	
	var nama = $("#browse_nama_file_pekerjaan_indoor_poster").val();
	var newFile = nama.split(String.fromCharCode(92)).join("|")
	
	$('#nama_file_pekerjaan_indoor_poster').val(newFile);
	
	
	/**
	var Form = document.forms['form_15'];
	var inputName2 = document.getElementById("browse_nama_file_pekerjaan_indoor_poster").value;
	var inputName=inputName2.split('\\').pop();	
	var ipComputer = $("#ClienComputerName").val();
	var completeName = ipComputer+' - '+inputName;
	
	$('#nama_file_pekerjaan_indoor_poster').val(inputName2);
	**/
});

$('#browse_nama_file_pekerjaan_indoor').change(function(evt) {
	
	var nama = $("#browse_nama_file_pekerjaan_indoor").val();
	var newFile = nama.split(String.fromCharCode(92)).join("|")
	
	$('#nama_file_pekerjaan_indoor').val(newFile);
	
	/**
	var Form = document.forms['form_6'];
	var inputName2 = document.getElementById("browse_nama_file_pekerjaan_indoor").value;
	var inputName=inputName2.split('\\').pop();	
	var ipComputer = $("#ClienComputerName").val();
	var completeName = ipComputer+' - '+inputName;
	
	$('#nama_file_pekerjaan_indoor').val(inputName2);
	**/
});