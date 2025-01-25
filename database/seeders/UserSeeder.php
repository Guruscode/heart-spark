<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        for ($i = 0; $i < 50; $i++) { // Update to create 50 users
            User::create([
                'name' => 'User ' . ($i + 1),
                'email' => strtolower(Str::random(10)) . '@example.com', // Use Str::random()
                'password' => bcrypt('password'), // Always hash passwords
                'profile_image' => ($i % 2 === 0) 
                    ? 'https://randomuser.me/api/portraits/men/' . rand(1, 100) . '.jpg' 
                    : 'https://randomuser.me/api/portraits/women/' . rand(1, 100) . '.jpg',
                'age' => rand(20, 35),
                'location' => 'City ' . ($i + 1),
            ]);
        }
    }
    
}
