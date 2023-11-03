<?php

namespace Database\Factories;

use App\Enums\StatusEnum;
use App\Models\AdministrativeEmployee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AdministrativeEmployee>
 */
class AdministrativeEmployeeFactory extends Factory
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
            'is_super_admin' => $this->faker->boolean(),
        ];
    }
}
