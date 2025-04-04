<?php
namespace App\Services;

use App\Repositories\UserRepository;

class UserService extends BaseService{

    protected $UserRepository;

    public function __construct(UserRepository $UserRepository)
    {
        parent::__construct($UserRepository);
        $this->UserRepository=$UserRepository;
    }

}
