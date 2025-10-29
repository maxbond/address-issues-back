<?php

namespace App\Observers;

use App\Models\Issue;
use App\Events\IssueCreated;
use App\Events\IssueUpdated;
use App\Events\IssueDeleted;
use App\Events\IssueCanceled;
use App\Enums\IssueStatus;

class IssueObserver
{
    /**
     * Handle the Issue "created" event.
     */
    public function created(Issue $issue): void
    {
        event(new IssueCreated($issue));
    }

    /**
     * Handle the Issue "updated" event.
     */
    public function updated(Issue $issue): void
    {
        $original = $issue->getOriginal();
        $wasCanceled = $original['status'] === IssueStatus::Canceled->value;
        $nowCanceled = $issue->status === IssueStatus::Canceled->value;

        if ($wasCanceled && $nowCanceled) {
            return;
        }

        if (!$wasCanceled && $nowCanceled) {
            event(new IssueCanceled($issue));
            return;
        }

        event(new IssueUpdated($issue));
    }

    /**
     * Handle the Issue "deleting" event.
     */
    public function deleting(Issue $issue): void
    {
        event(new IssueDeleted($issue));
    }
}
