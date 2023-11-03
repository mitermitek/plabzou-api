<?php

namespace App\Services\Promotion;

use App\Models\Promotion;
use App\Services\City\CityService;
use App\Services\Course\CourseService;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PromotionService
{
    /**
     * Récupérer la liste des promotions
     *
     * @param array $parameters
     * @return Collection
     */
    public static function getPromotions(array $parameters): Collection
    {
        $query = Promotion::with(['course', 'learners', 'city'])
            ->orderByDesc('starts_at')
            ->orderByDesc('ends_at');

        if (array_key_exists('training', $parameters)) {
            $query->whereHas('course.trainings', function (Builder $query) use ($parameters) {
                $query->where('training_id', $parameters['training']);
            });
        }

        // eager load pour optimiser
        if (array_key_exists('advancement', $parameters) && $parameters['advancement']) {
            $query->with(['course.trainings', 'timeslots']);
        }

        $promotions = $query->get();

        if (array_key_exists('advancement', $parameters) && $parameters['advancement']) {
            foreach ($promotions as $promotion) self::calculatePromotionAdvancement($promotion);
        }

        return $promotions;
    }

    public static function calculatePromotionAdvancement(Promotion $promotion)
    {
        // clone pour éviter d'avoir un problème de réutilisation des trainings quand la méthode est appelé dans un foreach
        $course = clone $promotion->course;
        $course->trainings = collect();
        foreach ($promotion->course->trainings as $training) $course->trainings->push(clone $training);
        $promotion->course = $course;

        // sur chaque formation du cursus, on va regarder les créneaux qui correspondent et ajouter le temps passé dessus à la formation
        foreach ($promotion->timeslots as $timeslot) {
            // on regarde que les créneaux qui correspondent à une formation du cursus
            $training = $promotion->course->trainings->first(fn($t) => $t->id === $timeslot->training_id);

            if ($training) {
                $start = Carbon::parse($timeslot->starts_at);
                $end = Carbon::parse($timeslot->ends_at);
                $diffInMinutes = $end->diffInMinutes($start);

                $training->advancement = $training->advancement ? $training->advancement + $diffInMinutes : $diffInMinutes;
            }
        }

        // calcul de l'avancement global de la promotion dans le cursus et du pourcentage d'avancement pour chaque formation
        $courseDuration = 0;
        $promotionAdvancement = 0;
        foreach ($promotion->course->trainings as $training) {
            $courseDuration += $training->duration;

            $training->percentage = round(($training->advancement / $training->duration) * 100);
            if ($training->percentage >= 100) {
                $promotionAdvancement += $training->duration;
                $training->percentage = 100;
            } else {
                $promotionAdvancement += $training->advancement;
                $training->remaining = $training->duration - $training->advancement;
            }
        }

        $promotion->remaining = $courseDuration - $promotionAdvancement;
        $promotion->duration = $courseDuration;
        $promotion->trainings = $promotion->course->trainings;
        $promotion->percentage = $courseDuration !== 0 ? round(($promotionAdvancement / $courseDuration) * 100) : 0;
    }

    /**
     * Enregistre une nouvelle promotion
     *
     * @param array $data
     * @return Promotion
     * @throws Exception
     */
    public static function createPromotion(array $data): Promotion
    {
        DB::beginTransaction();
        try {
            $promotion = Promotion::create(self::formatPromotionData($data));

            $course = CourseService::findCourseById($data['course']);
            // Définition du cursus suivi
            $promotion->course()->associate($course);

            if ($data['city']) {
                $city = CityService::findCityById($data['city']);
                // Définition de la ville de rattachement de la promotion
                $promotion->city()->associate($city);
            }

            if ($data['learners']) {
                // Association des apprenants à la promotion
                $promotion->learners()->attach(Collection::make($data['learners'])->pluck('user_id'));
            }
            $promotion->save();
            DB::commit();

            return $promotion;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Formater les données de la promotion
     *
     * @param array $data
     * @return array
     */
    private static function formatPromotionData(array $data): array
    {
        $formattedData = [
            'name' => $data['name'],
            'starts_at' => $data['starts_at'],
            'ends_at' => $data['ends_at'],
            'course_id' => $data['course'],
        ];

        if ($data['city']) $formattedData['city_id'] = $data['city'];

        return $formattedData;
    }

    /**
     * Mettre à jour les informations d'une promotion
     *
     * @param Promotion $promotion
     * @param array $data
     * @return Promotion
     * @throws Exception
     */
    public static function updatePromotion(Promotion $promotion, array $data): Promotion
    {
        DB::beginTransaction();
        try {
            $promotion = $promotion->fill(self::formatPromotionData($data));

            $course = CourseService::findCourseById($data['course']);
            if ($promotion->course <> $course) {
                // Définition du cursus suivi
                $promotion->course()->dissociate();
                $promotion->course()->associate($course);
            }

            if ($data['city']) {
                // Définition de la ville de rattachement de la promotion
                $city = CityService::findCityById($data['city']);
                if ($promotion->city <> $city) {
                    $promotion->city()->dissociate();
                }
                $promotion->city()->associate($city);
            } else {
                $promotion->city()->dissociate();
            }

            if ($data['learners']) {
                // Association des apprenants à la promotion
                $promotion->learners()->sync(Collection::make($data['learners'])->pluck('user_id'));
            } else {
                $promotion->learners()->detach();
            }
            $promotion->save();
            DB::commit();

            return $promotion;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Suppression d'une promotion
     *
     * @param Promotion $promotion
     * @return void
     */
    public static function deletePromotion(Promotion $promotion): void
    {
        $promotion->learnerPromotion()->delete();
        $promotion->delete();
    }
}
