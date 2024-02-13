<?php

namespace App\Listeners;

use App\Mail\UserPasswordReset;
use Illuminate\Support\Facades\Mail;
use App\Events\UserPasswordResetEvent;

class UserPasswordResetListener
{
    public function handle(UserPasswordResetEvent $event): void
    {
        $user_name = $event->user->first_name .' '. $event->user->last_name;

        Mail::to($event->user->email)->send(new UserPasswordReset($user_name));
    }
}
