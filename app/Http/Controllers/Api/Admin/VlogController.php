<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\Admin\VlogService;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateVlogRequest;
use App\Http\Requests\UpdateVlogRequest;

class VlogController extends Controller
{
    public function __construct(private VlogService $vlogService)
    {
    }

    public function createVlogItem(CreateVlogRequest $request): JsonResponse
    {
        $this->vlogService->createItem($request->validated());

        return $this->response(true, 'Vlog item created successfully', 200);
    }

    public function getVlogItems()
    {
        $vlogs = $this->vlogService->fetchVlogItems();

        return $this->response(
            true, 'Vlog items found: '.$vlogs->count(), 
            200, ['vlogs' => $vlogs]
        );
    }

    public function getVlogItem(int $id)
    {
        $vlogItem = $this->vlogService->fetchVlogItem($id);

        if (! $vlogItem) {
            return $this->response(true, 'Vlog item not found', 404);
        }

        return $this->response(
            true, 'Vlog item found', 
            200, ['vlog' => $vlogItem]
        );
    }

    public function updateVlogItem(int $id, UpdateVlogRequest $request)
    {
        $response = $this->vlogService->updateVlogItem($id, $request->validated());

        if (! $response) {
            return $this->response(true, 'Vlog item not found', 404);
        }

        return $this->response(true, 'Vlog item updated', 200);
    }

    public function getAllVlogItemsForFrontend()
    {
        $vlogs = $this->vlogService->fetchVlogItems();

        return $this->response(
            true, 'Vlog items found: '.$vlogs->count(), 
            200, ['vlogs' => $vlogs]
        );
    }

    public function deleteVlogItem(int $id)
    {
        $response = $this->vlogService->deleteVlogItem($id);

        if (! $response) {
            return $this->response(true, 'Vlog item not found', 404);
        }

        return $this->response(true, 'Vlog item deleted', 200);
    }
}
