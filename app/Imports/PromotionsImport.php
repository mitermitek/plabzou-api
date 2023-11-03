<?php

namespace App\Imports;

use App\Models\City;
use App\Models\Course;
use App\Models\Promotion;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class PromotionsImport implements ToCollection, WithHeadingRow
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

            $course = Course::firstOrCreate([
                'name' => $row['cursus']
            ]);

            Promotion::create([
                'course_id' => $course->id,
                'city_id' => $city->id,
                'starts_at' => Date::excelToDateTimeObject($row['date_debut']),
                'ends_at' => Date::excelToDateTimeObject($row['date_fin']),
                'name' => $row['promotion']
            ]);
        }
    }
}
