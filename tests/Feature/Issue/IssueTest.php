<?php

namespace Tests\Feature\Issue;

use Tests\TestCase;
use App\Enums\IssuePriority;
use App\Enums\IssueStatus;
use App\Models\Street;
use App\Models\Location;
use App\Models\Address;
use App\Models\Issue;
use App\Models\Tag;
use App\Models\User;
use App\Models\Phone;
use App\Models\IssueComment;
use Carbon\Carbon;
use Illuminate\Testing\Fluent\AssertableJson;

class IssueTest extends TestCase
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

        $dateTime = "2025-01-01 00:00:00";

        $this->data = [
            "title" => fake()->sentence,
            "description" => fake()->text,
            "status" => IssueStatus::Open->value,
            "priority" => IssuePriority::Default->value,
            "time_period_from" => Carbon::parse($dateTime)->format("Y-m-d\TH:i:s.vp"),
            "time_period_to" => Carbon::parse($dateTime)->format("Y-m-d\TH:i:s.vp"),
            "address_id" => 1,
            "tags" => [],
            "phones" => [["phone" => fake()->phoneNumber(), "comment" => fake()->sentence]],
            "executors" => []
        ];

        $this->jsonStructure = [
            "title",
            "description",
            "status",
            "priority",
            "time_period_from",
            "time_period_to",
            "tracking_start",
            "tracking_finish",
            "address",
            "phones",
            "tags",
            "executors",
        ];
    }

    public function test_list_issue()
    {
        $this->getNewIssue();
        $response = $this->getJson(route("issues.index"));
        $response->assertOk();
        $response->assertJsonCount(1, "data");
    }

    public function test_show_issue()
    {
        $issue = $this->getNewIssue();
        $response = $this->getJson(route("issues.show", $issue->id));
        $response->assertOk();
        $response->assertJsonStructure([
            "data" => $this->jsonStructure,
        ]);
    }

    public function test_filter_issue()
    {
        Issue::factory()->create(["user_id" => $this->user->id]);
        $title = fake()->sentence();
        Issue::factory()->create(["user_id" => $this->user->id, "title" => $title]);
        $response = $this->getJson(route("issues.index", ["title" => $title]));
        $response->assertOk();
        $response->assertJsonCount(1, "data");
    }

    public function test_create_issue(): void
    {
        $response = $this->postJson(route("issues.store"), $this->data);
        $response->assertCreated();

        $response->assertJsonStructure([
            "data" => $this->jsonStructure,
        ]);

        $response->assertJson(
            fn(AssertableJson $json) =>
            $json->where("data.title", $this->data["title"])
                ->where("data.description", $this->data["description"])
                ->where("data.status", $this->data["status"])
                ->where("data.priority", $this->data["priority"])
                ->where("data.time_period_from", "2025-01-01T00:00:00.000000Z")
                ->where("data.time_period_to", "2025-01-01T00:00:00.000000Z")
                ->where("data.tracking_start", null)
                ->where("data.tracking_finish", null)
                ->where("data.phones.0.phone", $this->data["phones"][0]["phone"])
                ->where("data.tags", $this->data["tags"])
                ->where("data.executors", $this->data["executors"])
        );
    }

    public function test_update_issue()
    {
        $issue = $this->getNewIssue();
        Tag::factory()->create();
        User::factory()->create();

        $this->data["title"] = "Updated title";
        $this->data["phones"] = [["phone" => "12345678", "comment" => "test"]];
        $this->data["executors"] = [User::first()->id];
        $this->data["tags"] = [Tag::first()->id];

        $response = $this->putJson(route("issues.update", $issue->id), $this->data);

        $response->assertOk();

        $response->assertJson(
            fn(AssertableJson $json) =>
            $json->where("data.title", "Updated title")
                ->where("data.phones.0.phone", "12345678")
                ->where("data.phones.0.comment", "test")
        );

        $response->assertJsonCount(1, "data.tags");
        $response->assertJsonCount(1, "data.executors");
    }

    public function test_delete_phones()
    {
        $issue = Issue::factory()->has(Phone::factory(5))->create(["user_id" => $this->user->id]);
        $response = $this->patchJson(route("issues.update", $issue->id), ['phones' => [["phone" => "12345678"]]]);
        $response->assertOk();
        $response->assertJsonCount(1, "data.phones");
    }

    public function test_failed_create_issue()
    {
        $data = [
            "title" => str_repeat("X", 201),
        ];

        $response = $this->postJson(route("issues.store"), $data);
        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(["title", "address_id", "status", "priority"]);
    }

    public function test_delete_issue()
    {
        $issue = $this->getNewIssue();
        $response = $this->delete(route("issues.destroy", $issue->id));
        $response->assertOk();
        $this->assertDatabaseMissing(Issue::class, [["id" => $issue->id]]);
    }

    public function test_create_issue_comment()
    {
        $issue = $this->getNewIssue();
        $response = $this->postJson(route("issues.comment.store", $issue->id), [
            "comment" => fake()->sentence(),
        ]);
        $response->assertCreated();
    }

    public function test_delete_issue_comment()
    {
        $issue = $this->getNewIssue();
        $comment = IssueComment::factory()->create([
            "issue_id" => $issue->id,
        ]);
        $response = $this->delete(route("issues.comment.destroy", $comment->id));
        $response->assertOk();
        $this->assertDatabaseMissing(IssueComment::class, ["id" => $comment->id]);
    }

    protected function getNewIssue()
    {
        return Issue::factory()->create(["user_id" => $this->user->id]);
    }
}
