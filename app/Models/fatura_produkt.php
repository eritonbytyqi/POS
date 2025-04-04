<?php
// app/Models/FaturaProdukt.php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class FaturaProdukt extends Pivot
{
    protected $table = 'fatura_product';  // Ose 'produkt_fatura', nëse ky është emri i tabelës suaj
    
    // Fushat që mund të mbushen nga kërkesa
    protected $fillable = [
        'fatura_id',   // ID e faturës
        'produkt_id',  // ID e produktit
        'sasia',    // Sasia e produktit
        'total',       // Çmimi i produktit në momentin e shtimit
    ];

    // Përcaktimi i lidhjes me modelin e Faturës
    public function fatura()
    {
        return $this->belongsTo(Fatura::class, 'fatura_id');
    }

    // Përcaktimi i lidhjes me modelin e Produktit
    public function produkt()
    {
        return $this->belongsTo(Produkt::class, 'produkt_id');
    }
}
