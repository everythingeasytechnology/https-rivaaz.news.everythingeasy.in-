@extends('layouts.app')

@section('title', 'Search Results - Rivaaz Chronicle')

@section('content')
<div class="container-xl">
    
    <!-- Search Query Bar -->
    <div class="bg-body-tertiary p-4 rounded-4 mb-4 border border-secondary-subtle">
        <h1 class="headline-font fw-extrabold mb-3 text-primary"><i class="fas fa-search me-2"></i> Search Rivaaz</h1>
        <form action="/search" method="GET" class="row g-2">
            <div class="col-md-9">
                <input type="text" name="q" class="form-control form-control-lg rounded-3 shadow-none border-secondary-subtle" placeholder="What are you looking for?" value="{{ $query }}" required>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill fw-bold"><i class="fas fa-search me-2"></i> Find Articles</button>
            </div>
        </form>
    </div>

    <!-- Search Results Content -->
    <div class="row g-4">
        <div class="col-lg-8">
            @if(!empty($query))
                <h3 class="headline-font mb-4 fw-bold text-uppercase border-bottom pb-2">
                    Results for "{{ $query }}" <span class="fs-6 fw-normal text-muted">({{ count($articles) }} match(es) found)</span>
                </h3>
                
                @if(count($articles) > 0)
                <div class="d-flex flex-column gap-3">
                    @foreach($articles as $article)
                    <div class="news-horizontal-row py-3 rounded-4 p-3 bg-body-tertiary bg-opacity-25 border border-secondary-subtle">
                        <div class="row-img-container" style="width: 140px; height: 90px; border-radius: 8px;">
                            <img src="{{ $article['image'] }}" alt="{{ $article['title'] }}" class="w-100 h-100 object-fit-cover">
                        </div>
                        <div class="row-content">
                            <span class="badge-category mb-2 py-0 px-2">{{ $article['category'] }}</span>
                            <h5 class="row-title fw-bold">
                                <a href="/news/{{ $article['slug'] }}">{{ $article['title'] }}</a>
                            </h5>
                            <p class="text-muted small line-clamp-2 mb-2">{{ $article['summary'] }}</p>
                            <small class="text-muted fs-8"><i class="far fa-user me-1"></i> {{ $article['author']['name'] }} • {{ $article['published_at'] }}</small>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-5">
                    <div class="fs-1 text-muted"><i class="fas fa-search-minus"></i></div>
                    <h5 class="fw-bold mt-3">No matching articles found</h5>
                    <p class="text-muted">Try searching for generic terms like "Budget", "AI", "Cricket", or "Himalayas".</p>
                </div>
                @endif
            @else
                <div class="text-center py-5 bg-body-tertiary rounded-4">
                    <div class="fs-1 text-muted"><i class="fas fa-keyboard"></i></div>
                    <h5 class="fw-bold mt-3">Enter a keyword to start searching</h5>
                    <p class="text-muted">Browse some trending tags instead:</p>
                    <div class="d-flex flex-wrap gap-2 justify-content-center mt-3">
                        @foreach(\App\Support\MockData::getTrendingTags() as $tag)
                        <a href="/tag/{{ strtolower($tag) }}" class="btn btn-sm btn-outline-primary rounded-pill fw-semibold">#{{ $tag }}</a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            @include('components.widgets', ['type' => 'trending'])
            @include('components.widgets', ['type' => 'newsletter'])
        </div>
    </div>

</div>
@endsection
