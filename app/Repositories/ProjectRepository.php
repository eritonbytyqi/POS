<?php

namespace App\Repositories;

use App\Models\Project;
use App\Repositories\IElequent\IProjectRepository;

class ProjectRepository extends BaseRepository implements IProjectRepository
{
    public function __construct(Project $model)
    {
        parent::__construct($model);
    }

}
