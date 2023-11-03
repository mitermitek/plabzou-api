<?php

namespace App\Services\Teacher;

use App\Enums\StatusEnum;
use App\Models\Teacher;
use Illuminate\Support\Collection;

class TeacherService
{
    /**
     * Récupérer une liste de statuts que l'on peut associer aux formateurs
     *
     * @return array
     */
    public static function getTeacherStatuses(): array
    {
        return collect(StatusEnum::cases())->pluck('value')->toArray();
    }

    /**
     * Récupérer une liste de formateurs
     *
     * @param array $parameters
     * @return Collection
     */
    public static function getTeachers(array $parameters): Collection
    {
        $query = Teacher::query();

        if (array_key_exists('training', $parameters))
            $query->whereRelation('trainings', 'trainings.id', '=', $parameters['training']);

        return $query->with('requests')->get();
    }
}
