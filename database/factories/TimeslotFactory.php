<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\Timeslot;
use App\Models\Training;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Timeslot>
 */
class TimeslotFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('now', '+30 days');

        $roundedStartHour = round($startDate->format('H'));
        $startDate->setTime($roundedStartHour, 0);

        $duration = $this->faker->randomElement([10, 30, 60, 90, 120, 180]);

        $endDate = clone $startDate;
        $endDate->modify('+' . $duration . ' minutes');

        return [
            'training_id' => Training::inRandomOrder()->first()->id,
            'room_id' => Room::inRandomOrder()->first()->id,
            'starts_at' => $startDate,
            'ends_at' => $endDate,
            'is_validated' => $this->faker->boolean(),
        ];
    }
}
