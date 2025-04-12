<?php

namespace Database\Factories;

use App\Models\Worker;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->firstName(),
            'second_name' => fake()->firstName(),
            'surname' => fake()->lastName(),
            'phone' => fake()->unique()->phoneNumber(),
        ];
    }
}
