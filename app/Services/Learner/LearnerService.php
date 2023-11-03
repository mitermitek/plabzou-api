<?php

namespace App\Services\Learner;

use App\Models\Learner;
use App\Models\Mode;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class LearnerService
{
    /**
     * Récupérer les modes de suivi des formations par les apprenants
     *
     * @return Collection
     */
    public static function getLearnerModes(): Collection
    {
        return Mode::all();
    }

    /**
     * Récupérer la liste des apprenants
     *
     * @param array $parameters
     * @return Collection
     */
    public static function getLearners(array $parameters): Collection
    {
        $query = Learner::query();

        if (array_key_exists('training', $parameters)) {
            $query->whereHas('promotions.course.trainings', function (Builder $query) use ($parameters) {
                $query->where('training_id', $parameters['training']);
            });
        }

        return $query->get();
    }
}
