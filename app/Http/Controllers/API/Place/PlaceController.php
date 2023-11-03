<?php

namespace App\Http\Controllers\API\Place;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\Place\PlaceRequest;
use App\Models\Place;
use App\Services\Place\PlaceService;
use Illuminate\Http\JsonResponse;

class PlaceController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $places = PlaceService::getPlaces();

        return $this->success($places->toArray(), 'Lieux récupérées avec succès.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PlaceRequest $request)
    {
        $place = PlaceService::createPlace($request->validated());

        return $this->success($place->toArray(), 'Lieu créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Place $place)
    {
        $place->load(['buildings']);
        return $this->success($place->toArray(), 'Lieu récupéré avec succès.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PlaceRequest $request, Place $place)
    {
        $place = PlaceService::updatePlace($place, $request->validated());

        return $this->success($place->toArray(), 'Lieu mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Place $place)
    {
        $place->delete();

        return $this->success([], 'Lieu supprimé avec succès.');
    }
}
