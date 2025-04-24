<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Policies\CartItemPolicy;
use App\Models\CartItem;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        CartItem::class => CartItemPolicy::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
