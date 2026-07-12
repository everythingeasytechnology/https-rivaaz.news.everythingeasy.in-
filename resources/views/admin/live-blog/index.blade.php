@extends('layouts.admin')

@section('title', 'Live Blog & Breaking - Rivaaz Admin')

@section('admin-content')
<div class="fade-in-up">
    
    <!-- Header -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="m-0 fw-bold">Live Blog & Breaking Updates</h3>
            <p class="text-muted small m-0">Post real-time event logs, activate breaking tickers, and broadcast live alerts.</p>
        </div>
        <div class="d-flex gap-2">
            <span class="badge bg-danger d-flex align-items-center px-3 rounded-pill animate-pulse"><i class="fa-solid fa-signal me-1"></i> Live Broadcast active</span>
        </div>
    </div>

    <div class="row g-4">
        
        <!-- Live Blog Stream updates (Left - 7 Grid Units) -->
        <div class="col-lg-7">
            <div class="card border border-secondary-subtle shadow-sm rounded-3 p-4">
                <h5 class="fw-bold mb-3 border-bottom pb-2">Active Events Stream</h5>
                
                <!-- Timeline container -->
                <div class="d-flex flex-column gap-3" id="adminLiveBlogTimeline">
                    
                    <!-- Event 1 -->
                    <div class="border rounded p-3 bg-body-tertiary position-relative">
                        <div class="d-flex align-items-center justify-content-between mb-2 small text-muted">
                            <span><i class="fa-regular fa-clock me-1"></i> 14:45 PM • Just Now</span>
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle">#Markets</span>
                        </div>
                        <h6 class="fw-bold">Automotive Index Reaches Session Peaks</h6>
                        <p class="text-muted small mb-0">Auto manufacturers are trading up to 7.8% higher after details show massive budget provisions for battery charging ports grid expansions.</p>
                        <button class="btn btn-xs btn-danger position-absolute top-0 end-0 m-2" onclick="this.parentElement.remove(); showNotification('Timeline event removed');" title="Delete event"><i class="fa-solid fa-xmark"></i></button>
                    </div>

                    <!-- Event 2 -->
                    <div class="border rounded p-3 bg-body-tertiary position-relative">
                        <div class="d-flex align-items-center justify-content-between mb-2 small text-muted">
                            <span><i class="fa-regular fa-clock me-1"></i> 13:20 PM</span>
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle">#Budget</span>
                        </div>
                        <h6 class="fw-bold">Tax Slab Structural Adjustments Applauded</h6>
                        <p class="text-muted small mb-0">Leading corporate audit groups indicate that standard deduction expansions will significantly trigger middle class consumer liquid investments.</p>
                        <button class="btn btn-xs btn-danger position-absolute top-0 end-0 m-2" onclick="this.parentElement.remove(); showNotification('Timeline event removed');" title="Delete event"><i class="fa-solid fa-xmark"></i></button>
                    </div>

                </div>

            </div>
        </div>

        <!-- Event publishers & Breaking switch (Right - 5 Grid Units) -->
        <div class="col-lg-5">
            
            <!-- Live Update Publisher -->
            <div class="card border border-secondary-subtle shadow-sm rounded-3 p-4 mb-4">
                <h5 class="fw-bold mb-3 border-bottom pb-2">Publish Live Timeline Item</h5>
                
                <form id="liveEventForm" onsubmit="publishLiveEventEntry(event)">
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Update Title</label>
                        <input type="text" class="form-control" id="eventTitle" placeholder="e.g. Rupee gains against Dollar" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Taxonomy Tag</label>
                        <input type="text" class="form-control form-control-sm" id="eventTag" placeholder="e.g. Economy" value="Politics" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Body Summary</label>
                        <textarea class="form-control" rows="3" id="eventContent" placeholder="Describe the live event update details..." required></textarea>
                    </div>

                    <button type="submit" class="btn btn-danger btn-sm rounded-pill px-4 fw-bold">Publish Timeline Update</button>

                </form>
            </div>

            <!-- Breaking news alerts control -->
            <div class="card border border-danger-subtle bg-danger bg-opacity-5 shadow-sm rounded-3 p-4">
                <h5 class="fw-bold mb-3 text-danger border-bottom pb-2">Breaking News Banner Ticker</h5>
                
                <form onsubmit="event.preventDefault(); showNotification('Breaking news ticker text updated.');">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Flash Headline Text</label>
                        <textarea class="form-control" rows="2" placeholder="e.g. PM Modi outlines digital reform roadmap for 2026. Live updates next.">PM Modi outlines digital reform roadmap for 2026. Live updates next.</textarea>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-3 small">
                        <span>Status banner: <strong class="text-success">Active</strong></span>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" checked onchange="showNotification('Breaking banner visibility toggled')">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-dark btn-sm rounded-pill px-4 fw-bold">Save Banner Text</button>
                </form>
            </div>

        </div>

    </div>

</div>

<!-- Timeline injection script -->
<script>
    function publishLiveEventEntry(e) {
        e.preventDefault();
        
        const title = document.getElementById('eventTitle').value.trim();
        const tag = document.getElementById('eventTag').value.trim();
        const content = document.getElementById('eventContent').value.trim();
        const timeline = document.getElementById('adminLiveBlogTimeline');
        
        if(!title || !content) return;
        
        const now = new Date();
        const timeStr = now.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        
        const cardHtml = `
            <div class="border rounded p-3 bg-body-tertiary position-relative border-primary fade-in-up">
                <div class="d-flex align-items-center justify-content-between mb-2 small text-muted">
                    <span><i class="fa-regular fa-clock me-1"></i> ${timeStr} PM • Just Now</span>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle">#${tag}</span>
                </div>
                <h6 class="fw-bold">${title}</h6>
                <p class="text-muted small mb-0">${content}</p>
                <button class="btn btn-xs btn-danger position-absolute top-0 end-0 m-2" onclick="this.parentElement.remove(); showNotification('Timeline event removed');" title="Delete event"><i class="fa-solid fa-xmark"></i></button>
            </div>
        `;
        
        timeline.insertAdjacentHTML('afterbegin', cardHtml);
        
        // Reset form inputs
        document.getElementById('eventTitle').value = '';
        document.getElementById('eventContent').value = '';
        
        showNotification('Live Blog timeline updated successfully.');
    }
</script>
@endsection
