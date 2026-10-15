<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PollVote extends Model
{
    protected $fillable = ['poll_id', 'voter_hash'];

    public function poll(): BelongsTo
    {
        return $this->belongsTo(Poll::class);
    }

    public function choices(): HasMany
    {
        return $this->hasMany(PollVoteChoice::class);
    }
}
