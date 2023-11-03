<?php

namespace App\Services\Building;

use App\Models\Building;
use Illuminate\Support\Collection;

class BuildingService
{
    /**
     * @return Collection
     */
    public static function getBuildings(): Collection
    {
        return Building::all();
    }

    /**
     * @param array $data
     * @return Building
     */
    public static function createBuilding(array $data): Building
    {
        return Building::create($data);
    }

    /**
     * @param Building $building
     * @param array $data
     * @return Building
     */
    public static function updateBuilding(Building $building, array $data): Building
    {
        $building->update($data);

        return $building;
    }
}
