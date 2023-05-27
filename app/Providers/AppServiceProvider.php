<?php

namespace App\Providers;

use App\Interfaces\RepositoryInterface;
use App\Repositories\RecipeRepository;
use App\Repositories\UserRepository;
use App\Services\RecipeService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        app()->when(UserService::class)->needs(RepositoryInterface::class)->give(UserRepository::class);
        app()->when(RecipeService::class)->needs(RepositoryInterface::class)->give(RecipeRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
