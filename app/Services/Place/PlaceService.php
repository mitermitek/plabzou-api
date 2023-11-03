<?php

namespace App\Services\Place;

use App\Models\Place;
use Illuminate\Database\Eloquent\Collection;

class PlaceService
{
    public static function getPlaces(): Collection
    {
        return Place::with(['buildings'])->get();
    }

    public static function createPlace(array $data): Place
    {
        return Place::create($data);
    }

    public static function findPlaceById(int $id): Place
    {
        return Place::with(['buildings'])->findOrFail($id);
    }

    public static function updatePlace(Place $place, array $data): Place
    {
        $place->update($data);
        return $place;
    }

    public static function deletePlace(Place $place): void
    {
        $place->delete();
    }
}
