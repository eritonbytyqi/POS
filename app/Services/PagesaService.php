<?php
namespace App\Services;

use App\Repositories\TransaksionRepository;
use App\Models\Pagesa;
use App\Repositories\PagesaRepository;
use App\Repositories\TransaksioniRepository;
use Illuminate\Support\Facades\DB;

class PagesaService extends BaseService
{
    protected $PagesaRepository;

    public function __construct(PagesaRepository $PagesaRepository)
    {
        parent::__construct($PagesaRepository);

        $this->PagesaRepository = $PagesaRepository;
    }

    public function makePayment($request)
    {
        return $this->PagesaRepository->bejePagesen(
            $request->shitje_id,
            $request->shuma,
            $request->metoda
        );
    }
    
    }

   
  

