<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['tag'];

    protected $hidden = ['pivot'];

    public function issues(): BelongsToMany
    {
        return $this->BelongsToMany(
            Issue::class,
            'issue_tags',
            'tag_id',
            'issue_id'
        );
    }
}
