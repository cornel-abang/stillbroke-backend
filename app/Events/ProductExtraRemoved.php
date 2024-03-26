<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class ProductExtraRemoved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public int $extra_id, public int $prod_id)
    {
    }
}
