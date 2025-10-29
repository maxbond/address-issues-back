<?php

namespace App\Enums;

enum IssueStatus: string
{
    case Open = 'open';
    case InProgress = 'inprogress';
    case Done = 'done';
    case Canceled = 'canceled';
}
