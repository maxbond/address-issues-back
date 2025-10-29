<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Models\User;

/**
 * Class ExecutorsController
 *
 * Controller for list executors
 */
class ExecutorController extends Controller
{
    /**
     * List active users with executor flag
     *
     * @return UserResource
     */
    public function active()
    {
        return UserResource::collection(User::activeExecutors()->get());
    }
}
