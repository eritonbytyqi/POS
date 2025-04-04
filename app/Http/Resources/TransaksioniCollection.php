<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransaksioniCollection extends AbstractJsonCollection
{
    public function getModelName(){
        return 'transaksioni';
    }
    
}
