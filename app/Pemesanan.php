<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pemesanan extends Model
{
    protected $table = 'pemesanan';

    public function scopeGetAllSingleItem($query, $limit)
    {
        return DB::table($this->table)
        ->select(
            'pemesanan.id',
            'pemesanan.harga_barang',
            'pemesanan.jumlah_unit',
            'pemesanan.total_cost',
            'pemesanan.reorder_point',
            'pemesanan.frekuensi_pembelian',
            'barang.id as id_barang',
            'barang.nama_barang',
            'barang.satuan_barang',
            'barang.idsupplier',
            'barang.biaya_penyimpanan',
            'supplier.biaya_pemesanan',
            'supplier.nama as nama_supplier'
        )
        ->leftJoin('barang', 'barang.id', '=', 'pemesanan.idbarang')
        ->leftJoin('supplier', 'supplier.id', '=', 'pemesanan.idsupplier')
        ->orderBy('pemesanan.id', 'desc')
        ->paginate($limit);
    }

    public function scopeGetAllMultiItemByIdsupplier($query, $limit, $idsupplier)
    {
        return DB::table($this->table)
        ->select(
            'pemesanan.id',
            'pemesanan.harga_barang',
            'pemesanan.jumlah_unit',
            'pemesanan.total_cost',
            'pemesanan.reorder_point',
            'pemesanan.frekuensi_pembelian',
            'pemesanan.total_cost_multiitem',
            'pemesanan.tipe',
            'barang.id as id_barang',
            'barang.nama_barang',
            'barang.satuan_barang',
            'barang.idsupplier',
            'barang.biaya_penyimpanan',
            'supplier.biaya_pemesanan',
            'supplier.id as id_supplier',
            'supplier.nama as nama_supplier'
        )
        ->leftJoin('barang', 'barang.id', '=', 'pemesanan.idbarang')
        ->leftJoin('supplier', 'supplier.id', '=', 'pemesanan.idsupplier')
        ->where('pemesanan.idsupplier', $idsupplier)
        ->orderBy('pemesanan.id', 'desc')
        ->paginate($limit);
    }

    public function scopeGetAllMultiItem($query, $limit)
    {
        return DB::table($this->table)
        ->select(
            'pemesanan.id',
            'pemesanan.harga_barang',
            'pemesanan.jumlah_unit',
            'pemesanan.total_cost',
            'pemesanan.reorder_point',
            'pemesanan.frekuensi_pembelian',
            'pemesanan.total_cost_multiitem',
            'barang.id as id_barang',
            'barang.nama_barang',
            'barang.satuan_barang',
            'barang.idsupplier',
            'barang.biaya_penyimpanan',
            'supplier.biaya_pemesanan',
            'supplier.id as id_supplier',
            'supplier.nama as nama_supplier',
            DB::raw('(select count(id) from pemesanan where idsupplier=pemesanan.idsupplier) as total_barang')
        )
        ->leftJoin('barang', 'barang.id', '=', 'pemesanan.idbarang')
        ->leftJoin('supplier', 'supplier.id', '=', 'pemesanan.idsupplier')
        ->groupBy('pemesanan.idsupplier')
        ->paginate($limit);
    }

    public function scopeGetTotalUnitMultiItemByIdsupplier($query, $idsupplier)
    {
        return DB::table($this->table)
        ->where('idsupplier', $idsupplier)
        ->sum('jumlah_unit');
    }

    public function scopeGetCountUnitMultiItemByIdsupplier($query, $idsupplier)
    {
        return DB::table($this->table)
        ->where('idsupplier', $idsupplier)
        ->count('id');
    }

    public function scopeByID($query, $id)
    {
    	return DB::table($this->table)
    	->select(
    		'pemesanan.id',
            'pemesanan.harga_barang',
    		'pemesanan.jumlah_unit',
    		'pemesanan.total_cost',
    		'pemesanan.reorder_point',
    		'pemesanan.frekuensi_pembelian',
            'pemesanan.tipe',
    		'barang.id as id_barang',
    		'barang.idsupplier',
    		'barang.biaya_penyimpanan',
    		'supplier.biaya_pemesanan'
    	)
    	->join('barang', 'barang.id', '=', 'pemesanan.idbarang')
        ->join('supplier', 'supplier.id', '=', 'barang.idsupplier')
    	->where('pemesanan.id', $id)
    	->get();
    }

    public function scopeByMultiitemSupplier($query, $idsupplier)
    {
        return DB::table($this->table)
        ->select(
            'pemesanan.id',
            'pemesanan.harga_barang',
            'pemesanan.jumlah_unit',
            'pemesanan.total_cost',
            'pemesanan.reorder_point',
            'pemesanan.frekuensi_pembelian',
            'pemesanan.tipe',
            'barang.id as id_barang',
            'barang.idsupplier',
            'barang.biaya_penyimpanan',
            'supplier.biaya_pemesanan'
        )
        ->join('barang', 'barang.id', '=', 'pemesanan.idbarang')
        ->join('supplier', 'supplier.id', '=', 'pemesanan.idsupplier')
        ->where('pemesanan.idsupplier', $idsupplier)
        ->get();
    }

}
