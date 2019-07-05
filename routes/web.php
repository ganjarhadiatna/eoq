<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::middleware('auth')->group(function() {
    // home
    Route::get('/', 'HomeController@index')->name('home');

    // user
    Route::get('/profile', 'HomeController@profile')->name('profile');

    // kategori
    Route::get('/kategori', 'KategoriController@index')->name('kategori');
    Route::get('/kategori/tambah', 'KategoriController@tambah')->name('kategori-tambah');
    Route::get('/kategori/edit/{idcategories}', 'KategoriController@edit')->name('kategori-edit');
    
    // crud
    Route::get('/kategori/byid/{idkategori}', 'KategoriController@byid')->name('kategori_byid');
    Route::post('/kategori/push', 'KategoriController@push')->name('kategori-push');
    Route::post('/kategori/put', 'KategoriController@put')->name('kategori-put');
    Route::post('/kategori/remove', 'KategoriController@remove')->name('kategori-remove');

    // etalase
    Route::get('/etalase', 'EtalaseController@index')->name('etalase');
    Route::get('/etalase/tambah', 'EtalaseController@tambah')->name('etalase-tambah');
    Route::get('/etalase/edit/{idetalase}', 'EtalaseController@edit')->name('etalase-edit');
    
    // crud
    Route::get('/etalase/byid/{idkategori}', 'EtalaseController@byid')->name('etalase_byid');
    Route::post('/etalase/push', 'EtalaseController@push')->name('etalase-push');
    Route::post('/etalase/put', 'EtalaseController@put')->name('etalase-put');
    Route::post('/etalase/remove', 'EtalaseController@remove')->name('etalase-remove');

    // barang
    Route::get('/barang', 'BarangController@index')->name('barang');
    Route::get('/barang/tambah', 'BarangController@tambah')->name('barang-tambah');
    Route::get('/barang/edit/{iditems}', 'BarangController@edit')->name('barang-edit');
    
    // crud
    Route::get('/barang/byid/{idbarang}', 'BarangController@byid')->name('barang_byid');
    Route::get('/barang/price_item/{idiems}', 'BarangController@price_item')->name('barang-price-item');
    Route::get('/barang/bysupplier/{idsupplier}', 'BarangController@bysupplier')->name('barang_bysupplier');
    Route::post('/barang/push', 'BarangController@push')->name('barang-push');
    Route::post('/barang/put', 'BarangController@put')->name('barang-put');
    Route::post('/barang/remove', 'BarangController@remove')->name('barang-remove');

    // dikson
    Route::get('/barang/{idbarang}/diskon', 'DiskonController@index')->name('diskon');

    // crud
    Route::get('/diskon/byid/{iddiskon}', 'DiskonController@byid')->name('diskon_byid');
    Route::get('/diskon/price_item/{idiems}', 'DiskonController@price_item')->name('diskon-price-item');
    Route::post('/diskon/push', 'DiskonController@push')->name('diskon-push');
    Route::post('/diskon/put', 'DiskonController@put')->name('diskon-put');
    Route::post('/diskon/remove', 'DiskonController@remove')->name('diskon-remove');

    // supplier
    Route::get('/supplier', 'SupplierController@index')->name('supplier');
    Route::get('/supplier/byid/{idsuppliers}', 'SupplierController@byid')->name('supplier_byid');
    Route::get('/supplier/tambah', 'SupplierController@tambah')->name('supplier-tambah');
    Route::get('/supplier/edit/{idsuppliers}', 'SupplierController@edit')->name('supplier-edit');
    
    // crud
    Route::post('/supplier/push', 'SupplierController@push')->name('supplier-push');
    Route::post('/supplier/put', 'SupplierController@put')->name('supplier-put');
    Route::post('/supplier/remove', 'SupplierController@remove')->name('supplier-remove');

    // pembelian
    Route::get('/pembelian', 'PembelianController@index')->name('pembelian');
    Route::get('/pembelian/tambah', 'PembelianController@tambah')->name('pembelian-tambah');
    Route::get('/pembelian/edit/{idbuying}', 'PembelianController@edit')->name('pembelian-edit');
    
    // crud
    Route::post('/pembelian/push', 'PembelianController@push')->name('pembelian-push');
    Route::post('/pembelian/put', 'PembelianController@put')->name('pembelian-put');
    Route::post('/pembelian/remove', 'PembelianController@remove')->name('pembelian-remove');
    Route::post('/pembelian/done', 'PembelianController@done')->name('pembelian-done');

    // penjualan
    Route::get('/penjualan', 'PenjualanController@index')->name('penjualan');
    Route::get('/penjualan/tambah', 'PenjualanController@tambah')->name('penjualan-tambah');
    Route::get('/penjualan/edit/{idtransactions}', 'PenjualanController@edit')->name('penjualan-edit');
    
    // crud
    Route::post('/penjualan/push', 'PenjualanController@push')->name('penjualan-push');
    Route::post('/penjualan/put', 'PenjualanController@put')->name('penjualan-put');
    Route::post('/penjualan/remove', 'PenjualanController@remove')->name('penjualan-remove');


    // single item
    // orders
    Route::get('/pesanan', 'PemesananSingleitemController@index')->name('pesanan-singleitem');
    Route::get('/pesanan/tambah', 'PemesananSingleitemController@tambah')->name('pesanan-singleitem-tambah');
    Route::get('/pesanan/edit/{idtransactions}', 'PemesananSingleitemController@edit')->name('pesanan-singleitem-edit');

    // crud
    Route::get('/pesanan/eoq/{idbarang}', 'PemesananSingleitemController@generate_eoq')->name('pesanan-singleitem-eoq');
    Route::get('/pesanan/backorder/{idbarang}/{biaya_backorder}', 'PemesananSingleitemController@generate_backorder')->name('pesanan-singleitem-backorder');
    Route::get('/pesanan/special_price/{idbarang}/{price}', 'PemesananSingleitemController@special_price')->name('pesanan-singleitemspecial-price');
    Route::get('/pesanan/increases_price/{idbarang}/{price}', 'PemesananSingleitemController@increases_price')->name('pesanan-singleitemincreases-price');

    Route::post('/pesanan/push', 'PemesananSingleitemController@push')->name('pesanan-singleitem-push');
    Route::post('/pesanan/remove', 'PemesananSingleitemController@remove')->name('pesanan-singleitem-remove');
    Route::post('/pesanan/create', 'PemesananSingleitemController@create')->name('pesanan-singleitem-create');


    // multi item
    Route::get('/pesanan/multiitem', 'PemesananMultiitemController@index')->name('pesanan-multiitem');
    Route::get('/pesanan/multiitem/{idsupplier}/daftar-barang/', 'PemesananMultiitemController@daftarBarang')->name('pesanan-multiitem-daftar');
    Route::get('/pesanan/multiitem/tambah', 'PemesananMultiitemController@tambah')->name('pesanan-multiitem-tambah');
    Route::get('/pesanan/multiitem/edit/{idtransactions}', 'PemesananMultiitemController@edit')->name('pesanan-multiitem-edit');

    Route::post('/pesanan/multiitem/push', 'PemesananMultiitemController@push')->name('pesanan-multiitem-push');
    Route::post('/pesanan/multiitem/remove', 'PemesananMultiitemController@remove')->name('pesanan-multiitem-remove');
    Route::post('/pesanan/multiitem/create', 'PemesananMultiitemController@create')->name('pesanan-multiitem-create');

    // crud
    Route::get('/pesanan/multiitem/eoq', 'PemesananMultiitemController@generate_eoq')->name('pesanan-multiitem-eoq');
    Route::get('/pesanan/multiitem/bo', 'PemesananMultiitemController@generate_bo')->name('pesanan-multiitem-bo');

});