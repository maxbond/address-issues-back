<?php

namespace Tests\Feature\Admin\Addresses;

use Tests\TestCase;
use App\Models\Address;
use App\Models\Street;
use App\Models\Location;

class AddressTest extends TestCase
{
    protected $data;

    protected function setUp(): void
    {
        parent::setUp();

        $this->signIn();

        //Create address
        Location::factory(1)->has(
            Street::factory(1)->has(Address::factory(1))
        )->create();


        $this->data = [
            "street_id" => 1,
            'house' => (string) fake()->numberBetween(1, 20),
            "flat" => (string) fake()->numberBetween(1, 100),
            "floor" => fake()->numberBetween(1, 100),
            "entrance" => fake()->numberBetween(1, 10),
            "entrance_is_locked" => fake()->boolean(),
            "has_gate" => fake()->boolean(),
            "comment" => fake()->sentence(),
        ];
    }

    public function test_list_address()
    {
        $response = $this->getJson(route("admin.addresses.index"));
        $response->assertOk();
    }

    public function test_create_form_address()
    {
        $response = $this->get(route('admin.addresses.create'));
        $response->assertOk();
    }


    public function test_create_address()
    {
        $response = $this->post(route('admin.addresses.store'), $this->data);
        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas(Address::class, $this->data);
    }

    public function test_edit_form_address()
    {
        $response = $this->get(route('admin.addresses.edit', 1));
        $response->assertOk();
    }

    public function test_update_address()
    {
        $address = Address::factory()->create(['street_id' => 1]);
        $this->data['house'] = 'ABCDE';
        $response = $this->put(route('admin.addresses.update', $address->id), $this->data);
        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas(Address::class, ['house' => 'ABCDE']);
    }

    public function test_delete_address()
    {
        $address = Address::factory()->create(['street_id' => 1]);
        $response = $this->delete(route('admin.addresses.destroy', $address->id));
        $response->assertRedirect();
        $this->assertDatabaseMissing(Address::class, ['id' => $address->id]);
    }
}
