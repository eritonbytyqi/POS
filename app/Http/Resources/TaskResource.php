<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class TaskResource extends AbstractJsonResource
{
    public function getModelName(){
        return "Task";
    }
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'description'=>$this->description
        ];
    }
}
