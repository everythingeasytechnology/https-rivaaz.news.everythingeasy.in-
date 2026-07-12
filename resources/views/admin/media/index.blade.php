@extends('layouts.admin')

@section('title', 'Media Manager - Rivaaz Admin')

@section('admin-content')
<div class="fade-in-up">
    
    <!-- Title Area -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="m-0 fw-bold">Media Library</h3>
            <p class="text-muted small m-0">Upload assets, organize nested directories, and compress images with AI Alt tags.</p>
        </div>
        <button class="btn btn-sm btn-primary d-flex align-items-center gap-2" onclick="alert('Triggering file select upload browser...');">
            <i class="fa-solid fa-cloud-arrow-up"></i> Upload Media
        </button>
    </div>

    <div class="row g-4">
        
        <!-- Directory structure & Drag-Drop upload (Left - 4 Grid Units) -->
        <div class="col-lg-4">
            
            <!-- Folders widget -->
            <div class="card border border-secondary-subtle shadow-sm rounded-3 p-4 mb-4">
                <h5 class="fw-bold mb-3 border-bottom pb-2">Assets Folders</h5>
                
                <div class="list-group list-group-flush small">
                    <a href="#" class="list-group-item list-group-item-action border-0 px-0 d-flex justify-content-between align-items-center active bg-transparent text-primary" onclick="event.preventDefault(); showNotification('Folder: Banners selected');">
                        <span><i class="fa-solid fa-folder me-2"></i> Banners & Covers</span>
                        <span class="badge bg-primary-subtle text-primary">12 files</span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action border-0 px-0 d-flex justify-content-between align-items-center bg-transparent" onclick="event.preventDefault(); showNotification('Folder: Articles selected');">
                        <span><i class="fa-solid fa-folder me-2"></i> News Articles</span>
                        <span class="badge bg-secondary-subtle text-secondary">85 files</span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action border-0 px-0 d-flex justify-content-between align-items-center bg-transparent" onclick="event.preventDefault(); showNotification('Folder: Avatars selected');">
                        <span><i class="fa-solid fa-folder me-2"></i> User Avatars</span>
                        <span class="badge bg-secondary-subtle text-secondary">8 files</span>
                    </a>
                </div>
            </div>

            <!-- Upload drop area -->
            <div class="card border border-secondary-subtle shadow-sm rounded-3 p-4">
                <h5 class="fw-bold mb-3 border-bottom pb-2">Bulk Upload</h5>
                <div class="border border-dashed rounded-3 p-4 text-center bg-body-tertiary cursor-pointer" onclick="alert('Selecting files for bulk processing...');">
                    <i class="fa-solid fa-cloud-arrow-up fs-2 text-primary mb-2"></i>
                    <span class="d-block small text-muted">Drag & Drop files here to upload</span>
                    <small class="text-muted d-block mt-1" style="font-size:0.6rem;">JPG, PNG, WebP allowed (max 5MB)</small>
                </div>
            </div>

        </div>

        <!-- Media Grid area (Right - 8 Grid Units) -->
        <div class="col-lg-8">
            <div class="card border border-secondary-subtle shadow-sm rounded-3 p-4">
                <h5 class="fw-bold mb-3 border-bottom pb-2">Banners & Covers Directory</h5>
                
                <!-- Media Cards grid -->
                <div class="row g-3">
                    
                    <!-- Item 1 -->
                    <div class="col-sm-6 col-md-4">
                        <div class="card border border-secondary-subtle rounded-3 overflow-hidden shadow-sm h-100 cursor-pointer" onclick="openMediaDetailsModal('https://images.unsplash.com/photo-1585829365295-ab7cd400c167?auto=format&fit=crop&w=400&q=80', 'live-tv-banner.jpg')">
                            <img src="https://images.unsplash.com/photo-1585829365295-ab7cd400c167?auto=format&fit=crop&w=400&q=80" class="card-img-top object-fit-cover" style="height:120px;" alt="Ad banner">
                            <div class="p-2 small">
                                <span class="d-block text-truncate fw-bold mb-0">live-tv-banner.jpg</span>
                                <small class="text-muted">380 KB • WebP</small>
                            </div>
                        </div>
                    </div>

                    <!-- Item 2 -->
                    <div class="col-sm-6 col-md-4">
                        <div class="card border border-secondary-subtle rounded-3 overflow-hidden shadow-sm h-100 cursor-pointer" onclick="openMediaDetailsModal('https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?auto=format&fit=crop&w=400&q=80', 'finance-reforms.jpg')">
                            <img src="https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?auto=format&fit=crop&w=400&q=80" class="card-img-top object-fit-cover" style="height:120px;" alt="Ad banner">
                            <div class="p-2 small">
                                <span class="d-block text-truncate fw-bold mb-0">finance-reforms.jpg</span>
                                <small class="text-muted">210 KB • JPEG</small>
                            </div>
                        </div>
                    </div>

                    <!-- Item 3 -->
                    <div class="col-sm-6 col-md-4">
                        <div class="card border border-secondary-subtle rounded-3 overflow-hidden shadow-sm h-100 cursor-pointer" onclick="openMediaDetailsModal('https://images.unsplash.com/photo-1620712943543-bcc4688e7485?auto=format&fit=crop&w=400&q=80', 'ai-mission-grid.png')">
                            <img src="https://images.unsplash.com/photo-1620712943543-bcc4688e7485?auto=format&fit=crop&w=400&q=80" class="card-img-top object-fit-cover" style="height:120px;" alt="Ad banner">
                            <div class="p-2 small">
                                <span class="d-block text-truncate fw-bold mb-0">ai-mission-grid.png</span>
                                <small class="text-muted">890 KB • PNG</small>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>

</div>

<!-- Media details overlay modal -->
<div class="modal fade" id="mediaDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mediaModalTitle">File Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-3">
                    <div class="col-md-6 text-center">
                        <img src="" id="mediaModalPreview" class="img-fluid rounded border shadow-sm max-vh-50 object-fit-contain" alt="Preview">
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-3 border-bottom pb-2">Asset Parameters</h6>
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold">AI Alt Text Suggestions</label>
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control form-control-sm" id="mediaAltText" value="News channel studio with anchors.">
                                <button class="btn btn-outline-primary" type="button" onclick="generateAiAltText()"><i class="fa-solid fa-wand-magic-sparkles"></i> AI Alt</button>
                            </div>
                        </div>

                        <!-- Modify Actions -->
                        <div class="mb-4">
                            <span class="d-block small fw-bold mb-2">Edit Image Utilities</span>
                            <div class="d-flex flex-wrap gap-2">
                                <button class="btn btn-xs btn-outline-secondary border-secondary-subtle" onclick="alert('Image cropped (Simulated).');"><i class="fa-solid fa-crop-simple"></i> Crop</button>
                                <button class="btn btn-xs btn-outline-secondary border-secondary-subtle" onclick="alert('Watermark logo overlay applied.');"><i class="fa-solid fa-signature"></i> Watermark</button>
                                <button class="btn btn-xs btn-outline-secondary border-secondary-subtle" onclick="alert('Assets compression complete. Saved 45% size.');"><i class="fa-solid fa-compress"></i> Compress</button>
                            </div>
                        </div>

                        <button class="btn btn-primary btn-sm rounded-pill w-100 fw-bold" data-bs-dismiss="modal">Update Parameters</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Simulation Scripts for Media -->
<script>
    let activeMediaModal = null;
    
    function openMediaDetailsModal(src, title) {
        document.getElementById('mediaModalTitle').innerText = title;
        document.getElementById('mediaModalPreview').src = src;
        
        // Reset alt tag input
        document.getElementById('mediaAltText').value = `Auto label: ${title.replace(/\.[^/.]+$/, "")}`;
        
        if (window.bootstrap) {
            if (!activeMediaModal) {
                activeMediaModal = new bootstrap.Modal(document.getElementById('mediaDetailsModal'));
            }
            activeMediaModal.show();
        }
    }

    function generateAiAltText() {
        const altInput = document.getElementById('mediaAltText');
        altInput.value = "AI Generated: Premium digital economy presentation board featuring fiscal data graphs.";
        showNotification('AI Image Alt-text generated and applied.');
    }
</script>
@endsection
