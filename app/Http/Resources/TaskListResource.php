<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class TaskListResource extends AbstractJsonResource
{
    public function getModelName(){
        return "TaskList";
    }
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'description'=>$this->description,
            'order'=>$this->order,
            'color'=>$this->color
        ];
    }
}
