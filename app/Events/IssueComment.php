<?php

namespace App\Events;

use App\Models\IssueComment as IssueCommentModel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

abstract class IssueComment implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $issueComment;

    /**
     * Create a new event instance.
     */
    public function __construct(IssueCommentModel $issueComment)
    {
        $this->issueComment = $issueComment;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('issues-comments'),
        ];
    }

    public function broadcastWith(): array
    {
        return ["issue_comment" => $this->issueComment];
    }
}
