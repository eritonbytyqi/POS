<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produkt extends Model
{
    use HasFactory;
protected $table='products';
    protected $fillable = [
        'emri',
        'barkodi',
        'cmimi_shitjes',
        'pershkrimi',
        'subfolder_id',
        'folder_id'

    ];
    public function subfolder()
    {
        return $this->belongsTo(Subfolder::class, 'subfolder_id');
    }
   
    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }
    public function stok()
    {
        return $this->hasOne(Stok::class, 'produkt_id'); // Sigurohuni që 'produkt_id' është i saktë
    }
    public function faturat()
    {
        return $this->belongsToMany(Fatura::class, 'produkt_fatura')
                    ->withPivot('sasia', 'total')
                    ->withTimestamps();
    }
    public function shitje()
    {
        return $this->hasMany(Shitje::class);
    }
}