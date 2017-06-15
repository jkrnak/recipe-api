<?php

namespace App\Providers;

use App\Transformer\Generic\RecipeTransformer;
use App\Transformer\RecipeTransformerInterface;
use Illuminate\Support\ServiceProvider;

class RecipeTransformerProvider extends ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->app->singleton(RecipeTransformerInterface::class, function () {
            return new RecipeTransformer();
        });
    }

    public function provides()
    {
        return [RecipeTransformerInterface::class];
    }
}
