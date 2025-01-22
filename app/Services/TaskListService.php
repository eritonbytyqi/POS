<?php

namespace App\Services;

use App\Repositories\TaskListRepository;

class TaskListService extends BaseService {

    protected $taskListRepository;

    public function __construct(TaskListRepository $taskListRepository)
    {
        parent::__construct($taskListRepository);
        $this->taskListRepository=$taskListRepository;
    }
    public function reorderTaskLists(array $taskListsOrder)
    {
        return $this->taskListRepository->reorderTaskLists($taskListsOrder);
    }

}
