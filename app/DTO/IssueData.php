<?php

namespace App\DTO;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;
use App\Enums\IssuePriority;
use App\Enums\IssueStatus;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Carbon\Carbon;

class IssueData extends Data
{
    public int|Optional $address_id;

    public IssueStatus|Optional $status;

    public IssuePriority|Optional $priority;

    public string|Optional $title;

    public string|Optional $description;

    #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d\TH:i:s.vp')]
    public Carbon|Optional $time_period_from;

    #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d\TH:i:s.vp')]
    public Carbon|Optional $time_period_to;

    #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d\TH:i:s.vp')]
    public Carbon|Optional $tracking_start;

    #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d\TH:i:s.vp')]
    public Carbon|Optional $tracking_finish;

    public array|Optional $tags;

    public array|Optional $phones;

    public array|Optional $executors;
}
