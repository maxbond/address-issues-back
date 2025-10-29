<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Attributes\Scope;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'street_id',
        'house',
        'flat',
        'floor',
        'entrance',
        'entrance_is_locked',
        'has_gate',
        'comment',
    ];

    protected $casts = [
        'entrance_is_locked' => 'boolean',
        'has_gate' => 'boolean',
    ];

    public function street(): BelongsTo
    {
        return $this->belongsTo(Street::class);
    }

    public function issues(): HasMany
    {
        return $this->hasMany(Issue::class);
    }

    public function readable(): string
    {
        return sprintf(
            __('address.readable'),
            $this->street->location->name,
            $this->street->name,
            $this->house,
            $this->flat,
        );
    }

    #[Scope]
    protected function filter(Builder $query, array $requestQuery): Builder
    {
        return $query->when(isset($requestQuery['street_id']), function (Builder $query) use ($requestQuery) {
            return $query->where('street_id', '=', (int) $requestQuery['street_id']);
        })->when(isset($requestQuery['house']), function (Builder $query) use ($requestQuery) {
            return $query->whereHouse($requestQuery['house']);
        })->when(isset($requestQuery['flat']), function (Builder $query) use ($requestQuery) {
            return $query->whereFlat($requestQuery['flat']);
        });
    }
}
