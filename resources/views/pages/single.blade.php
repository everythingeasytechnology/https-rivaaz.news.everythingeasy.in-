@extends('layouts.app')

@section('title', $article['title'] . ' - Rivaaz Chronicle')
@section('meta_description', $article['subtitle'])

@section('content')
<div class="container-xl">
    
    <!-- 1. Breadcrumbs -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb small fw-semibold">
            <li class="breadcrumb-item"><a href="/">होम</a></li>
            <li class="breadcrumb-item"><a href="/category/{{ $article['category'] }}">{{ $article['category_name'] ?? ucfirst($article['category']) }}</a></li>
            @if(!empty($article['subcategory']))
            <li class="breadcrumb-item"><a href="/category/{{ $article['category'] }}/{{ strtolower(str_replace(' ', '-', $article['subcategory'])) }}">{{ $article['subcategory'] }}</a></li>
            @endif
            <li class="breadcrumb-item active text-truncate" aria-current="page" style="max-width:250px;">{{ $article['title'] }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- Social Share Sticky (Left Col - 1 Grid Unit Desktop Only) -->
        <div class="col-lg-1 d-none d-lg-block">
            <div class="share-sticky text-center">
                <small class="text-muted text-uppercase fw-bold d-block mb-2" style="font-size:0.6rem; letter-spacing:0.5px;">शेयर करें</small>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank" class="share-btn" aria-label="Share Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($article['title']) }}" target="_blank" class="share-btn" aria-label="Share Twitter"><i class="fab fa-twitter"></i></a>
                <a href="https://api.whatsapp.com/send?text={{ urlencode($article['title'] . ' ' . request()->fullUrl()) }}" target="_blank" class="share-btn" aria-label="Share WhatsApp"><i class="fab fa-whatsapp"></i></a>
                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->fullUrl()) }}&title={{ urlencode($article['title']) }}" target="_blank" class="share-btn" aria-label="Share LinkedIn"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>

        <!-- Main News Column (7 Grid Units) -->
        <div class="col-lg-7">
            
            <!-- Category Badge -->
            <span class="badge-category badge-gold mb-2">{{ $article['subcategory'] ?: ($article['category_name'] ?? '') }}</span>
            
            <!-- Headline -->
            <h1 class="headline-font fw-extrabold mb-3" style="font-size: 2.5rem; line-height: 1.2;">{{ $article['title'] }}</h1>
            
            <!-- Subtitle -->
            <p class="fs-5 text-muted mb-4 fw-medium" style="line-height: 1.5;">{{ $article['subtitle'] }}</p>
            
            <!-- Clean Metadata Line -->
            <div class="text-muted small mb-4 py-2 border-bottom border-top border-secondary-subtle d-flex flex-wrap align-items-center gap-2">
                <span>द्वारा <a href="/author/{{ $article['author_key'] }}" class="text-reset fw-semibold text-decoration-none hover-primary">{{ $article['author']['name'] }}</a></span>
                <span class="text-secondary-subtle">|</span>
                <span>{{ $article['author']['title'] }}</span>
                <span class="text-secondary-subtle">|</span>
                <span>प्रकाशित: {{ $article['published_at'] }}</span>
                <span class="text-secondary-subtle">|</span>
                <span><i class="far fa-clock"></i> {{ $article['read_time'] }}</span>
            </div>

            <!-- Cover Media (Image or Video) -->
            <div class="mb-4 rounded-4 overflow-hidden shadow-sm position-relative" style="aspect-ratio: 16/9; background: #000;">
                @if($article['is_video'])
                    @if($article['media_type'] === 'video_link' && (str_contains($article['video_url'], 'youtube.com') || str_contains($article['video_url'], 'youtube-nocookie.com') || str_contains($article['video_url'], 'vimeo.com') || str_contains($article['video_url'], 'embed')))
                        <iframe class="w-100 h-100 border-0" src="{{ $article['video_url'] }}" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                    @else
                        <video src="{{ $article['video_url'] }}" class="w-100 h-100 object-fit-cover" controls playsinline></video>
                    @endif
                @else
                    <img src="{{ $article['image'] }}" class="w-100 h-100 object-fit-cover" alt="Article banner">
                @endif
            </div>

            <!-- Article Body Content -->
            <article class="article-container font-size-md" id="articleBodyContainer">
                <div class="article-body">
                    {!! $article['content'] !!}
                </div>
            </article>

            <!-- Tags section -->
            <div class="d-flex flex-wrap gap-2 border-top border-bottom py-3 my-4 border-secondary-subtle">
                <span class="fw-bold text-uppercase fs-8 text-muted d-flex align-items-center"><i class="fas fa-tags me-1"></i> टैग:</span>
                @foreach($article['tags'] as $tag)
                <a href="/tag/{{ strtolower($tag) }}" class="tag-badge">#{{ $tag }}</a>
                @endforeach
            </div>


            <!-- Related News & Videos -->
            <section class="mb-4">
                <h4 class="headline-font mb-3 fw-bold border-bottom pb-2 text-uppercase">संबंधित खबरें</h4>
                <div class="row g-3">
                    @foreach($related as $rel)
                    <div class="col-md-4">
                        <div class="news-card">
                            <div class="card-img-container" style="aspect-ratio:16/10;">
                                <img src="{{ $rel['image'] }}" alt="{{ $rel['title'] }}">
                            </div>
                            <div class="card-body p-2">
                                <h6 class="card-title fw-bold fs-7 mb-1" style="line-height:1.3;">
                                    <a href="/news/{{ $rel['slug'] }}">{{ $rel['title'] }}</a>
                                </h6>
                                <small class="text-muted fs-8">{{ $rel['read_time'] }}</small>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>

        </div>

        <!-- Right Column Sidebar (4 Grid Units) -->
        <div class="col-lg-4">
            


            @include('components.widgets', ['type' => 'latest_videos'])
            @include('components.widgets', ['type' => 'trending'])
            @include('components.widgets', ['type' => 'newsletter'])
        </div>
    </div>

</div>
@endsection
