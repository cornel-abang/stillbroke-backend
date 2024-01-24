<?php

namespace App\Listeners;

use App\Mail\EmailVerification;
use App\Models\VerificationCode;
use App\Events\ClientCreatedEvent;
use Illuminate\Support\Facades\Mail;

class ClientCreatedListener
{
    public function handle(ClientCreatedEvent $event): void
    {
        $user = $event->user;
        
        $verifyCode = VerificationCode::create([
            'code' => md5(random_bytes(60)),
            'user_id' => $user->id,
            'email' => $user->email,
        ]);

        Mail::to($user->email)->send(new EmailVerification($verifyCode));
    }
}
