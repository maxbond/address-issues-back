<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Attributes\Scope;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'active',
        'executor',
        'admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'pivot',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'active' => 'boolean',
            'executor' => 'boolean',
            'admin' => 'boolean',
        ];
    }

    public function issues(): HasMany
    {
        return $this->hasMany(Issue::class);
    }

    public function issuesExecutor(): BelongsToMany
    {
        return $this->BelongsToMany(
            Issue::class,
            'issue_executors',
            'user_id',
            'issue_id'
        );
    }

    /**
     * This user is active and admin
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->active === true && $this->admin === true;
    }

    /**
     * Send notification only when user active
     *
     * @param mixed $notifiable
     */
    public function notifyIfActive($notifiable): void
    {
        if ($this->active) {
            $this->notify($notifiable);
        }
    }

    #[Scope]
    protected function activeExecutors(Builder $query): Builder
    {
        return $query->whereActive(true)->whereExecutor(true);
    }
}
