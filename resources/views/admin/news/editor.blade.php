@extends('layouts.admin')

@section('title', 'Write Article - Gutenberg Editor - Rivaaz Admin')

@section('admin-content')
<div class="fade-in-up">
    
    <!-- Top Action Bar -->
    <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3 border-secondary-subtle">
        <div>
            <h3 class="m-0 fw-bold">Gutenberg Block Editor</h3>
            <p class="text-muted small m-0">Write, structure, and optimize multi-tenant news updates.</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-sm btn-outline-secondary border-secondary-subtle" onclick="alert('Draft saved as simulation.');">Save Draft</button>
            <button class="btn btn-sm btn-primary" onclick="alert('Article published successfully!');">Publish Post</button>
        </div>
    </div>

    <div class="row g-4">
        
        <!-- Left Column: Block Editor Canvas (8 Grid Units) -->
        <div class="col-lg-8">
            <div class="card border border-secondary-subtle shadow-sm rounded-3 p-4 bg-body-card">
                
                <!-- Headline Input (No borders look) -->
                <div class="mb-4">
                    <input type="text" id="gutenbergTitle" class="form-control form-control-lg border-0 shadow-none px-0 py-2 fw-bold" placeholder="Add title..." style="font-size: 2.2rem; font-family: var(--font-headlines); background: transparent;">
                    <input type="text" id="gutenbergSubtitle" class="form-control border-0 shadow-none px-0 text-muted" placeholder="Add subtitle or teaser description..." style="font-size: 1.1rem; background: transparent;">
                </div>

                <!-- Editor Canvas container -->
                <div class="editor-canvas py-3 min-vh-50" id="editorCanvas">
                    <!-- Default Paragraph Block -->
                    <div class="editor-block-item mb-3 p-2 rounded border border-transparent position-relative">
                        <textarea class="form-control border-0 shadow-none px-0 py-1" rows="3" placeholder="Start typing your story paragraph..." style="background: transparent; resize: none;"></textarea>
                    </div>
                </div>

                <!-- Add Block Controls -->
                <div class="border-top border-secondary-subtle pt-3 text-center">
                    <span class="text-muted small d-block mb-3">Insert Gutenberg Content Block</span>
                    <div class="d-flex flex-wrap justify-content-center gap-2">
                        <button class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1 border-secondary-subtle" onclick="addEditorBlock('paragraph')">
                            <i class="fa-solid fa-paragraph text-primary"></i> Paragraph
                        </button>
                        <button class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1 border-secondary-subtle" onclick="addEditorBlock('image')">
                            <i class="fa-regular fa-image text-success"></i> Image
                        </button>
                        <button class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1 border-secondary-subtle" onclick="addEditorBlock('quote')">
                            <i class="fa-solid fa-quote-left text-warning"></i> Quote
                        </button>
                        <button class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1 border-secondary-subtle" onclick="addEditorBlock('video')">
                            <i class="fa-solid fa-video text-danger"></i> Video Embed
                        </button>
                    </div>
                </div>

            </div>
        </div>

        <!-- Right Column: SEO and Publishing Parameters (4 Grid Units) -->
        <div class="col-lg-4">
            
            <!-- 1. SEO & AI Helper Widget -->
            <div class="card border border-secondary-subtle shadow-sm rounded-3 p-3 mb-4">
                <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2 border-secondary-subtle">
                    <h6 class="fw-bold m-0"><i class="fa-solid fa-wand-magic-sparkles text-primary me-2"></i>AI & SEO Score</h6>
                    <span class="badge bg-success-subtle text-success border border-success-subtle py-1" id="seoScoreLabel">SEO: 85/100</span>
                </div>

                <!-- Readability Scale -->
                <div class="mb-3">
                    <div class="d-flex align-items-center justify-content-between small mb-1">
                        <span>Readability Score</span>
                        <strong class="text-success">Excellent (92%)</strong>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 92%;" aria-valuenow="92" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>

                <!-- Slug generator -->
                <div class="mb-3">
                    <label for="articleSlug" class="form-label small fw-bold">Slug URL Path</label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light text-muted" style="font-size:0.75rem;">/news/</span>
                        <input type="text" class="form-control" id="articleSlug" value="union-budget-digital-reforms">
                    </div>
                </div>

                <!-- AI Title suggestions trigger -->
                <div class="mb-2">
                    <button class="btn btn-sm btn-outline-primary w-100 d-flex align-items-center justify-content-center gap-2" id="aiGenerateBtn" onclick="triggerAiSuggestions()">
                        <i class="fa-solid fa-brain"></i> Suggest AI Headlines
                    </button>
                </div>
                
                <!-- Dynamic suggestions box -->
                <div class="bg-body-tertiary rounded-3 p-2 border border-secondary-subtle d-none" id="aiSuggestionsBox">
                    <small class="text-muted d-block mb-2">Double-click a title to apply:</small>
                    <ul class="list-unstyled mb-0 d-flex flex-column gap-2 small">
                        <li><a href="#" class="d-block p-2 bg-card border rounded text-decoration-none text-reset hover-primary" onclick="applyHeadline(this.innerText)">Budget digital expansion: zero-carbon targets outlined by Finance Minister</a></li>
                        <li><a href="#" class="d-block p-2 bg-card border rounded text-decoration-none text-reset hover-primary" onclick="applyHeadline(this.innerText)">India Budget: Top Reforms targeting Salaried class deduction increases</a></li>
                        <li><a href="#" class="d-block p-2 bg-card border rounded text-decoration-none text-reset hover-primary" onclick="applyHeadline(this.innerText)">Finance Minister Digital economy roadmap: what you need to know</a></li>
                    </ul>
                </div>

            </div>

            <!-- 2. Featured Image Widget -->
            <div class="card border border-secondary-subtle shadow-sm rounded-3 p-3 mb-4">
                <h6 class="fw-bold mb-3 border-bottom pb-2 border-secondary-subtle">Featured Cover Banner</h6>
                <div class="border border-dashed rounded-3 p-4 text-center bg-body-tertiary cursor-pointer" onclick="alert('Media gallery selection modal opened...');">
                    <i class="fa-regular fa-image fs-1 text-muted opacity-50 mb-2"></i>
                    <span class="d-block text-muted small fw-semibold">Click to assign Featured Image</span>
                    <small class="text-muted text-uppercase d-block mt-1" style="font-size: 0.6rem;">Aspect ratio 16:10 recommended</small>
                </div>
            </div>

            <!-- SEO Meta Tags Widget -->
            <div class="card border border-secondary-subtle shadow-sm rounded-3 p-3 mb-4">
                <h6 class="fw-bold mb-3 border-bottom pb-2 border-secondary-subtle"><i class="fa-solid fa-magnifying-glass text-success me-2"></i>SEO Meta Tags</h6>
                
                <div class="mb-3">
                    <label class="form-label small fw-bold">Meta Title Override</label>
                    <input type="text" class="form-control form-control-sm" placeholder="Leave empty to use main title">
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Meta Description</label>
                    <textarea class="form-control form-control-sm" rows="3" id="metaDescriptionInput" placeholder="Write page synopsis for Google search listings (150-160 chars)..."></textarea>
                    <small class="text-muted d-block mt-1" style="font-size:0.65rem;" id="metaCharCounter">0 / 160 characters</small>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Focus Keywords</label>
                    <input type="text" class="form-control form-control-sm" placeholder="e.g. union budget, tax reforms">
                </div>

                <div class="form-check form-switch small">
                    <input class="form-check-input" type="checkbox" role="switch" id="ogTagSync" checked>
                    <label class="form-check-label font-weight-normal" for="ogTagSync">Sync with OG / Twitter Cards</label>
                </div>
            </div>

            <!-- 3. Publishing Parameters -->
            <div class="card border border-secondary-subtle shadow-sm rounded-3 p-3">
                <h6 class="fw-bold mb-3 border-bottom pb-2 border-secondary-subtle">Publish Settings</h6>
                
                <div class="mb-3">
                    <label class="form-label small fw-bold">Visibility Node</label>
                    <select class="form-select form-select-sm">
                        <option value="public" selected>Public (Search engines allowed)</option>
                        <option value="private">Private (Only active members)</option>
                        <option value="draft">Restricted Draft</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Schedule Publish Date</label>
                    <input type="datetime-local" class="form-control form-control-sm" value="2026-07-13T09:30">
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Category Folder</label>
                    <select class="form-select form-select-sm" id="categorySelect">
                        <option value="india">India</option>
                        <option value="politics">Politics (Sarkar channel)</option>
                        <option value="technology" selected>Technology (Metro Times)</option>
                        <option value="business">Business & Finance</option>
                        <option value="entertainment">Entertainment</option>
                    </select>
                </div>

                <div class="mb-2">
                    <label class="form-label small fw-bold">Subcategory</label>
                    <select class="form-select form-select-sm" id="subcategorySelect">
                        <!-- Loaded dynamically -->
                    </select>
                </div>
            </div>

        </div>

    </div>

</div>

<!-- Gutenberg block additions logic -->
<script>
    function addEditorBlock(blockType) {
        const canvas = document.getElementById('editorCanvas');
        let blockHtml = '';
        
        if (blockType === 'paragraph') {
            blockHtml = `
                <div class="editor-block-item mb-3 p-2 rounded border border-secondary-subtle position-relative bg-body-tertiary">
                    <textarea class="form-control border-0 shadow-none px-0 py-1" rows="3" placeholder="Enter paragraph details..." style="background: transparent; resize: none;"></textarea>
                    <button class="btn btn-xs btn-danger position-absolute top-0 end-0 m-1" onclick="this.parentElement.remove()" title="Delete block"><i class="fa-solid fa-xmark"></i></button>
                </div>
            `;
        } else if (blockType === 'image') {
            blockHtml = `
                <div class="editor-block-item mb-3 p-3 rounded border border-dashed border-success position-relative bg-success bg-opacity-5 text-center">
                    <i class="fa-regular fa-image fs-2 text-success mb-2"></i>
                    <span class="d-block small text-muted">Block Image. Click to load from Media Library</span>
                    <button class="btn btn-xs btn-danger position-absolute top-0 end-0 m-1" onclick="this.parentElement.remove()" title="Delete block"><i class="fa-solid fa-xmark"></i></button>
                </div>
            `;
        } else if (blockType === 'quote') {
            blockHtml = `
                <div class="editor-block-item mb-3 p-3 rounded border-start border-primary border-4 position-relative bg-body-tertiary">
                    <input type="text" class="form-control border-0 shadow-none fw-italic p-0" placeholder="Enter blockquote text..." style="background: transparent; font-style: italic;">
                    <input type="text" class="form-control border-0 shadow-none text-muted small p-0 mt-1" placeholder="— Author name" style="background: transparent; font-size: 0.75rem;">
                    <button class="btn btn-xs btn-danger position-absolute top-0 end-0 m-1" onclick="this.parentElement.remove()" title="Delete block"><i class="fa-solid fa-xmark"></i></button>
                </div>
            `;
        } else if (blockType === 'video') {
            blockHtml = `
                <div class="editor-block-item mb-3 p-3 rounded border border-danger position-relative bg-danger bg-opacity-5 text-center">
                    <i class="fa-solid fa-video fs-2 text-danger mb-2"></i>
                    <input type="text" class="form-control form-control-sm text-center border-secondary-subtle" placeholder="Paste YouTube, Vimeo or video URL link here...">
                    <button class="btn btn-xs btn-danger position-absolute top-0 end-0 m-1" onclick="this.parentElement.remove()" title="Delete block"><i class="fa-solid fa-xmark"></i></button>
                </div>
            `;
        }
        
        canvas.insertAdjacentHTML('beforeend', blockHtml);
    }

    function triggerAiSuggestions() {
        const btn = document.getElementById('aiGenerateBtn');
        const box = document.getElementById('aiSuggestionsBox');
        
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Connecting to AI Engine...';
        btn.disabled = true;
        
        setTimeout(() => {
            btn.innerHTML = '<i class="fa-solid fa-brain"></i> Suggest AI Headlines';
            btn.disabled = false;
            box.classList.remove('d-none');
            
            // Auto fill meta description suggestion as well!
            const metaDescInput = document.getElementById('metaDescriptionInput');
            if (metaDescInput) {
                metaDescInput.value = "Explore the key highlights of the new digital reforms roadmap, standard deductions, and capital investments proposed by the Finance Ministry.";
                // Trigger input event to update counter
                metaDescInput.dispatchEvent(new Event('input'));
            }
            
            // Increment SEO score simulation
            const scoreLabel = document.getElementById('seoScoreLabel');
            scoreLabel.innerText = "SEO: 95/100";
            scoreLabel.className = "badge bg-success text-white border border-success py-1 animate-pulse";
        }, 1200);
    }

    function applyHeadline(text) {
        document.getElementById('gutenbergTitle').value = text;
        
        // Auto convert to slug path
        const slug = text.toLowerCase()
            .replace(/[^\w\s-]/g, '')
            .replace(/[\s_]+/g, '-')
            .replace(/^-+|-+$/g, '');
        document.getElementById('articleSlug').value = slug;
    }

    // Dynamic Category Subcategory mapping dictionary
    const subcategoryMap = {
        'india': ['National', 'State News', 'Politics', 'Development'],
        'politics': ['Elections', 'Policy', 'Parliament', 'Debate'],
        'technology': ['AI', 'Gadgets', 'Software', 'Cybersecurity'],
        'business': ['Markets', 'Economy', 'Startups', 'Personal Finance'],
        'entertainment': ['Bollywood', 'Hollywood', 'Web Series', 'Reviews']
    };

    const categorySelect = document.getElementById('categorySelect');
    const subcategorySelect = document.getElementById('subcategorySelect');

    function populateSubcategories(categoryKey) {
        subcategorySelect.innerHTML = '';
        const subs = subcategoryMap[categoryKey] || [];
        subs.forEach(sub => {
            const opt = document.createElement('option');
            opt.value = sub.toLowerCase().replace(/\s+/g, '-');
            opt.textContent = sub;
            subcategorySelect.appendChild(opt);
        });
    }

    // Initialize subcategories on load
    if (categorySelect && subcategorySelect) {
        populateSubcategories(categorySelect.value);
        
        categorySelect.addEventListener('change', function() {
            populateSubcategories(this.value);
            showNotification(`Loaded subcategories for: ${this.options[this.selectedIndex].text}`);
        });
    }

    // Live Meta Description character counter
    const metaDesc = document.getElementById('metaDescriptionInput');
    const metaCounter = document.getElementById('metaCharCounter');
    if (metaDesc && metaCounter) {
        metaDesc.addEventListener('input', function() {
            const count = this.value.length;
            metaCounter.innerText = `${count} / 160 characters`;
            if (count > 160) {
                metaCounter.className = "text-danger d-block mt-1";
            } else {
                metaCounter.className = "text-muted d-block mt-1";
            }
        });
    }
</script>
@endsection
