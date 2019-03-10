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

    // etalase
    Route::get('/etalase', 'EtalaseController@index')->name('etalase');

    // barang
    Route::get('/barang', 'BarangController@index')->name('barang');

    // supplier
    Route::get('/supplier', 'SupplierController@index')->name('supplier');

    // pembelian
    Route::get('/pembelian', 'PembelianController@index')->name('pembelian');

    // penjualan
    Route::get('/penjualan', 'PenjualanController@index')->name('penjualan');
});