<?php

namespace Tests\Feature\User;

use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{

    public function test_success_login()
    {
        $user = User::factory()
            ->createOne(['active' => true]);
        $payload = [
            'email' => $user->email,
            'password' => 'password',
        ];

        $response = $this->postJson(route('api.login'), $payload);
        $response->assertOk();
        $response->assertJsonStructure(['token']);
    }

    public function test_failed_payload_login()
    {
        $response = $this->postJson(route('api.login'), []);
        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(["email", "password"]);
    }

    public function test_failed_wrong_user_login()
    {
        $response = $this->postJson(route('api.login'), ['email' => fake()->email(), 'password' => '000000']);
        $response->assertUnauthorized();
    }

    public function test_get_route_without_auth()
    {
        $response = $this->getJson(route("issues.index"));
        $response->assertUnauthorized();
    }

    public function test_inactive_user_login()
    {
        $user = User::factory()
            ->createOne(['active' => false]);

        $payload = [
            'email' => $user->email,
            'password' => 'password',
        ];

        $response = $this->postJson(route('api.login'), $payload);
        $response->assertForbidden();
    }
}
