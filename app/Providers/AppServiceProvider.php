<?php

namespace App\Providers;

use App\Domain\AnswerHistoryRepository;
use App\Domain\ExerciseRepository;
use App\Domain\StudyHistoryRepository;
use App\Domain\WorkbookRepository;
use Illuminate\Support\ServiceProvider;

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
        $this->app->bind(
            AnswerHistoryRepository::class,
            \App\Infrastructure\AnswerHistoryRepository::class
        );
        $this->app->bind(
            StudyHistoryRepository::class,
            \App\Infrastructure\StudyHistoryRepository::class
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
