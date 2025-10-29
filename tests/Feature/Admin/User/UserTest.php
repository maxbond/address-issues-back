<?php

namespace Tests\Feature\Admin\User;

use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    protected $data;

    protected function setUp(): void
    {
        parent::setUp();

        $this->signIn();

        User::factory()->create();
        $this->data = [
            'email' => fake()->email(),
            'name' => 'ABCDE',
            'password' => 'password',
            'password_confirmation' => 'password',
            'active' => fake()->boolean(),
            'executor' => fake()->boolean(),
            'admin' => fake()->boolean(),
        ];
    }

    public function test_list_users()
    {
        $response = $this->getJson(route("admin.users.index"));
        $response->assertOk();
    }

    public function test_create_form_user()
    {
        $response = $this->get(route('admin.users.create'));
        $response->assertOk();
    }


    public function test_create_user()
    {
        $response = $this->post(route('admin.users.store'), $this->data);
        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas(User::class, ['name' => 'ABCDE']);
    }

    public function test_edit_form_user()
    {
        $response = $this->get(route('admin.users.edit', 1));
        $response->assertOk();
    }

    public function test_update_user()
    {
        $user = User::factory()->create();
        $this->data['name'] = 'QWERTY';
        $response = $this->put(route('admin.users.update', $user->id), $this->data);
        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas(User::class, ['name' => 'QWERTY']);
    }

    public function test_delete_user()
    {
        $user = User::factory()->create();
        $response = $this->delete(route('admin.users.destroy', $user->id));
        $response->assertRedirect();
        $this->assertDatabaseMissing(User::class, [['id' => $user->id]]);
    }
}
