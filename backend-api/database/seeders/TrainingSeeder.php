<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TrainingSeeder extends Seeder
{
    /**
     * Seed the trainings table.
     *
     * @return void
     */
    public function run()
    {

        $userIds = \App\Models\User::pluck('id')->toArray();
        $adminUserIds = User::where('is_admin', true)->pluck('id')->toArray();

        if (empty($adminUserIds)) {
            $this->command->error('No admin users found. Please create admin users before running this seeder.');
            return;
        }

        foreach (range(1, 10) as $index) {
            DB::table('trainings')->insert([
                'title' => 'Training ' . $index,
                'description' => 'Description for training ' . $index,
                'start_date' => now()->format('Y-m-d'),
                'end_date' => now()->addDays($index + 5)->format('Y-m-d'),
                'user_id' => $adminUserIds[array_rand($adminUserIds)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
