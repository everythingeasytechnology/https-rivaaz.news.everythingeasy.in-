<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Models\PollVote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PollVoteController extends Controller
{
    public function active(): JsonResponse
    {
        $polls = Poll::where('is_active', true)->with('options:id,poll_id,option_text,sort_order')->latest()->get();

        return response()->json(['polls' => $polls]);
    }

    public function store(Request $request, Poll $poll): JsonResponse
    {
        abort_unless($poll->is_active, 404);
        $validated = $request->validate(['option_ids' => ['required', 'array', 'min:1'], 'option_ids.*' => ['integer', 'distinct', Rule::exists('poll_options', 'id')->where('poll_id', $poll->id)], 'voter_token' => ['required', 'uuid']]);
        if ($poll->choice_type === 'single' && count($validated['option_ids']) !== 1) {
            return response()->json(['message' => 'Please select exactly one option.'], 422);
        }
        $hash = hash_hmac('sha256', $validated['voter_token'], (string) config('app.key'));
        if (PollVote::where('poll_id', $poll->id)->where('voter_hash', $hash)->exists()) {
            return response()->json(['message' => 'You have already voted in this poll.', 'already_voted' => true], 409);
        }
        DB::transaction(function () use ($poll, $hash, $validated) {
            $vote = $poll->votes()->create(['voter_hash' => $hash]);
            foreach ($validated['option_ids'] as $id) {
                $vote->choices()->create(['poll_option_id' => $id]);
            }
        });

        return response()->json(['message' => 'Your vote has been saved.', 'poll_id' => $poll->id, 'store_local_marker' => true, 'results' => $this->resultData($poll)]);
    }

    public function results(Poll $poll): JsonResponse
    {
        return response()->json($this->resultData($poll));
    }

    private function resultData(Poll $poll): array
    {
        $poll->load(['options' => fn ($q) => $q->withCount('choices')]);
        $total = $poll->votes()->count();

        return ['poll_id' => $poll->id, 'total_voters' => $total, 'options' => $poll->options->map(fn ($o) => ['id' => $o->id, 'option_text' => $o->option_text, 'votes' => $o->choices_count, 'percentage' => $total ? round($o->choices_count / $total * 100, 1) : 0])->values()];
    }
}
