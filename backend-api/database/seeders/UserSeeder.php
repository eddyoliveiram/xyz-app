<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        User::create([
            'name' => 'Admin',
            'login' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin'),
            'is_admin' => true,
        ]);

        User::create([
            'name' => 'Admin 2',
            'login' => 'admin2',
            'email' => 'admin2@example.com',
            'password' => Hash::make('admin2'),
            'is_admin' => true,
        ]);

        User::create([
            'name' => 'Joao Silva',
            'login' => 'joao',
            'email' => 'joao@silva.com',
            'password' => Hash::make('123'),
            'is_admin' => false,
        ]);

        foreach (range(1, 9) as $index) {
            User::create([
                'name' => $faker->name(),
                'login' => $faker->unique()->userName(),
                'email' => $faker->unique()->safeEmail(),
                'password' => Hash::make('123'),
                'is_admin' => false,
            ]);
        }

    }
}
