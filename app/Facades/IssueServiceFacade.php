<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class IssueServiceFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'issueService';
    }
}
