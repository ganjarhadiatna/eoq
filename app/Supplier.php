<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Supplier extends Model
{
    protected $table = 'supplier';

    public function scopeGet($query)
    {
        return $this->get();
    }

    public function scopeGetById($query, $idSupplier)
    {
        return $this
                ->where('id', $idSupplier)
                ->get();
    }

    public function scopeGetLeadtime($query, $id)
    {
    	return DB::table($this->table)
    	->where('id', $id)
    	->value('leadtime');
    }

    public function scopeGetBiayaPemesanan($query, $id)
    {
        return DB::table($this->table)
        ->where('id', $id)
        ->value('biaya_pemesanan');
    }

    public function scopeGetWaktuOperasional($query, $id)
    {
    	return DB::table($this->table)
    	->where('id', $id)
    	->value('waktu_operasional');
    }
}
