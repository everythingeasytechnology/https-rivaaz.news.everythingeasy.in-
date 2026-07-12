@extends('layouts.admin')

@section('title', 'Comments & Notifications - Rivaaz Admin')

@section('admin-content')
<div class="fade-in-up">
    
    <!-- Header -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="m-0 fw-bold">Comments & Push Dispatcher</h3>
            <p class="text-muted small m-0">Approve user comments, configure spam blacklist words, and send browser notifications.</p>
        </div>
        <button class="btn btn-sm btn-outline-secondary border-secondary-subtle" onclick="alert('Comment cache cleared.');">
            <i class="fa-solid fa-broom"></i> Clear Cache
        </button>
    </div>

    <div class="row g-4">
        
        <!-- Comments list (Left - 7 Grid Units) -->
        <div class="col-lg-7">
            <div class="card border border-secondary-subtle shadow-sm rounded-3 p-4">
                <h5 class="fw-bold mb-3 border-bottom pb-2">Pending Moderation</h5>
                
                <div class="d-flex flex-column gap-3" id="pendingCommentsList">
                    
                    <!-- Comment 1 -->
                    <div class="p-3 border rounded bg-body-tertiary">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h6 class="fw-bold mb-0 small">Sanjay K.</h6>
                                <small class="text-muted fs-8">Article: /news/union-budget-reforms • 5m ago</small>
                            </div>
                            <span class="badge bg-warning text-dark fs-9">Pending Review</span>
                        </div>
                        <p class="small text-secondary-emphasis mb-2">"Standard deduction increase is a very positive reform, but I hope state taxes do not cancel out these relief measures."</p>
                        <div class="d-flex gap-2">
                            <button class="btn btn-xs btn-success fw-bold text-white px-3" onclick="approveComment(this)"><i class="fa-solid fa-check"></i> Approve</button>
                            <button class="btn btn-xs btn-outline-danger border-secondary-subtle px-3" onclick="this.closest('.border').remove(); showNotification('Comment flagged as Spam');"><i class="fa-solid fa-ban"></i> Spam</button>
                        </div>
                    </div>

                    <!-- Comment 2 -->
                    <div class="p-3 border rounded bg-body-tertiary">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h6 class="fw-bold mb-0 small">Meera Patel</h6>
                                <small class="text-muted fs-8">Article: /news/tech-quantum-computing • 15m ago</small>
                            </div>
                            <span class="badge bg-warning text-dark fs-9">Pending Review</span>
                        </div>
                        <p class="small text-secondary-emphasis mb-2">"Are there any open source projects participating in the national computing grid?"</p>
                        <div class="d-flex gap-2">
                            <button class="btn btn-xs btn-success fw-bold text-white px-3" onclick="approveComment(this)"><i class="fa-solid fa-check"></i> Approve</button>
                            <button class="btn btn-xs btn-outline-danger border-secondary-subtle px-3" onclick="this.closest('.border').remove(); showNotification('Comment flagged as Spam');"><i class="fa-solid fa-ban"></i> Spam</button>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <!-- Push notification dispatcher (Right - 5 Grid Units) -->
        <div class="col-lg-5">
            <div class="card border border-secondary-subtle shadow-sm rounded-3 p-4">
                <h5 class="fw-bold mb-3 border-bottom pb-2"><i class="fa-solid fa-paper-plane text-primary me-2"></i>Web Push Notification</h5>
                <p class="text-muted small">Dispatch push alerts instantly to subscribed browsers.</p>
                
                <form onsubmit="dispatchWebPush(event)">
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Push Title</label>
                        <input type="text" class="form-control" id="pushTitle" placeholder="e.g. Breaking News Alert" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Push Alert Text</label>
                        <textarea class="form-control" rows="3" id="pushMessage" placeholder="Type notification alert message detail..." required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Target Link (Click Action)</label>
                        <input type="text" class="form-control form-control-sm" value="https://rivaaz.news.everythingeasy.in">
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm rounded-pill w-100 fw-bold">Dispatch Broadcast</button>

                </form>

            </div>
        </div>

    </div>

</div>

<!-- Interactive simulation actions for Comments & Push Notifications -->
<script>
    function approveComment(btn) {
        const commentBox = btn.closest('.border');
        commentBox.remove();
        showNotification('Comment approved and live on portal.');
    }

    function dispatchWebPush(e) {
        e.preventDefault();
        
        const title = document.getElementById('pushTitle').value;
        const msg = document.getElementById('pushMessage').value;
        
        showNotification(`Push Alert Dispatched: "${title}" sent to 14,240 subscribers.`);
        
        // Reset form
        document.getElementById('pushTitle').value = '';
        document.getElementById('pushMessage').value = '';
    }
</script>
@endsection
