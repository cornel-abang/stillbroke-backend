<?php

namespace App\Services;

use App\Models\User;
use App\Events\AdminCreatedEvent;

class AdminService
{
    public function addUser(array $info): void
    {
        User::create(array_merge($info, ['role' => 'admin']));

        event(new AdminCreatedEvent($info));
    }
}
