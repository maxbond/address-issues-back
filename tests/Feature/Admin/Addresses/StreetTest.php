<?php

namespace Tests\Feature\Admin\Addresses;

use Tests\TestCase;
use App\Models\Street;
use App\Models\Location;

class StreetTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->signIn();

        //Create address
        Location::factory(1)->has(Street::factory(1))->create();
    }

    public function test_list_streets()
    {
        $response = $this->getJson(route("admin.streets.index"));
        $response->assertOk();
    }

    public function test_create_form_street()
    {
        $response = $this->get(route('admin.streets.create'));
        $response->assertOk();
    }


    public function test_create_street()
    {
        $response = $this->post(route('admin.streets.store'), ['location_id' => 1, 'name' => 'ABCDE']);
        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas(Street::class, ['name' => 'ABCDE']);
    }

    public function test_edit_form_street()
    {
        $response = $this->get(route('admin.streets.edit', 1));
        $response->assertOk();
    }


    public function test_update_street()
    {
        $street = Street::factory()->create(['location_id' => 1]);
        $response = $this->put(route('admin.streets.update', $street->id), ['name' => 'QWERTY', 'location_id' => 1]);
        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas(Street::class, ['name' => 'QWERTY']);
    }

    public function test_delete_street()
    {
        $street = Street::factory()->create(['location_id' => 1]);
        $response = $this->delete(route('admin.streets.destroy', $street->id));
        $response->assertRedirect();
        $this->assertDatabaseMissing(Street::class, ['id' => $street->id]);
    }
}
