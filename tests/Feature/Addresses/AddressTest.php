<?php

namespace Tests\Feature\Addresses;

use Tests\TestCase;
use App\Models\Address;
use App\Models\Street;
use App\Models\Location;
use Illuminate\Testing\Fluent\AssertableJson;

class AddressTest extends TestCase
{
    protected $data;
    protected $jsonStructure;

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

        $this->jsonStructure = [
            "id",
            "house",
            "flat",
            "floor",
            "entrance",
            "entrance_is_locked",
            "has_gate",
            "comment",
        ];
    }

    public function test_list_address()
    {
        $response = $this->getJson(route("addresses.index"));
        $response->assertOk();
        $response->assertJsonCount(1, "data");
    }

    public function test_show_address()
    {
        $address = Address::factory()->create(['street_id' => 1]);
        $response = $this->getJson(route("addresses.show", $address->id));
        $response->assertOk();
        $response->assertJsonStructure([
            "data" => $this->jsonStructure,
        ]);
    }

    public function test_filter_address()
    {
        Address::factory()->create(['street_id' => 1]);
        Address::factory()->create(['street_id' => 1, 'house' => '1B']);
        $response = $this->getJson(route("addresses.index", ["house" => '1B']));
        $response->assertOk();
        $response->assertJsonCount(1, "data");
    }

    public function test_create_address()
    {
        $response = $this->postJson(route("addresses.store"), $this->data);
        $response->assertCreated();
        $response->assertJsonStructure([
            "data" => $this->jsonStructure,
        ]);

        $response->assertJson(
            fn(AssertableJson $json) =>
            $json->where("data.street.id", 1)
                ->where("data.flat", $this->data["flat"])
                ->where("data.floor", $this->data["floor"])
                ->where("data.entrance", $this->data["entrance"])
                ->where("data.entrance_is_locked", $this->data["entrance_is_locked"])
                ->where("data.has_gate", $this->data["has_gate"])
                ->where("data.comment", $this->data["comment"])
        );
    }

    public function test_update_address()
    {
        $address = Address::factory()->create(['street_id' => 1]);
        $this->data["flat"] = "32B";
        $this->data["floor"] = 2;

        $response = $this->putJson(route("addresses.update", $address->id), $this->data);
        $response->assertOk();
        $response->assertJson(
            fn(AssertableJson $json) =>
            $json->where("data.street.id", 1)
                ->where("data.flat", "32B")
                ->where("data.floor", 2)
        );
    }

    public function test_failed_create_address()
    {
        $response = $this->postJson(route("addresses.store"), []);
        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(["street_id"]);
    }

    public function test_delete_address()
    {
        $address = Address::factory()->create(['street_id' => 1]);
        $response = $this->delete(route("addresses.destroy", $address->id));
        $response->assertOk();
        $this->assertDatabaseMissing(Address::class, [["id" => $address->id]]);
    }
}
