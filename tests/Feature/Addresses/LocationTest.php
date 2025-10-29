<?php

namespace Tests\Feature\Addresses;

use Tests\TestCase;
use App\Models\location;
use Illuminate\Testing\Fluent\AssertableJson;

class LocationTest extends TestCase
{
    protected $location;

    protected function setUp(): void
    {
        parent::setUp();
        $this->signIn();
        $this->location  = ["name" => fake()->city()];
    }

    public function test_list_location()
    {
        Location::factory()->create();
        $response = $this->getJson(route("locations.index"));
        $response->assertOk();
        $response->assertJsonCount(1, "data");
    }

    public function test_show_location()
    {
        $location = Location::factory()->create($this->location);
        $response = $this->getJson(route("locations.show", $location->id));
        $response->assertOk();
        $response->assertJsonStructure([
            "data" => ["id", "name"],
        ]);
    }

    public function test_create_location()
    {
        $response = $this->postJson(route("locations.store"), $this->location);
        $response->assertCreated();
        $response->assertJsonStructure([
            "data" =>
            [
                "id",
                "name",
            ],
        ]);

        $response->assertJson(
            fn(AssertableJson $json) =>
            $json->where("data.name", $this->location["name"])
        );
    }

    public function test_update_location()
    {
        $location = location::factory()->create();

        $response = $this->putJson(route("locations.update", $location->id), ["name" => "New name"]);
        $response->assertOk();
        $response->assertJson(
            fn(AssertableJson $json) =>
            $json->where("data.name", "New name")
        );
    }

    public function test_failed_create_location()
    {
        $response = $this->postJson(route("locations.store"), []);
        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(["name"]);
    }

    public function test_delete_location()
    {
        $location = location::factory()->create();
        $response = $this->delete(route("locations.destroy", $location->id));
        $response->assertOk();
        $this->assertDatabaseMissing(Location::class, ["id" => $location->id]);
    }
}
