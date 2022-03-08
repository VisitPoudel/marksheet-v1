<?php

namespace App\Providers;

use App\Repositories\Eloquent\StudentRepository;
use App\Repositories\Eloquent\ClassRepository;
use App\Repositories\Eloquent\SubjectRepository;
use App\Repositories\StudentRepositoryInterface;
use App\Repositories\ClassRepositoryInterface;
use App\Repositories\Eloquent\MarkRepository;
use App\Repositories\MarkRepositoryInterface;
use App\Repositories\SubjectRepositoryInterface;
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
        $this->app->bind(SubjectRepositoryInterface::class, SubjectRepository::class);
        $this->app->bind(MarkRepositoryInterface::class, MarkRepository::class);
    }
}
