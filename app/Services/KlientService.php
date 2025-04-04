<?php
namespace App\Services;

use App\Repositories\KlientRepository;

class KlientService extends BaseService{

    protected $KlientRepository;

    public function __construct(KlientRepository $KlientRepository)
    {
        parent::__construct($KlientRepository);
        $this->KlientRepository=$KlientRepository;
    }

}
