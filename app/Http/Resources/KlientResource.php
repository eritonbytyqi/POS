<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class KlientResource extends AbstractJsonResource
{
    public function getModelName(){
        return "Klient";
    }
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'emri'=>$this->emri,
            'mbiemri'=>$this->mbiemri,
            'telefoni'=>$this->telefoni,
            'email'=>$this->email,
            'adresa'=>$this->adresa,
            'qyteti'=>$this->qyteti,
        ];
    }
}
