<?php

namespace Tests\Feature\Tag;

use Tests\TestCase;
use App\Models\Tag;
use App\Models\Issue;
use App\Models\Street;
use App\Models\Location;
use App\Models\Address;
use Illuminate\Testing\Fluent\AssertableJson;

class TagTest extends TestCase
{

    protected $tag;

    protected function setUp(): void
    {
        parent::setUp();
        $this->signIn();
        $this->tag  = ["tag" => fake()->sentence()];
    }

    public function test_list_tag()
    {
        Tag::factory()->create();
        $response = $this->getJson(route("tags.index"));
        $response->assertOk();
        $response->assertJsonCount(1, "data");
    }

    public function test_show_tag()
    {
        $tag = Tag::factory()->create($this->tag);
        $response = $this->getJson(route("tags.show", $tag->id));
        $response->assertOk();
        $response->assertJsonStructure([
            "data" => ["id", "tag"],
        ]);
    }

    public function test_create_tag()
    {
        $response = $this->postJson(route("tags.store"), $this->tag);
        $response->assertCreated();
        $response->assertJsonStructure([
            "data" =>
            [
                "id",
                "tag",
            ],
        ]);

        $response->assertJson(
            fn(AssertableJson $json) =>
            $json->where("data.tag", $this->tag["tag"])
        );
    }

    public function test_update_tag()
    {
        $tag = Tag::factory()->create();

        $response = $this->putJson(route("tags.update", $tag->id), ["tag" => "New tag"]);
        $response->assertOk();
        $response->assertJson(
            fn(AssertableJson $json) =>
            $json->where("data.tag", "New tag")
        );
    }

    public function test_failed_create_tag()
    {
        $response = $this->postJson(route("tags.store"), []);
        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(["tag"]);
    }

    public function test_delete_tag()
    {
        $tag = Tag::factory()->create();
        $response = $this->delete(route("tags.destroy", $tag->id));
        $response->assertOk();
        $this->assertDatabaseMissing(Tag::class, ["id" => $tag->id]);
    }

    public function test_tag_issues()
    {
        Location::factory(1)->has(
            Street::factory(1)->has(Address::factory(1))
        )->create();
        $tag = Tag::factory()->create();
        $issue = Issue::factory()->create(["user_id" => $this->user->id, "address_id" => 1]);
        $issue->tags()->sync([$tag->id]);
        $response = $this->getJson(route("tags.issues", $tag->id));
        $response->assertOk();
        $response->assertJson(function (AssertableJson $json) {
            $json->has("data", 1)->etc();
            $json->has("data.0", function (AssertableJson $json) {
                $json->has("title")->etc();
            });
        });
    }
}
