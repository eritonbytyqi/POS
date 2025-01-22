<?php

namespace App\Services;

use App\Repositories\TaskRepository;

class TaskService extends BaseService {

    protected $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        parent::__construct($taskRepository);
        $this->taskRepository=$taskRepository;
    }
    public function addUserToTask($taskId,$userId){
        return $this->taskRepository->addUserToTask($taskId,$userId);
    }
    public function deleteUserFromTask($taskId,$userId){
        return $this->taskRepository->deleteUserFromTask($taskId,$userId);
    }
    /**
     * Reorder tasks.
     */
    public function reorderTasks(array $taskOrder)
    {
        return $this->taskRepository->reorderTasks($taskOrder);
    }

}
