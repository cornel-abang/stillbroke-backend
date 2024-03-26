<?php

namespace App\Providers;

use App\Events\ContactUsEvent;
use App\Events\PaymentMadeEvent;
use App\Events\AdminCreatedEvent;
use App\Events\ClientCreatedEvent;
use App\Events\ProductExtraRemoved;
use App\Listeners\ContactUsListener;
use Illuminate\Support\Facades\Event;
use App\Events\UserPasswordResetEvent;
use App\Listeners\PaymentMadeListener;
use Illuminate\Auth\Events\Registered;
use App\Listeners\AdminCreatedListener;
use App\Listeners\ClientCreatedListener;
use App\Listeners\UserPasswordResetListener;
use App\Listeners\ProductExtraRemovedListener;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ClientCreatedEvent::class => [
            ClientCreatedListener::class,
        ],
        AdminCreatedEvent::class => [
            AdminCreatedListener::class,
        ],
        UserPasswordResetEvent::class => [
            UserPasswordResetListener::class,
        ],
        ContactUsEvent::class => [
            ContactUsListener::class,
        ],
        ProductExtraRemoved::class => [
            ProductExtraRemovedListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
