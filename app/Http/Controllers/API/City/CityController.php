<?php

namespace App\Http\Controllers\API\City;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\City\CityRequest;
use App\Models\City;
use App\Services\City\CityService;
use Illuminate\Http\JsonResponse;

class CityController extends BaseController
{
    public function index(): JsonResponse
    {
        $cities = CityService::getCities();

        return $this->success($cities->toArray(), 'Villes récupérées avec succès.');
    }

    public function store(CityRequest $request): JsonResponse
    {
        $city = CityService::createCity($request->validated());

        return $this->success($city->toArray(), 'Ville créé avec succès.');
    }

    public function show(City $city): JsonResponse
    {
        return $this->success($city->toArray(), 'Ville récupérée avec succès.');
    }

    public function update(CityRequest $request, City $city): JsonResponse
    {
        $city = CityService::updateCity($city, $request->validated());

        return $this->success($city->toArray(), 'Ville mise à jour avec succès.');
    }

    public function destroy(City $city): JsonResponse
    {
        $city->delete();

        return $this->success([], 'Ville supprimée avec succès.');
    }
}
