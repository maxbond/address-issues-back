<?php

namespace Tests\Feature\Admin\User;

use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    protected $data;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_success_login()
    {
        $user = User::factory()->create([
            'admin' => true,
        ]);
        $response = $this->post(route('login'), ['email' => $user->email, 'password' => 'password']);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
    }

    public function test_failed_login()
    {
        $user = User::factory()->create();
        $response = $this->post(route('login'), ['email' => $user->email, 'password' => 'xxxxxxxxxx']);
        $response->assertSessionHasErrors();
        $response->assertRedirect();
    }

    public function test_permission_denied_to_inactive()
    {
        $user = User::factory()
            ->createOne(['active' => false, 'admin' => true]);
        $this->actingAs($user);
        $response = $this->get(route('admin.dashboard'));
        $response->assertForbidden();
    }

    public function test_permission_denied_to_nonadmin()
    {
        $user = User::factory()
            ->createOne(['active' => true, 'admin' => false]);
        $this->actingAs($user);
        $response = $this->get(route('admin.dashboard'));
        $response->assertForbidden();
    }
}
