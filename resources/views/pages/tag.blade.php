@extends('layouts.app')

@section('title', 'टैग: #' . $slug . ' - रीवाज़ क्रॉनिकल')

@section('content')
<div class="container-xl">
    
    <!-- Tag Header -->
    <div class="bg-body-tertiary p-4 rounded-4 mb-4 border border-secondary-subtle">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2 small fw-semibold">
                <li class="breadcrumb-item"><a href="/">होम</a></li>
                <li class="breadcrumb-item active" aria-current="page">टैग</li>
            </ol>
        </nav>
        <h1 class="headline-font fw-bold text-primary mb-2">#{{ $slug }} लेख</h1>
        <p class="text-muted mb-0 small">#{{ $slug }} के अंतर्गत प्रकाशित लेखों और विश्लेषणों का संग्रह।</p>
    </div>

    <!-- Tag Content Grid -->
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
            @else
            <div class="text-center py-5 bg-body-tertiary rounded-4">
                <div class="fs-1 text-muted"><i class="fas fa-tags"></i></div>
                <h5 class="fw-bold mt-3">इस #{{ $slug }} टैग से जुड़ा कोई लेख नहीं मिला</h5>
                @php $trendingTags = \App\Support\MockData::getTrendingTags(); @endphp
                @if(!empty($trendingTags))
                <p class="text-muted">कृपया अन्य ट्रेंडिंग हैशटैग देखें:</p>
                <div class="d-flex flex-wrap gap-2 justify-content-center mt-3">
                    @foreach($trendingTags as $tag)
                    <a href="/tag/{{ strtolower($tag) }}" class="btn btn-sm btn-outline-primary rounded-pill fw-semibold">#{{ $tag }}</a>
                    @endforeach
                </div>
                @endif
            </div>
            @endif
        </div>

        <!-- Sidebar Column -->
        <div class="col-lg-4">
            @include('components.widgets', ['type' => 'trending'])
            @include('components.widgets', ['type' => 'newsletter'])
        </div>
    </div>

</div>
@endsection
