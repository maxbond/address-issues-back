<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('private-issues', function ($user) {
    return $user->active;
});

Broadcast::channel('private-issues-comments', function ($user) {
    return $user->active;
});
