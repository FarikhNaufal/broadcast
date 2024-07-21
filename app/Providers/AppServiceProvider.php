<?php

namespace App\Providers;

use App\Events\GetDataEvent;
use App\Listeners\BroadcastMessage;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Laravel\Reverb\Events\MessageReceived;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Carbon::setLocale('id');
        // Event::listen(
        //     MessageReceived::class,
        //     BroadcastMessage::class,
        // );
    }
}
