<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Settings::updateOrCreate(
            ['key' => 'free_user_max_likes'],
            ['value' => 10] // Default value
        );
    }

}
