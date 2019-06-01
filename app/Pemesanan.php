<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pemesanan extends Model
{
    protected $table = 'pemesanan';

    public function scopeGetAll($query, $limit)
    {
        return DB::table($this->table)
        ->select(
            'pemesanan.id',
            'pemesanan.jumlah_unit',
            'pemesanan.total_cost',
            'pemesanan.reorder_point',
            'pemesanan.frekuensi_pembelian',
            'barang.id as id_barang',
            'barang.nama_barang',
            'barang.idsupplier',
            'barang.harga_barang',
            'barang.biaya_penyimpanan',
            'barang.biaya_pemesanan',
            'supplier.nama as nama_supplier'
        )
        ->join('barang', 'barang.id', '=', 'pemesanan.idbarang')
        ->join('supplier', 'supplier.id', '=', 'barang.id')
        ->orderBy('pemesanan.id', 'desc')
        ->paginate($limit);
    }

    public function scopeByID($query, $id)
    {
    	return DB::table($this->table)
    	->select(
    		'pemesanan.id',
    		'pemesanan.jumlah_unit',
    		'pemesanan.total_cost',
    		'pemesanan.reorder_point',
    		'pemesanan.frekuensi_pembelian',
    		'barang.id as id_barang',
    		'barang.idsupplier',
    		'barang.harga_barang',
    		'barang.biaya_penyimpanan',
    		'barang.biaya_pemesanan'
    	)
    	->join('barang', 'barang.id', '=', 'pemesanan.idbarang')
    	->where('pemesanan.id', $id)
    	->get();
    }
}
