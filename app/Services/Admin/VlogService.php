<?php

namespace App\Services\Admin;

use App\Models\Vlog;
use Illuminate\Database\Eloquent\Collection;

class VlogService
{
    public function createItem(array $item): void
    {
        Vlog::create($item);
    }

    public function fetchVlogItems(): Collection
    {
        return Vlog::all();
    }

    public function fetchVlogItem(int $id): Vlog | bool
    {
        $vlog = Vlog::find($id);

        if (! $vlog) {
            return false;
        }

        return $vlog;
    }

    public function updateVlogItem(int $id, $info): bool
    {
        $vlog = Vlog::find($id);

        if (! $vlog) {
            return false;
        }

        $vlog->update($info);

        return true;
    }

    public function deleteVlogItem(int $id)
    {
        $vlog = Vlog::find($id);

        if (! $vlog) {
            return false;
        }

        $vlog->delete();

        return true;
    }
}