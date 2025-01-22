<?php

namespace App\Repositories;

use App\Models\Task;
use App\Models\TaskList;
use App\Repositories\IElequent\ITaskListRepository;
use App\Repositories\IElequent\ITaskRepository;
use Illuminate\Support\Facades\Log;

class TaskRepository extends BaseRepository implements ITaskRepository
{
    public function __construct(Task $model)
    {
        parent::__construct($model);
    }
    public function addUserToTask($taskId,$userId){
        $task=$this->model->find($taskId);
        $task->users()->attach($userId);
        return $task;
    }
    public function deleteUserFromTask($taskId,$userId){
        $task=$this->model->find($taskId);
        $task->users()->detach($userId);
        return $task;
    }
    public function reorderTasks(array $tasksOrder)
    {
        foreach ($tasksOrder as $taskOrder) {
            if (isset($taskOrder['id']) && isset($taskOrder['order'])) {
                $this->model->where('id', $taskOrder['id'])->update(['order' => $taskOrder['order']]);
            }
        }
        return $this->model->orderBy('order')->get(); // Return reordered list
    }
}
