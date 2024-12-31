<?php

namespace App\Repositories;

use App\Models\Task;
use App\Models\TaskList;
use App\Repositories\IElequent\ITaskListRepository;
use App\Repositories\IElequent\ITaskRepository;

class TaskRepository extends BaseRepository implements ITaskRepository
{
    public function __construct(Task $model)
    {
        parent::__construct($model);
    }

}
