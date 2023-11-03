<?php

namespace Database\Factories;

use App\Models\Learner;
use App\Models\Mode;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Learner>
 */
class LearnerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => UserFactory::new(),
            'mode_id' => Mode::all()->random()->id,
        ];
    }
}
