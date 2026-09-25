@extends('layouts.app')

@section('title', $category['meta_title'] ?? $category['name'] . ' समाचार - उत्तराखंड नाउ')
@section('meta_description', $category['meta_description'] ?? $category['name'] . ' से संबंधित नवीनतम समाचार और अपडेट्स।')
@section('meta_keywords', $category['meta_keywords'] ?? strtolower($category['name']) . ', समाचार, अपडेट्स')

@section('content')
<div class="container-xl">
    
    <!-- Category Header and Subcategories navigation -->
    <div class="bg-body-tertiary p-4 rounded-4 mb-4 border border-secondary-subtle">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2 small fw-semibold">
                <li class="breadcrumb-item"><a href="/">होम</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $category['name'] }}</li>
            </ol>
        </nav>
        <h1 class="headline-font fw-bold text-primary mb-3">{{ $category['name'] }} बुलेटिन</h1>
        @if(count($category['subcategories']) > 0)
        <div class="d-flex flex-wrap gap-2 align-items-center">
            <span class="small fw-bold text-uppercase text-muted me-2">खोजें:</span>
            @foreach($category['subcategories'] as $sub)
            <a href="/category/{{ $category['slug'] }}/{{ strtolower(str_replace(' ', '-', $sub)) }}" class="btn btn-sm btn-outline-primary rounded-pill fw-semibold">{{ $sub }}</a>
            @endforeach
        </div>
        @endif
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
                        <div class="card-img-container position-relative">
                            <img src="{{ $article['image'] }}" alt="{{ $article['title'] }}">
                            @if(!empty($article['is_video']))
                                <span class="position-absolute top-50 start-50 translate-middle d-flex align-items-center justify-content-center bg-dark bg-opacity-75 text-white rounded-circle" style="width: 45px; height: 45px; z-index: 2;">
                                    <i class="fas fa-play" style="margin-left: 2px;"></i>
                                </span>
                            @endif
                        </div>
                        <div class="card-body">
                            <span class="badge-category mb-2">{{ $article['subcategory'] ?: ($article['category_name'] ?? '') }}</span>
                            <h4 class="card-title fw-bold">
                                <a href="/news/{{ $article['slug'] }}">{{ $article['title'] }}</a>
                            </h4>
                            <p class="text-muted small line-clamp-3 mb-3">{{ $article['summary'] }}</p>
                            <div class="card-meta d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-1">
                                    <span><i class="far fa-user me-1"></i> {{ $article['author']['name'] }}</span>
                                    <span>•</span>
                                    <span>{{ $article['read_time'] }}</span>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <a href="https://api.whatsapp.com/send?text={{ urlencode($article['title'] . ' ' . url('/news/' . $article['slug'])) }}" target="_blank" class="text-success text-decoration-none" title="व्हाट्सएप पर शेयर करें">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm p-0 text-muted border-0 copy-link-btn" data-url="{{ url('/news/' . $article['slug']) }}" data-title="{{ $article['title'] }}" title="शेयर करें">
                                        <i class="fas fa-share-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-5">
                <div class="fs-1 text-muted"><i class="far fa-folder-open"></i></div>
                <h5 class="fw-bold mt-3">इस श्रेणी में कोई लेख नहीं मिला</h5>
                <p class="text-muted">बाद में दोबारा देखें या अन्य ट्रेंडिंग टैग खोजें।</p>
                <a href="/" class="btn btn-primary rounded-pill fw-bold px-4 mt-2">होम पेज पर वापस जाएं</a>
            </div>
            @endif
        </div>

        <!-- Sidebar Column -->
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

            @include('components.widgets', ['type' => 'trending'])
            @include('components.widgets', ['type' => 'newsletter'])
        </div>
    </div>

</div>
@endsection
