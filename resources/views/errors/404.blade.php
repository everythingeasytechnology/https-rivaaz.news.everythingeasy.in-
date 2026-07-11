@extends('layouts.app')

@section('title', 'Page Not Found - Rivaaz Chronicle')

@section('content')
<div class="container-xl py-5 text-center">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <!-- 404 Graphic/Icon -->
            <div class="display-1 text-primary fw-extrabold mb-3" style="font-family: var(--font-headlines); font-size: 7rem; letter-spacing: -2px;">
                404
            </div>
            
            <h2 class="headline-font fw-bold mb-3">Whoops! That Page Took a Coffee Break.</h2>
            <p class="text-muted mb-4 fs-6">The bulletin, photo album, or author column you are looking for has been moved, archived, or doesn't exist. Let's get you back on track.</p>
            
            <!-- Inline Search Form -->
            <div class="card border-0 bg-body-tertiary p-4 rounded-4 shadow-sm mb-4 border border-secondary-subtle">
                <h5 class="fw-bold mb-3"><i class="fas fa-search me-1 text-primary"></i> Search Rivaaz Chronicle</h5>
                <form action="/search" method="GET">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control border-secondary-subtle shadow-none" placeholder="Search keywords (e.g. Budget, AI, Cricket)..." required>
                        <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i> Search</button>
                    </div>
                </form>
            </div>

            <!-- Category Links -->
            <div class="mb-4">
                <span class="small fw-bold text-uppercase text-muted d-block mb-3">Or explore our primary desks:</span>
                <div class="d-flex flex-wrap gap-2 justify-content-center">
                    <a href="/" class="btn btn-sm btn-outline-primary rounded-pill fw-semibold"><i class="fas fa-home me-1"></i> Home</a>
                    <a href="/category/india" class="btn btn-sm btn-outline-primary rounded-pill fw-semibold">India</a>
                    <a href="/category/politics" class="btn btn-sm btn-outline-primary rounded-pill fw-semibold">Politics</a>
                    <a href="/category/business" class="btn btn-sm btn-outline-primary rounded-pill fw-semibold">Business</a>
                    <a href="/category/technology" class="btn btn-sm btn-outline-primary rounded-pill fw-semibold">Technology</a>
                    <a href="/videos" class="btn btn-sm btn-outline-primary rounded-pill fw-semibold"><i class="fas fa-play-circle me-1"></i> Videos</a>
                </div>
            </div>

            <a href="/" class="btn btn-primary rounded-pill py-2 px-4 fw-bold shadow"><i class="fas fa-long-arrow-alt-left me-2"></i> Return to Homepage</a>
        </div>
    </div>
</div>
@endsection
