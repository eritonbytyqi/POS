<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Pagesa extends Model
{
    protected $table='pagesat';

    protected $fillable = [
        'shitje_id',
        'shuma',
        'metoda'


    ];
    public function shitje()
    {
        return $this->belongsTo(Shitje::class);
    }
    public function faturat()
    {
        return $this->belongsTo(Fatura::class);
    }

    protected static function booted()
    {
        static::creating(function ($pagesa) {
            // Kontrolloni nëse shitja është e lidhur dhe ka produkt dhe sasi
            if ($pagesa->shitje && $pagesa->shitje->produkt && $pagesa->shitje->sasia) {
                // Llogaritja e shumës bazuar në produkt dhe sasi
                $pagesa->shuma = $pagesa->shitje->sasia * $pagesa->shitje->produkt->cmimi_shitjes;
            } else {
                // Nëse sasia ose produkti nuk janë të disponueshme, vendos shumën në 0
                $pagesa->shuma = 0;
            }
        });
        
}

}