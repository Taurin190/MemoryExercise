<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use \App\Domain\WorkbookRepository;
use \App\Domain\ExerciseRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            WorkbookRepository::class,
            \App\Infrastructure\WorkbookRepository::class
        );
        $this->app->bind(
            ExerciseRepository::class,
            \App\Infrastructure\ExerciseRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
