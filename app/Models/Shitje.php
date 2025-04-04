<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shitje extends Model
{
    protected $table='shitjet';
    protected $fillable = [
        'klienti_id',
        'produkt_id',
        'sasia',
        'totali',
        'statusi',
    ];
   

    public function pagesa()
    {
        return $this->hasOne(Pagesa::class, 'shitja_id');
    }
    public function klienti()
    {
        return $this->belongsTo(Klienti::class, 'klienti_id');
    }
    public function produkt()
    {
        return $this->belongsTo(Produkt::class, 'produkt_id');
    }
    public function raportimet()
    {
        return $this->hasMany(Raportimet::class);
    }
    public function faturat()
    {
        return $this->hasMany(Fatura::class);
    }

    protected static function booted()
    {
        static::creating(function ($shitje) {
            // Kontrolloni nëse shitja ka produkt dhe sasia
            if ($shitje->produkt) {
                // Kontrolloni nëse ka sasi të mjaftueshme në stok
                $stok = $shitje->produkt->stok()->first(); // Merrni stokun e produktit
        
                // Kontrolloni nëse stok është gjetur dhe ka sasi të mjaftueshme
                if ($stok && $stok->sasia_ne_stok >= $shitje->sasia) {
                    // Llogaritni totalin duke shumëzuar sasinë me çmimin e shitjes
                    $shitje->totali = $shitje->sasia * $shitje->produkt->cmimi_shitjes;

                    // Zbritni sasinë e shitjes nga sasia_stok në stok
                    $stok->sasia_ne_stok -= $shitje->sasia;
                    $stok->save(); // Ruani përditësimin e stokut
                } else {
                    // Nëse nuk ka mjaftueshëm stok, mund të ndaloni krijimin e shitjes ose të vendosni një mesazh gabimi
                    throw new \Exception("Nuk ka mjaftueshëm stok për këtë produkt.");
                }
            } else {
                // Nëse nuk ka produkt, mund të hedhim një përjashtim ose të dërgojmë një mesazh gabimi
                throw new \Exception("Produkt i pasaktë ose i pavlefshëm.");
            }
        });
    }
    
    }        

