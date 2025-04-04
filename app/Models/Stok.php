<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
protected $table='stoku';
    protected $fillable = [
        'produkt_id',
        'sasia_ne_stok',
        'cmimi_blerjes'
    ];

    public function produkt()
    {
        return $this->belongsTo(Produkt::class);
    }
}
