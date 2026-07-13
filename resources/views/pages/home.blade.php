@extends('layouts.app')

@section('title', 'Rivaaz Chronicle - Premium News Portal')

@section('content')
<div class="container-xl">
    
    <!-- 1. Hero Section (3-Column Content Hierarchy) -->
    <section class="mb-5">
        <div class="row g-4">
            <!-- Left Column: TOP NEWS (Large Story + horizontal items) -->
            <div class="col-lg-5 col-md-12">
                <h5 class="headline-font mb-3 fw-bold text-uppercase border-bottom pb-2 border-dark border-2" style="font-size:0.95rem; letter-spacing:0.5px;">Top News</h5>
                <div class="mb-4 d-flex flex-column">
                    <a href="/news/{{ $featured['slug'] }}" class="order-2 order-md-1">
                        <img src="{{ $featured['image'] }}" class="w-100 rounded-3 mb-3" style="aspect-ratio: 16/10; object-fit: cover;" alt="{{ $featured['title'] }}">
                    </a>
                    <h3 class="fw-extrabold mb-2 order-1 order-md-2" style="font-size: 1.6rem; line-height: 1.25;">
                        <a href="/news/{{ $featured['slug'] }}" class="text-reset hover-primary">{{ $featured['title'] }}</a>
                    </h3>
                    <p class="text-muted small mb-2 order-3">{{ $featured['summary'] }}</p>
                    <div class="d-flex align-items-center gap-2 text-uppercase fw-bold text-muted mb-2 order-4" style="font-size:0.65rem; letter-spacing:0.5px;">
                        <a href="/category/{{ $featured['category'] }}" class="category-label">{{ $featured['category'] }}</a>
                    </div>
                </div>

                @foreach(array_slice($others, 0, 2) as $article)
                <div class="news-horizontal-row border-0 border-top py-3 border-secondary-subtle">
                    <div class="row-content">
                        @if($article['is_breaking'])
                        <span class="text-danger fw-bold fs-9 me-1"><i class="fas fa-circle me-1" style="font-size: 6px; vertical-align: middle;"></i> LIVE</span>
                        @endif
                        <h6 class="fw-bold fs-7 mb-2 lh-base">
                            <a href="/news/{{ $article['slug'] }}" class="text-reset hover-primary">{{ $article['title'] }}</a>
                        </h6>
                        <div class="d-flex align-items-center gap-2 text-uppercase fw-bold text-muted" style="font-size:0.65rem; letter-spacing:0.5px;">
                            <a href="/category/{{ $article['category'] }}" class="category-label">{{ $article['category'] }}</a>
                        </div>
                    </div>
                    <div class="row-img-container">
                        <img src="{{ $article['image'] }}" class="w-100 h-100 object-fit-cover" alt="Thumb">
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Center Column: LIVE TV + Feed -->
            <div class="col-lg-4 col-md-7 border-start-lg ps-lg-4">
                <h5 class="headline-font mb-3 fw-bold text-uppercase border-bottom pb-2 border-dark border-2" style="font-size:0.95rem; letter-spacing:0.5px;">Live TV</h5>
                <div class="position-relative rounded-3 overflow-hidden mb-3" style="aspect-ratio: 16/9; background-color: #000; box-shadow: 0 4px 10px rgba(0,0,0,0.15);">
                    <img src="https://images.unsplash.com/photo-1585829365295-ab7cd400c167?auto=format&fit=crop&w=600&q=80" class="w-100 h-100 object-fit-cover opacity-75" alt="Live stream cover">
                    <span class="position-absolute top-0 start-0 m-2 badge bg-danger animate-pulse py-1 px-2 fw-bold fs-9">LIVE TV</span>
                    <button class="position-absolute top-50 end-50 translate-middle btn btn-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;" onclick="alert('Playing live news broadcast...');" aria-label="Play live feed"><i class="fas fa-play"></i></button>
                </div>

                @foreach(array_slice($others, 2, 3) as $article)
                <div class="news-horizontal-row border-0 @if(!$loop->first) border-top border-secondary-subtle @endif py-3">
                    <div class="row-content">
                        <h6 class="fw-bold fs-7 mb-2 lh-base">
                            <a href="/news/{{ $article['slug'] }}" class="text-reset hover-primary">{{ $article['title'] }}</a>
                        </h6>
                        <div class="d-flex align-items-center gap-2 text-uppercase fw-bold text-muted" style="font-size:0.65rem; letter-spacing:0.5px;">
                            <a href="/category/{{ $article['category'] }}" class="category-label">{{ $article['category'] }}</a>
                        </div>
                    </div>
                    <div class="row-img-container center-row-thumb">
                        <img src="{{ $article['image'] }}" class="w-100 h-100 object-fit-cover" alt="Thumb">
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Right Column: Trending stories widget (no numbers) -->
            <div class="col-lg-3 col-md-5 border-start-lg ps-lg-4">
                @include('components.widgets', ['type' => 'trending'])
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
                <!-- Trending Tags Widget -->
                <div class="widget-box mb-3">
                    <div class="widget-title">
                        <span><i class="fas fa-tags text-primary me-2"></i>Trending Tags</span>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($tags as $tag)
                        <a href="/tag/{{ strtolower($tag) }}" class="trending-tag-btn">#{{ $tag }}</a>
                        @endforeach
                    </div>
                </div>
                @include('components.widgets', ['type' => 'weather'])
                <div class="mt-4">
                    @include('components.widgets', ['type' => 'newsletter'])
                </div>
            </div>
        </div>
    </section>


    <!-- 5. Category blocks (Tech, Politics) -->
    <section class="mb-5">
        @php
            $politics = collect($others)->filter(fn($a) => strtolower($a['category']) === 'politics')->values();
            if ($politics->count() < 5) {
                $politics = $politics->concat(collect($others)->filter(fn($a) => strtolower($a['category']) !== 'politics'))->unique('id')->values();
            }

            $tech = collect($others)->filter(fn($a) => strtolower($a['category']) === 'technology')->values();
            if ($tech->count() < 5) {
                $tech = $tech->concat(collect($others)->filter(fn($a) => strtolower($a['category']) !== 'technology'))->unique('id')->values();
            }
        @endphp

        <!-- Politics Category (Full Width Row) -->
        <div class="mb-5">
            <div class="d-flex justify-content-between align-items-center mb-3 border-bottom border-secondary border-3 pb-1">
                <h3 class="headline-font fw-bold text-uppercase mb-0 fs-4 text-body" style="letter-spacing: 0.5px;">Politics</h3>
                <a href="/category/politics" class="text-decoration-none text-secondary fw-bold fs-8 text-uppercase">Politics News <i class="fas fa-angle-right ms-1"></i></a>
            </div>
            <div class="row g-4">
                <!-- Left: Headline on TOP, Image below -->
                <div class="col-lg-7">
                    <div class="featured-block mb-3">
                        <h4 class="fw-bold mb-3 fs-3" style="line-height: 1.25; letter-spacing: -0.5px;">
                            <a href="/news/{{ $politics[0]['slug'] }}" class="text-reset text-decoration-none hover-primary">{{ $politics[0]['title'] }}</a>
                        </h4>
                        <div class="rounded-3 overflow-hidden" style="aspect-ratio: 16/9; border: 1px solid var(--border-color);">
                            <img src="{{ $politics[0]['image'] }}" class="w-100 h-100 object-fit-cover" alt="Featured News Image">
                        </div>
                    </div>
                </div>
                <!-- Right: Stack of 4 horizontal row-list items with image on the right -->
                <div class="col-lg-5">
                    <div class="d-flex flex-column gap-3 h-100 justify-content-between">
                        @foreach($politics->slice(1, 4) as $idx => $art)
                        <div class="d-flex justify-content-between align-items-center gap-3 pb-3 @if(!$loop->last) border-bottom border-secondary-subtle @endif">
                            <div class="flex-grow-1">
                                <h6 class="fw-bold fs-7 mb-1" style="line-height: 1.35;">
                                    <a href="/news/{{ $art['slug'] }}" class="text-reset text-decoration-none hover-primary">{{ $art['title'] }}</a>
                                </h6>
                                <small class="text-muted fs-9">{{ $art['published_at'] ?? $art['read_time'] }}</small>
                            </div>
                            <div class="flex-shrink-0" style="width: 100px; height: 60px; border-radius: 6px; overflow: hidden; border: 1px solid var(--border-color);">
                                <img src="{{ $art['image'] }}" class="w-100 h-100 object-fit-cover" alt="Thumbnail">
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Technology Category (Full Width Row) -->
        <div class="mb-5">
            <div class="d-flex justify-content-between align-items-center mb-3 border-bottom border-secondary border-3 pb-1">
                <h3 class="headline-font fw-bold text-uppercase mb-0 fs-4 text-body" style="letter-spacing: 0.5px;">Technology</h3>
                <a href="/category/technology" class="text-decoration-none text-secondary fw-bold fs-8 text-uppercase">Tech News <i class="fas fa-angle-right ms-1"></i></a>
            </div>
            <div class="row g-4">
                <!-- Left: Headline on TOP, Image below -->
                <div class="col-lg-7">
                    <div class="featured-block mb-3">
                        <h4 class="fw-bold mb-3 fs-3" style="line-height: 1.25; letter-spacing: -0.5px;">
                            <a href="/news/{{ $tech[0]['slug'] }}" class="text-reset text-decoration-none hover-primary">{{ $tech[0]['title'] }}</a>
                        </h4>
                        <div class="rounded-3 overflow-hidden" style="aspect-ratio: 16/9; border: 1px solid var(--border-color);">
                            <img src="{{ $tech[0]['image'] }}" class="w-100 h-100 object-fit-cover" alt="Featured News Image">
                        </div>
                    </div>
                </div>
                <!-- Right: Stack of 4 horizontal row-list items with image on the right -->
                <div class="col-lg-5">
                    <div class="d-flex flex-column gap-3 h-100 justify-content-between">
                        @foreach($tech->slice(1, 4) as $idx => $art)
                        <div class="d-flex justify-content-between align-items-center gap-3 pb-3 @if(!$loop->last) border-bottom border-secondary-subtle @endif">
                            <div class="flex-grow-1">
                                <h6 class="fw-bold fs-7 mb-1" style="line-height: 1.35;">
                                    <a href="/news/{{ $art['slug'] }}" class="text-reset text-decoration-none hover-primary">{{ $art['title'] }}</a>
                                </h6>
                                <small class="text-muted fs-9">{{ $art['published_at'] ?? $art['read_time'] }}</small>
                            </div>
                            <div class="flex-shrink-0" style="width: 100px; height: 60px; border-radius: 6px; overflow: hidden; border: 1px solid var(--border-color);">
                                <img src="{{ $art['image'] }}" class="w-100 h-100 object-fit-cover" alt="Thumbnail">
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. Latest News Grid -->
    <section class="mb-5">
        <h3 class="headline-font mb-4 fw-bold text-uppercase d-flex align-items-end justify-content-between position-relative pb-2" style="border-bottom: 1px solid var(--border-color);">
            <span class="position-relative pb-2" style="margin-bottom: -9px;">
                LATEST NEWS
                <span class="position-absolute start-0 bottom-0 bg-primary" style="height: 3px; width: 40px;"></span>
            </span>
            <a href="/archive" class="fs-7 text-primary text-decoration-none text-uppercase fw-bold d-flex align-items-center gap-1">All stories <i class="fas fa-arrow-right"></i></a>
        </h3>
        
        <div class="row g-4" id="loadMoreContainer">
            @foreach(array_slice($others, 0, 6) as $article)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="latest-news-horizontal-card">
                    <div class="latest-card-img-wrap">
                        <img src="{{ $article['image'] }}" alt="{{ $article['title'] }}">
                    </div>
                    <div class="latest-card-content">
                        <span class="latest-card-category text-uppercase">{{ $article['category'] }}</span>
                        <h5 class="latest-card-title">
                            <a href="/news/{{ $article['slug'] }}">{{ $article['title'] }}</a>
                        </h5>
                        <p class="latest-card-summary">{{ $article['summary'] }}</p>
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

    <!-- 8. Opinion Section (Authors) -->
    <!-- <section class="mb-5">
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
    </section> -->


</div>
@endsection
