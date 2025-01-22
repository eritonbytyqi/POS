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
    public function reorderTaskLists(array $taskListsOrder)
    {
        foreach ($taskListsOrder as $tlOrder) {
            if (isset($tlOrder['id']) && isset($tlOrder['order'])) {
                $this->model->where('id', $tlOrder['id'])->update(['order' => $tlOrder['order']]);
            }
        }
        return $this->model->orderBy('order')->get(); // Return reordered list
    }

}
