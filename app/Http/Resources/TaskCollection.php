<?php
namespace App\Http\Resources;

class TaskCollection extends AbstractJsonCollection
{
    public function getModelName()
    {
        return 'Task';
    }
}
