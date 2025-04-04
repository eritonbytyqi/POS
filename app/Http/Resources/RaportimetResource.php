<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class RaportimetResource extends AbstractJsonResource
{
    public function getModelName(){
        return "Raportimet";
    }
    public function toArray($request)
    {
        return [
            'id'      => $this->id,
            'produkt' => $this->shitje && $this->shitje->produkt ? $this->shitje->produkt->emri : 'Produkt i paidentifikuar',
            'sasia'   => $this->shitje ? $this->shitje->sasia : null,
            'totali'  => $this->totali,
            
           
        ];
    }
}
