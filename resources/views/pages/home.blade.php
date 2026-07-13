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
                        <a href="/tag/{{ strtolower($tag) }}" class="btn btn-sm btn-outline-secondary rounded-pill fw-medium fs-8">#{{ $tag }}</a>
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

    <!-- 4. Latest News Grid -->
    <section class="mb-5">
        <h3 class="headline-font mb-4 fw-bold text-uppercase d-flex align-items-center justify-content-between border-bottom pb-2">
            <span>Latest News Grid</span>
            <span class="fs-7 text-primary text-lowercase fw-normal">all stories <i class="fas fa-angle-right"></i></span>
        </h3>
        
        <div class="row g-3" id="loadMoreContainer">
            @foreach(array_slice($others, 0, 6) as $article)
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                <div class="news-card mini-news-box">
                    <div class="card-img-container">
                        <img src="{{ $article['image'] }}" alt="{{ $article['title'] }}">
                    </div>
                    <div class="card-body">
                        <span class="badge-category mb-1">{{ $article['category'] }}</span>
                        <h6 class="card-title fw-bold">
                            <a href="/news/{{ $article['slug'] }}">{{ $article['title'] }}</a>
                        </h6>
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
                <h4 class="headline-font mb-3 fw-bold text-uppercase border-bottom pb-2 border-dark border-2">Politics</h4>
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
                <h4 class="headline-font mb-3 fw-bold text-uppercase border-bottom pb-2 border-dark border-2">Technology</h4>
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
