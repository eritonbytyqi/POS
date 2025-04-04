<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
    
use Illuminate\Database\Eloquent\Model;

class Transaksioni extends Model
{
    use HasFactory;
    protected $table= 'transaksionet';
    protected $fillable = ['klient_id', 'produkt_id','fatura_id','totali','statusi'];

    public function klient()
    {
        return $this->belongsTo(Klienti::class);
    }

    public function fatura()
    {
        return $this->hasOne(Fatura::class);
    }
    public function produkts()
    {
        return $this->belongsTo(Produkt::class);  
    }

   
}
