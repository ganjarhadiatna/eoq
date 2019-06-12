<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Penjualan extends Model
{
    protected $table = 'penjualan';

    public function scopeGetAll($query, $limit)
    {
    	return DB::table($this->table)
    	->select(
    		'penjualan.id',
    		'penjualan.kode_transaksi',
    		'penjualan.jumlah_barang',
    		'penjualan.harga_barang',
    		'penjualan.total_biaya',
    		'penjualan.satuan',
    		'penjualan.tanggal_penjualan',
    		'barang.nama_barang'
    	)
    	->join('barang', 'barang.id', '=', 'penjualan.idbarang')
    	->orderBy('penjualan.id', 'desc')
    	->paginate($limit);
    }
}
