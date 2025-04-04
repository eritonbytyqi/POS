<?php


namespace App\Http\Resources;

use App\Http\Resources\AbstractJsonResource;
use Illuminate\Http\Request;

class ArtikujShitjeResource extends  AbstractJsonResource
{
    public function getModelName()
    {
        return 'artikuj_shitjesh';
    }
    public function toArray(Request $request)
    {
        return [
            'id'            => $this->id,
            'shitja_id'     => $this->shitja_id,      
            'produkt_id'    => $this->produkt_id,     
            'produkt'       => $this->produkt->emri,  
            'klienti'       => $this->shitje->klienti->emri,
            'sasia'         => $this->sasia,
            'cmimi'         => $this->cmimi,
            'totali'        => $this->totali,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
        ];
    }
}