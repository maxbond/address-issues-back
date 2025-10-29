<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;

class IssueCommentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => (User::inRandomOrder()->first())->id,
            'comment' => fake()->realText(50),
        ];
    }
}
