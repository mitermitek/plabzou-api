<?php

namespace Database\Seeders;

use App\Models\AdministrativeEmployee;
use App\Models\Learner;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AdministrativeEmployee::factory()->count(10)->create();
        Teacher::factory()->count(30)->create();
        Learner::factory()->count(50)->create();
    }
}
