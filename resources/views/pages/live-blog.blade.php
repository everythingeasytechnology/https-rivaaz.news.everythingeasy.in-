@extends('layouts.app')

@section('title', 'LIVE: ' . $article['title'] . ' - Rivaaz Chronicle')

@section('content')
<div class="container-xl">
    
    <!-- Live Blog Header Banner -->
    <div class="bg-dark text-white p-4 rounded-4 mb-4 shadow border border-secondary border-opacity-25">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2 small fw-semibold text-white-50">
                <li class="breadcrumb-item text-white-50"><a href="/" class="text-white-50">Home</a></li>
                <li class="breadcrumb-item text-white-50"><a href="/category/{{ $article['category'] }}" class="text-white-50">{{ ucfirst($article['category']) }}</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Live Coverage</li>
            </ol>
        </nav>
        <div class="d-flex align-items-center gap-2 mb-2">
            <span class="badge bg-danger animate-pulse py-1 px-3 fw-bold fs-7" id="liveStatusIndicator">LIVE</span>
            <span class="text-white-50 fs-8 fw-semibold">REAL-TIME NEWS CORRESPONDENCE</span>
        </div>
        <h1 class="headline-font fw-extrabold text-white mb-2 fs-2">{{ $article['title'] }}</h1>
        <p class="text-white-50 mb-0 small">{{ $article['subtitle'] }}</p>
    </div>

    <!-- Live Blog Layout -->
    <div class="row g-4">
        <!-- Live timeline stream -->
        <div class="col-lg-8">
            
            <!-- Controls bar -->
            <div class="d-flex align-items-center justify-content-between bg-body-tertiary p-3 rounded-4 mb-4 border border-secondary-subtle">
                <div class="form-check form-switch mb-0">
                    <input class="form-check-input" type="checkbox" role="switch" id="autoScrollToggle" checked>
                    <label class="form-check-label small fw-semibold text-muted" for="autoScrollToggle"><i class="fas fa-magic me-1"></i> Auto-Scroll to New Updates</label>
                </div>
                <div>
                    <button class="btn btn-sm btn-outline-primary rounded-pill fw-bold" onclick="alert('Checking for new live bullets...');">
                        <i class="fas fa-redo-alt me-1"></i> Sync Feed
                    </button>
                </div>
            </div>

            <!-- Timeline Box -->
            <div class="live-timeline-stream d-flex flex-column gap-4" id="liveBlogTimeline">
                @foreach($events as $event)
                <div class="live-item @if($loop->first) live-active @endif bg-body-tertiary bg-opacity-25 rounded-4 p-4 border border-secondary-subtle">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="badge bg-secondary-subtle text-secondary fw-bold">{{ $event['time'] }}</span>
                        @if($event['tag'])
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle">#{{ $event['tag'] }}</span>
                        @endif
                    </div>
                    <h5 class="fw-bold mb-2">{{ $event['title'] }}</h5>
                    <p class="text-muted">{{ $event['content'] }}</p>
                    
                    @if($event['image'])
                    <div class="rounded-3 overflow-hidden mb-3 border border-secondary border-opacity-10" style="max-height: 320px;">
                        <img src="{{ $event['image'] }}" class="w-100 object-fit-cover" alt="Event visual">
                    </div>
                    @endif
                    
                    <div class="d-flex gap-3 mt-2">
                        <button class="btn btn-sm btn-link text-decoration-none p-0 text-muted fs-8" onclick="alert('Copied link of this bulletin to clipboard!')"><i class="far fa-share-square me-1"></i> Share</button>
                        <button class="btn btn-sm btn-link text-decoration-none p-0 text-muted fs-8" onclick="alert('Comment dialog simulated...')"><i class="far fa-comment me-1"></i> Comment</button>
                    </div>
                </div>
                @endforeach
            </div>

        </div>

        <!-- Sidebar columns -->
        <div class="col-lg-4">
            @include('components.widgets', ['type' => 'trending'])
            @include('components.widgets', ['type' => 'stocks'])
            @include('components.widgets', ['type' => 'newsletter'])
        </div>
    </div>

</div>
@endsection
