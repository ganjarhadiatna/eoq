<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pembelian extends Model
{
    protected $table = 'pembelian';

    public function scopeGetAll($query, $limit)
    {
    	return DB::table($this->table)
    	->select(
    		$this->table.'.id',
            $this->table.'.idsupplier',
    		'barang.id as id_barang',
    		'barang.nama_barang',
            'barang.satuan_barang',
    		'supplier.nama as nama_supplier',
            DB::raw('(select count(id) from pembelian where idsupplier=pembelian.idsupplier) as total_barang')
    	)
    	->leftJoin('barang', 'barang.id', '=', $this->table.'.idbarang')
        ->leftJoin('supplier', 'supplier.id', '=', $this->table.'.idsupplier')
        ->orderBy($this->table.'.status', 'asc')
        ->groupBy($this->table.'.idsupplier')
    	->paginate($limit);
    }

    public function scopeJumlahPembelian($query, $idsupplier)
    {
        return DB::table($this->table)
        ->where('idsupplier', $idsupplier)
        ->count('id');
    }

    public function scopeTotalPembelian($query, $idsupplier)
    {
        return DB::table($this->table)
        ->where('idsupplier', $idsupplier)
        ->sum('total_biaya');
    }

    public function scopeGetBySupplier($query, $idsupplier, $limit)
    {
        return DB::table($this->table)
        ->select(
            $this->table.'.id',
            $this->table.'.kode_transaksi',
            $this->table.'.jumlah_pembelian',
            $this->table.'.harga_barang',
            $this->table.'.biaya_penyimpanan',
            $this->table.'.diskon',
            $this->table.'.tanggal_pembelian',
            $this->table.'.status',
            'barang.id as id_barang',
            'barang.nama_barang',
            'barang.satuan_barang',
            'supplier.nama as nama_supplier'
        )
        ->leftJoin('barang', 'barang.id', '=', $this->table.'.idbarang')
        ->leftJoin('supplier', 'supplier.id', '=', $this->table.'.idsupplier')
        ->where($this->table.'.idsupplier', $idsupplier)
        ->orderBy($this->table.'.status', 'asc')
        ->paginate($limit);
    }

    public function scopeGetAllForLaporan($query, $tglAwal, $tglAkhir, $order)
    {
        return DB::table($this->table)
        ->select(
            $this->table.'.id',
            $this->table.'.kode_transaksi',
            $this->table.'.jumlah_pembelian',
            $this->table.'.harga_barang',
            $this->table.'.biaya_penyimpanan',
            $this->table.'.diskon',
            $this->table.'.tanggal_pembelian',
            $this->table.'.status',
            'barang.id as id_barang',
            'barang.nama_barang',
            'barang.satuan_barang',
            'supplier.nama as nama_supplier'
        )
        ->leftJoin('barang', 'barang.id', '=', $this->table.'.idbarang')
        ->leftJoin('supplier', 'supplier.id', '=', $this->table.'.idsupplier')
        ->whereBetween($this->table.'.created_at', [$tglAwal, $tglAkhir])
        ->orderBy($this->table.'.status', 'asc')
        ->get();
    }

    public function scopeGetTotalCostMultiItemByIdsupplier($query, $idsupplier)
    {
        return DB::table($this->table)
        ->where('idsupplier', $idsupplier)
        ->sum('total_cost');
    }
}
