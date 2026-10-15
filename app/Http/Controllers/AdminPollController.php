<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AdminPollController extends Controller
{
    public function index(Request $request)
    {
        $polls = Poll::with(['options' => fn ($q) => $q->withCount('choices')])->withCount('votes')
            ->when($request->filled('search'), fn ($q) => $q->where('question', 'like', '%'.trim($request->search).'%'))
            ->when($request->status === 'active', fn ($q) => $q->where('is_active', true))
            ->when($request->status === 'inactive', fn ($q) => $q->where('is_active', false))
            ->latest()->paginate(15)->withQueryString();

        return view('admin.polls.index', compact('polls'));
    }

    public function create()
    {
        return view('admin.polls.create');
    }

    public function store(Request $request)
    {
        $data = $this->validatePoll($request);
        $poll = DB::transaction(function () use ($data) {
            $poll = Poll::create(['question' => $data['question'], 'choice_type' => $data['choice_type'], 'is_active' => $data['is_active'], 'created_by' => Auth::id()]);
            foreach ($data['options'] as $i => $option) {
                $poll->options()->create(['option_text' => $option['option_text'], 'sort_order' => $i]);
            }

            return $poll;
        });

        return redirect()->route('admin.polls.index')->with('success', 'Poll created successfully.');
    }

    public function edit(Poll $poll)
    {
        $poll->load('options');

        return view('admin.polls.edit', compact('poll'));
    }

    public function update(Request $request, Poll $poll)
    {
        $data = $this->validatePoll($request);
        DB::transaction(function () use ($poll, $data) {
            $poll->update(['question' => $data['question'], 'choice_type' => $data['choice_type'], 'is_active' => $data['is_active']]);
            $kept = [];
            foreach ($data['options'] as $i => $row) {
                $option = ! empty($row['id']) ? $poll->options()->whereKey($row['id'])->first() : null;
                $values = ['option_text' => $row['option_text'], 'sort_order' => $i];
                $option = $option ? tap($option)->update($values) : $poll->options()->create($values);
                $kept[] = $option->id;
            }
            $poll->options()->whereNotIn('id', $kept)->delete();
        });

        return redirect()->route('admin.polls.index')->with('success', 'Poll updated successfully.');
    }

    public function destroy(Poll $poll)
    {
        $poll->delete();

        return back()->with('success', 'Poll deleted successfully.');
    }

    public function toggle(Poll $poll)
    {
        $poll->update(['is_active' => ! $poll->is_active]);

        return back()->with('success', 'Poll status updated.');
    }

    private function validatePoll(Request $request): array
    {
        $request->merge(['is_active' => $request->boolean('is_active')]);

        return $request->validate([
            'question' => ['required', 'string', 'max:500'], 'choice_type' => ['required', Rule::in(['single', 'multiple'])], 'is_active' => ['boolean'],
            'options' => ['required', 'array', 'min:2', 'max:20'], 'options.*.id' => ['nullable', 'integer'],
            'options.*.option_text' => ['required', 'string', 'max:255', 'distinct'],
        ]);
    }
}
