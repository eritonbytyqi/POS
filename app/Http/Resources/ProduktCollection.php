<?php
namespace App\Http\Resources;

class ProduktCollection extends AbstractJsonCollection
{
    public function getModelName()
    {
        return 'products';
    }
}
