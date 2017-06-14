<?php

namespace App\Providers;

use App\Model\Repository\CsvRecipeRepository;
use App\Model\Repository\RecipeRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RecipeRepositoryProvider extends ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->app->singleton(RecipeRepositoryInterface::class, function ($app) {
            return new CsvRecipeRepository($app['config']->get('app')['csv_path']);
        });
    }

    public function provides()
    {
        return [RecipeRepositoryInterface::class];
    }
}
