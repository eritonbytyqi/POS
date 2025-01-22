<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable=[
        'task_list_id',
        'name',
        'description',
        'order',
        'priority',
        'story_point'
    ];
    public function taskloist(){
        return $this->belongsTo(TaskList::class);
    }
    public function users(){
        return $this->belongsToMany(User::class);
    }
}
