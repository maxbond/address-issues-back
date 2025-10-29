<?php

namespace App\DTO;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class PhoneData extends Data
{
    public int|Optional $issue_id;

    public string|Optional $phone;

    public string|Optional $comment;
}
