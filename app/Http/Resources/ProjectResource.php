<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class ProjectResource extends AbstractJsonResource
{
    public function getModelName(){
        return "Project";
    }
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'description'=>$this->description,
            'tasklist'=>$this->taskLists
        ];
    }
}
