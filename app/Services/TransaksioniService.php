<?php
namespace App\Services;

use App\Repositories\ProduktRepository;
use App\Repositories\TransaksioniRepository;
use Illuminate\Support\Facades\DB;

class TransaksioniService extends BaseService{

    protected $TransaksioniRepository;

    public function __construct(TransaksioniRepository $TransaksioniRepository)
    {
        parent::__construct($TransaksioniRepository);
        $this->TransaksioniRepository=$TransaksioniRepository;
    }

  

}
