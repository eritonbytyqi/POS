<?php
namespace App\Services;

use App\Repositories\ProduktRepository;

class ProduktService extends BaseService{

    protected $ProduktRepository;

    public function __construct(ProduktRepository $ProduktRepository)
    {
        parent::__construct($ProduktRepository);
        $this->ProduktRepository=$ProduktRepository;
    }

}
