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
    		$this->table.'.kode_transaksi',
    		$this->table.'.jumlah_pembelian',
    		$this->table.'.harga_barang',
    		$this->table.'.biaya_penyimpanan',
    		$this->table.'.diskon',
    		$this->table.'.tanggal_pembelian',
    		$this->table.'.status',
    		'barang.id as id_barang',
    		'barang.nama_barang',
    		'supplier.nama as nama_supplier'
    	)
    	->join('barang', 'barang.id', '=', $this->table.'.idbarang')
        ->join('supplier', 'supplier.id', '=', 'barang.id')
        ->orderBy($this->table.'.id', 'desc')
    	->paginate($limit);
    }
}
