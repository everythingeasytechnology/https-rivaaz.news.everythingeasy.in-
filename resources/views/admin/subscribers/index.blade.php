@extends('layouts.admin')

@section('page_title', 'Newsletter Subscribers')

@section('content')
<div class="admin-card">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h5 class="fw-bold mb-1">Subscriber List</h5>
            <p class="text-muted small mb-0">Total subscribers: {{ $subscribers->total() }}</p>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle border-top">
            <thead class="table-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Email Address</th>
                    <th scope="col">Subscribed On</th>
                    <th scope="col" class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subscribers as $subscriber)
                    <tr>
                        <td class="text-muted">{{ $subscribers->firstItem() + $loop->index }}</td>
                        <td class="fw-semibold">
                            <i class="fas fa-envelope text-primary me-2"></i>{{ $subscriber->email }}
                        </td>
                        <td class="text-muted small">{{ $subscriber->subscribed_at->format('d M Y, h:i A') }}</td>
                        <td class="text-end">
                            <form action="{{ route('admin.subscribers.destroy', $subscriber) }}" method="POST" onsubmit="return confirm('Remove this subscriber?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" title="Remove subscriber" aria-label="Remove subscriber">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-5">
                            <i class="far fa-envelope-open d-block fs-2 mb-2"></i>
                            No subscribers yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $subscribers->links() }}
    </div>
</div>
@endsection
