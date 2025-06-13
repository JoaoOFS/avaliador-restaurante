<?php

namespace App\Providers;

use App\Models\Restaurant;
use App\Models\Review;
use App\Models\Category;
use App\Models\Cuisine;
use App\Policies\RestaurantPolicy;
use App\Policies\ReviewPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\CuisinePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Restaurant::class => RestaurantPolicy::class,
        Review::class => ReviewPolicy::class,
        Category::class => CategoryPolicy::class,
        Cuisine::class => CuisinePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Gate para verificar se o usuário é admin
        Gate::define('isAdmin', function ($user) {
            return $user->is_admin;
        });
    }
}
