<?php

namespace App\DTO;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class StreetData extends Data
{
    public string|Optional $name;

    public int|Optional $location_id;
}
