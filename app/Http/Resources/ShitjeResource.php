<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class ShitjeResource extends AbstractJsonResource
{
    public function getModelName(){
        return "shitjet";
    }
    public function toArray($request)
    {
       
        return [
            'id'            => $this->id,
            'klienti_id'   => $this->klienti_id,
            
            'klienti_emri'  => $this->klienti ? $this->klienti->emri : 'Klienti nuk u gjet', // Emri i klientit
            'produkt_id'    => $this->produkt_id,
            'produkt_emri'  => $this->produkt ? $this->produkt->emri : 'Emri i produktit nuk u gjet',
            'totali'        => $this->totali, // Këtu duhet të vendosim $totali, jo $this->totali
            'SASIA'         => $this->sasia,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
        ];
    } 
}
