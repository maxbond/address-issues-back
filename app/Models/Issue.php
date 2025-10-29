<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\IssueObserver;
use Carbon\Carbon;

#[ObservedBy(IssueObserver::class)]
class Issue extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'address_id',
        'status',
        'priority',
        'title',
        'description',
        'time_period_from',
        'time_period_to',
        'tracking_start',
        'tracking_finish',
    ];

    protected function casts(): array
    {
        return [
            'time_period_from' => 'datetime',
            'time_period_to' => 'datetime',
            'tracking_start' => 'datetime',
            'tracking_finish' => 'datetime',
        ];
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function issueComments(): HasMany
    {
        return $this->hasMany(IssueComment::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'issue_tags', 'issue_id', 'tag_id');
    }

    public function phones(): HasMany
    {
        return $this->hasMany(Phone::class);
    }

    public function executors(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'issue_executors', 'issue_id', 'user_id');
    }

    #[Scope]
    protected function filter(Builder $query, array $requestQuery): Builder
    {
        return $query->when(isset($requestQuery['address_id']), function (Builder $query) use ($requestQuery) {
            return $query->where('address_id', '=', (int) $requestQuery['address_id']);
        })->when(isset($requestQuery['title']), function (Builder $query) use ($requestQuery) {
            return $query->whereLike('title', "%{$requestQuery['title']}%");
        })->when(isset($requestQuery['time_period_from']), function (Builder $query) use ($requestQuery) {
            return $query->where('time_period_from', '>=', Carbon::parse($requestQuery['time_period_from']));
        })->when(isset($requestQuery['time_period_to']), function (Builder $query) use ($requestQuery) {
            return $query->where('time_period_to', '<=', Carbon::parse($requestQuery['time_period_to']));
        })->when(isset($requestQuery['status']), function (Builder $query) use ($requestQuery) {
            return $query->whereStatus($requestQuery['status']);
        })->when(isset($requestQuery['priority']), function (Builder $query) use ($requestQuery) {
            return $query->wherePriority($requestQuery['priority']);
        });
    }
}
