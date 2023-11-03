<?php

namespace App\Imports;

use App\Models\Building;
use App\Models\City;
use App\Models\Place;
use App\Models\Room;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RoomsImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows): void
    {
        foreach ($rows as $row) {
            $city = City::firstOrCreate([
                'name' => $row['ville'],
                'postcode' => $row['code_postal']
            ]);

            $place = Place::firstOrCreate([
                'name' => $row['adresse'],
                'street_address' => $row['numero'],
                'city_id' => $city->id
            ]);

            $building = Building::firstOrCreate([
                'name' => $row['batiment'],
                'place_id' => $place->id
            ]);

            Room::create([
                'name' => $row['salle'],
                'seats_number' => $row['nombre_de_places'],
                'building_id' => $building->id
            ]);
        }
    }
}
