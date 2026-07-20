@extends('layouts.app')

@section('title', 'Rivaaz Chronicle - Premium News Portal')

@section('content')
<div class="container-xl">
    
    <!-- 1. Hero Section (3-Column Content Hierarchy) -->
    <section class="mb-5">
        <div class="row g-4">
            <!-- Left Column: TOP NEWS (Large Story + horizontal items) -->
            <div class="col-lg-5 col-md-12">
                <h5 class="headline-font mb-3 fw-bold text-uppercase border-bottom pb-2 border-dark border-2" style="font-size:0.95rem; letter-spacing:0.5px;">मुख्य समाचार</h5>
                <div class="mb-4 d-flex flex-column">
                    <a href="/news/{{ $featured['slug'] }}" class="order-2 order-md-1 position-relative d-block">
                        <img src="{{ $featured['image'] }}" class="w-100 rounded-3 mb-3" style="aspect-ratio: 16/10; object-fit: cover;" alt="{{ $featured['title'] }}">
                        @if(!empty($featured['is_video']))
                            <span class="position-absolute top-50 start-50 translate-middle d-flex align-items-center justify-content-center bg-dark bg-opacity-75 text-white rounded-circle mb-3" style="width: 60px; height: 60px; z-index: 2;">
                                <i class="fas fa-play fa-lg" style="margin-left: 4px;"></i>
                            </span>
                        @endif
                    </a>
                    <h3 class="fw-extrabold mb-2 order-1 order-md-2" style="font-size: 1.6rem; line-height: 1.25;">
                        <a href="/news/{{ $featured['slug'] }}" class="text-reset hover-primary">{{ $featured['title'] }}</a>
                    </h3>
                    <p class="text-muted small mb-2 order-3">{{ $featured['summary'] }}</p>
                    <div class="d-flex align-items-center gap-2 text-uppercase fw-bold text-muted mb-2 order-4" style="font-size:0.65rem; letter-spacing:0.5px;">
                        <a href="/category/{{ $featured['category'] }}" class="category-label">{{ $featured['category_name'] ?? ucfirst($featured['category']) }}</a>
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
                            <a href="/category/{{ $article['category'] }}" class="category-label">{{ $article['category_name'] ?? ucfirst($article['category']) }}</a>
                        </div>
                    </div>
                    <div class="row-img-container position-relative">
                        <img src="{{ $article['image'] }}" class="w-100 h-100 object-fit-cover" alt="Thumb">
                        @if(!empty($article['is_video']))
                            <span class="position-absolute top-50 start-50 translate-middle d-flex align-items-center justify-content-center bg-dark bg-opacity-75 text-white rounded-circle" style="width: 35px; height: 35px; z-index: 2;">
                                <i class="fas fa-play" style="font-size: 11px; margin-left: 2px;"></i>
                            </span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Center Column: LIVE TV + Feed -->
            <div class="col-lg-4 col-md-7 border-start-lg ps-lg-4">
                <h5 class="headline-font mb-3 fw-bold text-uppercase border-bottom pb-2 border-dark border-2" style="font-size:0.95rem; letter-spacing:0.5px;">लाइव टीवी</h5>
                <div class="position-relative rounded-3 overflow-hidden mb-3" style="aspect-ratio: 16/9; background-color: #000; box-shadow: 0 4px 10px rgba(0,0,0,0.15);" id="liveTvContainer">
                    @if(!empty($siteSettings->live_tv_url))
                        <img src="{{ $siteSettings->live_tv_cover ?: 'https://images.unsplash.com/photo-1585829365295-ab7cd400c167?auto=format&fit=crop&w=600&q=80' }}" class="w-100 h-100 object-fit-cover opacity-75" alt="Live stream cover">
                        <span class="position-absolute top-0 start-0 m-2 badge bg-danger animate-pulse py-1 px-2 fw-bold fs-9">LIVE TV</span>
                        <button class="position-absolute top-50 end-50 translate-middle btn btn-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;" onclick="playLiveTv()" aria-label="Play live feed"><i class="fas fa-play"></i></button>
                        
                        <script>
                            function playLiveTv() {
                                const container = document.getElementById('liveTvContainer');
                                container.innerHTML = `<iframe class="w-100 h-100" src="{{ $siteSettings->live_tv_url }}{{ str_contains($siteSettings->live_tv_url, '?') ? '&' : '?' }}autoplay=1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>`;
                            }
                        </script>
                    @else
                        <img src="https://images.unsplash.com/photo-1585829365295-ab7cd400c167?auto=format&fit=crop&w=600&q=80" class="w-100 h-100 object-fit-cover opacity-75" alt="Live stream cover">
                        <span class="position-absolute top-0 start-0 m-2 badge bg-danger animate-pulse py-1 px-2 fw-bold fs-9">LIVE TV</span>
                        <button class="position-absolute top-50 end-50 translate-middle btn btn-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;" onclick="alert('Live broadcast stream is currently offline.');" aria-label="Play live feed"><i class="fas fa-play"></i></button>
                    @endif
                </div>

                @foreach(array_slice($others, 2, 3) as $article)
                <div class="news-horizontal-row border-0 @if(!$loop->first) border-top border-secondary-subtle @endif py-3">
                    <div class="row-content">
                        <h6 class="fw-bold fs-7 mb-2 lh-base">
                            <a href="/news/{{ $article['slug'] }}" class="text-reset hover-primary">{{ $article['title'] }}</a>
                        </h6>
                        <div class="d-flex align-items-center gap-2 text-uppercase fw-bold text-muted" style="font-size:0.65rem; letter-spacing:0.5px;">
                            <a href="/category/{{ $article['category'] }}" class="category-label">{{ $article['category_name'] ?? ucfirst($article['category']) }}</a>
                        </div>
                    </div>
                    <div class="row-img-container center-row-thumb position-relative">
                        <img src="{{ $article['image'] }}" class="w-100 h-100 object-fit-cover" alt="Thumb">
                        @if(!empty($article['is_video']))
                            <span class="position-absolute top-50 start-50 translate-middle d-flex align-items-center justify-content-center bg-dark bg-opacity-75 text-white rounded-circle" style="width: 35px; height: 35px; z-index: 2;">
                                <i class="fas fa-play" style="font-size: 11px; margin-left: 2px;"></i>
                            </span>
                        @endif
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
                @if(!empty($tags) && count($tags) > 0)
                <!-- Trending Tags Widget -->
                <div class="widget-box mb-3">
                    <div class="widget-title">
                        <span><i class="fas fa-tags text-primary me-2"></i>ट्रेंडिंग टैग</span>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($tags as $tag)
                        <a href="/tag/{{ strtolower($tag) }}" class="trending-tag-btn">#{{ $tag }}</a>
                        @endforeach
                    </div>
                </div>
                @endif
                @include('components.widgets', ['type' => 'weather'])
                <div class="mt-4">
                    @include('components.widgets', ['type' => 'newsletter'])
                </div>
            </div>
        </div>
    </section>


    <!-- 5. Category-Wise Interactive News Hub -->
    @if(!empty($categoriesList) && count($categoriesList) > 0)
    @php
        $visibleCats = array_slice($categoriesList, 0, 6);
        $dropdownCats = array_slice($categoriesList, 6);
    @endphp
    <section class="mb-5">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4 pb-2 border-bottom border-primary border-3">
            <h3 class="headline-font fw-bold text-uppercase mb-0 fs-4 text-body" style="letter-spacing: 0.5px;">
                <i class="fas fa-layer-group text-primary me-2"></i>श्रेणी अनुसार खबरें
            </h3>
            <ul class="nav nav-pills category-news-tabs flex-nowrap align-items-center pb-1 overflow-visible" id="categoryNewsTab" role="tablist">
                @foreach($visibleCats as $index => $cat)
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-pill fw-bold fs-7 px-3 py-1 me-1 text-nowrap @if($index === 0) active @endif" id="cat-tab-{{ $cat['slug'] }}" data-bs-toggle="pill" data-bs-target="#cat-pane-{{ $cat['slug'] }}" type="button" role="tab" aria-controls="cat-pane-{{ $cat['slug'] }}" aria-selected="{{ $index === 0 ? 'true' : 'false' }}">{{ $cat['name'] }}</button>
                </li>
                @endforeach

                @if(count($dropdownCats) > 0)
                <li class="nav-item dropdown position-relative" role="presentation">
                    <button class="nav-link rounded-pill fw-bold fs-7 px-3 py-1 me-1 text-nowrap dropdown-toggle bg-body-tertiary border text-body" data-bs-toggle="dropdown" type="button" aria-expanded="false" id="moreCatDropdownBtn">
                        और श्रेणियां
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow rounded-3 py-2 mt-1">
                        @foreach($dropdownCats as $cat)
                        <li>
                            <button class="dropdown-item fw-semibold py-2 px-3 fs-7" id="cat-tab-{{ $cat['slug'] }}" data-bs-toggle="pill" data-bs-target="#cat-pane-{{ $cat['slug'] }}" type="button" role="tab" aria-controls="cat-pane-{{ $cat['slug'] }}" aria-selected="false" onclick="document.getElementById('moreCatDropdownBtn').innerHTML = '{{ $cat['name'] }}';">
                                {{ $cat['name'] }}
                            </button>
                        </li>
                        @endforeach
                    </ul>
                </li>
                @endif
            </ul>
        </div>

        <div class="tab-content" id="categoryNewsTabContent">
            @foreach($categoriesList as $index => $cat)
            @php
                $catArticles = collect($articles)->filter(fn($a) => strtolower($a['category']) === strtolower($cat['slug']))->values();
            @endphp
            <div class="tab-pane fade @if($index === 0) show active @endif" id="cat-pane-{{ $cat['slug'] }}" role="tabpanel" aria-labelledby="cat-tab-{{ $cat['slug'] }}" tabindex="0">
                @if($catArticles->count() > 0)
                <div class="row g-4">
                    <!-- Left: Lead Featured Article -->
                    <div class="col-lg-7">
                        <div class="featured-block mb-3">
                            <h4 class="fw-bold mb-3 fs-3" style="line-height: 1.25; letter-spacing: -0.5px;">
                                <a href="/news/{{ $catArticles[0]['slug'] }}" class="text-reset text-decoration-none hover-primary">{{ $catArticles[0]['title'] }}</a>
                            </h4>
                            <div class="rounded-3 overflow-hidden position-relative" style="aspect-ratio: 16/9; border: 1px solid var(--border-color);">
                                <img src="{{ $catArticles[0]['image'] }}" class="w-100 h-100 object-fit-cover" alt="{{ $catArticles[0]['title'] }}">
                                @if(!empty($catArticles[0]['is_video']))
                                    <span class="position-absolute top-50 start-50 translate-middle d-flex align-items-center justify-content-center bg-dark bg-opacity-75 text-white rounded-circle" style="width: 50px; height: 50px; z-index: 2;">
                                        <i class="fas fa-play fa-lg" style="margin-left: 3px;"></i>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- Right: Stack of up to 4 horizontal row items -->
                    @if($catArticles->count() > 1)
                    <div class="col-lg-5">
                        <div class="d-flex flex-column gap-3 h-100 justify-content-start">
                            @foreach($catArticles->slice(1, 4) as $idx => $art)
                            <div class="d-flex justify-content-between align-items-center gap-3 pb-3 @if(!$loop->last) border-bottom border-secondary-subtle @endif">
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold fs-7 mb-1" style="line-height: 1.35;">
                                        <a href="/news/{{ $art['slug'] }}" class="text-reset text-decoration-none hover-primary">{{ $art['title'] }}</a>
                                    </h6>
                                    <small class="text-muted fs-9">{{ $art['published_at'] ?? $art['read_time'] }}</small>
                                </div>
                                <div class="flex-shrink-0 position-relative" style="width: 100px; height: 60px; border-radius: 6px; overflow: hidden; border: 1px solid var(--border-color);">
                                    <img src="{{ $art['image'] }}" class="w-100 h-100 object-fit-cover" alt="Thumbnail">
                                    @if(!empty($art['is_video']))
                                        <span class="position-absolute top-50 start-50 translate-middle d-flex align-items-center justify-content-center bg-dark bg-opacity-75 text-white rounded-circle" style="width: 28px; height: 28px; z-index: 2;">
                                            <i class="fas fa-play" style="font-size: 9px; margin-left: 1px;"></i>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
                @else
                <div class="text-center py-4 bg-body-tertiary rounded-3 border border-secondary-subtle">
                    <p class="text-muted mb-0 fw-semibold fs-6"><i class="fas fa-newspaper me-2"></i>इस श्रेणी में फ़िलहाल कोई समाचार प्रकाशित नहीं किया गया है।</p>
                </div>
                @endif
                <div class="text-end mt-3">
                    <a href="/category/{{ $cat['slug'] }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold">
                        {{ $cat['name'] }} की सभी खबरें <i class="fas fa-angle-right ms-1"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- 4. Latest News Grid -->
    <section class="mb-5">
        <h3 class="headline-font mb-4 fw-bold text-uppercase d-flex align-items-end justify-content-between position-relative pb-2" style="border-bottom: 1px solid var(--border-color);">
            <span class="position-relative pb-2" style="margin-bottom: -9px;">
                ताज़ा ख़बरें
                <span class="position-absolute start-0 bottom-0 bg-primary" style="height: 3px; width: 40px;"></span>
            </span>
            <a href="/archive" class="fs-7 text-primary text-decoration-none text-uppercase fw-bold d-flex align-items-center gap-1">सभी समाचार <i class="fas fa-arrow-right"></i></a>
        </h3>
        
        <div class="row g-4" id="loadMoreContainer">
            @foreach(array_slice($others, 0, 6) as $article)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="latest-news-horizontal-card">
                    <div class="latest-card-img-wrap position-relative">
                        <img src="{{ $article['image'] }}" alt="{{ $article['title'] }}">
                        @if(!empty($article['is_video']))
                            <span class="position-absolute top-50 start-50 translate-middle d-flex align-items-center justify-content-center bg-dark bg-opacity-75 text-white rounded-circle" style="width: 45px; height: 45px; z-index: 2;">
                                <i class="fas fa-play" style="margin-left: 2px;"></i>
                            </span>
                        @endif
                    </div>
                    <div class="latest-card-content">
                        <span class="latest-card-category text-uppercase">{{ $article['category_name'] ?? ucfirst($article['category']) }}</span>
                        <h5 class="latest-card-title">
                            <a href="/news/{{ $article['slug'] }}">{{ $article['title'] }}</a>
                        </h5>
                        <p class="latest-card-summary">{{ $article['summary'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        @if(count($others) > 6)
        <div class="text-center mt-4" id="loadMoreWrapper">
            <button class="btn btn-outline-primary rounded-pill px-4 fw-bold" id="loadMoreBtn">
                और लोड करें <i class="fas fa-arrow-down ms-1"></i>
            </button>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const remainingArticles = @json(array_slice($others, 6));
                const container = document.getElementById('loadMoreContainer');
                const btn = document.getElementById('loadMoreBtn');
                const wrapper = document.getElementById('loadMoreWrapper');
                
                let currentIndex = 0;
                const chunkSize = 6;
                
                btn.addEventListener('click', function() {
                    const chunk = remainingArticles.slice(currentIndex, currentIndex + chunkSize);
                    currentIndex += chunkSize;
                    
                    chunk.forEach(article => {
                        const col = document.createElement('div');
                        col.className = 'col-12 col-md-6 col-lg-4';
                        
                        let playOverlay = '';
                        if (article.is_video) {
                            playOverlay = `
                                <span class="position-absolute top-50 start-50 translate-middle d-flex align-items-center justify-content-center bg-dark bg-opacity-75 text-white rounded-circle" style="width: 45px; height: 45px; z-index: 2;">
                                    <i class="fas fa-play" style="margin-left: 2px;"></i>
                                </span>
                            `;
                        }
                        
                        col.innerHTML = `
                            <div class="latest-news-horizontal-card">
                                <div class="latest-card-img-wrap position-relative">
                                    <img src="${article.image}" alt="${article.title}">
                                    ${playOverlay}
                                </div>
                                <div class="latest-card-content">
                                    <span class="latest-card-category text-uppercase">${article.category_name || article.category}</span>
                                    <h5 class="latest-card-title">
                                        <a href="/news/${article.slug}">${article.title}</a>
                                    </h5>
                                    <p class="latest-card-summary">${article.summary || ''}</p>
                                </div>
                            </div>
                        `;
                        container.appendChild(col);
                    });
                    
                    // Hide load more button if no more articles are left
                    if (currentIndex >= remainingArticles.length) {
                        wrapper.remove();
                    }
                });
            });
        </script>
        @endif
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
