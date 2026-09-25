@extends('layouts.app')

@section('title', 'वीडियो बुलेटिन - उत्तराखंड नाउ')

@section('content')
<div class="container-xl">
    
    <!-- Videos Header -->
    <div class="bg-body-tertiary p-4 rounded-4 mb-4 border border-secondary-subtle">
        <h1 class="headline-font fw-extrabold text-primary mb-2"><i class="fas fa-play-circle me-2"></i> उत्तराखंड नाउ टीवी</h1>
        <p class="text-muted mb-0 small">लाइव प्रसारण, साक्षात्कार, वीडियो ब्रीफिंग और विस्तृत जमीनी कवरेज देखें।</p>
    </div>

    @if(!empty($featured) && !empty($videos))
    <!-- Video Grid stage -->
    <div class="row g-4 mb-5">
        <!-- Main Video Stage (7 units) -->
        <div class="col-lg-8">
            <div class="video-featured-player position-relative" id="videoStageContainer" style="aspect-ratio: 16/9; background: #000; border-radius: 12px; overflow: hidden;">
                <!-- Cover placeholder -->
                <div class="video-placeholder-cover position-absolute w-100 h-100 top-0 start-0 d-flex align-items-center justify-content-center" id="stageCover" style="background-image: url('{{ $featured['image'] }}'); background-size: cover; background-position: center; z-index: 3;">
                    <button class="play-btn btn btn-danger rounded-circle d-flex align-items-center justify-content-center animate-pulse" style="width: 65px; height: 65px;" onclick="playStageVideo()" aria-label="Play video"><i class="fas fa-play fs-3" style="margin-left: 4px;"></i></button>
                </div>
                <!-- YouTube/Vimeo iframe player -->
                <iframe id="stagePlayer" class="w-100 h-100 border-0 d-none" src="" title="Video Player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="z-index: 2;"></iframe>
                <!-- Local video player -->
                <video id="stageLocalPlayer" class="w-100 h-100 d-none" controls playsinline style="z-index: 2; object-fit: contain;"></video>
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mt-3 pb-2 border-bottom border-secondary-subtle">
                <h2 class="headline-font fw-bold fs-4 mb-0" id="stageTitle">{{ $featured['title'] }}</h2>
                <div class="d-flex align-items-center gap-2">
                    <a id="stageWhatsAppShare" href="https://api.whatsapp.com/send?text={{ urlencode($featured['title'] . ' ' . request()->fullUrl()) }}" target="_blank" class="btn btn-sm btn-success rounded-pill px-3 fw-semibold d-inline-flex align-items-center gap-1 shadow-sm" title="व्हाट्सएप">
                        <i class="fab fa-whatsapp"></i> <span>व्हाट्सएप</span>
                    </a>
                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-semibold d-inline-flex align-items-center gap-1 copy-link-btn" data-url="{{ request()->fullUrl() }}" data-title="{{ $featured['title'] }}" title="शेयर करें">
                        <i class="fas fa-share-alt"></i> <span>शेयर</span>
                    </button>
                </div>
            </div>
            <p class="text-muted small mt-2" id="stageMeta">{{ $featured['views'] }} • {{ $featured['date'] }} • {{ $featured['category'] }}</p>
        </div>

        <!-- Sidebar Playlist feed (4 units) -->
        <div class="col-lg-4">
            <div class="widget-box h-100">
                <div class="widget-title">
                    <span><i class="fas fa-list text-primary me-2"></i>प्लेलिस्ट स्ट्रीम</span>
                </div>
                <div class="d-flex flex-column gap-3 overflow-y-auto" style="max-height: 480px;">
                    @foreach($videos as $vid)
                    <div class="d-flex gap-3 align-items-center bg-body-tertiary bg-opacity-75 p-2 rounded-3 border border-secondary-subtle cursor-pointer hover-shadow" 
                         onclick="changeStage('{{ addslashes($vid['title']) }}', '{{ $vid['image'] }}', '{{ $vid['video_url'] }}', '{{ $vid['youtube_id'] }}', '{{ $vid['is_local'] ? 1 : 0 }}', '{{ $vid['views'] }}', '{{ $vid['date'] }}', '{{ $vid['category'] }}')">
                        <div class="position-relative flex-shrink-0" style="width: 100px; height: 65px; border-radius: 6px; overflow: hidden;">
                            <img src="{{ $vid['image'] }}" class="w-100 h-100 object-fit-cover" alt="Video cover">
                            <span class="position-absolute bottom-0 end-0 bg-dark text-white fs-9 px-1 m-1 rounded-1"><i class="fas fa-play me-1 fs-10"></i>{{ $vid['duration'] }}</span>
                        </div>
                        <div>
                            <h6 class="mb-1 fw-bold fs-7 line-clamp-2">{{ $vid['title'] }}</h6>
                            <small class="text-muted fs-8">{{ $vid['views'] }}</small>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @else
    <!-- Clean No Videos Empty State -->
    <div class="text-center py-5 bg-body-tertiary rounded-4 border border-secondary-subtle my-5">
        <div class="display-3 text-muted mb-3"><i class="fas fa-video-slash"></i></div>
        <h3 class="fw-bold headline-font text-body mb-2">कोई वीडियो बुलेटिन उपलब्ध नहीं है</h3>
        <p class="text-muted col-lg-6 mx-auto mb-4 fs-6">फ़िलहाल कोई वीडियो प्रकाशित नहीं किया गया है। कृपया बाद में दोबारा देखें या मुख्य पृष्ठ से ताज़ा समाचार पढ़ें।</p>
        <a href="/" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">
            <i class="fas fa-home me-2"></i>मुख्य पृष्ठ पर जाएं
        </a>
    </div>
    @endif

</div>

@section('styles')
@if(!empty($featured))
<script>
    // State of the current featured video
    let currentVideo = @json($featured);

    function changeStage(title, coverUrl, videoUrl, youtubeId, isLocal, views, date, category) {
        currentVideo = {
            title: title,
            image: coverUrl,
            video_url: videoUrl,
            youtube_id: youtubeId,
            is_local: isLocal === '1' || isLocal === true || isLocal === 1,
            views: views,
            date: date,
            category: category
        };

        // Reset stage players
        const player = document.getElementById('stagePlayer');
        const localPlayer = document.getElementById('stageLocalPlayer');
        const cover = document.getElementById('stageCover');
        
        player.classList.add('d-none');
        player.src = "";
        localPlayer.classList.add('d-none');
        localPlayer.src = "";
        localPlayer.pause();

        cover.style.backgroundImage = `url('${coverUrl}')`;
        cover.classList.remove('d-none');
        
        // Update texts & share links
        document.getElementById('stageTitle').textContent = title;
        document.getElementById('stageMeta').textContent = `${views} • ${date} • ${category}`;
        const waBtn = document.getElementById('stageWhatsAppShare');
        if (waBtn) {
            waBtn.href = `https://api.whatsapp.com/send?text=${encodeURIComponent(title + ' ' + window.location.href)}`;
        }
    }

    function playStageVideo() {
        const player = document.getElementById('stagePlayer');
        const localPlayer = document.getElementById('stageLocalPlayer');
        const cover = document.getElementById('stageCover');
        
        cover.classList.add('d-none');
        
        if (currentVideo.is_local) {
            localPlayer.src = currentVideo.video_url;
            localPlayer.classList.remove('d-none');
            localPlayer.play();
        } else {
            if (currentVideo.youtube_id) {
                player.src = `https://www.youtube.com/embed/${currentVideo.youtube_id}?autoplay=1`;
            } else {
                player.src = currentVideo.video_url + (currentVideo.video_url.includes('?') ? '&' : '?') + 'autoplay=1';
            }
            player.classList.remove('d-none');
        }
    }
</script>
@endif
@endsection
@endsection
