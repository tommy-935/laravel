<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Listeners\MailSentListener;
use Illuminate\Mail\Events\MessageSent;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        MessageSent::class => [
            MailSentListener::class,
        ],
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
