<?php

namespace Tests\Feature\Addresses;

use Tests\TestCase;
use App\Models\Street;
use App\Models\Location;
use Illuminate\Testing\Fluent\AssertableJson;

class StreetTest extends TestCase
{
    protected $data;
    protected $jsonStructure;

    protected function setUp(): void
    {
        parent::setUp();

        $this->signIn();

        //Create address

        $this->data = [
            "name" => fake()->streetName(),
            "location_id" => Location::factory()->create()->id,
        ];

        $this->jsonStructure =  [
            "id",
            "location",
            "name",
        ];
    }

    public function test_list_street()
    {
        Street::factory()->create($this->data);
        $response = $this->getJson(route("streets.index"));
        $response->assertOk();
        $response->assertJsonCount(1, "data");
    }

    public function test_show_street()
    {
        $street = Street::factory()->create($this->data);
        $response = $this->getJson(route("streets.show", $street->id));
        $response->assertOk();
        $response->assertJsonStructure([
            "data" => $this->jsonStructure,
        ]);
    }

    public function test_filter_street()
    {
        Street::factory()->create($this->data);
        $name = fake()->streetAddress();
        Street::factory()->create(["location_id" => Location::factory()->create()->id, "name" => $name]);
        $response = $this->getJson(route("streets.index", ["name" => $name]));
        $response->assertOk();
        $response->assertJsonCount(1, "data");
    }

    public function test_create_street()
    {
        $response = $this->postJson(route("streets.store"), $this->data);
        $response->assertCreated();
        $response->assertJsonStructure([
            "data" => $this->jsonStructure,

        ]);

        $response->assertJson(
            fn(AssertableJson $json) =>
            $json->where("data.name", $this->data["name"])
                ->where("data.location.id", $this->data["location_id"])
        );
    }

    public function test_update_street()
    {
        $street = Street::factory()->create(["location_id" => $this->data["location_id"]]);
        $this->data["name"] = "New name";

        $response = $this->putJson(route("streets.update", $street->id), $this->data);
        $response->assertOk();
        $response->assertJson(
            fn(AssertableJson $json) =>
            $json->where("data.name", "New name")
        );
    }

    public function test_failed_create_street()
    {
        $response = $this->postJson(route("streets.store"), []);
        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(["name"]);
    }

    public function test_delete_street()
    {
        $street = Street::factory()->create(["location_id" => $this->data["location_id"]]);
        $response = $this->delete(route("streets.destroy", $street->id));
        $response->assertOk();
        $this->assertDatabaseMissing(Street::class, [["id" => $street->id]]);
    }
}
