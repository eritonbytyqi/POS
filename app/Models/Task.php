<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable=[
        'task_list_id',
        'name',
        'description'
    ];
    public function taskloist(){
        return $this->belongsTo(TaskList::class);
    }
}
