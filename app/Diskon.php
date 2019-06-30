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

}
