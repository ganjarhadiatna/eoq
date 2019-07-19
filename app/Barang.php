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

    public function scopeGetAllWithoutLimit($query)
    {
        return DB::table($this->table)
        ->select(
            'barang.id as idbarang',
            'barang.nama_barang',
            'barang.satuan_barang',
            'barang.stok',
            'barang.stok_pengaman',
            'barang.harga_barang',
            'barang.harga_jual',
            'barang.biaya_penyimpanan',
            'barang.tanggal_kadaluarsa',
            'barang.idusers',
            'barang.idsupplier',
            'supplier.nama as nama_supplier',
            'supplier.leadtime',
            'supplier.waktu_operasional',
            'supplier.biaya_pemesanan',
            'etalase.etalase',
            'kategori.kategori',
            DB::raw('(select count(id) from diskons where idbarang=barang.id) as jumlah_diskon')
        )
        ->join('supplier', 'supplier.id', '=', 'barang.idsupplier')
        ->join('kategori', 'kategori.id', '=', 'barang.idkategori')
        ->join('etalase', 'etalase.id', '=', 'barang.idetalase')
        ->orderBy('barang.id', 'desc')
        ->get();
    }

    public function scopeGetAll($query, $limit)
    {
    	return DB::table($this->table)
    	->select(
    		'barang.id',
    		'barang.nama_barang',
            'barang.satuan_barang',
    		'barang.stok',
            'barang.stok_pengaman',
    		'barang.harga_barang',
            'barang.harga_jual',
    		'barang.biaya_penyimpanan',
    		'barang.tanggal_kadaluarsa',
    		'supplier.nama as nama_supplier',
    		'etalase.etalase',
    		'kategori.kategori',
            DB::raw('(select count(id) from diskons where idbarang=barang.id) as jumlah_diskon')
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
            'barang.satuan_barang',
            'barang.stok',
            'barang.stok_pengaman',
            'barang.harga_barang',
            'barang.harga_jual',
            'barang.biaya_penyimpanan',
            'barang.tanggal_kadaluarsa',
            'supplier.nama as nama_supplier',
            'etalase.etalase',
            'kategori.kategori',
            DB::raw('(select count(id) from diskons where idbarang=barang.id) as jumlah_diskon')
        )
        ->join('supplier', 'supplier.id', '=', 'barang.idsupplier')
        ->join('kategori', 'kategori.id', '=', 'barang.idkategori')
        ->join('etalase', 'etalase.id', '=', 'barang.idetalase')
        ->where('barang.idsupplier', $idsupplier)
        ->orderBy('barang.id', 'desc')
        ->get();
    }
}
