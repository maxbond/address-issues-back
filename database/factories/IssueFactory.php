<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\IssuePriority;
use App\Enums\IssueStatus;
use App\Models\Address;

class IssueFactory extends Factory
{
    public function definition(): array
    {
        $date = now();
        $date2 = ($date->copy())->addDay();
        return [
            'address_id' => (Address::inRandomOrder()->first())->id,
            'title' => fake()->sentence(),
            'description' => fake()->realTextBetween(50, 200),
            'status' => fake()->randomElement([
                IssueStatus::Open,
                IssueStatus::Done,
                IssueStatus::InProgress,
                IssueStatus::Canceled,
            ]),
            'priority' => fake()->randomElement([
                IssuePriority::Low,
                IssuePriority::Default,
                IssuePriority::High,
                IssuePriority::Immediately,
            ]),
            'time_period_from' => $date,
            'time_period_to' => $date2,
        ];
    }
}
