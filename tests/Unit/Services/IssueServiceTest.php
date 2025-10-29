<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Facades\IssueServiceFacade as IssueService;
use App\Models\Issue;
use App\Models\IssueComment;
use App\Models\Street;
use App\Models\Location;
use App\Models\Address;
use App\Models\Tag;
use App\Models\User;
use App\DTO\IssueData;
use App\DTO\IssueCommentData;
use App\Enums\IssuePriority;
use App\Enums\IssueStatus;

class IssueServiceTest extends TestCase
{
    protected $issueService;
    protected $data;

    public function setUp(): void
    {
        parent::setUp();

        $this->signIn();

        Location::factory(1)->has(
            Street::factory(1)->has(Address::factory(1))
        )->create();

        $this->data = [
            "title" => fake()->sentence,
            "description" => fake()->text,
            "status" => IssueStatus::Open->value,
            "priority" => IssuePriority::Default->value,
            "address_id" => 1,
            "tags" => [],
            "phones" => [["phone" => fake()->phoneNumber(), "comment" => fake()->sentence]],
            "executors" => []
        ];
    }

    public function test_issue_create(): void
    {
        $issue = IssueService::store(IssueData::from($this->data));
        $this->assertDatabaseHas(Issue::class, ["id" => $issue->id]);
    }

    public function test_issue_update()
    {
        $tag = Tag::factory()->create();
        $executor = User::factory()->create(['executor' => true]);

        $issue = IssueService::store(IssueData::from($this->data));
        $this->data["title"] = "New title";
        $this->data["phones"] = [["phone" => "12345678"]];
        $this->data["tags"] = [$tag->id];
        $this->data["executors"] = [$executor->id];
        $issue = IssueService::setIssue($issue)->update(IssueData::from($this->data));
        $this->assertEquals($issue->title, "New title");
        $this->assertCount(1, $issue->phones);
        $this->assertEquals($issue->phones[0]["phone"], "12345678");
        $this->assertEquals($issue->tags->pluck("id")->toArray(), [$tag->id]);
        $this->assertEquals($issue->executors->pluck("id")->toArray(), [$executor->id]);
    }

    public function test_add_comment_to_issue()
    {
        $issue = IssueService::store(IssueData::from($this->data));
        $commentData = ["comment" => fake()->sentence()];
        $comment = IssueService::setIssue($issue)->storeComment(IssueCommentData::from($commentData));
        $this->assertDatabaseHas(IssueComment::class, ["id" => $comment->id]);
    }
}
