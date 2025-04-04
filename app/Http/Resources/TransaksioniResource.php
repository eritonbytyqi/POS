<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransaksioniResource extends AbstractJsonResource
{
    public function getModelName(){
        return 'transaksioni';
    }
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'klient_id'    => $this->klient_id ? $this->klient->emri : null,// Emri i klientit
            'produkt_id'   => $this->produkt_id ? $this->klient->emri : null,
            'fatura_id'=>$this->fatura_id,  
            'Totali_Transaksionit'         => $this->Totali_Transaksionit,
            'Menyra_Pageses'=>$this->Menyra_Pageses,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,

        ];
    }
}
