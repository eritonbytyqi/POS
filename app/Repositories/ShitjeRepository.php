<?php
namespace App\Repositories;

use App\Models\Shitje;
use App\Repositories\IElequent\IShitjeRepository;

class ShitjeRepository extends BaseRepository implements IShitjeRepository{
    public function __construct(Shitje $model)
    {
        parent::__construct($model);  // Përdor modelin e shitjes
    }

    // Kjo metodë do të llogarisë shumën totale të shitjes


    // Kjo metodë merr të gjitha shitjet dhe shton shumën totale
   
}
