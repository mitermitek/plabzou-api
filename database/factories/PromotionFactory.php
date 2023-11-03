<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Course;
use App\Models\Promotion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Promotion>
 */
class PromotionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startAt = $this->faker->dateTimeBetween('-1 year', '+1 year');
        $endAt = $this->faker->dateTimeBetween($startAt, '+1 year');

        return [
            'name' => $this->faker->name,
            'starts_at' => $startAt->format('Y-m-d'),
            'ends_at' => $endAt->format('Y-m-d'),
            'course_id' => Course::all()->random()->id,
            'city_id' => City::all()->random()->id,
        ];
    }
}
