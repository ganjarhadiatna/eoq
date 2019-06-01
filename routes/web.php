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
    Route::post('/barang/push', 'BarangController@push')->name('barang-push');
    Route::post('/barang/put', 'BarangController@put')->name('barang-put');
    Route::post('/barang/remove', 'BarangController@remove')->name('barang-remove');

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

    // orders
    Route::get('/pesanan', 'PemesananController@index')->name('pesanan');
    Route::get('/pesanan/tambah', 'PemesananController@tambah')->name('pesanan-tambah');
    Route::get('/pesanan/edit/{idtransactions}', 'PemesananController@edit')->name('pesanan-edit');

    // crud
    Route::get('/pesanan/eoq/{idbarang}', 'PemesananController@generate_eoq')->name('pesanan-eoq');
    Route::get('/pesanan/backorder/{idbarang}/{biaya_backorder}', 'PemesananController@generate_backorder')->name('pesanan-backorder');

    Route::post('/pesanan/push', 'PemesananController@push')->name('pesanan-push');

    Route::post('/pesanan/remove', 'PemesananController@remove')->name('pesanan-remove');

    // 
    Route::post('/pesanan/create', 'PemesananController@create')->name('pesanan-create');

});