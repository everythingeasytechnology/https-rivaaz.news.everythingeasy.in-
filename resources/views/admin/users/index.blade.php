@extends('layouts.admin')

@section('title', 'Users & Roles - Rivaaz Admin')

@section('admin-content')
<div class="fade-in-up">
    
    <!-- Title Section -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="m-0 fw-bold">Users & Roles Manager</h3>
            <p class="text-muted small m-0">Setup tenant scopes, authorize journalists, and manage permission nodes for editors.</p>
        </div>
        <button class="btn btn-sm btn-primary d-flex align-items-center gap-2" onclick="alert('Open invitation builder for new users...');">
            <i class="fa-solid fa-user-plus"></i> Invite User
        </button>
    </div>

    <div class="row g-4">
        
        <!-- User listings table (Left - 8 Grid Units) -->
        <div class="col-lg-8">
            <div class="card border border-secondary-subtle shadow-sm rounded-3 p-4">
                
                <!-- Filter bar controls -->
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="fw-bold m-0">Active Team members</h5>
                    
                    <div class="d-flex gap-2">
                        <select class="form-select form-select-sm border-secondary-subtle" id="roleFilter" onchange="filterUserRowsByRole(this.value)">
                            <option value="all" selected>All Roles</option>
                            <option value="Super Admin">Super Admin</option>
                            <option value="Chief Editor">Chief Editor</option>
                            <option value="Reporter">Reporter</option>
                            <option value="SEO Manager">SEO Manager</option>
                        </select>
                    </div>
                </div>

                <!-- Table data -->
                <div class="table-responsive">
                    <table class="table align-middle table-hover small">
                        <thead>
                            <tr class="text-muted">
                                <th>Name & Profile</th>
                                <th>Email Address</th>
                                <th>Role</th>
                                <th>Active Tenant</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="userRows">
                            <tr data-role="Chief Editor">
                                <td class="fw-bold d-flex align-items-center gap-2">
                                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=80&q=80" alt="Avatar" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                                    <span>Ananya Sen</span>
                                </td>
                                <td>ananya@rivaaz.news</td>
                                <td><span class="badge bg-danger-subtle text-danger border border-danger-subtle py-1 fs-9">Chief Editor</span></td>
                                <td>Rivaaz Chronicle</td>
                                <td>
                                    <button class="btn btn-xs btn-outline-secondary border-secondary-subtle p-1" onclick="alert('Editing user permissions...');"><i class="fa-solid fa-pen-to-square"></i></button>
                                </td>
                            </tr>
                            <tr data-role="Reporter">
                                <td class="fw-bold d-flex align-items-center gap-2">
                                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=80&q=80" alt="Avatar" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                                    <span>Rajesh Sharma</span>
                                </td>
                                <td>rajesh@sarkarnews.in</td>
                                <td><span class="badge bg-warning-subtle text-warning border border-warning-subtle py-1 fs-9">Reporter</span></td>
                                <td>Sarkar News</td>
                                <td>
                                    <button class="btn btn-xs btn-outline-secondary border-secondary-subtle p-1" onclick="alert('Editing user permissions...');"><i class="fa-solid fa-pen-to-square"></i></button>
                                </td>
                            </tr>
                            <tr data-role="SEO Manager">
                                <td class="fw-bold d-flex align-items-center gap-2">
                                    <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=80&q=80" alt="Avatar" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                                    <span>Vikram Malhotra</span>
                                </td>
                                <td>vikram@metrotimes.co.in</td>
                                <td><span class="badge bg-primary-subtle text-primary border border-primary-subtle py-1 fs-9">SEO Manager</span></td>
                                <td>Metro Times</td>
                                <td>
                                    <button class="btn btn-xs btn-outline-secondary border-secondary-subtle p-1" onclick="alert('Editing user permissions...');"><i class="fa-solid fa-pen-to-square"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        <!-- Role permissions details viewer (Right - 4 Grid Units) -->
        <div class="col-lg-4">
            <div class="card border border-secondary-subtle shadow-sm rounded-3 p-4">
                <h5 class="fw-bold mb-3 border-bottom pb-2">Simulate Role node permissions</h5>
                
                <div class="mb-3">
                    <label class="form-label small fw-bold">Select target Role</label>
                    <select class="form-select" onchange="adjustPermissionCheckboxes(this.value)">
                        <option value="super_admin" selected>Super Admin (Full SaaS Owner)</option>
                        <option value="chief_editor">Chief Editor (Content Director)</option>
                        <option value="reporter">Reporter (Author / Writer)</option>
                    </select>
                </div>

                <!-- Checkbox list -->
                <div class="d-flex flex-column gap-2 small border rounded p-3 bg-body-tertiary">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="perm1" checked disabled>
                        <label class="form-check-label fw-semibold" for="perm1">Manage SaaS Tenants</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="perm2" checked disabled>
                        <label class="form-check-label fw-semibold" for="perm2">Publish Articles</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="perm3" checked disabled>
                        <label class="form-check-label fw-semibold" for="perm3">Edit Ad Placements</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="perm4" checked disabled>
                        <label class="form-check-label fw-semibold" for="perm4">Manage Web Stories</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="perm5" checked disabled>
                        <label class="form-check-label fw-semibold" for="perm5">Database Backups</label>
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>

<!-- Roles filtering script -->
<script>
    function filterUserRowsByRole(role) {
        const rows = document.querySelectorAll('#userRows tr');
        rows.forEach(row => {
            if (role === 'all') {
                row.classList.remove('d-none');
            } else if (row.getAttribute('data-role') === role) {
                row.classList.remove('d-none');
            } else {
                row.classList.add('d-none');
            }
        });
    }

    function adjustPermissionCheckboxes(role) {
        const p1 = document.getElementById('perm1');
        const p2 = document.getElementById('perm2');
        const p3 = document.getElementById('perm3');
        const p4 = document.getElementById('perm4');
        const p5 = document.getElementById('perm5');

        if (role === 'super_admin') {
            p1.checked = true; p2.checked = true; p3.checked = true; p4.checked = true; p5.checked = true;
        } else if (role === 'chief_editor') {
            p1.checked = false; p2.checked = true; p3.checked = false; p4.checked = true; p5.checked = false;
        } else if (role === 'reporter') {
            p1.checked = false; p2.checked = false; p3.checked = false; p4.checked = false; p5.checked = false;
        }
        
        showNotification(`Simulated permissions preview updated for: ${role}`);
    }
</script>
@endsection
