<?php

namespace App\Services;

use App\Repositories\FaturaRepository;
use App\Models\Fatura;
use App\Models\Product;
use App\Models\Produkt;
use App\Models\Transaction;
use App\Models\Transaksioni;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FaturaService extends BaseService
{
    protected $FaturaRepository;
    public function __construct(FaturaRepository $FaturaRepository)
    {
        parent::__construct($FaturaRepository);
    }
    public function allWithRelations($relations = [])
    {
        // Mund të përdorni 'with' këtu për të ngarkuar lidhjet
        return $this->FaturaRepository->with($relations)->get();
    } 
}
