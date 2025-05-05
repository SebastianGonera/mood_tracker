<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Mood;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 users and for each user create 5 moods
        // using the User and Mood factories.
        User::factory(10)
            ->create()
            ->each(
                function ($user) {
                    Mood::factory(5)->create(['user_id' => $user->id]);
                }
            );
    }
}
