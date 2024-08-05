<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
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
            'name' => 'Admin (Gestor)',
            'login' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin'),
            'is_admin' => true,
        ]);

        User::create([
            'name' => 'Joao Silva',
            'login' => 'joao',
            'email' => $faker->unique()->safeEmail(),
            'password' => Hash::make('joao'),
            'is_admin' => false,
        ]);
    }
}
