@php
    $stocks = \App\Support\MockData::getStocks();
    $weather = \App\Support\MockData::getWeather();
    $trending = collect(\App\Support\MockData::getArticles())->sortByDesc('views')->take(5);
    $liveUpdates = \App\Support\MockData::getLiveEvents();
    $videos = \App\Support\MockData::getVideos();
@endphp

<!-- 1. Stock Widget -->
@if($type === 'stocks')
<div class="widget-box">
    <div class="widget-title">
        <span><i class="fas fa-chart-line text-primary me-2"></i>Stock Market</span>
        <span class="badge bg-success-subtle text-success border border-success-subtle fs-9">Live Updates</span>
    </div>
    <div class="stock-indices-list">
        @foreach($stocks as $stock)
        <div class="stock-index-row">
            <span class="fw-semibold">{{ $stock['name'] }}</span>
            <div class="text-end">
                <span class="fw-bold d-block">{{ $stock['value'] }}</span>
                <small class="{{ $stock['up'] ? 'index-up' : 'index-down' }} fw-medium">
                    <i class="fas {{ $stock['up'] ? 'fa-caret-up' : 'fa-caret-down' }} me-1"></i>{{ $stock['change'] }} ({{ $stock['pct'] }})
                </small>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

<!-- 2. Weather Widget -->
@if($type === 'weather')
<div class="widget-box">
    <div class="widget-title">
        <span><i class="fas fa-cloud-sun text-warning me-2"></i>Weather</span>
    </div>
    <div class="row align-items-center g-3">
        @foreach($weather as $city => $data)
        <div class="col-6 d-flex align-items-center gap-2 mb-2">
            <div class="fs-4 text-secondary-emphasis"><i class="fas {{ $data['icon'] }} text-primary"></i></div>
            <div>
                <span class="fw-semibold fs-7 d-block">{{ $city }}</span>
                <small class="text-muted">{{ $data['temp'] }} • {{ $data['condition'] }}</small>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

<!-- 3. Trending Stories Widget -->
@if($type === 'trending')
<div class="widget-box">
    <div class="widget-title">
        <span><i class="fas fa-fire text-danger me-2"></i>Trending Stories</span>
    </div>
    <div class="d-flex flex-column">
        @foreach($trending as $index => $article)
        <div class="py-3 @if(!$loop->last) border-bottom @endif">
            <h6 class="mb-2 fw-bold fs-6 lh-base">
                <a href="/news/{{ $article['slug'] }}" class="text-reset hover-primary">{{ $article['title'] }}</a>
            </h6>
            <div class="d-flex align-items-center gap-2 text-uppercase fw-bold text-muted" style="font-size:0.65rem; letter-spacing:0.5px;">
                <a href="/category/{{ $article['category'] }}" class="category-label">{{ $article['category'] }}</a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

<!-- 4. Live Updates Timeline -->
@if($type === 'live_timeline')
<div class="widget-box">
    <div class="widget-title">
        <span><i class="fas fa-broadcast-tower text-danger me-2 animate-pulse"></i>Live Updates</span>
        <a href="/live-blog/india-union-budget-2026-analysis" class="text-decoration-none fs-8 fw-semibold">View Blog</a>
    </div>
    <div class="live-timeline">
        @foreach($liveUpdates as $event)
        <div class="live-item @if($loop->first) live-active @endif d-flex gap-3 align-items-start py-3 border-bottom border-secondary-subtle">
            <!-- Small image on the side -->
            <div class="flex-shrink-0" style="width: 70px; height: 70px; border-radius: 8px; overflow: hidden; border: 1px solid var(--border-color);">
                <img src="{{ $event['image'] ?? 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&w=150&q=80' }}" class="w-100 h-100 object-fit-cover" alt="Live Event Image">
            </div>

            <!-- Content Area -->
            <div class="flex-grow-1">
                <h6 class="fw-bold fs-7 mb-1" style="line-height: 1.35;">{{ $event['title'] }}</h6>
                <p class="text-muted fs-8 mb-2 line-clamp-2">{{ $event['content'] }}</p>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-danger bg-opacity-10 text-danger fw-bold border border-danger border-opacity-25 fs-9" style="padding: 2px 6px;">{{ $event['time'] }}</span>
                    @if($event['tag'])
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle fs-9">#{{ $event['tag'] }}</span>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

<!-- 5. Latest Videos Widget -->
@if($type === 'latest_videos')
<div class="widget-box">
    <div class="widget-title">
        <span><i class="fas fa-play-circle text-primary me-2"></i>Latest Videos</span>
        <a href="/videos" class="text-decoration-none fs-8 fw-semibold">More Videos</a>
    </div>
    <div class="d-flex flex-column gap-3">
        @foreach($videos as $video)
        <div class="news-horizontal-row py-0 border-0">
            <div class="row-img-container position-relative" style="width: 100px; height: 65px;">
                <img src="{{ $video['image'] }}" alt="{{ $video['title'] }}">
                <span class="position-absolute bottom-0 end-0 bg-dark text-white fs-9 px-1 m-1 rounded-1"><i class="fas fa-play me-1 fs-10"></i>{{ $video['duration'] }}</span>
            </div>
            <div class="row-content">
                <h6 class="row-title fw-bold fs-8 line-clamp-2 mb-1">
                    <a href="/videos" class="text-reset hover-primary">{{ $video['title'] }}</a>
                </h6>
                <small class="text-muted fs-9">{{ $video['date'] }}</small>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

<!-- 6. Newsletter Widget -->
@if($type === 'newsletter')
<!-- Newsletter disabled globally -->
@endif
