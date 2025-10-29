<?php

namespace App\Http\Resources\Issue;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Address\AddressResource;
use App\Http\Resources\Phone\PhoneResource;
use App\Http\Resources\Tag\TagResource;
use App\Http\Resources\User\UserResource;
use App\Enums\IssuePriority;
use App\Enums\IssueStatus;

class IssueResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => new UserResource($this->user),
            'address' => new AddressResource($this->address),
            'status' => IssueStatus::from($this->status),
            'priority' => IssuePriority::from($this->priority),
            'title' => $this->title,
            'description' => $this->description,
            'time_period_from' => $this->time_period_from,
            'time_period_to' => $this->time_period_to,
            'tracking_start' => $this->tracking_start,
            'tracking_finish' => $this->tracking_to,
            'phones' => PhoneResource::collection($this->phones),
            'tags' => TagResource::collection($this->tags),
            'comments' => IssueCommentResource::collection($this->issueComments),
            'executors' => UserResource::collection($this->executors),
        ];
    }
}
