<?php

namespace Database\Seeders;

use App\Models\Learner;
use App\Models\Promotion;
use App\Models\Teacher;
use App\Models\Timeslot;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Seeder;

class TimeslotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Timeslot::factory()->count(200)->create()->each(function (Timeslot $timeslot) {
            $teachers = Teacher::whereRelation('trainings', 'trainings.id', '=', $timeslot->training_id)
                ->inRandomOrder()->limit(rand(1, 10))
                ->get();

            $timeslot->teachers()->attach($teachers->random(rand(1, $teachers->count())));

            $promotions = Promotion::inRandomOrder()->limit(rand(1, 2))->get();

            $timeslot->promotions()->attach($promotions);

            $learners = Learner::with(['promotions.course.trainings'])
                ->whereHas('promotions', function (Builder $query) use ($promotions) {
                    $query->whereIn('promotion_id', $promotions->pluck('id'));
                })
                ->whereHas('promotions.course.trainings', function (Builder $query) use ($timeslot) {
                    $query->where('training_id', $timeslot->training_id);
                })->inRandomOrder()->limit(rand(1, 5))->get();

            $timeslot->learners()->attach($learners);
        });
    }
}
