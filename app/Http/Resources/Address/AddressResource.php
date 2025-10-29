<?php

namespace App\Http\Resources\Address;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            'street' => new StreetResource($this->street),
            'house' => $this->house,
            'flat' => $this->flat,
            'floor' => $this->floor,
            'entrance' => $this->entrance,
            'entrance_is_locked' => $this->entrance_is_locked,
            'has_gate' => $this->has_gate,
            'comment' => $this->comment,
        ];
    }
}
