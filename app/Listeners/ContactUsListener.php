<?php

namespace App\Listeners;

use App\Events\ContactUsEvent;
use App\Mail\NotifyForContactUs;
use Illuminate\Support\Facades\Mail;

class ContactUsListener
{
    public function handle(ContactUsEvent $event): void
    {
        $info = $event->info;

        Mail::to('admin@stillbroke.com')->send(new NotifyForContactUs($info));
    }
}
