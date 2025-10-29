<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    protected User $user;

    protected function signIn(): void
    {
        Event::fake();

        $this->user = User::factory()
            ->createOne(['active' => true, 'executor' => false, 'admin' => true]);

        Sanctum::actingAs($this->user);
    }
}
