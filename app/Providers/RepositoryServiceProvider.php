<?php

namespace App\Providers;

use App\Repositories\Eloquent\StudentRepository;
use App\Repositories\Eloquent\ClassRepository;
use App\Repositories\StudentRepositoryInterface;
use App\Repositories\ClassRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(StudentRepositoryInterface::class, StudentRepository::class);
        $this->app->bind(ClassRepositoryInterface::class, ClassRepository::class);
    }
}
