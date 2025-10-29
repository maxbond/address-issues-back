<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Issue\IssueService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('issueService', IssueService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
