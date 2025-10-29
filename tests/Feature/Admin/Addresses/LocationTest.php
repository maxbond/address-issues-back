<?php

namespace Tests\Feature\Admin\Addresses;

use Tests\TestCase;
use App\Models\Location;

class LocationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->signIn();

        //Create address
        Location::factory(1)->create();
    }

    public function test_list_locations()
    {
        $response = $this->getJson(route("admin.locations.index"));
        $response->assertOk();
    }

    public function test_create_form_location()
    {
        $response = $this->get(route('admin.locations.create'));
        $response->assertOk();
    }


    public function test_create_location()
    {
        $response = $this->post(route('admin.locations.store'), ['name' => 'ABCDE']);
        $response->assertRedirect();
        $this->assertDatabaseHas(Location::class, ['name' => 'ABCDE']);
    }

    public function test_edit_form_location()
    {
        $response = $this->get(route('admin.locations.edit', 1));
        $response->assertOk();
    }


    public function test_update_location()
    {
        $location = Location::factory()->create();
        $response = $this->put(route('admin.locations.update', $location->id), ['name' => 'QWERTY']);
        $response->assertRedirect();
        $this->assertDatabaseHas(Location::class, ['name' => 'QWERTY']);
    }

    public function test_delete_location()
    {
        $location = Location::factory()->create();
        $response = $this->delete(route('admin.locations.destroy', $location->id));
        $response->assertRedirect();
        $this->assertDatabaseMissing(Location::class, ['id' => $location->id]);
    }
}
