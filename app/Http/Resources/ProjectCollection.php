<?php
namespace App\Http\Resources;

class ProjectCollection extends AbstractJsonCollection
{
    public function getModelName()
    {
        return 'Project';
    }
}
