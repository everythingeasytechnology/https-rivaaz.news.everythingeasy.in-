@extends('layouts.app')

@section('title', $category['name'] . ' News - Rivaaz Chronicle')

@section('content')
<div class="container-xl">
    
    <!-- Category Header and Subcategories navigation -->
    <div class="bg-body-tertiary p-4 rounded-4 mb-4 border border-secondary-subtle">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2 small fw-semibold">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $category['name'] }}</li>
            </ol>
        </nav>
        <h1 class="headline-font fw-bold text-primary mb-3">{{ $category['name'] }} Bulletin</h1>
        <div class="d-flex flex-wrap gap-2 align-items-center">
            <span class="small fw-bold text-uppercase text-muted me-2">Explore:</span>
            @foreach($category['subcategories'] as $sub)
            <a href="/category/{{ $category['slug'] }}/{{ strtolower(str_replace(' ', '-', $sub)) }}" class="btn btn-sm btn-outline-primary rounded-pill fw-semibold">{{ $sub }}</a>
            @endforeach
        </div>
    </div>

    <!-- Category Content Grid -->
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
            <div class="text-center py-5">
                <div class="fs-1 text-muted"><i class="far fa-folder-open"></i></div>
                <h5 class="fw-bold mt-3">No articles found in this category</h5>
                <p class="text-muted">Check back later or search for other trending tags.</p>
                <a href="/" class="btn btn-primary rounded-pill fw-bold px-4 mt-2">Back to Home</a>
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
