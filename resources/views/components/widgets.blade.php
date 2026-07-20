@php
    $stocks = \App\Support\MockData::getStocks();
    $weather = \App\Support\MockData::getWeather();
    $trending = \App\Models\Article::with('category')->orderByDesc('views')->take(5)->get();
    $liveUpdates = \App\Models\Article::latest()->take(4)->get();
    $videos = \App\Models\Article::whereIn('media_type', ['video_file', 'video_link'])->orderByDesc('created_at')->take(4)->get();
@endphp

<!-- 1. Stock Widget -->
@if($type === 'stocks')
<div class="widget-box">
    <div class="widget-title">
        <span><i class="fas fa-chart-line text-primary me-2"></i>शेयर बाज़ार</span>
        <span class="badge bg-success-subtle text-success border border-success-subtle fs-9">लाइव अपडेट्स</span>
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
        <span><i class="fas fa-cloud-sun text-warning me-2"></i>मौसम</span>
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
        <span><i class="fas fa-fire text-danger me-2"></i>लोकप्रिय समाचार</span>
    </div>
    <div class="d-flex flex-column">
        @foreach($trending as $article)
        <div class="py-3 @if(!$loop->last) border-bottom @endif">
            <h6 class="mb-2 fw-bold fs-6 lh-base">
                <a href="/news/{{ $article->slug }}" class="text-reset hover-primary">{{ $article->title }}</a>
            </h6>
            @if($article->category)
            <div class="d-flex align-items-center gap-2 text-uppercase fw-bold text-muted" style="font-size:0.65rem; letter-spacing:0.5px;">
                <a href="/category/{{ $article->category->slug }}" class="category-label">{{ $article->category->name }}</a>
            </div>
            @endif
        </div>
        @endforeach
    </div>
</div>
@endif

<!-- 4. Live Updates Timeline -->
@if($type === 'live_timeline')
<div class="widget-box">
    <div class="widget-title">
        <span><i class="fas fa-newspaper text-danger me-2"></i>ताज़ा ख़बरें</span>
    </div>
    <div class="live-timeline">
        @foreach($liveUpdates as $event)
        <div class="live-item @if($loop->first) live-active @endif d-flex gap-3 align-items-start py-3">
            <!-- Small image on the side -->
            <div class="flex-shrink-0" style="width: 70px; height: 70px; border-radius: 8px; overflow: hidden; border: 1px solid var(--border-color);">
                <img src="{{ $event->image_path ?? 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&w=150&q=80' }}" class="w-100 h-100 object-fit-cover" alt="Live Event Image">
            </div>

            <!-- Content Area -->
            <div class="flex-grow-1">
                <h6 class="fw-bold fs-7 mb-1" style="line-height: 1.35;">
                    <a href="/news/{{ $event->slug }}" class="text-reset hover-primary">{{ $event->title }}</a>
                </h6>
                <p class="text-muted fs-8 mb-2 line-clamp-2">{{ $event->summary ?? \Illuminate\Support\Str::limit(strip_tags($event->content), 120) }}</p>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-danger bg-opacity-10 text-danger fw-bold border border-danger border-opacity-25 fs-9" style="padding: 2px 6px;">
                        @if($event->published_at)
                            {{ $event->published_at->format('H:i A') }}
                        @else
                            {{ $event->created_at->format('H:i A') }}
                        @endif
                    </span>
                    @php
                        $firstTag = null;
                        if (!empty($event->tags)) {
                            $tagsArray = explode(',', $event->tags);
                            $firstTag = trim($tagsArray[0]);
                            $firstTag = ltrim($firstTag, '#');
                        }
                    @endphp
                    @if($firstTag)
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle fs-9">#{{ $firstTag }}</span>
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
@if(isset($videos) && count($videos) > 0)
<div class="widget-box">
    <div class="widget-title">
        <span><i class="fas fa-play-circle text-primary me-2"></i>नवीनतम वीडियो</span>
        <a href="/videos" class="text-decoration-none fs-8 fw-semibold">और वीडियो देखें</a>
    </div>
    <div class="d-flex flex-column gap-3">
        @foreach($videos as $video)
        <div class="news-horizontal-row py-0 border-0">
            <div class="row-img-container position-relative" style="width: 100px; height: 65px; border-radius: 6px; overflow: hidden;">
                <img src="{{ $video->image_path ?? 'https://images.unsplash.com/photo-1574717024653-61fd2cf4d44d?auto=format&fit=crop&w=300&q=80' }}" class="w-100 h-100 object-fit-cover" alt="{{ $video->title }}">
                <span class="position-absolute bottom-0 end-0 bg-dark text-white fs-9 px-1 m-1 rounded-1"><i class="fas fa-play me-1 fs-10"></i>वीडियो</span>
            </div>
            <div class="row-content">
                <h6 class="row-title fw-bold fs-8 line-clamp-2 mb-1">
                    <a href="/news/{{ $video->slug }}" class="text-reset hover-primary">{{ $video->title }}</a>
                </h6>
                <small class="text-muted fs-9">{{ $video->created_at->format('M d, Y') }}</small>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif
@endif

<!-- 6. Newsletter Widget -->
@if($type === 'newsletter')
<!-- Newsletter disabled globally -->
@endif
