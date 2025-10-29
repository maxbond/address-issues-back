<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Attributes\Scope;

class Street extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['location_id', 'name'];

    /*
     * Get all of the comments for the Street
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    #[Scope]
    protected function filter(Builder $query, array $requestQuery): Builder
    {
        return $query->when(isset($requestQuery['location_id']), function (Builder $query) use ($requestQuery) {
            return $query->where('location_id', '=', (int) $requestQuery['location_id']);
        })->when(isset($requestQuery['name']), function (Builder $query) use ($requestQuery) {
            return $query->whereLike('name', "%{$requestQuery['name']}%");
        });
    }
}
