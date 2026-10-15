<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PollVoteChoice extends Model
{
    public $timestamps = false;

    protected $fillable = ['poll_vote_id', 'poll_option_id'];

    public function vote(): BelongsTo
    {
        return $this->belongsTo(PollVote::class, 'poll_vote_id');
    }

    public function option(): BelongsTo
    {
        return $this->belongsTo(PollOption::class, 'poll_option_id');
    }
}
