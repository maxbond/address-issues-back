<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    public function definition(): array
    {
        return [
            'house' => fake()->numberBetween(1, 20),
            'flat' => fake()->numberBetween(1, 100),
            'floor' => fake()->numberBetween(1, 16),
            'entrance' => fake()->numberBetween(1, 10),
            'entrance_is_locked' => fake()->boolean(),
            'has_gate' => fake()->boolean(),
            'comment' => fake()->realTextBetween(20, 100),
        ];
    }
}
