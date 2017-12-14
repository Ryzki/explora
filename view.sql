create or replace view v_barang_order
AS

 select 
	b.no_wo,
	b.tgl_order,
	b.no_order_lain,
	date_format(b.tgl_order,'%d-%m-%Y' )  as tgl_order_indo,
	`a`.`COUNT_BARANG` AS `COUNT_BARANG`,
	`a`.`ID_ORDER` AS `ID_ORDER`,
	`a`.`ID_PRODUK` AS `ID_PRODUK`,
	`a`.`ID_KERTAS` AS `ID_KERTAS`,
	`a`.`ID_UKURAN_KERTAS` AS `ID_UKURAN_KERTAS`,
	`a`.`JUMLAH_QTY` AS `JUMLAH_QTY`,
	`a`.`HARGA_SATUAN` AS `HARGA_SATUAN`,
	`a`.`TOTAL_HARGA` AS `TOTAL_HARGA`,
	`a`.`NAMA_FILE_PEKERJAAN` AS `NAMA_FILE_PEKERJAAN`,
	`a`.`KETERANGAN` AS `KETERANGAN`,
	`a`.`KETERANGAN_FINISHING` AS `KETERANGAN_FINISHING`,
	`a`.`PAGE_IMG` AS `PAGE_IMG`,
	`a`.`JML_SISI` AS `JML_SISI`,
	`a`.`JML_COPY` AS `JML_COPY`,
	`a`.`JML_KLIK` AS `JML_KLIK`,
	`a`.`UP` AS `UP`,
	`a`.`PAGE_ON_SITE_SIDE` AS `PAGE_ON_SITE_SIDE`,
	`a`.`PANJANG` AS `PANJANG`,
	`a`.`LEBAR` AS `LEBAR`,
	c.nama_produk as NAMA_PRODUK,
	c.id_profil as ID_PROFIL,

	(select `c`.`NAMA_KERTAS` from `m_kertas` `c` where (`a`.`ID_KERTAS` = `c`.`ID_KERTAS`)) AS `NAMA_KERTAS`,
	(select `d`.`UKURAN_KERTAS` from `m_ukuran_kertas` `d` where (`a`.`ID_UKURAN_KERTAS` = `d`.`ID_UKURAN_KERTAS`)) AS `UKURAN_KERTAS` 
from `t_barang_order` `a`,t_order b ,m_produk c

where
	
	a.id_order=b.id_order and
	a.id_produk = c.id_produk
	
    and a.ID_KARYAWAN_CANCEL = 0
	;
	
create or replace view v_barang_order_cancel
AS

 select 
	b.no_wo,
	b.tgl_order,
	b.no_order_lain,
	date_format(b.tgl_order,'%d-%m-%Y' )  as tgl_order_indo,
	`a`.`COUNT_BARANG` AS `COUNT_BARANG`,
	`a`.`ID_ORDER` AS `ID_ORDER`,
	`a`.`ID_PRODUK` AS `ID_PRODUK`,
	`a`.`ID_KERTAS` AS `ID_KERTAS`,
	`a`.`ID_UKURAN_KERTAS` AS `ID_UKURAN_KERTAS`,
	`a`.`JUMLAH_QTY` AS `JUMLAH_QTY`,
	`a`.`HARGA_SATUAN` AS `HARGA_SATUAN`,
	`a`.`TOTAL_HARGA` AS `TOTAL_HARGA`,
	`a`.`NAMA_FILE_PEKERJAAN` AS `NAMA_FILE_PEKERJAAN`,
	`a`.`KETERANGAN` AS `KETERANGAN`,
	`a`.`KETERANGAN_FINISHING` AS `KETERANGAN_FINISHING`,
	`a`.`PAGE_IMG` AS `PAGE_IMG`,
	`a`.`JML_SISI` AS `JML_SISI`,
	`a`.`JML_COPY` AS `JML_COPY`,
	`a`.`JML_KLIK` AS `JML_KLIK`,
	`a`.`UP` AS `UP`,
	`a`.`PAGE_ON_SITE_SIDE` AS `PAGE_ON_SITE_SIDE`,
	`a`.`PANJANG` AS `PANJANG`,
	`a`.`LEBAR` AS `LEBAR`,
	a.ID_KARYAWAN_CANCEL,
	a.STATUS_BAYAR_CANCEL,
	date_format(a.TGL_CANCEL,'%d-%m-%Y' )  as TGL_CANCEL_INDO,
	date_format(a.TGL_CANCEL,'%H:%i:%s')  as JAM_CANCEL_INDO,
	a.TGL_CANCEL,
	(select `b`.`nama_produk` from `m_produk` `b` where (`a`.`ID_PRODUK` = `b`.`id_produk`)) AS `NAMA_PRODUK`,
	(select `c`.`NAMA_KERTAS` from `m_kertas` `c` where (`a`.`ID_KERTAS` = `c`.`ID_KERTAS`)) AS `NAMA_KERTAS`,
	(select `d`.`UKURAN_KERTAS` from `m_ukuran_kertas` `d` where (`a`.`ID_UKURAN_KERTAS` = `d`.`ID_UKURAN_KERTAS`)) AS `UKURAN_KERTAS` 
from `t_barang_order` `a`,t_order b 

where
	
	a.id_order=b.id_order
	
    and a.ID_KARYAWAN_CANCEL != 0
	;	
	
 create or replace 
 VIEW `v_harga_kertas`  AS 
 select 
	`b`.`nama_produk` AS `nama_produk`,
	`b`.`id_produk` AS `id_produk`,
	`c`.`NAMA_KERTAS` AS `nama_kertas`,
	`c`.`ID_KERTAS` AS `id_kertas`,
	`d`.`UKURAN_KERTAS` AS `ukuran_kertas`,
	`d`.`ID_UKURAN_KERTAS` AS `id_ukuran_kertas`,
	`a`.`MINIMAL` AS `minimal`,
	`a`.`MAXIMAL` AS `maximal`,
	`a`.`HARGA_SATU_SISI` AS `harga_satu_sisi`,
	`a`.`HARGA_DUA_SISI` AS `harga_dua_sisi`,
	`a`.`HARGA_SATU_SISI_member` AS `harga_satu_sisi_member`,
	`a`.`HARGA_DUA_SISI_member` AS `harga_dua_sisi_member`,
	`a`.`ID_T_HARGA_BARANG` AS `id_t_harga_barang`,
	`b`.`kategori` AS `kategori` from (((`t_harga_kertas` `a` join `m_produk` `b`) join `m_kertas` `c`) join `m_ukuran_kertas` `d`) 
	
where 
	((`c`.`ID_KERTAS` = `a`.`ID_KERTAS`) and (`a`.`ID_UKURAN_KERTAS` = `d`.`ID_UKURAN_KERTAS`) and (`a`.`ID_PRODUK` = `b`.`id_produk`)) ;
	
	
	
	
 create or replace  view v_member_aktif  as SELECT a.id_pelanggan,a.nomor_telp,a.nama_pelanggan,a.alamat,date_format(a.tgl_mulai_member,'%d-%m-%Y') as tgl_mulai_member,date_format(a.tgl_akhir_member,'%d-%m-%Y') as tgl_akhir_member from master_pelanggan a  where now() >= a.tgl_mulai_member and now() <= a.tgl_akhir_member;

 create or replace view v_bayar as 
SELECT
	t_bayar_order.ID_T_BAYAR_ORDER,
	t_bayar_order.ID_KARYAWAN,
	t_bayar_order.ID_ORDER,
	t_bayar_order.JENIS_BAYAR,
	t_bayar_order.JUMLAH_BAYAR,
	 t_bayar_order.JUMLAH_KEMBALI ,
	t_bayar_order.JUMLAH_BAYAR -   t_bayar_order.JUMLAH_KEMBALI   as JUMLAH_KAS,
	
	t_bayar_order.TGL_BAYAR,
	date_format(t_bayar_order.TGL_BAYAR,'%d-%m-%Y %H:%i:%s') as TGL_BAYAR_INDO,
	date_format(t_bayar_order.TGL_BAYAR,'%H:%i:%s') as JAM_BAYAR_INDO,
	
	t_order.NO_WO,
	
	master_pelanggan.NAMA_PELANGGAN,
	
		
	m_karyawan.NAMA_KARYAWAN

FROM 
	t_bayar_order,m_karyawan,t_order,master_pelanggan
WHERE 
	t_bayar_order.ID_KARYAWAN=m_karyawan.ID_KARYAWAN and 
	t_bayar_order.ID_ORDER=t_order.ID_ORDER   and
	t_order.id_karyawan=master_pelanggan.id_pelanggan
;
 
 
 create or replace  view v_order as  SELECT
	t_order.ID_ORDER,
    t_order.ID_CUSTOMER,
    t_order.ID_KARYAWAN,
    t_order.TGL_ORDER,
    date_format(t_order.TGL_ORDER,'%d-%m-%Y') as TGL_ORDER_INDO,
    date_format(t_order.TGL_ORDER,'%H:%i:%s') as JAM_ORDER_INDO,
    t_order.DISCOUNT,
    t_order.TOTAL_BAYAR,
    t_order.NO_ORDER_LAIN,
    t_order.NO_ORDER,
    t_order.LINE,
    t_order.NO_WO,
    t_order.LOG_MEMBER,
    t_order.STATUS_BAYAR,
    t_order.TUJUAN_ORDER,
    t_order.POSISI_ORDER,
	(select sum(v_bayar.JUMLAH_KAS) from v_bayar where v_bayar.id_order=t_order.id_order) as JUMLAH_BAYAR,
    
   master_pelanggan.NOMOR_TELP,
   master_pelanggan.NAMA_PELANGGAN,
    m_karyawan.NAMA_KARYAWAN
from	
	t_order ,master_pelanggan,m_karyawan

WHERE
	t_order.ID_CUSTOMER=master_pelanggan.id_pelanggan AND
    t_order.ID_KARYAWAN=m_karyawan.ID_KARYAWAN;
    





		 
		 	
		 	
create or replace view v_barang_order_all as SELECT 
	t_barang_order.*,
    t_order.TGL_ORDER,
    t_order.ID_CUSTOMER,
    t_order.NO_ORDER,
    t_order.ID_KARYAWAN as ID_KARYAWAN_CS,
    t_order.LINE,
	t_order.NO_WO,
	t_order.STATUS_BAYAR,
    m_karyawan.NAMA_KARYAWAN,
    master_pelanggan.nomor_telp,
    master_pelanggan.nama_pelanggan,
	m_produk.KATEGORI as KATEGORI_PRODUK,
	(select `b`.`nama_produk` from `m_produk` `b` where (`t_barang_order`.`ID_PRODUK` = `b`.`id_produk`)) AS `NAMA_PRODUK`,
	(select `c`.`NAMA_KERTAS` from `m_kertas` `c` where (`t_barang_order`.`ID_KERTAS` = `c`.`ID_KERTAS`)) AS `NAMA_KERTAS`,
	(select `d`.`UKURAN_KERTAS` from `m_ukuran_kertas` `d` where (`t_barang_order`.`ID_UKURAN_KERTAS` = `d`.`ID_UKURAN_KERTAS`)) AS `UKURAN_KERTAS` 
FROM 
	t_barang_order,t_order,m_karyawan,master_pelanggan,m_produk
WHERE
	t_barang_order.ID_ORDER=t_order.ID_ORDER AND
    t_order.ID_CUSTOMER=master_pelanggan.id_pelanggan AND
    t_order.ID_KARYAWAN=m_karyawan.ID_KARYAWAN and
	t_barang_order.id_produk = m_produk.id_produk ;


	
create or replace view v_barang_order_complete as SELECT 
	t_barang_order.*,
 CAST( t_barang_order.PAGE_IMG / t_barang_order.JML_SISI AS SIGNED ) as JUMLAH_BOX ,
    t_order.TGL_ORDER,
    t_order.ID_CUSTOMER,
    t_order.NO_ORDER,
    t_order.ID_KARYAWAN as ID_KARYAWAN_CS,
    t_order.LINE,
	t_order.NO_WO,
	t_order.STATUS_BAYAR,
    m_karyawan.NAMA_KARYAWAN,
    master_pelanggan.nomor_telp,
    master_pelanggan.nama_pelanggan,
	m_produk.KATEGORI as KATEGORI_PRODUK,
	(select `b`.`nama_produk` from `m_produk` `b` where (`t_barang_order`.`ID_PRODUK` = `b`.`id_produk`)) AS `NAMA_PRODUK`,
	(select `c`.`NAMA_KERTAS` from `m_kertas` `c` where (`t_barang_order`.`ID_KERTAS` = `c`.`ID_KERTAS`)) AS `NAMA_KERTAS`,
	(select `d`.`UKURAN_KERTAS` from `m_ukuran_kertas` `d` where (`t_barang_order`.`ID_UKURAN_KERTAS` = `d`.`ID_UKURAN_KERTAS`)) AS `UKURAN_KERTAS` 
FROM 
	t_barang_order,t_order,m_karyawan,master_pelanggan,m_produk
WHERE
	t_barang_order.ID_ORDER=t_order.ID_ORDER AND
    t_order.ID_CUSTOMER=master_pelanggan.id_pelanggan AND
    t_barang_order.ID_KARYAWAN=m_karyawan.ID_KARYAWAN and
	t_barang_order.id_produk = m_produk.id_produk and
	     t_barang_order.ID_KARYAWAN_CANCEL = 0;
		 
		 
create or replace view v_lap_klik_per_wo as 
SELECT
	t_order.*,
	(select sum(JML_KLIK) from t_barang_order,m_produk where m_produk.id_produk=t_barang_order.id_produk and t_barang_order.id_order=t_order.id_order and m_produk.kategori='1') as JUMLAH_KLIK,
	(select sum(TOTAL_HARGA) from t_barang_order,m_produk where m_produk.id_produk=t_barang_order.id_produk and t_barang_order.id_order=t_order.id_order and m_produk.kategori='1' and t_barang_order.jml_klik > 0 ) as TOTAL_HARGA
FROM 
	t_order ;
	
	
create or replace view v_karyawan_ambil_order as 
select 
	t_order.ID_ORDER,t_order.TGL_ORDER,t_order.ID_CUSTOMER,t_order.TOTAL_BAYAR,
    (select t_log_order.ID_KARYAWAN from t_log_order where t_log_order.KE='KASIR' and t_order.ID_ORDER=t_log_order.ID_ORDER  and t_log_order.dari in ('OP-PRINT','FINISH-DESIGN') ) as ID_KARYAWAN,
    (select m_karyawan.NAMA_KARYAWAN from t_log_order,m_karyawan where t_log_order.KE='KASIR' and t_log_order.dari in ('OP-PRINT','FINISH-DESIGN')  and t_order.ID_ORDER=t_log_order.ID_ORDER and m_karyawan.ID_KARYAWAN=t_log_order.ID_KARYAWAN) as NAMA_KARYAWAN
FROM
	t_order;
	
create or replace view v_tutup_kas as 
select 
	t_tutup_kas.ID_TUTUP_KAS,
	t_tutup_kas.ID_KARYAWAN,
	t_tutup_kas.SHIFT,
	t_tutup_kas.KETERANGAN,
	t_tutup_kas.ID_T_BAYAR_ORDER_MULAI,
	t_tutup_kas.ID_T_BAYAR_ORDER_AKHIR,
	
	date_format(t_tutup_kas.TGL_TUTUP_KAS, '%d-%m-%Y %H:%i') as TGL_TUTUP_KAS,
	
	m_karyawan.NAMA_KARYAWAN,
	
	t_bayar_order.ID_ORDER,
	t_bayar_order.JENIS_BAYAR,
	t_bayar_order.JUMLAH_BAYAR,
	t_bayar_order.JUMLAH_KEMBALI,
	date_format(t_bayar_order.	TGL_BAYAR, '%d-%m-%Y %H:%i') as 	TGL_BAYAR
from	
	t_tutup_kas,
	m_karyawan,
	t_bayar_order
where
	t_tutup_kas.id_karyawan=m_karyawan.id_karyawan  and 
	t_tutup_kas.ID_T_BAYAR_ORDER_AKHIR=t_bayar_order.ID_T_BAYAR_ORDER  and
	t_tutup_kas.TGL_TUTUP_KAS BETWEEN  (SELECT DATE_ADD(NOW(), INTERVAL -3 DAY)) AND (SELECT now())
order by 
	t_tutup_kas.ID_TUTUP_KAS desc;
	

	