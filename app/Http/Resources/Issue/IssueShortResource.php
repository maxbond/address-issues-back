<?php

namespace App\Http\Resources\Issue;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Address\AddressShortResource;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\Phone\PhoneResource;
use App\Http\Resources\Tag\TagResource;
use App\Enums\IssuePriority;
use App\Enums\IssueStatus;

class IssueShortResource extends JsonResource
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
            'address' => new AddressShortResource($this->address),
            'status' => IssueStatus::from($this->status),
            'priority' => IssuePriority::from($this->priority),
            'title' => $this->title,
            'time_period_from' => $this->time_period_from,
            'time_period_to' => $this->time_period_to,
            'phones' => PhoneResource::collection($this->phones),
            'tags' => TagResource::collection($this->tags),
            'executors' => UserResource::collection($this->executors),
        ];
    }
}
