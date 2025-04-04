<?php
namespace App\Services;

use App\Repositories\ShitjeRepository;

    class ShitjeService extends BaseService{

        protected $ShitjeRepository;

        public function __construct(ShitjeRepository $ShitjeRepository)
        {
            parent::__construct($ShitjeRepository);
            $this->ShitjeRepository=$ShitjeRepository;
        }



    }
