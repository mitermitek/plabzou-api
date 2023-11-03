<?php

namespace Database\Seeders;

use App\Models\Mode;
use Illuminate\Database\Seeder;

class ModeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Mode::insert([
            ['name' => 'Présentiel', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Distanciel', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mixte', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
