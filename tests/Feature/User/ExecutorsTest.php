<?php

namespace Tests\Feature\User;

use Tests\TestCase;
use App\Models\User;

class ExecutorsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->signIn();
    }

    public function test_list_executors()
    {
        User::factory(5)
            ->create(['active' => true, 'executor' => true]);
        $response = $this->getJson(route("executors.active"));
        $response->assertOk();
        $response->assertJsonCount(5, "data");
    }
}
