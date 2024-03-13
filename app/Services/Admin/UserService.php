<?php

namespace App\Services\Admin;

use App\Models\User;
use App\Events\AdminCreatedEvent;
use Illuminate\Database\Eloquent\Collection;

class UserService
{
    public function addUser(array $info): void
    {
        User::create(array_merge($info, ['role' => 'admin']));

        event(new AdminCreatedEvent($info));
    }

    public function getUser(int $id): User | bool
    {
        $user = User::find($id);

        return $user ? $user : false;
    }

    public function updateUser(int $id, array $info)
    {
        $user = User::find($id);

        if (! $user || $user->role == 'client') {
            return false;
        }

        $user->update($info);

        return $user;
    }

    public function fetchUsers(string $role): Collection
    {
        return User::where('role', $role)->get();
    }

    public function deleteUser(int $id): bool
    {
        $user = User::find($id);

        if (! $user) {
            return false;
        }

        $user->delete();

        return true;
    }
}