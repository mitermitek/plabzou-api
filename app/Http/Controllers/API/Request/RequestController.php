<?php

namespace App\Http\Controllers\API\Request;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\Request\RequestRequest;
use App\Models\Request;
use App\Services\Request\RequestService;
use Illuminate\Http\JsonResponse;
use InvalidArgumentException;

class RequestController extends BaseController
{
    public function index(): JsonResponse
    {
        $requests = RequestService::getRequestsWithRelations();

        return $this->success($requests->toArray(), "Demandes recupérées avec succès.");
    }

    public function store(RequestRequest $request): JsonResponse
    {
        try {
            $course = RequestService::createRequest($request->validated());
        } catch (InvalidArgumentException $e) {
            return $this->error($e->getMessage(), 422);
        }
        return $this->success($course->toArray(), 'Demande créée avec succès.');
    }

    public function show(Request $request): JsonResponse
    {
        $request->load('teacher', 'timeslot.training', 'administrativeEmployee');

        return $this->success($request->toArray(), 'Demande récupérée avec succès.');
    }

    public function update(RequestRequest $requestRequest, Request $request): JsonResponse
    {
        try {
            $request = RequestService::updateRequest($request, $requestRequest->validated());
        } catch (InvalidArgumentException $e) {
            return $this->error($e->getMessage(), 422);
        }
        return $this->success($request->toArray(), 'Demande mise à jour avec succès.');
    }

    public function destroy(Request $request): JsonResponse
    {
        RequestService::deleteRequest($request);

        return $this->success([], 'Demande annulée avec succès.');
    }
}
