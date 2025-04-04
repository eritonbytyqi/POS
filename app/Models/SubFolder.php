<?php    
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subfolder extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'parent_id'];

    /**
     * Marrëdhënia me subfolderin prind.
     */
    public function parent()
    {
        return $this->belongsTo(Subfolder::class, 'parent_id');
    }

    /**
     * Marrëdhënia me subfolderët fëmijë.
     */
    public function children()
    {
        return $this->hasMany(Subfolder::class, 'parent_id');
    }
}
