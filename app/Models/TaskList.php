<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskList extends Model
{
    protected $fillable=[
        'project_id',
        'name',
        'description'
    ];
    public function project(){
        return $this->belongsTo(Project::class);
    }
    public function tasks(){
        return $this->belongsTo(Task::class);
    }
}
