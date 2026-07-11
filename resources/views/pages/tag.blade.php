@extends('layouts.app')

@section('title', 'Tag: #' . $slug . ' - Rivaaz Chronicle')

@section('content')
<div class="container-xl">
    
    <!-- Tag Header -->
    <div class="bg-body-tertiary p-4 rounded-4 mb-4 border border-secondary-subtle">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2 small fw-semibold">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tag</li>
            </ol>
        </nav>
        <h1 class="headline-font fw-bold text-primary mb-2">#{{ $slug }} Articles</h1>
        <p class="text-muted mb-0 small">A curated stream of publications and analysis tagged under #{{ $slug }}.</p>
    </div>

    <!-- Tag Content Grid -->
    <div class="row g-4">
        <!-- Main Column (Articles Grid) -->
        <div class="col-lg-8">
            @if(count($articles) > 0)
            <div class="row g-4">
                @foreach($articles as $article)
                <div class="col-md-6 mb-3">
                    <div class="news-card">
                        <div class="card-img-container">
                            <img src="{{ $article['image'] }}" alt="{{ $article['title'] }}">
                        </div>
                        <div class="card-body">
                            <span class="badge-category mb-2">{{ $article['subcategory'] }}</span>
                            <h4 class="card-title fw-bold">
                                <a href="/news/{{ $article['slug'] }}">{{ $article['title'] }}</a>
                            </h4>
                            <p class="text-muted small line-clamp-3 mb-3">{{ $article['summary'] }}</p>
                            <div class="card-meta">
                                <span><i class="far fa-user me-1"></i> {{ $article['author']['name'] }}</span>
                                <span>•</span>
                                <span>{{ $article['read_time'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-5 bg-body-tertiary rounded-4">
                <div class="fs-1 text-muted"><i class="fas fa-tags"></i></div>
                <h5 class="fw-bold mt-3">No articles found matching #{{ $slug }}</h5>
                <p class="text-muted">Browse other trending hashtags instead:</p>
                <div class="d-flex flex-wrap gap-2 justify-content-center mt-3">
                    @foreach(\App\Support\MockData::getTrendingTags() as $tag)
                    <a href="/tag/{{ strtolower($tag) }}" class="btn btn-sm btn-outline-primary rounded-pill fw-semibold">#{{ $tag }}</a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar Column -->
        <div class="col-lg-4">
            @include('components.widgets', ['type' => 'trending'])
            @include('components.widgets', ['type' => 'newsletter'])
        </div>
    </div>

</div>
@endsection
