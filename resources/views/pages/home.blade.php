@extends('layouts.app')

@section('title', 'Rivaaz Chronicle - Premium News Portal')

@section('content')
<div class="container-xl">
    
    <!-- 1. Web Stories Section (Instagram Style) -->
    <section class="mb-4">
        <h5 class="headline-font mb-3 fw-bold text-uppercase d-flex align-items-center gap-2">
            <span class="d-inline-block bg-primary rounded-circle" style="width:8px; height:8px;"></span>
            Web Stories
        </h5>
        <div class="stories-container">
            @foreach($webStories as $story)
            <div class="story-card" data-story-id="{{ $story['id'] }}">
                <img src="{{ $story['image'] }}" alt="{{ $story['title'] }}">
                <div class="story-avatar-container">
                    <img src="{{ $story['avatar'] }}" alt="{{ $story['user'] }}">
                </div>
                <div class="story-caption">{{ $story['title'] }}</div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- 2. Hero Section -->
    <section class="mb-5">
        <div class="row g-4">
            <!-- Left Hero Featured Card (Large News) -->
            <div class="col-lg-8">
                <div class="hero-featured-card">
                    <img src="{{ $featured['image'] }}" alt="{{ $featured['title'] }}">
                    <div class="hero-gradient">
                        <div class="mb-2">
                            <span class="badge-category badge-gold animate-pulse me-2">Breaking</span>
                            <span class="badge-category">{{ $featured['category'] }}</span>
                        </div>
                        <h1 class="hero-title">
                            <a href="/news/{{ $featured['slug'] }}">{{ $featured['title'] }}</a>
                        </h1>
                        <p class="d-none d-md-block opacity-90 small mb-3">{{ $featured['summary'] }}</p>
                        <div class="d-flex align-items-center gap-3 small text-white-50">
                            <span><i class="far fa-user me-1"></i> {{ $featured['author']['name'] }}</span>
                            <span><i class="far fa-clock me-1"></i> {{ $featured['published_at'] }}</span>
                            <span><i class="far fa-eye me-1"></i> {{ $featured['views'] }} views</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Sidebar (Trending, Stocks, Weather) -->
            <div class="col-lg-4">
                <div class="row g-4">
                    <div class="col-12">
                        @include('components.widgets', ['type' => 'trending'])
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. Breaking Ticker & Stocks for Mid-Screen Row -->
    <section class="mb-5">
        <div class="row g-4">
            <div class="col-lg-8">
                @include('components.widgets', ['type' => 'live_timeline'])
            </div>
            <div class="col-lg-4">
                @include('components.widgets', ['type' => 'stocks'])
                @include('components.widgets', ['type' => 'weather'])
            </div>
        </div>
    </section>

    <!-- 4. Latest News Grid -->
    <section class="mb-5">
        <h3 class="headline-font mb-4 fw-bold text-uppercase d-flex align-items-center justify-content-between border-bottom pb-2">
            <span>Latest News Grid</span>
            <span class="fs-7 text-primary text-lowercase fw-normal">all stories <i class="fas fa-angle-right"></i></span>
        </h3>
        
        <div class="row g-4" id="loadMoreContainer">
            @foreach(array_slice($others, 0, 4) as $article)
            <div class="col-md-6 col-lg-3">
                <div class="news-card">
                    <div class="card-img-container">
                        <img src="{{ $article['image'] }}" alt="{{ $article['title'] }}">
                    </div>
                    <div class="card-body">
                        <span class="badge-category mb-2">{{ $article['category'] }}</span>
                        <h5 class="card-title">
                            <a href="/news/{{ $article['slug'] }}">{{ $article['title'] }}</a>
                        </h5>
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
        
        <div class="text-center mt-4">
            <button class="btn btn-outline-primary rounded-pill px-4 fw-bold" id="loadMoreBtn">
                Load More <i class="fas fa-arrow-down ms-1"></i>
            </button>
        </div>
    </section>

    <!-- 5. Category blocks (Tech, Business, Politics) -->
    <section class="mb-5">
        <div class="row g-4">
            <!-- Politics Block -->
            <div class="col-lg-6 mb-4">
                <h4 class="headline-font mb-3 fw-bold text-uppercase border-bottom pb-2 border-primary border-2">Politics</h4>
                <div class="row g-3">
                    @php
                        $politics = collect($others)->filter(fn($a) => $a['category'] === 'politics')->values();
                    @endphp
                    @if($politics->count() > 0)
                        <div class="col-md-6">
                            <div class="news-card">
                                <div class="card-img-container" style="aspect-ratio:4/3;">
                                    <img src="{{ $politics[0]['image'] }}" alt="{{ $politics[0]['title'] }}">
                                </div>
                                <div class="card-body">
                                    <h6 class="card-title fw-bold"><a href="/news/{{ $politics[0]['slug'] }}">{{ $politics[0]['title'] }}</a></h6>
                                    <small class="text-muted">{{ $politics[0]['published_at'] }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex flex-column gap-2">
                            @foreach($politics->slice(1, 3) as $side)
                            <div class="news-horizontal-row py-2">
                                <div class="row-content">
                                    <h6 class="row-title fw-bold fs-7 mb-1"><a href="/news/{{ $side['slug'] }}">{{ $side['title'] }}</a></h6>
                                    <small class="text-muted">{{ $side['read_time'] }}</small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Tech Block -->
            <div class="col-lg-6 mb-4">
                <h4 class="headline-font mb-3 fw-bold text-uppercase border-bottom pb-2 border-primary border-2">Technology</h4>
                <div class="row g-3">
                    @php
                        $tech = collect($others)->filter(fn($a) => $a['category'] === 'technology')->values();
                    @endphp
                    @if($tech->count() > 0)
                        <div class="col-md-6">
                            <div class="news-card">
                                <div class="card-img-container" style="aspect-ratio:4/3;">
                                    <img src="{{ $tech[0]['image'] }}" alt="{{ $tech[0]['title'] }}">
                                </div>
                                <div class="card-body">
                                    <h6 class="card-title fw-bold"><a href="/news/{{ $tech[0]['slug'] }}">{{ $tech[0]['title'] }}</a></h6>
                                    <small class="text-muted">{{ $tech[0]['published_at'] }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex flex-column gap-2">
                            @foreach($tech->slice(1, 3) as $side)
                            <div class="news-horizontal-row py-2">
                                <div class="row-content">
                                    <h6 class="row-title fw-bold fs-7 mb-1"><a href="/news/{{ $side['slug'] }}">{{ $side['title'] }}</a></h6>
                                    <small class="text-muted">{{ $side['read_time'] }}</small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- 6. Video Section -->
    <section class="mb-5 bg-dark text-white p-4 rounded-4 shadow">
        <h3 class="headline-font mb-4 fw-bold text-uppercase text-white border-bottom border-secondary pb-2 d-flex align-items-center justify-content-between">
            <span>Featured Video Gallery</span>
            <a href="/videos" class="text-decoration-none fs-7 text-primary text-lowercase">More Videos <i class="fas fa-angle-right"></i></a>
        </h3>
        <div class="row g-4">
            <div class="col-lg-7">
                <div class="video-featured-player">
                    <div class="video-placeholder-cover" style="background-image: url('{{ $videos[1]['image'] }}')">
                        <button class="play-btn" onclick="alert('Playing featured video simulation...')" aria-label="Play video"><i class="fas fa-play"></i></button>
                    </div>
                </div>
                <h4 class="headline-font text-white mb-2">{{ $videos[1]['title'] }}</h4>
                <p class="text-white-50 small mb-0">{{ $videos[1]['views'] }} • {{ $videos[1]['date'] }}</p>
            </div>
            <div class="col-lg-5">
                <div class="d-flex flex-column gap-3">
                    @foreach(array_slice($videos, 1, 3) as $vid)
                    <div class="d-flex gap-3 align-items-center bg-secondary bg-opacity-10 p-2 rounded-3 border border-secondary border-opacity-25" style="cursor:pointer;" onclick="alert('Loading video: {{ $vid['title'] }}')">
                        <div class="position-relative flex-shrink-0" style="width:120px; height:75px; border-radius:6px; overflow:hidden;">
                            <img src="{{ $vid['image'] }}" class="w-100 h-100 object-fit-cover" alt="Video cover">
                            <span class="position-absolute bottom-0 end-0 bg-dark text-white fs-9 px-1 m-1 rounded-1"><i class="fas fa-play me-1 fs-10"></i>{{ $vid['duration'] }}</span>
                        </div>
                        <div>
                            <h6 class="text-white mb-1 fw-bold fs-7 line-clamp-2">{{ $vid['title'] }}</h6>
                            <small class="text-white-50 fs-9">{{ $vid['views'] }}</small>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- 7. Photo Gallery Masonry -->
    <section class="mb-5">
        <h3 class="headline-font mb-4 fw-bold text-uppercase border-bottom pb-2">Photo Gallery</h3>
        <div class="masonry-gallery">
            @foreach($photos as $album)
            <div class="masonry-item {{ $album['size'] }}" onclick="alert('Viewing photo album: {{ $album['title'] }}')">
                <img src="{{ $album['image'] }}" alt="{{ $album['title'] }}">
                <div class="masonry-overlay">
                    <span class="badge-category badge-gold mb-2 py-0 px-2 align-self-start" style="font-size:0.65rem;">{{ $album['category'] }}</span>
                    <h5 class="fw-bold text-white mb-1 fs-6">{{ $album['title'] }}</h5>
                    <small class="text-white-50"><i class="far fa-images me-1"></i> {{ $album['count'] }} Photos</small>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- 8. Opinion Section (Authors) -->
    <section class="mb-5">
        <h3 class="headline-font mb-4 fw-bold text-uppercase border-bottom pb-2">Opinion & Editorials</h3>
        <div class="row g-4">
            @foreach(\App\Support\MockData::getAuthors() as $key => $author)
            <div class="col-md-6 col-lg-3">
                <div class="opinion-card">
                    <img src="{{ $author['avatar'] }}" alt="{{ $author['name'] }}" class="author-avatar">
                    <h5 class="author-name">{{ $author['name'] }}</h5>
                    <div class="author-role">{{ $author['title'] }}</div>
                    <p class="opinion-title">
                        <a href="/author/{slug}" onclick="event.preventDefault(); window.location.href='/author/{{ $key }}';">"Why the Green Energy Transition is Not Just Clean, but Economically Crucial for 2026"</a>
                    </p>
                    <a href="/author/{{ $key }}" class="btn btn-sm btn-link text-decoration-none p-0 mt-2 fw-semibold">Read Columns <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- 9. Editors Pick & Trending Tags & Newsletter -->
    <section class="mb-4">
        <div class="row g-4">
            <!-- Editors Pick (Left) -->
            <div class="col-lg-8">
                <h4 class="headline-font mb-3 fw-bold text-uppercase border-bottom pb-2">Editor's Pick</h4>
                <div class="row g-3">
                    @foreach(array_slice($others, 1, 2) as $article)
                    <div class="col-md-6">
                        <div class="news-card">
                            <div class="card-img-container">
                                <img src="{{ $article['image'] }}" alt="{{ $article['title'] }}">
                            </div>
                            <div class="card-body">
                                <span class="badge-category mb-2">{{ $article['category'] }}</span>
                                <h5 class="card-title"><a href="/news/{{ $article['slug'] }}">{{ $article['title'] }}</a></h5>
                                <p class="text-muted small line-clamp-2">{{ $article['summary'] }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Trending Tags & Newsletter (Right) -->
            <div class="col-lg-4">
                <div class="widget-box">
                    <div class="widget-title">
                        <span><i class="fas fa-tags text-primary me-2"></i>Trending Tags</span>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($tags as $tag)
                        <a href="/tag/{{ strtolower($tag) }}" class="btn btn-sm btn-outline-secondary rounded-pill fw-medium fs-8">#{{ $tag }}</a>
                        @endforeach
                    </div>
                </div>
                
                @include('components.widgets', ['type' => 'newsletter'])
            </div>
        </div>
    </section>

</div>
@endsection
