<?php

namespace App\Imports;

use App\Models\Learner;
use App\Models\Mode;
use App\Models\Promotion;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LearnersImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows): void
    {
        foreach ($rows as $row) {
            $user = User::create([
                'last_name' => $row['nom'],
                'first_name' => $row['prenom'],
                'phone_number' => $row['telephone'],
                'email' => $row['email'],
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' // password
            ]);

            $promotion = Promotion::where(['name' => $row['promotion']])->first();

            $mode = Mode::firstOrCreate(['name' => $row['mode_de_formation']]);

            $learner = Learner::create([
                'user_id' => $user->id,
                'mode_id' => $mode->id,
            ]);

            $learner->promotions()->attach($promotion->id);

        }
    }
}
