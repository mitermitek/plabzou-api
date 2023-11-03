<?php

namespace App\Services\Training;

use App\Models\Training;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TrainingService
{
    /**
     * Récupérer la liste des formations
     *
     * @return Collection
     */
    public static function getTrainings(): Collection
    {
        return Training::with('categories')->get();
    }

    /**
     * Enregistrer une nouvelle formation
     *
     * @param array $data
     * @return Training
     * @throws Exception
     */
    public static function createTraining(array $data): Training
    {
        DB::beginTransaction();
        try {
            $training = Training::create($data);

            $training->categories()->attach(array_map(fn($category) => $category['id'], $data['categories']));

            $training->courses()->attach(array_map(fn($course) => $course['id'], $data['courses']));

            $training->teachers()->attach(array_map(fn($teacher) => $teacher['user_id'], $data['teachers']));

            DB::commit();

            return $training;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Mettre à jour les informations d'une formation
     *
     * @param Training $training
     * @param array $data
     * @return Training
     * @throws Exception
     */
    public static function updateTraining(Training $training, array $data): Training
    {
        DB::beginTransaction();
        try {
            $training->update($data);

            $training->categories()->sync(array_map(fn($category) => $category['id'], $data['categories']));

            $training->courses()->sync(array_map(fn($course) => $course['id'], $data['courses']));

            $training->teachers()->sync(array_map(fn($teacher) => $teacher['user_id'], $data['teachers']));

            DB::commit();

            return $training;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
