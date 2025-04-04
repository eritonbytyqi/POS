<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'subfolder_id'];

    public function subfolders()
    {
        return $this->hasMany(Folder::class, 'subfolder_id');
    }

    // public function parent()
    // {
    //     return $this->belongsTo(Folder::class, 'subfolder_id');
    // }
    public function products()
    {
        return $this->hasMany(Produkt::class);
    }
}
