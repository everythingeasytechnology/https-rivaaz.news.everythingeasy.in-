@extends('layouts.admin')

@section('page_title', 'Dashboard Overview')

@section('content')
<div class="row g-4 mb-4">
    <!-- Total Articles Card -->
    <div class="col-md-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 p-4 d-flex flex-row align-items-center justify-content-between" style="background-color: var(--bs-body-bg); border: 1px solid var(--bs-border-color) !important;">
            <div>
                <span class="text-muted small fw-bold text-uppercase d-block mb-1">Total Articles</span>
                <h2 class="fw-extrabold mb-0">{{ $totalArticles }}</h2>
            </div>
            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 54px; height: 54px;">
                <i class="fas fa-file-alt fs-4"></i>
            </div>
        </div>
    </div>

    <!-- Total Views Card -->
    <div class="col-md-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 p-4 d-flex flex-row align-items-center justify-content-between" style="background-color: var(--bs-body-bg); border: 1px solid var(--bs-border-color) !important;">
            <div>
                <span class="text-muted small fw-bold text-uppercase d-block mb-1">Total Views</span>
                <h2 class="fw-extrabold mb-0">{{ $formattedViews }}</h2>
            </div>
            <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 54px; height: 54px;">
                <i class="fas fa-eye fs-4"></i>
            </div>
        </div>
    </div>

    <!-- Total Categories Card -->
    <div class="col-md-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 p-4 d-flex flex-row align-items-center justify-content-between" style="background-color: var(--bs-body-bg); border: 1px solid var(--bs-border-color) !important;">
            <div>
                <span class="text-muted small fw-bold text-uppercase d-block mb-1">Categories</span>
                <h2 class="fw-extrabold mb-0">{{ $totalCategories }}</h2>
            </div>
            <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 54px; height: 54px;">
                <i class="fas fa-folder fs-4"></i>
            </div>
        </div>
    </div>

    <!-- Total Users Card -->
    <div class="col-md-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 p-4 d-flex flex-row align-items-center justify-content-between" style="background-color: var(--bs-body-bg); border: 1px solid var(--bs-border-color) !important;">
            <div>
                <span class="text-muted small fw-bold text-uppercase d-block mb-1">Staff / Users</span>
                <h2 class="fw-extrabold mb-0">{{ $totalUsers }}</h2>
            </div>
            <div class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center" style="width: 54px; height: 54px;">
                <i class="fas fa-users fs-4"></i>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Articles Table -->
    <div class="col-lg-8 mb-4 mb-lg-0">
        <div class="admin-card h-100">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">Recently Published Articles</h5>
                <a href="{{ route('admin.articles.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">View All</a>
            </div>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr class="text-muted small text-uppercase">
                            <th scope="col">Title</th>
                            <th scope="col">Category</th>
                            <th scope="col">Views</th>
                            <th scope="col">Author</th>
                            <th scope="col" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestArticles as $article)
                            <tr>
                                <td style="max-width: 250px;">
                                    <div class="text-truncate fw-semibold" title="{{ $article->title }}">{{ $article->title }}</div>
                                    <small class="text-muted">{{ $article->published_at ? $article->published_at->format('M d, Y h:i A') : 'Draft' }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 rounded-pill">{{ $article->category->name ?? 'None' }}</span>
                                </td>
                                <td>{{ number_format($article->views) }}</td>
                                <td>{{ $article->author->name ?? 'Unknown' }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.articles.edit', $article->id) }}" class="btn btn-sm btn-outline-secondary rounded-circle" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="fas fa-file-excel fs-2 mb-3"></i>
                                    <p class="mb-0">No articles created yet.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Quick Actions Panel -->
    <div class="col-lg-4">
        <div class="admin-card h-100">
            <h5 class="fw-bold mb-4">Quick Management Actions</h5>
            <div class="d-flex flex-column gap-3">
                <a href="{{ route('admin.articles.create') }}" class="btn btn-outline-primary w-100 rounded-pill text-start py-3 px-4 d-flex align-items-center justify-content-between">
                    <span><i class="fas fa-edit me-3"></i>Write a News Article</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-warning w-100 rounded-pill text-start py-3 px-4 d-flex align-items-center justify-content-between">
                    <span><i class="fas fa-folder-plus me-3"></i>Add New Category</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
                @if(Auth::user()->role === 'super_admin')
                    <a href="{{ route('admin.users.create') }}" class="btn btn-outline-info w-100 rounded-pill text-start py-3 px-4 d-flex align-items-center justify-content-between">
                        <span><i class="fas fa-user-plus me-3"></i>Register New Staff</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    <a href="{{ route('admin.settings.edit') }}" class="btn btn-outline-secondary w-100 rounded-pill text-start py-3 px-4 d-flex align-items-center justify-content-between">
                        <span><i class="fas fa-cog me-3"></i>Update Logo & Info</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
