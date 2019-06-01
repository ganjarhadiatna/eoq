<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Barang extends Model
{
    protected $table = 'barang';

    public function scopeGetAll($query, $limit)
    {
    	return DB::table($this->table)
    	->select(
    		'barang.id',
    		'barang.nama_barang',
    		'barang.stok',
    		'barang.harga_barang',
    		'barang.biaya_pemesanan',
    		'barang.biaya_penyimpanan',
    		'barang.tanggal_kadaluarsa',
    		'supplier.nama as nama_supplier',
    		'etalase.etalase',
    		'kategori.kategori'
    	)
    	->join('supplier', 'supplier.id', '=', 'barang.idsupplier')
    	->join('kategori', 'kategori.id', '=', 'barang.idkategori')
    	->join('etalase', 'etalase.id', '=', 'barang.idetalase')
    	->orderBy('barang.id', 'desc')
    	->paginate($limit);
    }
}
