<?php

namespace App\Services;

use App\Repositories\ProjectRepository;

class ProjectService extends BaseService {

    protected $projectRepository;

    public function __construct(ProjectRepository $projectRepository)
    {
        parent::__construct($projectRepository);
        $this->projectRepository=$projectRepository;
    }
}
