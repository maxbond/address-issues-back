<?php

namespace App\Listeners;

use App\Events\IssueCreated;
use App\Events\IssueUpdated;
use App\Events\IssueDeleted;
use App\Events\IssueCanceled;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\IssueDummyNotification;

class SendExecutorNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param IssueCreated|IssueUpdated|IssueDeleted|IssueCanceled $event
     * @return void
     */
    public function handle(IssueCreated|IssueUpdated|IssueDeleted|IssueCanceled $event): void
    {
        $issue = $event->getIssue();
        $title = sprintf("%s #%s", $this->getTitle($event), $issue->id);

        foreach ($issue->executors as $executor) {
            $executor->notifyIfActive(new IssueDummyNotification($issue, $title));
        }
    }

    /**
     * Get message title for notification based on event type.
     *
     * @param IssueCreated|IssueUpdated|IssueDeleted|IssueCanceled $event
     * @return string
     */
    protected function getTitle(object $event): string
    {
        return match (get_class($event)) {
            IssueCanceled::class => __('issues.issue_canceled'),
            IssueCreated::class => __('issues.issue_assigned'),
            IssueDeleted::class => __('issues.issue_deleted'),
            default => __('issues.issue_updated'),
        };
    }
}
