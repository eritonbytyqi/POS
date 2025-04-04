<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class StokResource extends AbstractJsonResource
{
    public function getModelName(){
        return "stoku";
    }
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
'produkti_id' => $this->produkt ? $this->produkt->emri : null,
            'sasia'=> $this->sasia_ne_stok,
            'cmimi_blerjes'       => $this->cmimi_blerjes,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
        ];
    }
}
