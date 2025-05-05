<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mood>
 */
class MoodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Create a new user for each mood.
            'user_id' => User::factory(),
            'emoji' => $this->faker->randomElement(['😊', '😢', '😡', '😱', '😍']),
            'note' => $this->faker->sentence(),
            'rating' => $this->faker->numberBetween(1, 10)
        ];
    }
}
