@extends('layouts.app')

@section('title', $article['title'] . ' - Rivaaz Chronicle')
@section('meta_description', $article['subtitle'])

@section('content')
<div class="container-xl">
    
    <!-- 1. Breadcrumbs -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb small fw-semibold">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/category/{{ $article['category'] }}">{{ ucfirst($article['category']) }}</a></li>
            <li class="breadcrumb-item"><a href="/category/{{ $article['category'] }}/{{ strtolower(str_replace(' ', '-', $article['subcategory'])) }}">{{ $article['subcategory'] }}</a></li>
            <li class="breadcrumb-item active text-truncate" aria-current="page" style="max-width:250px;">{{ $article['title'] }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- Social Share Sticky (Left Col - 1 Grid Unit Desktop Only) -->
        <div class="col-lg-1 d-none d-lg-block">
            <div class="share-sticky text-center">
                <small class="text-muted text-uppercase fw-bold d-block mb-2" style="font-size:0.6rem; letter-spacing:0.5px;">Share</small>
                <a href="#" class="share-btn" aria-label="Share Facebook" onclick="event.preventDefault(); alert('Sharing to Facebook...');"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="share-btn" aria-label="Share Twitter" onclick="event.preventDefault(); alert('Sharing to Twitter...');"><i class="fab fa-twitter"></i></a>
                <a href="#" class="share-btn" aria-label="Share WhatsApp" onclick="event.preventDefault(); alert('Sharing to WhatsApp...');"><i class="fab fa-whatsapp"></i></a>
                <a href="#" class="share-btn" aria-label="Share LinkedIn" onclick="event.preventDefault(); alert('Sharing to LinkedIn...');"><i class="fab fa-linkedin-in"></i></a>
                <a href="#" class="share-btn" aria-label="Bookmark" onclick="event.preventDefault(); alert('Article bookmarked!');"><i class="far fa-bookmark"></i></a>
            </div>
        </div>

        <!-- Main News Column (7 Grid Units) -->
        <div class="col-lg-7">
            
            <!-- Category Badge -->
            <span class="badge-category badge-gold mb-2">{{ $article['subcategory'] }}</span>
            
            <!-- Headline -->
            <h1 class="headline-font fw-extrabold mb-3" style="font-size: 2.5rem; line-height: 1.2;">{{ $article['title'] }}</h1>
            
            <!-- Subtitle -->
            <p class="fs-5 text-muted mb-4 fw-medium" style="line-height: 1.5;">{{ $article['subtitle'] }}</p>
            
            <!-- Author profile & publish date & reading configurations -->
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 border-top border-bottom py-3 mb-4 border-secondary-subtle">
                <div class="d-flex align-items-center gap-3">
                    <img src="{{ $article['author']['avatar'] }}" alt="{{ $article['author']['name'] }}" class="rounded-circle border border-primary" style="width: 50px; height: 50px; object-fit: cover;">
                    <div>
                        <h6 class="mb-0 fw-bold"><a href="/author/{{ $article['author_key'] }}" class="text-reset hover-primary">{{ $article['author']['name'] }}</a></h6>
                        <small class="text-muted">{{ $article['author']['title'] }}</small>
                    </div>
                </div>
                
                <div class="d-flex align-items-center gap-3 text-muted small">
                    <div>
                        <span class="d-block"><i class="far fa-calendar-alt me-1"></i> Published: <strong>{{ $article['published_at'] }}</strong></span>
                        @if($article['updated_at'] !== $article['published_at'])
                        <span class="d-block text-secondary-emphasis"><i class="fas fa-edit me-1"></i> Updated: <strong>{{ $article['updated_at'] }}</strong></span>
                        @endif
                    </div>
                    <span class="border-start ps-3 py-2 border-secondary-subtle d-none d-sm-inline">
                        <i class="far fa-clock me-1"></i> {{ $article['read_time'] }}
                    </span>
                </div>
            </div>

            <!-- Reading Controls bar -->
            <div class="d-flex align-items-center justify-content-between bg-body-tertiary p-2 rounded-3 mb-4 border border-secondary-subtle">
                <div class="d-flex align-items-center gap-2">
                    <span class="small fw-semibold text-muted ms-2"><i class="fas fa-text-height me-1"></i> Text Size:</span>
                    <button class="btn btn-sm btn-outline-secondary rounded-circle" style="width:30px;height:30px;padding:0;" id="btnFontSizeDec" title="Decrease Font Size">A-</button>
                    <button class="btn btn-sm btn-outline-secondary rounded-circle" style="width:30px;height:30px;padding:0;" id="btnFontSizeInc" title="Increase Font Size">A+</button>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-sm btn-link text-decoration-none p-0 text-muted me-2" onclick="window.print();"><i class="fas fa-print me-1"></i> Print</button>
                    <button class="btn btn-sm btn-link text-decoration-none p-0 text-muted" onclick="alert('Article listening simulated... (TTS Engine)');"><i class="fas fa-volume-up me-1"></i> Listen</button>
                </div>
            </div>

            <!-- Large Cover Image -->
            <div class="mb-4 rounded-4 overflow-hidden shadow-sm" style="aspect-ratio: 16/9;">
                <img src="{{ $article['image'] }}" class="w-100 h-100 object-fit-cover" alt="Article banner">
            </div>

            <!-- Table of Contents (Inline Mobile) -->
            <div class="toc-box d-lg-none">
                <div class="toc-title">Quick Highlights</div>
                <ul>
                    <li><a href="#section1">Fiscal Reforms & Standard Deductions</a></li>
                    <li><a href="#section2">National AI Initiatives & Computing Grid</a></li>
                    <li><a href="#section3">Green Hydrogen Capital Investment</a></li>
                </ul>
            </div>

            <!-- Article Body Content -->
            <article class="article-container font-size-md" id="articleBodyContainer">
                <div class="article-body">
                    {!! $article['content'] !!}
                    
                    <!-- Inline Ad Placeholder -->
                    <div class="my-4 p-4 text-center rounded-3 bg-secondary bg-opacity-10 border border-secondary border-opacity-25" style="min-height: 120px;">
                        <span class="text-uppercase fw-bold text-muted d-block mb-1" style="font-size:0.6rem; letter-spacing:1px;">Sponsored Content</span>
                        <div class="fs-5 fw-bold text-primary mb-1">Rivaaz SaaS Premium Deployments</div>
                        <p class="text-muted small mb-2">Sell high-fidelity news portals to multi-tenant configurations in minutes.</p>
                        <a href="/contact" class="btn btn-xs btn-primary rounded-pill py-1 px-3 fw-bold fs-8">Learn More</a>
                    </div>

                    <p>Subsequent discussions in public domains indicate solid support for the proposed standard deduction revisions. Retail bank indexes reflected positive growths as household liquidity projections improved for the second quarter. Editorial analysts suggest this framework positions structural investments correctly before international trade shifts occur.</p>
                    
                    <p>In conclusion, the fiscal strategy achieves essential equilibrium points. While opposition elements point to credit reliance as a potential point of caution, capital expenditure numbers provide heavy security buffers for industrial developers.</p>
                </div>
            </article>

            <!-- Tags section -->
            <div class="d-flex flex-wrap gap-2 border-top border-bottom py-3 my-4 border-secondary-subtle">
                <span class="fw-bold text-uppercase fs-8 text-muted d-flex align-items-center"><i class="fas fa-tags me-1"></i> Tags:</span>
                @foreach($article['tags'] as $tag)
                <a href="/tag/{{ strtolower($tag) }}" class="badge bg-secondary text-reset text-decoration-none py-2 px-3 fw-semibold">#{{ $tag }}</a>
                @endforeach
            </div>

            <!-- Comments Section -->
            <section class="mb-5">
                <h4 class="headline-font mb-4 fw-bold border-bottom pb-2">Comments ({{ count($comments) }})</h4>
                
                <!-- Comment submission form -->
                <div class="card border-0 bg-body-tertiary p-3 rounded-4 mb-4">
                    <h6 class="fw-bold mb-2">Join the Conversation</h6>
                    <form onsubmit="event.preventDefault(); alert('Thank you for commenting! Your submission is in moderation.'); this.reset();">
                        <div class="row g-2 mb-2">
                            <div class="col-md-6">
                                <input type="text" class="form-control rounded-3" placeholder="Your Name" required>
                            </div>
                            <div class="col-md-6">
                                <input type="email" class="form-control rounded-3" placeholder="Your Email" required>
                            </div>
                        </div>
                        <div class="mb-2">
                            <textarea class="form-control rounded-3" rows="3" placeholder="Add your perspective..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm rounded-pill fw-bold px-3">Post Comment</button>
                    </form>
                </div>

                <!-- Comments list -->
                <div class="d-flex flex-column gap-3">
                    @foreach($comments as $comment)
                    <div class="d-flex gap-3 bg-body-tertiary bg-opacity-50 p-3 rounded-3 border border-secondary-subtle">
                        <img src="{{ $comment['avatar'] }}" alt="{{ $comment['name'] }}" class="rounded-circle border" style="width: 40px; height: 40px; object-fit: cover; flex-shrink: 0;">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <h6 class="mb-0 fw-bold fs-7">{{ $comment['name'] }}</h6>
                                <small class="text-muted fs-8">{{ $comment['date'] }}</small>
                            </div>
                            <p class="mb-0 fs-7 text-secondary-emphasis">{{ $comment['comment'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>

            <!-- Related News & Videos -->
            <section class="mb-4">
                <h4 class="headline-font mb-3 fw-bold border-bottom pb-2 text-uppercase">Related Stories</h4>
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
            
            <!-- Table of Contents (Desktop Only) -->
            <div class="toc-box d-none d-lg-block mb-4 shadow-sm">
                <div class="toc-title"><i class="fas fa-list me-1 text-primary"></i> Article Sections</div>
                <ul class="list-unstyled d-flex flex-column gap-2 mb-0">
                    <li><a href="#articleBodyContainer" class="text-reset hover-primary"><i class="fas fa-chevron-right text-primary me-1 fs-9"></i> 1. Standard Deductions Revisions</a></li>
                    <li><a href="#articleBodyContainer" class="text-reset hover-primary"><i class="fas fa-chevron-right text-primary me-1 fs-9"></i> 2. Green Energy Custom Duties</a></li>
                    <li><a href="#articleBodyContainer" class="text-reset hover-primary"><i class="fas fa-chevron-right text-primary me-1 fs-9"></i> 3. National AI Grids & GPUs</a></li>
                </ul>
            </div>

            @include('components.widgets', ['type' => 'latest_videos'])
            @include('components.widgets', ['type' => 'trending'])
            @include('components.widgets', ['type' => 'newsletter'])
        </div>
    </div>

</div>
@endsection
