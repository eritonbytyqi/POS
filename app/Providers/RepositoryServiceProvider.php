<?php

namespace App\Providers;

use App\Models\Appointment;
use App\Repositories\AppointmentRepository;
use App\Repositories\BaseRepository;
use App\Repositories\IEloquent\IBaseRepository;
use App\Repositories\IEloquent\IAppointmentRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider{

    public function register()
    {
        $this->app->bind(IBaseRepository::class, BaseRepository::class);
        $this->app->bind(IAppointmentRepository::class, AppointmentRepository::class);

    }
    public function boot(){

    }
}
