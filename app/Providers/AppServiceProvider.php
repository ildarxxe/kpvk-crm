<?php

namespace App\Providers;

use App\Repositories\TaskRepository;
use App\Services\TaskService;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(TaskRepository::class, function () {
            return new TaskRepository();
        });

        $this->app->bind(TaskService::class, function ($app) {
            return new TaskService($app->make(TaskRepository::class));
        });
    }

    public function boot(): void
    {
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}
