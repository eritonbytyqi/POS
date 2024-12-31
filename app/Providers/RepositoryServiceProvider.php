<?php

namespace App\Providers;

use App\Repositories\BaseRepository;
use App\Repositories\IElequent\IBaseRepository;
use App\Repositories\IElequent\IProjectRepository;
use App\Repositories\IElequent\ITaskListRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\TaskListRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider{

    public function register()
    {
        $this->app->bind(IBaseRepository::class, BaseRepository::class);
        $this->app->bind(IProjectRepository::class, ProjectRepository::class);
        $this->app->bind(ITaskListRepository::class, TaskListRepository::class);
    }
    public function boot(){

    }
}
