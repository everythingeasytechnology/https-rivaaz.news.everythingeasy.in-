@extends('layouts.admin')
@section('page_title', 'Poll Management')
@section('content')
<div class="admin-card">
<div class="d-flex flex-wrap justify-content-between gap-3 mb-4"><div><h5 class="fw-bold mb-1">All Polls</h5><p class="small text-muted mb-0">WhatsApp-style single and multiple-choice polls.</p></div><a href="{{ route('admin.polls.create') }}" class="btn btn-primary rounded-pill px-4"><i class="fas fa-plus me-2"></i>Create Poll</a></div>
<form method="GET" class="row g-2 mb-4"><div class="col-md-8"><input name="search" value="{{ request('search') }}" class="form-control" placeholder="Search question..."></div><div class="col-md-3"><select name="status" class="form-select"><option value="">All statuses</option><option value="active" @selected(request('status')==='active')>Active</option><option value="inactive" @selected(request('status')==='inactive')>Inactive</option></select></div><div class="col-md-1 d-grid"><button class="btn btn-outline-primary"><i class="fas fa-filter"></i></button></div></form>
<div class="table-responsive"><table class="table table-hover align-middle border-top"><thead class="table-light"><tr><th>Question & Options</th><th>Type</th><th>Status</th><th>Votes</th><th>Created</th><th class="text-end">Actions</th></tr></thead><tbody>
@forelse($polls as $poll)
<tr><td><strong>{{ $poll->question }}</strong><div class="small text-muted mt-1">{{ $poll->options->pluck('option_text')->join(' · ') }}</div></td><td>{{ ucfirst($poll->choice_type) }}</td><td><span class="badge {{ $poll->is_active ? 'bg-success' : 'bg-secondary' }} rounded-pill">{{ $poll->is_active ? 'Active' : 'Inactive' }}</span></td><td><button type="button" class="btn btn-sm btn-outline-primary rounded-pill text-nowrap" data-bs-toggle="modal" data-bs-target="#pollResult{{ $poll->id }}"><i class="fas fa-chart-simple me-1"></i>View Result <span class="badge bg-primary ms-1">{{ $poll->votes_count }}</span></button></td><td class="small text-muted">{{ $poll->created_at->format('d M Y') }}</td><td class="text-end"><div class="d-flex justify-content-end gap-2"><form action="{{ route('admin.polls.toggle',$poll) }}" method="POST">@csrf @method('PATCH')<button class="btn btn-sm btn-outline-{{ $poll->is_active ? 'warning' : 'success' }} rounded-circle" title="{{ $poll->is_active ? 'Deactivate' : 'Activate' }}"><i class="fas fa-power-off"></i></button></form><a href="{{ route('admin.polls.edit',$poll) }}" class="btn btn-sm btn-outline-secondary rounded-circle"><i class="fas fa-edit"></i></a><form action="{{ route('admin.polls.destroy',$poll) }}" method="POST" onsubmit="return confirm('Delete this poll and all votes?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger rounded-circle"><i class="fas fa-trash"></i></button></form></div></td></tr>
@empty<tr><td colspan="6" class="text-center text-muted py-5">No polls created yet.</td></tr>@endforelse
</tbody></table></div><div class="d-flex justify-content-center mt-4">{{ $polls->links() }}</div></div>

@foreach($polls as $poll)
@php($totalChoices = $poll->options->sum('choices_count'))
<div class="modal fade" id="pollResult{{ $poll->id }}" tabindex="-1" aria-labelledby="pollResultLabel{{ $poll->id }}" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered"><div class="modal-content border-0 shadow"><div class="modal-header"><div><h5 class="modal-title fw-bold" id="pollResultLabel{{ $poll->id }}">Poll Result</h5><div class="small text-muted mt-1">{{ $poll->question }}</div></div><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
<div class="modal-body">
@foreach($poll->options as $option)
@php($percentage = $totalChoices > 0 ? round(($option->choices_count / $totalChoices) * 100) : 0)
<div class="mb-3"><div class="d-flex justify-content-between gap-3 mb-1"><span>{{ $option->option_text }}</span><span class="text-nowrap fw-semibold">{{ $option->choices_count }} {{ Str::plural('vote', $option->choices_count) }} · {{ $percentage }}%</span></div><div class="progress" style="height: 8px;" role="progressbar" aria-label="{{ $option->option_text }}" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"><div class="progress-bar" style="width: {{ $percentage }}%"></div></div></div>
@endforeach
</div><div class="modal-footer justify-content-between"><span class="small text-muted"><i class="fas fa-users me-1"></i>{{ $poll->votes_count }} {{ Str::plural('respondent', $poll->votes_count) }}</span><button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Close</button></div></div></div>
</div>
@endforeach
@endsection
