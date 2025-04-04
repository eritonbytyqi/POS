<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class PagesaResource extends AbstractJsonResource
{
    public function getModelName(){
        return "Pagesa";
    }

   
    public function toArray($request)
    {

        $shitje = $this->pagesa ? $this->pagesa->shitje : null;

        return [
            'id'        => $this->id ?? 'id nuk u gjet',
            'metoda'    => $this->metoda,
            
            'shuma_totale' => $this->shuma,
            'statusi' => $this->pagesa && $this->pagesa->shitje ? $this->pagesa->shitje->statusi : 'skastatus',
            'created_at'=> $this->created_at,
            'updated_at'=> $this->updated_at,
        ];
        
    }
}
