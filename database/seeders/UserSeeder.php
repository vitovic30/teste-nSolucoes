<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'carlos',
            'email' => 'carlos@example.com',
            'password' =>  bcrypt("1234"),
        ])->assignRole('user');

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' =>  bcrypt("1234"),
        ])->assignRole('admin');
    }
}
