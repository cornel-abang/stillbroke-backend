<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class PaymentMadeEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public array $info)
    {
    }
}
