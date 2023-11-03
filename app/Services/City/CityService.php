<?php

namespace App\Services\City;

use App\Models\City;
use Illuminate\Support\Collection;

class CityService
{
    /**
     * Récupérer la liste des villes
     *
     * @return Collection
     */
    public static function getCities(): Collection
    {
        return City::orderBy('postcode')
            ->orderBy('name')
            ->get();
    }

    /**
     * Récupérer une ville par son ID
     *
     * @param int $id
     * @return City
     */
    public static function findCityById(int $id): City
    {
        return City::findOrFail($id);
    }

    /**
     * Enregistrer une nouvelle ville
     * @param array $data
     * @return City
     */
    public static function createCity(array $data): City
    {
        return City::create($data);
    }

    /**
     * Mettre à jour les informations d'une ville
     *
     * @param City $city
     * @param array $data
     * @return City
     */
    public static function updateCity(City $city, array $data): City
    {
        $city->update($data);

        return $city;
    }
}
