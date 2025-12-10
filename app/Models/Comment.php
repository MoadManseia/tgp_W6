<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'content',
        'note_id',
    ];

    public function note(): BelongsTo
    {
        return $this->belongsTo(Note::class);
    }
}
