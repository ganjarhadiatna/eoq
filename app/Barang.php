<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Barang extends Model
{
    protected $table = 'barang';

    public function scopeGetIdsupplier($query, $id)
    {
        return DB::table($this->table)
        ->where('id', $id)
        ->value('idsupplier');
    }

    public function scopeGetBiayaPemesanan($query, $id)
    {
        return DB::table($this->table)
        ->where('id', $id)
        ->value('biaya_pemesanan');
    }

    public function scopeGetHargaBarang($query, $id)
    {
        return DB::table($this->table)
        ->where('id', $id)
        ->value('harga_barang');
    }

    public function scopeGetBiayaPenyimpanan($query, $id)
    {
        return DB::table($this->table)
        ->where('id', $id)
        ->value('biaya_penyimpanan');
    }

    public function scopeGetAll($query, $limit)
    {
    	return DB::table($this->table)
    	->select(
    		'barang.id',
    		'barang.nama_barang',
    		'barang.stok',
    		'barang.harga_barang',
    		'barang.biaya_penyimpanan',
    		'barang.tanggal_kadaluarsa',
    		'supplier.nama as nama_supplier',
    		'etalase.etalase',
    		'kategori.kategori',
            DB::raw('(select count(id) from diskons where idbarang=barang.id) as jumlah_diskon'),
            DB::raw('(select id from pembelian where idbarang=barang.id) as status_pembelian'),
            DB::raw('(select id from pemesanan where idbarang=barang.id) as status_pemesanan')
    	)
    	->join('supplier', 'supplier.id', '=', 'barang.idsupplier')
    	->join('kategori', 'kategori.id', '=', 'barang.idkategori')
    	->join('etalase', 'etalase.id', '=', 'barang.idetalase')
    	->orderBy('barang.id', 'desc')
    	->paginate($limit);
    }

    public function scopeGetAllBySupplier($query, $idsupplier)
    {
        return DB::table($this->table)
        ->select(
            'barang.id',
            'barang.nama_barang',
            'barang.stok',
            'barang.harga_barang',
            'barang.biaya_penyimpanan',
            'barang.tanggal_kadaluarsa',
            'supplier.nama as nama_supplier',
            'etalase.etalase',
            'kategori.kategori',
            DB::raw('(select count(id) from diskons where idbarang=barang.id) as jumlah_diskon'),
            DB::raw('(select id from pembelian where idbarang=barang.id) as status_pembelian'),
            DB::raw('(select id from pemesanan where idbarang=barang.id) as status_pemesanan')
        )
        ->join('supplier', 'supplier.id', '=', 'barang.idsupplier')
        ->join('kategori', 'kategori.id', '=', 'barang.idkategori')
        ->join('etalase', 'etalase.id', '=', 'barang.idetalase')
        ->where('barang.idsupplier', $idsupplier)
        ->orderBy('barang.id', 'desc')
        ->get();
    }
}
