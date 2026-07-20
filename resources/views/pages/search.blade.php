@extends('layouts.app')

@section('title', 'खोज परिणाम - रीवाज़ क्रॉनिकल')

@section('content')
<div class="container-xl">
    
    <!-- Search Query Bar -->
    <div class="bg-body-tertiary p-4 rounded-4 mb-4 border border-secondary-subtle">
        <h1 class="headline-font fw-extrabold mb-3 text-primary"><i class="fas fa-search me-2"></i> समाचार खोजें</h1>
        <form action="/search" method="GET" class="row g-2">
            <div class="col-md-9">
                <input type="text" name="q" class="form-control form-control-lg rounded-3 shadow-none border-secondary-subtle" placeholder="आप क्या खोजना चाहते हैं?" value="{{ $query }}" required>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill fw-bold"><i class="fas fa-search me-2"></i> लेख खोजें</button>
            </div>
        </form>
    </div>

    <!-- Search Results Content -->
    <div class="row g-4">
        <div class="col-lg-8">
            @if(!empty($query))
                <h3 class="headline-font mb-4 fw-bold text-uppercase border-bottom pb-2">
                    "{{ $query }}" के लिए परिणाम <span class="fs-6 fw-normal text-muted">({{ count($articles) }} परिणाम मिले)</span>
                </h3>
                
                @if(count($articles) > 0)
                <div class="d-flex flex-column gap-3">
                    @foreach($articles as $article)
                    <div class="news-horizontal-row py-3 rounded-4 p-3 bg-body-tertiary bg-opacity-25 border border-secondary-subtle">
                        <div class="row-img-container position-relative" style="width: 140px; height: 90px; border-radius: 8px; overflow: hidden;">
                            <img src="{{ $article['image'] }}" alt="{{ $article['title'] }}" class="w-100 h-100 object-fit-cover">
                            @if(!empty($article['is_video']))
                                <span class="position-absolute top-50 start-50 translate-middle d-flex align-items-center justify-content-center bg-dark bg-opacity-75 text-white rounded-circle" style="width: 30px; height: 30px; z-index: 2;">
                                    <i class="fas fa-play" style="font-size: 10px; margin-left: 1px;"></i>
                                </span>
                            @endif
                        </div>
                        <div class="row-content">
                            <span class="badge-category mb-2 py-0 px-2">{{ $article['subcategory'] ?: ($article['category_name'] ?? '') }}</span>
                            <h5 class="row-title fw-bold">
                                <a href="/news/{{ $article['slug'] }}">{{ $article['title'] }}</a>
                            </h5>
                            <p class="text-muted small line-clamp-2 mb-2">{{ $article['summary'] }}</p>
                            <small class="text-muted fs-8"><i class="far fa-user me-1"></i> {{ $article['author']['name'] }} • {{ $article['published_at'] }}</small>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-5">
                    <div class="fs-1 text-muted"><i class="fas fa-search-minus"></i></div>
                    <h5 class="fw-bold mt-3">कोई मेल खाता हुआ लेख नहीं मिला</h5>
                    <p class="text-muted">कृपया "बजट", "एआई", "क्रिकेट" या अन्य शब्दों को खोजकर देखें।</p>
                </div>
                @endif
            @else
                <div class="text-center py-5 bg-body-tertiary rounded-4">
                    <div class="fs-1 text-muted"><i class="fas fa-keyboard"></i></div>
                    <h5 class="fw-bold mt-3">खोज शुरू करने के लिए कोई शब्द दर्ज करें</h5>
                    @php $trendingTags = \App\Support\MockData::getTrendingTags(); @endphp
                    @if(!empty($trendingTags))
                    <p class="text-muted">या इनमें से कोई ट्रेंडिंग टैग देखें:</p>
                    <div class="d-flex flex-wrap gap-2 justify-content-center mt-3">
                        @foreach($trendingTags as $tag)
                        <a href="/tag/{{ strtolower($tag) }}" class="btn btn-sm btn-outline-primary rounded-pill fw-semibold">#{{ $tag }}</a>
                        @endforeach
                    </div>
                    @endif
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            @include('components.widgets', ['type' => 'trending'])
            @include('components.widgets', ['type' => 'newsletter'])
        </div>
    </div>

</div>
@endsection
