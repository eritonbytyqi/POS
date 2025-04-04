<?php

namespace App\Http\Resources;


class FaturaResource extends AbstractJsonResource
{
    public function getModelName(){
        return "fatura";
    }
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            "pagesa_id"=> $this->pagesa_id,
'shuma_totale' => $this->pagesa->shuma ?  : 'Totali nuk u gjet',



            'data_fatures' => $this->data_fatures,
            'nr_fatures' => $this->nr_fatures,
         'status'=>'papaguar',

        ];
        
    }
}
