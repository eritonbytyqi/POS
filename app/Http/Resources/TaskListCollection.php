<?php
namespace App\Http\Resources;

class TaskListCollection extends AbstractJsonCollection
{
    public function getModelName()
    {
        return 'Task';
    }
}
