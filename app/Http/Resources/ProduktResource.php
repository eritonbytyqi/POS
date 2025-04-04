<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class ProduktResource extends AbstractJsonResource
{
    public function getModelName(){
        return "products";
    }
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'emri'          => $this->emri,
            'barkodi'       => $this->barkodi,
            'cmimi_shitjes' => $this->cmimi_shitjes,
            'sasia_ne_stok' => $this->sasia_ne_stok,
            'pershkrimi'          => $this->pershkrimi,
            
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
        ];
    }
}
