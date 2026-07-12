@extends('layouts.admin')

@section('title', 'Support & Logs - Rivaaz Admin')

@section('admin-content')
<div class="fade-in-up">
    
    <!-- Title Area -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="m-0 fw-bold">Support, Logs & Backups</h3>
            <p class="text-muted small m-0">Monitor open support tickets, view system activity trails, and generate database backups.</p>
        </div>
        <button class="btn btn-sm btn-outline-danger" onclick="alert('Clearing error logs...');">
            <i class="fa-solid fa-trash-can"></i> Clear Error Logs
        </button>
    </div>

    <div class="row g-4">
        
        <!-- Support Tickets List (Left - 7 Grid Units) -->
        <div class="col-lg-7">
            <div class="card border border-secondary-subtle shadow-sm rounded-3 p-4 mb-4">
                <h5 class="fw-bold mb-3 border-bottom pb-2">Active Support Tickets</h5>
                
                <div class="table-responsive">
                    <table class="table align-middle table-hover small">
                        <thead>
                            <tr class="text-muted">
                                <th>Ticket ID</th>
                                <th>Subject Query</th>
                                <th>Priority</th>
                                <th>Tenant</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-bold text-primary">#TC-889</td>
                                <td>SQLite DB Connection Timeout on Live Staging</td>
                                <td><span class="badge bg-danger text-white fs-9">High</span></td>
                                <td>Sarkar News</td>
                                <td>
                                    <button class="btn btn-xs btn-outline-secondary border-secondary-subtle p-1" onclick="alert('Replying to support ticket...');"><i class="fa-solid fa-reply"></i> Reply</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-primary">#TC-872</td>
                                <td>Bulk Image upload compression threshold exceeded</td>
                                <td><span class="badge bg-warning text-dark fs-9">Medium</span></td>
                                <td>Metro Times</td>
                                <td>
                                    <button class="btn btn-xs btn-outline-secondary border-secondary-subtle p-1" onclick="alert('Replying to support ticket...');"><i class="fa-solid fa-reply"></i> Reply</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

            <!-- Activity Logs list -->
            <div class="card border border-secondary-subtle shadow-sm rounded-3 p-4">
                <h5 class="fw-bold mb-3 border-bottom pb-2">System Activity Trails</h5>
                <div class="list-group list-group-flush small">
                    <div class="list-group-item bg-transparent px-0 border-0 d-flex justify-content-between">
                        <span><i class="fa-solid fa-user-check text-primary me-2"></i> Editor <strong>Ananya S.</strong> published post <em>/news/union-budget-reforms</em></span>
                        <small class="text-muted">3m ago</small>
                    </div>
                    <div class="list-group-item bg-transparent px-0 border-0 d-flex justify-content-between">
                        <span><i class="fa-solid fa-rectangle-ad text-success me-2"></i> User <strong>Rajesh S.</strong> modified sidebar banner code</span>
                        <small class="text-muted">22m ago</small>
                    </div>
                    <div class="list-group-item bg-transparent px-0 border-0 d-flex justify-content-between">
                        <span><i class="fa-solid fa-arrows-rotate text-warning me-2"></i> System database backup successfully compiled</span>
                        <small class="text-muted">1h ago</small>
                    </div>
                </div>
            </div>

        </div>

        <!-- Backups and API key (Right - 5 Grid Units) -->
        <div class="col-lg-5">
            
            <!-- Database Backup widget -->
            <div class="card border border-secondary-subtle shadow-sm rounded-3 p-4 mb-4">
                <h5 class="fw-bold mb-3 border-bottom pb-2">Backup Scheduler</h5>
                <p class="text-muted small">Download compressed snapshot of templates, views, settings, and news indices.</p>
                
                <div class="bg-body-tertiary p-3 rounded-3 border border-secondary-subtle mb-3 text-center" id="backupProgessBox">
                    <i class="fa-solid fa-database fs-1 text-primary mb-2"></i>
                    <strong class="d-block small text-dark" id="backupStatusText">Database Storage Node</strong>
                    <span class="text-muted d-block small mb-2">Last backup: 4h ago</span>
                    
                    <div class="progress d-none mb-3" style="height: 10px;" id="backupProgressBar">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;" id="backupFill"></div>
                    </div>

                    <button class="btn btn-primary btn-sm w-100 fw-bold" onclick="runBackupSimulation()">Generate Backup Now</button>
                </div>
            </div>

            <!-- API Keys management -->
            <div class="card border border-secondary-subtle shadow-sm rounded-3 p-4">
                <h5 class="fw-bold mb-3 border-bottom pb-2">SaaS API Integration Keys</h5>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Active API Secret Token</label>
                    <div class="input-group">
                        <input type="password" class="form-control form-control-sm" id="apiToken" value="riv_live_9923a1d99d98fa01a0dbcf8">
                        <button class="btn btn-sm btn-outline-secondary" onclick="toggleApiMask()"><i class="fa-solid fa-eye" id="apiEyeIcon"></i></button>
                    </div>
                </div>
                <button class="btn btn-outline-primary btn-sm w-100 fw-bold" onclick="alert('Regenerating new secret API key...');">Regenerate Token</button>
            </div>

        </div>

    </div>

</div>

<!-- Backup simulation scripts -->
<script>
    function runBackupSimulation() {
        const fill = document.getElementById('backupFill');
        const bar = document.getElementById('backupProgressBar');
        const status = document.getElementById('backupStatusText');
        
        bar.classList.remove('d-none');
        status.innerText = "Processing Backup...";
        
        let val = 0;
        const interval = setInterval(() => {
            if (val >= 100) {
                clearInterval(interval);
                status.innerText = "Backup complete! File saved: rivaaz_backup_sql.zip";
                bar.classList.add('d-none');
                showNotification('Backup archive successfully generated and saved.');
            } else {
                val += 10;
                fill.style.width = `${val}%`;
            }
        }, 150);
    }

    function toggleApiMask() {
        const input = document.getElementById('apiToken');
        const icon = document.getElementById('apiEyeIcon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'fa-solid fa-eye-slash';
        } else {
            input.type = 'password';
            icon.className = 'fa-solid fa-eye';
        }
    }
</script>
@endsection
