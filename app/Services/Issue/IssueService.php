<?php

namespace App\Services\Issue;

use App\DTO\IssueCommentData;
use Illuminate\Support\Facades\DB;
use App\DTO\IssueData;
use App\DTO\PhoneData;
use App\Models\Issue;
use App\Models\Phone;
use App\Models\IssueComment;

/**
 * Service for working with issues.
 *
 * Provides methods for creating, updating, deleting and managing issues,
 * including working with comments, phones, tags and executors.
 */
class IssueService
{
    private Issue $issue;

    /**
     * Creates a new issue with the provided data.
     *
     * @param IssueData $data DTO with data
     * @return Issue Created issue
     */
    public function store(IssueData $data): Issue
    {
        DB::transaction(function () use ($data) {
            $this->issue = auth()->user()->issues()->create($data->toArray());
            $this->createOrUpdatePhones($data?->phones);
            $this->syncRelated($data);
        });

        return $this->issue->load(['phones', 'tags', 'executors']);
    }

    /**
     * Updates issue data with the provided data.
     *
     * @param IssueData $data DTO with data for updating the issue
     * @return Issue Updated issue
     */
    public function update(IssueData $data): Issue
    {
        DB::transaction(function () use ($data) {
            $this->issue->fill($data->toArray())->save();
            if (is_array($data?->phones)) {
                $this->syncPhones($data->phones);
            }
            $this->syncRelated($data);
        });

        return $this->issue->load(['phones', 'tags', 'executors']);
    }

    /**
     * Delete issue
     */
    public function delete(): void
    {
        $this->issue->delete();
    }

    /**
     * Creates a new comment for the issue.
     *
     * @param IssueCommentData $data DTO with data for creating a comment
     * @return \App\Models\IssueComment Created comment
     */
    public function storeComment(IssueCommentData $data): IssueComment
    {
        $data->setUserId(auth()->id());
        return $this->issue->issueComments()->create($data->toArray());
    }

    /**
     * Delete issue comment
     */
    public function deleteComment(IssueComment $comment): void
    {
        $comment->delete();
    }

    /**
     * Set issue
     *
     * @param Issue $issue Issue to work with
     * @return IssueService
     */
    public function setIssue(Issue $issue): IssueService
    {
        $this->issue = $issue;

        return $this;
    }

    /**
     * Creates or updates phones for the issue.
     *
     * @param array $phones Array of phones
     * @return void
     */
    protected function createOrUpdatePhones($phones): void
    {
        foreach ($phones as $phone) {
            $phoneData = PhoneData::from($phone)->toArray();
            if (empty($phone['id'])) {
                $this->issue->phones()->create($phoneData);
            } else {
                Phone::findOrFail($phone['id'])->fill($phoneData)->save();
            }
        }
    }

    /**
     * Synchronizes issue phones with the provided array.
     *
     * Deletes phones that are missing in the new array, and creates/updates existing ones.
     *
     * @param array $phones Array of phones
     * @return void
     */
    protected function syncPhones($phones): void
    {
        $newPhonesIds = collect($phones)->pluck('id')->toArray();
        $existPhonesIds = $this->issue->phones->pluck('id')->toArray();
        $phonesToDelete = array_diff($existPhonesIds, $newPhonesIds);

        if ($phonesToDelete) {
            $this->issue->phones()->whereIn('id', $phonesToDelete)->delete();
        }

        $this->createOrUpdatePhones($phones);
    }

    /**
     * Synchronizes related issue data.
     *
     * @param IssueData $data DTO with issue data
     * @return void
     */
    protected function syncRelated($data): void
    {
        if (is_array($data?->tags)) {
            $this->issue->tags()->sync($data->tags);
        }
        if (is_array($data?->executors)) {
            $this->issue->executors()->sync($data->executors);
        }
    }
}
