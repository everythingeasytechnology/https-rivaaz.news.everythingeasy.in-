@extends('layouts.app')

@section('title', 'लेखक - ' . $author['name'] . ' - रीवाज़ क्रॉनिकल')

@section('content')
<div class="container-xl">
    
    <!-- Author Profile Bio Card -->
    <div class="card border-0 bg-body-tertiary p-4 rounded-4 mb-4 border border-secondary-subtle">
        <div class="row align-items-center g-4">
            <div class="col-md-2 text-center">
                <img src="{{ $author['avatar'] }}" alt="{{ $author['name'] }}" class="rounded-circle border border-primary shadow-sm" style="width: 120px; height: 120px; object-fit: cover;">
            </div>
            <div class="col-md-7">
                <h1 class="headline-font fw-extrabold mb-1">{{ $author['name'] }}</h1>
                <div class="fw-bold text-primary mb-2 text-uppercase fs-7">{{ $author['title'] }}</div>
                <p class="text-secondary-emphasis mb-3">{{ $author['bio'] }}</p>
                <div class="d-flex align-items-center gap-3">
                    <a href="#" class="btn btn-sm btn-outline-primary rounded-pill fw-semibold px-3" onclick="event.preventDefault(); alert('Following author updates...');"><i class="fas fa-plus me-1"></i> लेखक का अनुसरण करें</a>
                    <a href="#" class="text-reset hover-primary fs-5" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <span class="text-muted small"><strong>{{ $author['articles_count'] }}</strong> योगदान</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Author Articles List -->
    <div class="row g-4">
        <!-- Main list of articles -->
        <div class="col-lg-8">
            <h3 class="headline-font mb-4 fw-bold text-uppercase border-bottom pb-2">{{ $author['name'] }} के लेख</h3>
            @if(count($articles) > 0)
            <div class="d-flex flex-column gap-4">
                @foreach($articles as $article)
                <div class="news-horizontal-row py-3 rounded-4 p-3 bg-body-tertiary bg-opacity-25 border border-secondary-subtle">
                    <div class="row-img-container" style="width: 180px; height: 120px; border-radius: 8px;">
                        <img src="{{ $article['image'] }}" alt="{{ $article['title'] }}" class="w-100 h-100 object-fit-cover">
                    </div>
                    <div class="row-content">
                        <span class="badge bg-secondary text-reset fs-9 py-1 mb-2 text-uppercase">{{ $article['category'] }}</span>
                        <h4 class="row-title fw-bold fs-5 mb-2">
                            <a href="/news/{{ $article['slug'] }}">{{ $article['title'] }}</a>
                        </h4>
                        <p class="text-muted small line-clamp-2 d-none d-md-block">{{ $article['summary'] }}</p>
                        <small class="text-muted fs-8"><i class="far fa-calendar-alt me-1"></i> {{ $article['published_at'] }} • {{ $article['read_time'] }}</small>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-5">
                <div class="fs-1 text-muted"><i class="far fa-newspaper"></i></div>
                <h5 class="fw-bold mt-3">इस लेखक द्वारा अभी तक कोई लेख प्रकाशित नहीं किया गया है</h5>
                <p class="text-muted">कॉलम और लेख जल्द ही अपडेट किए जाएंगे।</p>
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
