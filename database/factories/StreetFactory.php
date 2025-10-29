<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StreetFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->streetName(),
        ];
    }
}
