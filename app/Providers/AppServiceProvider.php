<?php

namespace App\Providers;

use App\Repositories\TaskRepository;
use App\Repositories\TaskRepositoryInterface;
use App\Services\Filters\QueryFilter\FilterFactory;
use App\Services\Filters\QueryFilter\FilterFactoryInterface;
use App\Services\Sorters\QuerySorter;
use App\Services\Sorters\SorterInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
        $this->app->bind(FilterFactoryInterface::class, FilterFactory::class);
        $this->app->bind(SorterInterface::class, QuerySorter::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
