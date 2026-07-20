@extends('layouts.app')

@section('title', 'समाचार अभिलेखागार - रीवाज़ क्रॉनिकल')

@section('content')
<div class="container-xl">
    
    <!-- Archive Header -->
    <div class="bg-body-tertiary p-4 rounded-4 mb-4 border border-secondary-subtle">
        <h1 class="headline-font fw-extrabold text-primary mb-2"><i class="fas fa-history me-2"></i> समाचार अभिलेखागार</h1>
        <p class="text-muted mb-0 small">वर्ष और महीने के अनुसार पुराने लेख और समाचार बुलेटिन खोजें।</p>
    </div>

    <!-- Archive Filters and Lists -->
    <div class="row g-4">
        <!-- Main Column (Archive Lists) -->
        <div class="col-lg-8">
            
            <!-- Date Filter Widget -->
            <div class="card border-0 bg-body-tertiary p-3 rounded-4 mb-4">
                <h5 class="fw-bold mb-3">फिल्टर करें</h5>
                <form onsubmit="event.preventDefault(); alert('Loading historical archive data...');" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label small fw-semibold">वर्ष</label>
                        <select class="form-select rounded-3">
                            <option>2026</option>
                            <option>2025</option>
                            <option>2024</option>
                            <option>2023</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-semibold">महीना</label>
                        <select class="form-select rounded-3">
                            <option>July</option>
                            <option>June</option>
                            <option>May</option>
                            <option>April</option>
                            <option>March</option>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold">लागू करें</button>
                    </div>
                </form>
            </div>

            <!-- Publications list -->
            <h3 class="headline-font mb-4 fw-bold text-uppercase border-bottom pb-2">प्रकाशित समाचार सूची</h3>
            <div class="d-flex flex-column gap-3">
                @foreach($articles as $article)
                <div class="d-flex justify-content-between align-items-center p-3 bg-body-tertiary bg-opacity-25 rounded-3 border border-secondary-subtle">
                    <div class="text-truncate me-3" style="max-width:80%;">
                        <span class="badge bg-secondary-subtle text-secondary me-2 fs-9">{{ $article['published_at'] }}</span>
                        <a href="/news/{{ $article['slug'] }}" class="fw-bold text-reset hover-primary text-decoration-none">{{ $article['title'] }}</a>
                    </div>
                    <a href="/news/{{ $article['slug'] }}" class="btn btn-sm btn-outline-secondary rounded-pill py-1 px-3 fw-bold fs-8">पढ़ें</a>
                </div>
                @endforeach
            </div>

        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            @include('components.widgets', ['type' => 'trending'])
            @include('components.widgets', ['type' => 'newsletter'])
        </div>
    </div>

</div>
@endsection
