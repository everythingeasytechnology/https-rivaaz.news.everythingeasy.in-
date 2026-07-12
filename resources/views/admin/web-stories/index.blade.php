@extends('layouts.admin')

@section('title', 'Web Stories Builder - Rivaaz Admin')

@section('admin-content')
<div class="fade-in-up">
    
    <!-- Title Area -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="m-0 fw-bold">Web Stories Builder</h3>
            <p class="text-muted small m-0">Create Instagram-style dynamic slides for mobile storytelling grids.</p>
        </div>
        <button class="btn btn-sm btn-primary" onclick="alert('Web story draft saved.');">
            <i class="fa-solid fa-floppy-disk"></i> Save Draft
        </button>
    </div>

    <div class="row g-4">
        
        <!-- Active Web Stories (Left - 7 Grid Units) -->
        <div class="col-lg-7">
            <div class="card border border-secondary-subtle shadow-sm rounded-3 p-4">
                <h5 class="fw-bold mb-3 border-bottom pb-2">Active Web Stories</h5>
                
                <div class="row g-3" id="activeStoriesList">
                    
                    <!-- Story 1 -->
                    <div class="col-sm-6 col-md-4">
                        <div class="card border rounded-3 overflow-hidden shadow-sm h-100 position-relative">
                            <img src="https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?auto=format&fit=crop&w=400&q=80" class="card-img-top object-fit-cover" style="height: 140px;" alt="Story">
                            <div class="p-2 small">
                                <span class="d-block fw-bold text-truncate mb-1">Union Budget Details</span>
                                <small class="text-muted">3 slides • Active</small>
                            </div>
                            <button class="btn btn-xs btn-danger position-absolute top-0 end-0 m-1" onclick="this.closest('.col-sm-6').remove(); showNotification('Web story deleted');" title="Delete Story"><i class="fa-solid fa-xmark"></i></button>
                        </div>
                    </div>

                    <!-- Story 2 -->
                    <div class="col-sm-6 col-md-4">
                        <div class="card border rounded-3 overflow-hidden shadow-sm h-100 position-relative">
                            <img src="https://images.unsplash.com/photo-1620712943543-bcc4688e7485?auto=format&fit=crop&w=400&q=80" class="card-img-top object-fit-cover" style="height: 140px;" alt="Story">
                            <div class="p-2 small">
                                <span class="d-block fw-bold text-truncate mb-1">National AI Mission</span>
                                <small class="text-muted">4 slides • Active</small>
                            </div>
                            <button class="btn btn-xs btn-danger position-absolute top-0 end-0 m-1" onclick="this.closest('.col-sm-6').remove(); showNotification('Web story deleted');" title="Delete Story"><i class="fa-solid fa-xmark"></i></button>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <!-- Create Story Form (Right - 5 Grid Units) -->
        <div class="col-lg-5">
            <div class="card border border-secondary-subtle shadow-sm rounded-3 p-4">
                <h5 class="fw-bold mb-3 border-bottom pb-2">Create Web Story</h5>
                
                <form onsubmit="publishNewWebStory(event)">
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Story Global Title</label>
                        <input type="text" class="form-control form-control-sm" id="storyGlobalTitle" placeholder="e.g. Rupee gains vs Dollar" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Select Category</label>
                        <select class="form-select form-select-sm" id="storyCategory">
                            <option value="business">Business</option>
                            <option value="technology">Technology</option>
                            <option value="entertainment">Entertainment</option>
                        </select>
                    </div>

                    <!-- Slides list editor -->
                    <div class="mb-4">
                        <label class="form-label small fw-bold d-flex justify-content-between align-items-center mb-2">
                            <span>Story Slides (Timeline)</span>
                            <button class="btn btn-xs btn-outline-primary" type="button" onclick="addNewSlideEditorRow()"><i class="fa-solid fa-plus"></i> Add Slide</button>
                        </label>
                        
                        <div class="d-flex flex-column gap-2" id="slidesEditorTimeline">
                            <!-- Default Slide 1 -->
                            <div class="border rounded p-2 bg-body-tertiary position-relative slide-row-item">
                                <div class="mb-1">
                                    <input type="text" class="form-control form-control-sm slide-title-input" placeholder="Slide 1 Headline text" required>
                                </div>
                                <div>
                                    <input type="text" class="form-control form-control-sm slide-img-input" placeholder="Image URL (Unsplash or local path)" value="https://images.unsplash.com/photo-1526304640581-d334cdbbf45e?auto=format&fit=crop&w=400&q=80" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm rounded-pill w-100 fw-bold">Publish Web Story</button>

                </form>

            </div>
        </div>

    </div>

</div>

<!-- Interactive simulation scripts for Web Stories -->
<script>
    let slideCounter = 1;
    
    function addNewSlideEditorRow() {
        slideCounter++;
        const timeline = document.getElementById('slidesEditorTimeline');
        const rowHtml = `
            <div class="border rounded p-2 bg-body-tertiary position-relative slide-row-item fade-in-up">
                <div class="mb-1">
                    <input type="text" class="form-control form-control-sm slide-title-input" placeholder="Slide ${slideCounter} Headline text" required>
                </div>
                <div class="mb-2">
                    <input type="text" class="form-control form-control-sm slide-img-input" placeholder="Image URL" value="https://images.unsplash.com/photo-1620712943543-bcc4688e7485?auto=format&fit=crop&w=400&q=80" required>
                </div>
                <button class="btn btn-xs btn-danger position-absolute top-0 end-0 m-1" type="button" onclick="this.parentElement.remove()" title="Remove Slide"><i class="fa-solid fa-trash-can"></i></button>
            </div>
        `;
        timeline.insertAdjacentHTML('beforeend', rowHtml);
    }

    function publishNewWebStory(e) {
        e.preventDefault();
        
        const title = document.getElementById('storyGlobalTitle').value.trim();
        const slidesCount = document.querySelectorAll('.slide-row-item').length;
        const firstImg = document.querySelector('.slide-img-input').value;
        const list = document.getElementById('activeStoriesList');
        
        if (!title) return;
        
        const storyCardHtml = `
            <div class="col-sm-6 col-md-4 fade-in-up">
                <div class="card border rounded-3 overflow-hidden shadow-sm h-100 position-relative">
                    <img src="${firstImg}" class="card-img-top object-fit-cover" style="height: 140px;" alt="Story">
                    <div class="p-2 small">
                        <span class="d-block fw-bold text-truncate mb-1">${title}</span>
                        <small class="text-muted">${slidesCount} slides • Active</small>
                    </div>
                    <button class="btn btn-xs btn-danger position-absolute top-0 end-0 m-1" onclick="this.closest('.col-sm-6').remove(); showNotification('Web story deleted');" title="Delete Story"><i class="fa-solid fa-xmark"></i></button>
                </div>
            </div>
        `;
        
        list.insertAdjacentHTML('beforeend', storyCardHtml);
        
        // Reset form inputs
        document.getElementById('storyGlobalTitle').value = '';
        document.getElementById('slidesEditorTimeline').innerHTML = `
            <div class="border rounded p-2 bg-body-tertiary position-relative slide-row-item">
                <div class="mb-1">
                    <input type="text" class="form-control form-control-sm slide-title-input" placeholder="Slide 1 Headline text" required>
                </div>
                <div>
                    <input type="text" class="form-control form-control-sm slide-img-input" placeholder="Image URL (Unsplash or local path)" value="https://images.unsplash.com/photo-1526304640581-d334cdbbf45e?auto=format&fit=crop&w=400&q=80" required>
                </div>
            </div>
        `;
        slideCounter = 1;
        
        showNotification(`Web Story: "${title}" containing ${slidesCount} slides successfully published to portal!`);
    }
</script>
@endsection
