<?php
namespace App\Services;

use App\Models\Stok;
use App\Repositories\ShitjeRepository;
use App\Repositories\StokRepository;
use App\Repositories\StokuRepository;
use Illuminate\Http\Request;

class StokService extends BaseService{

    protected $StokRepository;

    public function __construct(StokRepository $StokRepository)
    {
        parent::__construct($StokRepository);
        $this->StokRepository=$StokRepository;
    }

    public function addStock(Request $request)
    {
        $data = $request->validate([
            'produkt_id' => 'required|exists:products,id',
            'sasia_ne_stok' => 'required|numeric|min:1',
            'cmimi_blerjes' => 'required|numeric|min:0',
        ]);

        return $this->StokRepository->addStock($data);
    }
}


