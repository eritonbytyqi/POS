<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Klienti extends Model
{


    protected $fillable = [
        'emri',
  'mbiemri',
  'telefoni',
  'email',
  'adresa',
  'qyteti',


    ];
    protected $table = 'klientet';

    public function transaksionet()
    {
        return $this->hasMany(Transaksioni::class);  
    }
}
