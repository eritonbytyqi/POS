<?php

namespace App\Repositories;

use App\Models\TaskList;
use App\Repositories\IElequent\ITaskListRepository;

class TaskListRepository extends BaseRepository implements ITaskListRepository
{
    public function __construct(TaskList $model)
    {
        parent::__construct($model);
    }

}
