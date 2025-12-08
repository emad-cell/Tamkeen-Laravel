<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'description' => $this->faker->paragraph(),
            'type' => $this->faker->word(),
            'size' => $this->faker->randomFloat(2, 1, 1000),
            'date' => $this->faker->date(),
            'price' => $this->faker->numberBetween(10, 10000),
            'location' => $this->faker->city(),
            'avilable' => $this->faker->boolean(),
        ];
    }
}
