<?php

namespace App\Repositories\IElequent;

interface ITaskRepository{
    public function addUserToTask($taskId,$userId);
    public function deleteUserFromTask($taskId,$userId);
}
