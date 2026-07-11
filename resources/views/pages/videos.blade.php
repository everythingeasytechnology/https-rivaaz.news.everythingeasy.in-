@extends('layouts.app')

@section('title', 'Video Bulletins - Rivaaz Chronicle')

@section('content')
<div class="container-xl">
    
    <!-- Video Portal Header -->
    <div class="bg-body-tertiary p-4 rounded-4 mb-4 border border-secondary-subtle">
        <h1 class="headline-font fw-extrabold text-primary mb-2"><i class="fas fa-play-circle me-2"></i> Rivaaz TV</h1>
        <p class="text-muted mb-0 small">Watch live telecasts, interviews, video briefings, and detailed on-ground coverages.</p>
    </div>

    <!-- Video Grid stage -->
    <div class="row g-4 mb-5">
        <!-- Main Video Stage (7 units) -->
        <div class="col-lg-8">
            <div class="video-featured-player" id="videoStageContainer">
                <div class="video-placeholder-cover" id="stageCover" style="background-image: url('{{ $featured['image'] }}')">
                    <button class="play-btn" onclick="startStageVideo('{{ $featured['youtube_id'] }}')" aria-label="Play video"><i class="fas fa-play"></i></button>
                </div>
                <iframe id="stagePlayer" class="d-none" src="" title="Video Player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
            <h2 class="headline-font fw-bold fs-3 mb-2" id="stageTitle">{{ $featured['title'] }}</h2>
            <p class="text-muted small" id="stageMeta">{{ $featured['views'] }} • {{ $featured['date'] }} • {{ $featured['category'] }}</p>
        </div>

        <!-- Sidebar Playlist feed (4 units) -->
        <div class="col-lg-4">
            <div class="widget-box h-100">
                <div class="widget-title">
                    <span><i class="fas fa-list text-primary me-2"></i>Playlist Stream</span>
                </div>
                <div class="d-flex flex-column gap-3 overflow-y-auto" style="max-height: 480px;">
                    @foreach($videos as $vid)
                    <div class="d-flex gap-3 align-items-center bg-body-tertiary bg-opacity-75 p-2 rounded-3 border border-secondary-subtle cursor-pointer hover-shadow" 
                         onclick="changeStage('{{ $vid['title'] }}', '{{ $vid['image'] }}', '{{ $vid['youtube_id'] }}', '{{ $vid['views'] }}', '{{ $vid['date'] }}', '{{ $vid['category'] }}')">
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

</div>

@section('styles')
<script>
    function changeStage(title, coverUrl, youtubeId, views, date, category) {
        // Reset stage player
        const player = document.getElementById('stagePlayer');
        const cover = document.getElementById('stageCover');
        
        player.classList.add('d-none');
        player.src = "";
        cover.style.backgroundImage = `url('${coverUrl}')`;
        cover.classList.remove('d-none');
        
        // Update texts
        document.getElementById('stageTitle').textContent = title;
        document.getElementById('stageMeta').textContent = `${views} • ${date} • ${category}`;
        
        // Set onclick for cover play-btn
        const playBtn = cover.querySelector('.play-btn');
        playBtn.onclick = function() {
            startStageVideo(youtubeId);
        };
    }

    function startStageVideo(youtubeId) {
        const player = document.getElementById('stagePlayer');
        const cover = document.getElementById('stageCover');
        
        cover.classList.add('d-none');
        player.src = `https://www.youtube.com/embed/${youtubeId}?autoplay=1`;
        player.classList.remove('d-none');
    }
</script>
@endsection
@endsection
