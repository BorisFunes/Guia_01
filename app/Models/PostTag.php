<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PostTag extends Pivot
{
    protected $fillable = [
        'posts_id',
        'tags_id'
    ];

    protected $table = 'posts_tags';

    public $timestamps = false;

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'posts_id');
    }

    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class, 'tags_id');
    }
}
