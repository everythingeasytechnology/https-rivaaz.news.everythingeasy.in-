import * as bootstrap from 'bootstrap';

// Attach bootstrap globally so plugins and templates can access modals/dropdowns if needed
window.bootstrap = bootstrap;

document.addEventListener('DOMContentLoaded', () => {
    initThemeToggle();
    initDateAndTime();
    initFontSizeControls();
    initReadingProgress();
    initWebStoriesViewer();
    initSkeletonLoading();
    initLiveBlogSimulation();
});

/**
 * 1. Persistent Light/Dark Mode Toggle
 */
function initThemeToggle() {
    const toggleButtons = document.querySelectorAll('.theme-toggle-btn');
    
    // Update button icons based on current theme
    const updateIcons = (theme) => {
        toggleButtons.forEach(btn => {
            const icon = btn.querySelector('i');
            if (icon) {
                if (theme === 'dark') {
                    icon.className = 'fas fa-sun fs-5 text-warning';
                } else {
                    icon.className = 'fas fa-moon fs-5 text-secondary';
                }
            }
        });
    };
    
    // Read theme initially
    const currentTheme = document.documentElement.getAttribute('data-bs-theme') || 'light';
    updateIcons(currentTheme);

    toggleButtons.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const activeTheme = document.documentElement.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-bs-theme', activeTheme);
            localStorage.setItem('theme', activeTheme);
            updateIcons(activeTheme);
        });
    });
}

/**
 * 2. Format Dates in Header
 */
function initDateAndTime() {
    const dateEl = document.getElementById('currentDate');
    if (dateEl) {
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        dateEl.textContent = new Date().toLocaleDateString('en-US', options);
    }
}

/**
 * 3. Single Article Font Size Adjustment
 */
function initFontSizeControls() {
    const btnDecrease = document.getElementById('btnFontSizeDec');
    const btnIncrease = document.getElementById('btnFontSizeInc');
    const articleContainer = document.getElementById('articleBodyContainer');
    
    if (!articleContainer || !btnDecrease || !btnIncrease) return;

    const sizes = ['font-size-sm', 'font-size-md', 'font-size-lg', 'font-size-xl'];
    let currentIdx = 1; // Default is 'font-size-md'

    const applySize = () => {
        sizes.forEach(cls => articleContainer.classList.remove(cls));
        articleContainer.classList.add(sizes[currentIdx]);
    };

    btnDecrease.addEventListener('click', (e) => {
        e.preventDefault();
        if (currentIdx > 0) {
            currentIdx--;
            applySize();
        }
    });

    btnIncrease.addEventListener('click', (e) => {
        e.preventDefault();
        if (currentIdx < sizes.length - 1) {
            currentIdx++;
            applySize();
        }
    });
}

/**
 * 4. Reading Progress Bar for News Reading Page
 */
function initReadingProgress() {
    const progressContainer = document.getElementById('readingProgress');
    const progressBar = document.getElementById('readingProgressBar');
    const article = document.getElementById('articleBodyContainer');

    if (!progressContainer || !progressBar || !article) return;

    progressContainer.classList.remove('d-none');

    window.addEventListener('scroll', () => {
        const rect = article.getBoundingClientRect();
        const articleHeight = rect.height;
        // Calculate progress percentage relative to article bounding box
        const scrolled = window.scrollY - (rect.top + window.scrollY - 100);
        let pct = (scrolled / (articleHeight - window.innerHeight + 100)) * 100;
        
        pct = Math.max(0, Math.min(100, pct));
        progressBar.style.width = `${pct}%`;
    });
}

/**
 * 5. Web Stories Carousel and Modals
 */
function initWebStoriesViewer() {
    const storyCards = document.querySelectorAll('.story-card');
    if (storyCards.length === 0) return;

    // Create story viewer modal element dynamically
    const modalHtml = `
        <div class="modal fade story-viewer-modal" id="storyViewerModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-header border-0 pb-0 justify-content-end">
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4 pt-1 text-center">
                        <div class="story-progress-bar">
                            <div class="story-progress-segment"><div class="story-progress-fill" id="storyFill1"></div></div>
                            <div class="story-progress-segment"><div class="story-progress-fill" id="storyFill2"></div></div>
                            <div class="story-progress-segment"><div class="story-progress-fill" id="storyFill3"></div></div>
                        </div>
                        <div class="story-view-screen position-relative rounded-4 overflow-hidden border border-secondary" style="height: 420px; background-color:#161925;">
                            <img id="storyViewerImg" src="" alt="Story Screen" class="w-100 h-100 object-fit-cover">
                            <div class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-75 p-3 text-white">
                                <h6 class="fw-bold mb-1" id="storyViewerTitle">Story Title</h6>
                                <p class="small mb-0 text-white-50" id="storyViewerCaption">Press left/right to browse slides.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;

    document.body.insertAdjacentHTML('beforeend', modalHtml);
    const modalEl = document.getElementById('storyViewerModal');
    const modalObj = new bootstrap.Modal(modalEl);
    
    const storyImg = document.getElementById('storyViewerImg');
    const storyTitle = document.getElementById('storyViewerTitle');
    const storyCaption = document.getElementById('storyViewerCaption');
    
    let timer = null;
    let slideIndex = 0;
    const slidesData = [
        { title: "Union Budget Details", caption: "Finance Minister outlines green cap-ex expansions.", img: "/assets/images/hero.png" },
        { title: "Personal Income Tax", caption: "Salaried class sees standard deduction increase.", img: "https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?auto=format&fit=crop&w=600&q=80" },
        { title: "National AI Mission", caption: "₹50,000 crores approved for indigenous computing.", img: "https://images.unsplash.com/photo-1620712943543-bcc4688e7485?auto=format&fit=crop&w=600&q=80" }
    ];

    const runSlides = () => {
        if (slideIndex >= slidesData.length) {
            modalObj.hide();
            return;
        }

        // Reset progress fills
        for (let i = 0; i < slidesData.length; i++) {
            const fill = document.getElementById(`storyFill${i+1}`);
            if (i < slideIndex) fill.style.width = '100%';
            else if (i > slideIndex) fill.style.width = '0%';
        }

        // Set slide info
        storyImg.src = slidesData[slideIndex].img;
        storyTitle.textContent = slidesData[slideIndex].title;
        storyCaption.textContent = slidesData[slideIndex].caption;

        // Animate active slide progress bar
        const activeFill = document.getElementById(`storyFill${slideIndex+1}`);
        let width = 0;
        clearInterval(timer);
        timer = setInterval(() => {
            if (width >= 100) {
                clearInterval(timer);
                slideIndex++;
                runSlides();
            } else {
                width += 2;
                activeFill.style.width = `${width}%`;
            }
        }, 80);
    };

    storyCards.forEach(card => {
        card.addEventListener('click', (e) => {
            e.preventDefault();
            slideIndex = 0;
            modalObj.show();
            runSlides();
        });
    });

    modalEl.addEventListener('hidden.bs.modal', () => {
        clearInterval(timer);
    });
}

/**
 * 6. Skeleton Screen simulation for "Load More"
 */
function initSkeletonLoading() {
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    const container = document.getElementById('loadMoreContainer');
    
    if (!loadMoreBtn || !container) return;

    loadMoreBtn.addEventListener('click', (e) => {
        e.preventDefault();
        loadMoreBtn.disabled = true;
        loadMoreBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Loading...';

        // 1. Create skeleton cards
        const skeletonHtml = `
            <div class="col-md-6 col-lg-3 temp-skeleton">
                <div class="card border-0 h-100">
                    <div class="skeleton skeleton-img rounded-3 mb-2" style="height:160px; width:100%;"></div>
                    <div class="skeleton skeleton-title"></div>
                    <div class="skeleton skeleton-text"></div>
                    <div class="skeleton skeleton-text" style="width: 50%;"></div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 temp-skeleton">
                <div class="card border-0 h-100">
                    <div class="skeleton skeleton-img rounded-3 mb-2" style="height:160px; width:100%;"></div>
                    <div class="skeleton skeleton-title"></div>
                    <div class="skeleton skeleton-text"></div>
                    <div class="skeleton skeleton-text" style="width: 50%;"></div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', skeletonHtml);

        // 2. Simulate delay then append final items
        setTimeout(() => {
            // Remove skeletons
            document.querySelectorAll('.temp-skeleton').forEach(el => el.remove());

            // Append real cards
            const realCardsHtml = `
                <div class="col-md-6 col-lg-3 fade-in-up">
                    <div class="news-card">
                        <div class="card-img-container">
                            <img src="https://images.unsplash.com/photo-1526304640581-d334cdbbf45e?auto=format&fit=crop&w=400&q=80" alt="Finance">
                        </div>
                        <div class="card-body">
                            <span class="badge-category mb-2">business</span>
                            <h5 class="card-title"><a href="/news/market-rally-nifty-hits-record-high">Digital Currencies Gain Global Ground as Regulatory Laws Standardize</a></h5>
                            <div class="card-meta">
                                <span>Vikram M.</span>
                                <span>•</span>
                                <span>3 min read</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 fade-in-up">
                    <div class="news-card">
                        <div class="card-img-container">
                            <img src="https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=400&q=80" alt="Chips">
                        </div>
                        <div class="card-body">
                            <span class="badge-category mb-2">technology</span>
                            <h5 class="card-title"><a href="/news/tech-quantum-computing-breakthrough">Silicon Foundries Commit Bilateral Manufacturing expansion</a></h5>
                            <div class="card-meta">
                                <span>Ananya S.</span>
                                <span>•</span>
                                <span>4 min read</span>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', realCardsHtml);
            
            // Restore button
            loadMoreBtn.disabled = false;
            loadMoreBtn.innerHTML = 'Load More <i class="fas fa-arrow-down ms-1"></i>';
        }, 1200);
    });
}

/**
 * 7. Live Blog simulation (adds new live timelines dynamically)
 */
function initLiveBlogSimulation() {
    const timeline = document.getElementById('liveBlogTimeline');
    const autoScrollCheck = document.getElementById('autoScrollToggle');
    const liveIndicator = document.getElementById('liveStatusIndicator');

    if (!timeline) return;

    // Simulate real-time pulses on indicator
    setInterval(() => {
        if (liveIndicator) {
            liveIndicator.classList.toggle('bg-danger');
            liveIndicator.classList.toggle('bg-secondary');
        }
    }, 1000);

    const simulationData = [
        { time: "14:45 PM", title: "Automotive Index Reaches Session Peaks", content: "Auto manufacturers are trading up to 7.8% higher after details show massive budget provisions for battery charging ports grid expansions.", tag: "Markets" },
        { time: "15:05 PM", title: "President Commends Budget Targets on Social Channels", content: "The presidential account published a thread supporting capital allocation frameworks, emphasizing long-term debt controls.", tag: "Politics" }
    ];

    let dataIndex = 0;

    // Append new updates every 15 seconds
    const interval = setInterval(() => {
        if (dataIndex >= simulationData.length) {
            clearInterval(interval);
            return;
        }

        const data = simulationData[dataIndex];
        
        // Construct event card
        const cardHtml = `
            <div class="live-item live-active fade-in-up">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="badge bg-secondary-subtle text-secondary fw-bold">${data.time}</span>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle">#${data.tag}</span>
                </div>
                <h5 class="fw-bold mb-2">${data.title}</h5>
                <p class="text-muted">${data.content}</p>
                <div class="d-flex gap-3 mt-2">
                    <button class="btn btn-sm btn-link text-decoration-none p-0 text-muted fs-8"><i class="far fa-share-square me-1"></i> Share</button>
                    <button class="btn btn-sm btn-link text-decoration-none p-0 text-muted fs-8"><i class="far fa-comment me-1"></i> Comment</button>
                </div>
            </div>
        `;

        // De-active existing items
        timeline.querySelectorAll('.live-item').forEach(el => el.classList.remove('live-active'));

        // Prepend new item
        timeline.insertAdjacentHTML('afterbegin', cardHtml);

        // Smooth scroll if enabled
        if (autoScrollCheck && autoScrollCheck.checked) {
            timeline.firstElementChild.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }

        dataIndex++;
    }, 15000);
}
