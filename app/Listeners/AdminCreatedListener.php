<?php

namespace App\Listeners;

use App\Mail\AdminUserDetails;
use App\Events\AdminCreatedEvent;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdminCreatedListener
{
    public function handle(AdminCreatedEvent $event): void
    {
        if ($event->info['send_details']) {
            Mail::to($event->info['email'])->send(new AdminUserDetails($event->info));
        }
    }
}
