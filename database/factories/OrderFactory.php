<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => User::factory(),
            'service_id' => Service::factory(),
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected', 'completed']),
            'notes' => $this->faker->optional()->paragraph(),
        ];
    }
}
