<?php

namespace Database\Seeders;

use App\Models\Conversation;
use App\Models\Teacher;
use App\Services\AdministrativeEmployee\AdministrativeEmployeeService;
use Illuminate\Database\Seeder;

class ConversationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teacher = Teacher::inRandomOrder()->first()->user_id;
        $admins = AdministrativeEmployeeService::getAllAdministrativeEmployeeId();
        $all = $admins->merge(collect($teacher));

        Conversation::factory()
            ->count(10)
            ->create()
            ->each(function ($conversation) use ($all) {
                $conversation->members()->sync($all);
            });
    }
}
