<?php

namespace App\DTO;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class AddressData extends Data
{
    public int|Optional $street_id;

    public string|Optional $house;

    public string|Optional $flat;

    public int|Optional $floor;

    public int|Optional $entrance;

    public bool|Optional $entrance_is_locked;

    public bool|Optional $has_gate;

    public string|Optional $comment;
}
