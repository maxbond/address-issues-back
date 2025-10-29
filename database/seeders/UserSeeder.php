<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Executor;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{

    public function run(): void
    {
        User::factory(10)->create();
    }
}
