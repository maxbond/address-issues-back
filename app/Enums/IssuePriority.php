<?php

namespace App\Enums;

enum IssuePriority: string
{
    case Low = 'low';
    case Default = 'default';
    case High = 'high';
    case Immediately = 'immediately';
}
