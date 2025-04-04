<?php    
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Raportimet extends Model
{
    protected $table='raportimet';
    protected $fillable = [
        'shitje_id', 'totali'
    ];

    public function shitje()
    {
        return $this->belongsTo(Shitje::class, 'shitje_id');
    }

    // Lidhja për të marrë produktin përkatës nga shitja
    public function produkt()
    {
        return $this->belongsTo(Produkt::class, 'produkt_id', 'id');
    }
}
