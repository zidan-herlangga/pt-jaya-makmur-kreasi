<?php

namespace App\Providers;

use App\Services\ActivityLoggerService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ActivityLoggerService::class);
    }

    public function boot(): void
    {
        Paginator::defaultView('pagination::tailwind');
    }
}
