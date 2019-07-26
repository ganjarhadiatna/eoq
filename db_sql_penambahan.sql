-- lama
alter table barang add stok_pengaman int(10) unsigned not null after stok;
alter table barang add harga_jual int(10) unsigned not null after harga_barang;
alter table barang add satuan_barang varchar(150) null after tanggal_kadaluarsa;

-- baru
alter table pembelian add total_biaya int(10) unsigned not null after diskon;
alter table barang add ukuran_barang double unsigned not null after satuan_barang;
alter table etalase add ukuran_etalase double unsigned not null after etalase;