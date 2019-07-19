<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Penjualan extends Model
{
    protected $table = 'penjualan';

    public function scopeGetTotalOrderByMonth($query, $id, $month)
    {
        return DB::table($this->table)
        ->where('idbarang', $id)
        ->whereMonth('tanggal_penjualan', $month)
        ->sum('jumlah_barang');
    }

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
    		'barang.nama_barang',
            'barang.satuan_barang'
    	)
    	->join('barang', 'barang.id', '=', 'penjualan.idbarang')
    	->orderBy('penjualan.id', 'desc')
    	->paginate($limit);
    }

    public function scopeGetAllByKodeTransaksi($query, $kode_transaksi)
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
            'barang.nama_barang',
            'barang.satuan_barang'
        )
        ->join('barang', 'barang.id', '=', 'penjualan.idbarang')
        ->where('penjualan.kode_transaksi', $kode_transaksi)
        ->orderBy('penjualan.id', 'desc')
        ->get();
    }
}
