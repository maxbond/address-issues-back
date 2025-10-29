<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name'];

    public function streets(): HasMany
    {
        return $this->hasMany(Street::class);
    }
}
