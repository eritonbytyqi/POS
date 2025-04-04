<?php


namespace App\Repositories;

use App\Models\Fatura;
use App\Models\fatura_produkt;
use App\Models\Product;
use App\Models\FaturaProdukt;
use App\Models\Produkt;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FaturaRepository extends BaseRepository
{
    public function __construct(Fatura $model)
    {
        parent::__construct($model);
    }

    /**
     * Shto produktin në faturë dhe përditëso totalin
     */
   
}
