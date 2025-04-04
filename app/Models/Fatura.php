<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Fatura extends Model
{
    use HasFactory;
    protected $table= 'faturat';

    protected $fillable = ['data_fatures','pagesa_id'];

  
    public function produktet()
    {
        return $this->belongsToMany(Produkt::class, 'fatura_produkt')
                    ->withPivot('sasia', 'toal') // Shtojmë sasinë dhe çmimin në lidhje
                    ->withTimestamps();
    }
    public function shitje()
    {
        return $this->belongsTo(Shitje::class);
    }
   public function pagesa(){
    return $this->belongsTo(Pagesa::class);

   }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($fatura) {
            $fatura->nr_fatures = 'FAT-' . strtoupper(Str::random(10));  // Krijo një numër të rastësishëm të faturës
        });

    }
   

    // public function detajet()
    // {
    //     return $this->hasMany(DetajiFatures::class);
    // }
}
