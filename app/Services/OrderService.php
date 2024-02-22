<?php

namespace App\Services;

use App\Models\User;

class OrderService
{
    public function fetchOrders(int $id)
    {
        $user = User::find($id);

        if (! $user) {
            return false;
        }

        return $user->orders;
    }
}
