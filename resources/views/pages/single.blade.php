@extends('layouts.app')

@section('title', $article['title'] . ' - Uttarakhand Now')
@section('meta_description', !empty($article['summary']) ? $article['summary'] : $article['subtitle'])
@section('meta_image', $article['image'])
@section('og_type', 'article')

@section('styles')
<style>
    /* Editor content may contain fixed dimensions; keep images phone-friendly
       even when the compiled Vite stylesheet has not yet been rebuilt. */
    .article-body img {
        max-width: 100% !important;
        height: auto !important;
    }
    .article-body figure {
        max-width: 100%;
        margin-left: 0;
        margin-right: 0;
    }
    @media (max-width: 767.98px) {
        .article-body img {
            width: auto !important;
            max-height: 65vh !important;
            display: block;
            margin-left: auto !important;
            margin-right: auto !important;
            object-fit: contain;
        }
    }
</style>
@endsection

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
                <a href="https://api.whatsapp.com/send?text={{ urlencode($article['title'] . "\n\n" . request()->fullUrl()) }}" target="_blank" class="share-btn text-success" title="WhatsApp" aria-label="Share on WhatsApp"><i class="fab fa-whatsapp fs-5"></i></a>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank" class="share-btn text-primary" title="Facebook" aria-label="Share on Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($article['title']) }}" target="_blank" class="share-btn text-body" title="X (Twitter)" aria-label="Share on Twitter"><i class="fab fa-x-twitter"></i></a>
                <a href="https://t.me/share/url?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($article['title']) }}" target="_blank" class="share-btn text-info" title="Telegram" aria-label="Share on Telegram"><i class="fab fa-telegram-plane"></i></a>
                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->fullUrl()) }}&title={{ urlencode($article['title']) }}" target="_blank" class="share-btn text-primary" title="LinkedIn" aria-label="Share on LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                <button type="button" class="share-btn border-0 text-muted copy-link-btn" data-url="{{ request()->fullUrl() }}" data-title="{{ $article['title'] }}" title="लिंक कॉपी करें" aria-label="Copy Link"><i class="fas fa-link"></i></button>
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
            <div class="text-muted small mb-3 py-2 border-bottom border-top border-secondary-subtle d-flex flex-wrap align-items-center justify-content-between gap-2">
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <span>द्वारा <a href="/author/{{ $article['author_key'] }}" class="text-reset fw-semibold text-decoration-none hover-primary">{{ $article['author']['name'] }}</a></span>
                    <span class="text-secondary-subtle">|</span>
                    <span>{{ $article['author']['title'] }}</span>
                    <span class="text-secondary-subtle">|</span>
                    <span>प्रकाशित: {{ $article['published_at'] }}</span>
                    <span class="text-secondary-subtle">|</span>
                    <span><i class="far fa-clock"></i> {{ $article['read_time'] }}</span>
                </div>
            </div>

            <!-- In-Article Top Social Share Bar (Visible on All Devices) -->
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 p-2 px-3 mb-4 rounded-3 bg-body-tertiary border border-secondary-subtle">
                <span class="small fw-bold text-muted text-uppercase d-flex align-items-center"><i class="fas fa-share-alt text-primary me-2"></i>शेयर करें:</span>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <a href="https://api.whatsapp.com/send?text={{ urlencode($article['title'] . "\n\n" . request()->fullUrl()) }}" target="_blank" class="btn btn-sm btn-success rounded-pill px-3 fw-semibold d-inline-flex align-items-center gap-1 shadow-sm" aria-label="Share on WhatsApp">
                        <i class="fab fa-whatsapp fs-6"></i> <span>WhatsApp</span>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank" class="btn btn-sm text-white rounded-pill px-3 fw-semibold d-inline-flex align-items-center gap-1 shadow-sm" style="background-color: #1877F2;" aria-label="Share on Facebook">
                        <i class="fab fa-facebook-f"></i> <span>Facebook</span>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($article['title']) }}" target="_blank" class="btn btn-sm btn-dark rounded-pill px-3 fw-semibold d-inline-flex align-items-center gap-1 shadow-sm" aria-label="Share on X">
                        <i class="fab fa-x-twitter"></i> <span>X</span>
                    </a>
                    <a href="https://t.me/share/url?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($article['title']) }}" target="_blank" class="btn btn-sm text-white rounded-pill px-3 fw-semibold d-inline-flex align-items-center gap-1 shadow-sm" style="background-color: #229ED9;" aria-label="Share on Telegram">
                        <i class="fab fa-telegram-plane"></i> <span>Telegram</span>
                    </a>
                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-semibold d-inline-flex align-items-center gap-1 copy-link-btn" data-url="{{ request()->fullUrl() }}" data-title="{{ $article['title'] }}" title="लिंक कॉपी करें">
                        <i class="fas fa-link"></i> <span>कॉपी लिंक</span>
                    </button>
                </div>
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

            <!-- Google AdSense In-Article Ad Slot -->
            @if(!empty($siteSettings->adsense_article_code) && ($siteSettings->adsense_enabled ?? true))
                <div class="my-4 text-center adsense-article-slot">
                    {!! $siteSettings->adsense_article_code !!}
                </div>
            @endif

            <!-- Tags section -->
            <div class="d-flex flex-wrap gap-2 border-top border-bottom py-3 my-4 border-secondary-subtle">
                <span class="fw-bold text-uppercase fs-8 text-muted d-flex align-items-center"><i class="fas fa-tags me-1"></i> टैग:</span>
                @foreach($article['tags'] as $tag)
                <a href="/tag/{{ strtolower($tag) }}" class="tag-badge">#{{ $tag }}</a>
                @endforeach
            </div>

            <!-- Bottom Share Box -->
            <div class="p-3 my-4 rounded-4 bg-body-tertiary border border-secondary-subtle">
                <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3">
                    <div>
                        <h6 class="fw-bold mb-1"><i class="fas fa-bullhorn text-primary me-2"></i>यह खबर अपने दोस्तों के साथ साझा करें</h6>
                        <p class="text-muted small mb-0">सच्ची और निष्पक्ष पत्रकारिता को आगे बढ़ाने में मदद करें।</p>
                    </div>
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($article['title'] . "\n\n" . request()->fullUrl()) }}" target="_blank" class="btn btn-success rounded-pill px-3 fw-semibold d-inline-flex align-items-center gap-1 shadow-sm" aria-label="Share on WhatsApp">
                            <i class="fab fa-whatsapp fs-5"></i> <span>व्हाट्सएप</span>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank" class="btn text-white rounded-pill px-3 fw-semibold d-inline-flex align-items-center gap-1 shadow-sm" style="background-color: #1877F2;" aria-label="Share on Facebook">
                            <i class="fab fa-facebook-f"></i> <span>फेसबुक</span>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($article['title']) }}" target="_blank" class="btn btn-dark rounded-pill px-3 fw-semibold d-inline-flex align-items-center gap-1 shadow-sm" style="background-color: #000; border-color: #000;" aria-label="Share on X">
                            <i class="fab fa-x-twitter"></i> <span>X (ट्विटर)</span>
                        </a>
                        <a href="https://t.me/share/url?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($article['title']) }}" target="_blank" class="btn text-white rounded-pill px-3 fw-semibold d-inline-flex align-items-center gap-1 shadow-sm" style="background-color: #229ED9;" aria-label="Share on Telegram">
                            <i class="fab fa-telegram-plane"></i> <span>टेलीग्राम</span>
                        </a>
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-3 fw-semibold d-inline-flex align-items-center gap-1 copy-link-btn" data-url="{{ request()->fullUrl() }}" data-title="{{ $article['title'] }}" title="लिंक कॉपी करें">
                            <i class="fas fa-link"></i> <span>कॉपी करें</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Related News & Videos -->
            <section class="mb-4">
                <h4 class="headline-font mb-3 fw-bold border-bottom pb-2 text-uppercase">संबंधित खबरें</h4>
                <div class="row g-3">
                    @foreach($related as $rel)
                    <div class="col-md-4">
                        <div class="news-card">
                            <div class="card-img-container position-relative" style="aspect-ratio:16/10;">
                                <img src="{{ $rel['image'] }}" alt="{{ $rel['title'] }}">
                                @if(!empty($rel['is_video']))
                                    <span class="position-absolute top-50 start-50 translate-middle d-flex align-items-center justify-content-center bg-dark bg-opacity-75 text-white rounded-circle" style="width: 35px; height: 35px; z-index: 2;">
                                        <i class="fas fa-play" style="font-size: 11px; margin-left: 2px;"></i>
                                    </span>
                                @endif
                            </div>
                            <div class="card-body p-2 d-flex flex-column justify-content-between">
                                <div>
                                    <h6 class="card-title fw-bold fs-7 mb-1" style="line-height:1.3;">
                                        <a href="/news/{{ $rel['slug'] }}">{{ $rel['title'] }}</a>
                                    </h6>
                                </div>
                                <div class="card-meta d-flex justify-content-between align-items-center mt-2">
                                    <small class="text-muted fs-8">{{ $rel['read_time'] }}</small>
                                    <div class="d-flex align-items-center gap-2">
                                        <a href="https://api.whatsapp.com/send?text={{ urlencode($rel['title'] . ' ' . url('/news/' . $rel['slug'])) }}" target="_blank" class="text-success text-decoration-none" title="व्हाट्सएप पर शेयर करें" onclick="event.stopPropagation();">
                                            <i class="fab fa-whatsapp"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm p-0 text-muted border-0 copy-link-btn" data-url="{{ url('/news/' . $rel['slug']) }}" data-title="{{ $rel['title'] }}" title="शेयर करें" onclick="event.stopPropagation();">
                                            <i class="fas fa-share-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>

        </div>

        <!-- Right Column Sidebar (4 Grid Units) -->
        <div class="col-lg-4">
            <!-- Manual Right Sidebar Ad 1 -->
            @if(!empty($siteSettings) && ($siteSettings->ad_sidebar_1_enabled ?? false) && (!empty($siteSettings->ad_sidebar_1_image) || !empty($siteSettings->ad_sidebar_1_code)))
                <div class="mb-4 manual-ad-sidebar-box">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="text-uppercase text-muted fw-semibold" style="font-size: 0.60rem; letter-spacing: 0.5px;">विज्ञापन / ADVERTISEMENT</span>
                    </div>
                    @if(!empty($siteSettings->ad_sidebar_1_code))
                        <div class="overflow-hidden rounded-3 border bg-body-tertiary text-center p-1 shadow-sm">
                            {!! $siteSettings->ad_sidebar_1_code !!}
                        </div>
                    @elseif(!empty($siteSettings->ad_sidebar_1_image))
                        <a href="{{ $siteSettings->ad_sidebar_1_link ?: '#' }}" target="_blank" rel="noopener noreferrer" class="d-block overflow-hidden rounded-3 border shadow-sm">
                            <img src="{{ $siteSettings->ad_sidebar_1_image }}" alt="Sidebar Advertisement" class="w-100 object-fit-cover">
                        </a>
                    @endif
                </div>
            @endif

            @include('components.widgets', ['type' => 'latest_videos'])
            @include('components.widgets', ['type' => 'trending'])
            @include('components.widgets', ['type' => 'newsletter'])
        </div>
    </div>

</div>
@endsection

@section('scripts')
<!-- Official Twitter / X Embed Widget Script -->
<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (window.twttr && window.twttr.widgets) {
            window.twttr.widgets.load();
        }
    });
</script>
@endsection
