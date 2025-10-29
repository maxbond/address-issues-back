<?php

namespace App\DTO;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class IssueCommentData extends Data
{
    public string $comment;

    public int|Optional $user_id;

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }
}
