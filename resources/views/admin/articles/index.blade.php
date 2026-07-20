@extends('layouts.admin')

@section('page_title', 'News Articles Management')

@section('content')
<div class="admin-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0">Published Articles</h5>
        <a href="{{ route('admin.articles.create') }}" class="btn btn-primary rounded-pill px-4">
            <i class="fas fa-edit me-2"></i>Write New Article
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle border-top">
            <thead class="table-light">
                <tr>
                    <th scope="col" style="width: 35%;">Article</th>
                    <th scope="col" style="width: 15%;">Category</th>
                    <th scope="col" style="width: 10%;">Views</th>
                    <th scope="col" style="width: 15%;">Author</th>
                    <th scope="col" style="width: 10%;">Flags</th>
                    <th scope="col" style="width: 15%;" class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($articles as $article)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="flex-shrink-0" style="width: 50px; height: 50px; border-radius: 8px; overflow: hidden; border: 1px solid var(--bs-border-color);">
                                    @if($article->image_path)
                                        <img src="{{ $article->image_path }}" class="w-100 h-100 object-fit-cover" alt="Thumb">
                                    @else
                                        <div class="w-100 h-100 bg-secondary bg-opacity-10 d-flex align-items-center justify-content-center text-muted"><i class="far fa-image"></i></div>
                                    @endif
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
                            <span class="text-muted"><i class="far fa-eye me-1"></i>{{ number_format($article->views) }}</span>
                        </td>
                        <td>{{ $article->author->name ?? 'Unknown' }}</td>
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
                                <a href="{{ route('admin.articles.edit', $article->id) }}" class="btn btn-sm btn-outline-secondary rounded-circle" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this news article?');">
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
                            <i class="fas fa-file-invoice fs-2 mb-3"></i>
                            <p class="mb-0">No articles created yet. Get started by writing one!</p>
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
