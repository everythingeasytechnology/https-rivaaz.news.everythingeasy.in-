@extends('layouts.app')

@section('title', 'Photo Galleries - Rivaaz Chronicle')

@section('content')
<div class="container-xl">
    
    <!-- Gallery Header -->
    <div class="bg-body-tertiary p-4 rounded-4 mb-4 border border-secondary-subtle">
        <h1 class="headline-font fw-extrabold text-primary mb-2"><i class="fas fa-images me-2"></i> Photo Galleries</h1>
        <p class="text-muted mb-0 small">Explore major news items, red carpet celebrations, and sports finales in visual frames.</p>
    </div>

    <!-- Masonry Albums Grid -->
    <div class="masonry-gallery mb-5">
        @foreach($photos as $album)
        <div class="masonry-item {{ $album['size'] }}" data-bs-toggle="modal" data-bs-target="#lightboxModal" onclick="loadLightbox('{{ $album['title'] }}', '{{ $album['image'] }}', '{{ $album['count'] }}')">
            <img src="{{ $album['image'] }}" alt="{{ $album['title'] }}">
            <div class="masonry-overlay">
                <span class="badge bg-primary text-white mb-2 py-1 px-3 align-self-start fw-bold fs-9 text-uppercase" style="letter-spacing:0.5px;">{{ $album['category'] }}</span>
                <h4 class="fw-bold text-white mb-1 fs-5">{{ $album['title'] }}</h4>
                <small class="text-white-50"><i class="far fa-images me-1"></i> {{ $album['count'] }} Frames</small>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Lightbox Modal (Simulated Album slides) -->
    <div class="modal fade" id="lightboxModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-dark border-0 rounded-4 shadow-lg text-white">
                <div class="modal-header border-0 pb-0 justify-content-between">
                    <h5 class="modal-title fw-bold text-white" id="lightboxTitle">Album Title</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    <div class="position-relative overflow-hidden rounded-3 border border-secondary border-opacity-25" style="max-height: 480px; background-color:#000;">
                        <img id="lightboxImg" src="" alt="Album Slide" class="w-100 object-fit-contain" style="height:420px;">
                        
                        <!-- Nav buttons -->
                        <button class="position-absolute top-50 start-0 translate-middle-y btn btn-link text-white fs-3" onclick="alert('Previous slide simulated...')"><i class="fas fa-chevron-left"></i></button>
                        <button class="position-absolute top-50 end-0 translate-middle-y btn btn-link text-white fs-3" onclick="alert('Next slide simulated...')"><i class="fas fa-chevron-right"></i></button>
                    </div>
                    <p class="mt-3 text-white-50 mb-0"><i class="far fa-image"></i> Slide 1 of <span id="lightboxCount">10</span>. Photo: Special Editorial Coverage.</p>
                </div>
            </div>
        </div>
    </div>

</div>

@section('styles')
<script>
    function loadLightbox(title, imgUrl, count) {
        document.getElementById('lightboxTitle').textContent = title;
        document.getElementById('lightboxImg').src = imgUrl;
        document.getElementById('lightboxCount').textContent = count;
    }
</script>
@endsection
@endsection
