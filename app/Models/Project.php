<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //test
    protected $fillable=[
        'name',
        'description'
    ];
    public function taskLists(){
        return $this->hasMany(TaskList::class);
    }
}
