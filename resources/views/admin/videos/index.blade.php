@extends('layouts.admin')

@section('page_title', 'Video News Management')

@section('content')
<div class="admin-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0">Published Video News</h5>
        <a href="{{ route('admin.videos.create') }}" class="btn btn-primary rounded-pill px-4">
            <i class="fas fa-video me-2"></i>Post New Video News
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle border-top">
            <thead class="table-light">
                <tr>
                    <th scope="col" style="width: 35%;">Video Title</th>
                    <th scope="col" style="width: 15%;">Category</th>
                    <th scope="col" style="width: 15%;">Media Source</th>
                    <th scope="col" style="width: 10%;">Views</th>
                    <th scope="col" style="width: 10%;">Flags</th>
                    <th scope="col" style="width: 15%;" class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($articles as $article)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="flex-shrink-0" style="width: 50px; height: 50px; border-radius: 8px; overflow: hidden; border: 1px solid var(--bs-border-color); background: #000; position: relative;">
                                    @if($article->image_path)
                                        <img src="{{ $article->image_path }}" class="w-100 h-100 object-fit-cover" alt="Thumb">
                                    @else
                                        <div class="w-100 h-100 bg-dark d-flex align-items-center justify-content-center text-muted"><i class="fas fa-play text-danger"></i></div>
                                    @endif
                                    <span class="position-absolute bottom-0 end-0 bg-dark text-white rounded px-1 m-1" style="font-size: 0.6rem;"><i class="fas fa-video"></i></span>
                                </div>
                                <div class="text-truncate" style="max-width: 300px;">
                                    <div class="fw-bold text-truncate" title="{{ $article->title }}">{{ $article->title }}</div>
                                    <small class="text-muted">{{ $article->published_at ? $article->published_at->format('M d, Y h:i A') : 'Draft' }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 rounded-pill">{{ $article->category->name ?? 'None' }}</span>
                        </td>
                        <td>
                            @if($article->media_type === 'video_file')
                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-pill"><i class="fas fa-file-video me-1"></i>Uploaded MP4</span>
                            @else
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill"><i class="fab fa-youtube me-1"></i>External Link</span>
                            @endif
                        </td>
                        <td>
                            <span class="text-muted"><i class="far fa-eye me-1"></i>{{ number_format($article->views) }}</span>
                        </td>
                        <td>
                            <div class="d-flex flex-wrap gap-1">
                                @if($article->is_featured)
                                    <span class="badge bg-warning text-dark rounded-pill" style="font-size: 0.7rem;">Featured</span>
                                @endif
                                @if($article->is_breaking)
                                    <span class="badge bg-danger rounded-pill" style="font-size: 0.7rem;">Breaking</span>
                                @endif
                            </div>
                        </td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="/news/{{ $article->slug }}" target="_blank" class="btn btn-sm btn-outline-secondary rounded-circle" title="Preview on website">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                                <a href="{{ route('admin.videos.edit', $article->id) }}" class="btn btn-sm btn-outline-secondary rounded-circle" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.videos.destroy', $article->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this video news?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-video fs-2 mb-3 text-secondary animate-pulse"></i>
                            <p class="mb-0">No video news created yet. Get started by uploading or linking one!</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4 d-flex justify-content-center">
        {{ $articles->links() }}
    </div>
</div>
@endsection
