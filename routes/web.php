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

    // kategori
    Route::get('/kategori', 'KategoriController@index')->name('kategori');
    Route::get('/kategori/tambah', 'KategoriController@tambah')->name('kategori-tambah');
    Route::get('/kategori/edit/{idcategories}', 'KategoriController@edit')->name('kategori-edit');
    
    // crud
    Route::post('/kategori/push', 'KategoriController@push')->name('kategori-push');
    Route::post('/kategori/put', 'KategoriController@put')->name('kategori-put');
    Route::post('/kategori/remove', 'KategoriController@remove')->name('kategori-remove');

    // etalase
    Route::get('/etalase', 'EtalaseController@index')->name('etalase');
    Route::get('/etalase/tambah', 'EtalaseController@tambah')->name('etalase-tambah');
    Route::get('/etalase/edit/{idetalase}', 'EtalaseController@edit')->name('etalase-edit');
    
    // crud
    Route::post('/etalase/push', 'EtalaseController@push')->name('etalase-push');
    Route::post('/etalase/put', 'EtalaseController@put')->name('etalase-put');
    Route::post('/etalase/remove', 'EtalaseController@remove')->name('etalase-remove');

    // barang
    Route::get('/barang', 'BarangController@index')->name('barang');
    Route::get('/barang/tambah', 'BarangController@tambah')->name('barang-tambah');
    Route::get('/barang/edit/{iditems}', 'BarangController@edit')->name('barang-edit');
    
    // crud
    Route::post('/barang/push', 'BarangController@push')->name('barang-push');
    Route::post('/barang/put', 'BarangController@put')->name('barang-put');
    Route::post('/barang/remove', 'BarangController@remove')->name('barang-remove');

    // supplier
    Route::get('/supplier', 'SupplierController@index')->name('supplier');

    // pembelian
    Route::get('/pembelian', 'PembelianController@index')->name('pembelian');

    // penjualan
    Route::get('/penjualan', 'PenjualanController@index')->name('penjualan');
});