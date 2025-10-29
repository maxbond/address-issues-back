<?php

namespace App\Observers;

use App\Models\IssueComment;
use App\Events\IssueCommentCreated;
use App\Events\IssueCommentDeleted;

class IssueCommentObserver
{
    /**
     * Handle the IssueComment "created" event.
     */
    public function created(IssueComment $issueComment): void
    {
        event(new IssueCommentCreated($issueComment));
    }

    /**
     * Handle the IssueComment "deleted" event.
     */
    public function deleted(IssueComment $issueComment): void
    {
        event(new IssueCommentDeleted($issueComment));
    }
}
