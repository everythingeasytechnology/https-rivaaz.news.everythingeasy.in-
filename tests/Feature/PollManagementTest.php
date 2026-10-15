<?php

namespace Tests\Feature;

use App\Models\Poll;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class PollManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_crud_and_anonymous_duplicate_protection(): void
    {
        $admin = User::factory()->create(['role' => 'editor']);
        $this->actingAs($admin)->post(route('admin.polls.store'), ['question' => 'Who will win?', 'choice_type' => 'single', 'is_active' => 1, 'options' => [['option_text' => 'A'], ['option_text' => 'B']]])->assertRedirect(route('admin.polls.index'));
        $poll = Poll::with('options')->firstOrFail();
        $this->assertTrue($poll->is_active);
        $this->assertCount(2, $poll->options);
        $token = (string) Str::uuid();
        $this->postJson(route('polls.vote', $poll), ['option_ids' => [$poll->options[0]->id], 'voter_token' => $token])->assertOk()->assertJsonPath('store_local_marker', true);
        $this->postJson(route('polls.vote', $poll), ['option_ids' => [$poll->options[1]->id], 'voter_token' => $token])->assertStatus(409)->assertJsonPath('already_voted', true);
        $this->assertDatabaseCount('poll_votes', 1);
        $this->actingAs($admin)->patch(route('admin.polls.toggle', $poll))->assertRedirect();
        $this->assertFalse($poll->fresh()->is_active);
    }

    public function test_multiple_choice_validation(): void
    {
        $poll = Poll::create(['question' => 'Choose', 'choice_type' => 'multiple', 'is_active' => true]);
        $a = $poll->options()->create(['option_text' => 'A', 'sort_order' => 0]);
        $b = $poll->options()->create(['option_text' => 'B', 'sort_order' => 1]);
        $this->postJson(route('polls.vote', $poll), ['option_ids' => [$a->id, $b->id], 'voter_token' => (string) Str::uuid()])->assertOk();
        $this->getJson(route('polls.results', $poll))->assertOk()->assertJsonPath('total_voters',1);
    }
}
