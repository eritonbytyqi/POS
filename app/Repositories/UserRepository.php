<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\IElequent\IUserRepository;

class UserRepository extends BaseRepository implements IUserRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
    public function withTrashed()
    {
        return User::withTrashed();
    }
    public function onlyTrashed()
    {
        return User::onlyTrashed();  
    }

    public function forceDelete($id)
{
    $user= $this->model->withTrashed()->find($id);

    if ($user) {
        $user->forceDelete();  
    }

    return $user;
}
}
