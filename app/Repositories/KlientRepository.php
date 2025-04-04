<?php

namespace App\Repositories;

use App\Models\Klienti;
use App\Repositories\IElequent\IKlientRepository;

class KlientRepository extends BaseRepository implements IKlientRepository{
    public function __construct(Klienti $model)
    {
        parent::__construct($model);
    }

}
