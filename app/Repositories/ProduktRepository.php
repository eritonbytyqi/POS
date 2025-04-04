<?php
namespace App\Repositories;

use App\Models\Produkt;
use App\Repositories\IElequent\IProduktRepository;

class ProduktRepository extends BaseRepository implements IProduktRepository{

    public function __construct(Produkt $model)
    {
        parent::__construct($model);
    }
    

}