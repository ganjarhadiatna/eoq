<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Diskon extends Model
{
    protected $table = 'diskons';

    public function scopeCheckTypeDiscount($query, $idbarang, $type)
    {
        return DB::table($this->table)
        ->where('idbarang', $idbarang)
        ->where('tipe', $type)
        ->value('id');
    }

    public function scopeGetAll($query, $idbarang, $limit)
    {
    	return DB::table($this->table)
    	->select(
    		'diskons.id',
    		'diskons.diskon',
    		'diskons.min',
    		'diskons.max',
    		'diskons.tipe',
    		'diskons.idbarang',
    		'diskons.created_at',
    		'barang.harga_barang as harga',
    	)
    	->join('barang', 'barang.id', '=', 'diskons.idbarang')
    	->where('diskons.idbarang', $idbarang)
    	->orderBy('id', 'desc')
    	->paginate($limit);
    }

    public function scopeGetAllNoLimit($query, $idbarang)
    {
        return DB::table($this->table)
        ->select(
            'diskons.id',
            'diskons.diskon',
            'diskons.min',
            'diskons.max',
            'diskons.tipe',
            'diskons.idbarang',
            'diskons.created_at',
            'barang.harga_barang as harga',
        )
        ->join('barang', 'barang.id', '=', 'diskons.idbarang')
        ->where('diskons.idbarang', $idbarang)
        ->orderBy('id', 'desc')
        ->get();
    }

    public function scopeGetAllByType($query, $idbarang, $type)
    {
        return DB::table($this->table)
        ->select(
            'diskons.id',
            'diskons.diskon',
            'diskons.min',
            'diskons.max',
            'diskons.tipe',
            'diskons.idbarang',
            'diskons.created_at',
            'barang.harga_barang as harga',
        )
        ->join('barang', 'barang.id', '=', 'diskons.idbarang')
        ->where('diskons.idbarang', $idbarang)
        ->where('diskons.tipe', $type)
        ->orderBy('id', 'asc')
        ->get();
    }

}
