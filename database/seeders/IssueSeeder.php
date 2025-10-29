<?php

namespace Database\Seeders;

use App\Models\Issue;
use App\Models\IssueComment;
use App\Models\Phone;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class IssueSeeder extends Seeder
{
    public function run(): void
    {
        Tag::factory(5)->create();

        Issue::factory(30)
            ->has(Phone::factory(rand(1, 2)))
            ->has(IssueComment::factory(rand(1, 3)))->createQuietly([
                'user_id' => User::inRandomOrder()->first()->id,
            ]);
        $issues = Issue::all();
        foreach ($issues as $issue) {
            $issue->tags()->saveQuietly(Tag::inRandomOrder()->first());
            $issue->executors()->saveQuietly(User::inRandomOrder()->first());
        }
    }
}
