<?php

namespace App\Http\Controllers\API\Building;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\Building\BuildingRequest;
use App\Models\Building;
use App\Services\Building\BuildingService;
use Illuminate\Http\JsonResponse;

class BuildingController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $buildings = BuildingService::getBuildings();

        return $this->success($buildings->toArray(), 'Bâtiments récupérés avec succès.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BuildingRequest $request)
    {
        $building = BuildingService::createBuilding($request->validated());

        return $this->success($building->toArray(), 'Bâtiment créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Building $building)
    {
        return $this->success($building->toArray(), 'Bâtiment récupéré avec succès.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BuildingRequest $request, Building $building)
    {
        $building = BuildingService::updateBuilding($building, $request->validated());

        return $this->success($building->toArray(), 'Bâtiment mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Building $building)
    {
        $building->delete();

        return $this->success([], 'Bâtiment supprimé avec succès.');
    }
}
