@extends('layouts.admin')

@section('title', 'Articles List - Rivaaz Admin')

@section('admin-content')
<div class="fade-in-up">
    
    <!-- Title Area -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="m-0 fw-bold">News Articles Index</h3>
            <p class="text-muted small m-0">Browse, search, edit, and manage publication states of all news portal posts.</p>
        </div>
        <a href="/admin/news/create" class="btn btn-sm btn-primary d-flex align-items-center gap-2">
            <i class="fa-solid fa-plus"></i> Write New Article
        </a>
    </div>

    <!-- Articles Table Card -->
    <div class="card border border-secondary-subtle shadow-sm rounded-3 p-4">
        
        <!-- Filters panel -->
        <div class="row g-2 mb-4 align-items-center">
            <div class="col-md-5">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light"><i class="fa-solid fa-magnifying-glass"></i></span>
                    <input type="text" class="form-control" id="articleSearchInput" onkeyup="filterArticlesList()" placeholder="Search headlines...">
                </div>
            </div>
            <div class="col-md-3">
                <select class="form-select form-select-sm border-secondary-subtle" id="catFilter" onchange="filterArticlesList()">
                    <option value="all" selected>All Categories</option>
                    <option value="india">India</option>
                    <option value="politics">Politics</option>
                    <option value="technology">Technology</option>
                    <option value="business">Business</option>
                    <option value="entertainment">Entertainment</option>
                </select>
            </div>
            <div class="col-md-4 text-md-end">
                <span class="text-muted small" id="recordCounter">Showing 3 active articles</span>
            </div>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table align-middle table-hover small">
                <thead>
                    <tr class="text-muted">
                        <th>Cover</th>
                        <th>Headline Title</th>
                        <th>Category</th>
                        <th>Subcategory</th>
                        <th>Views</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="articlesListBody">
                    
                    <!-- Row 1 -->
                    <tr data-category="india">
                        <td>
                            <img src="https://images.unsplash.com/photo-1541872703-74c5e44368f9?auto=format&fit=crop&w=80&q=80" class="rounded object-fit-cover" style="width: 50px; height: 35px;" alt="Banner">
                        </td>
                        <td class="fw-bold headline-col">
                            <a href="/news/narottam-mishra-meets-mp-bjp-leadership" class="text-reset text-decoration-none hover-primary">Narottam Mishra Meets MP BJP Leadership After Datia Snub</a>
                            <span class="d-block text-muted small fw-normal">By Rajesh Sharma • July 11, 2026</span>
                        </td>
                        <td><span class="badge bg-secondary-subtle text-secondary text-uppercase fs-9">India</span></td>
                        <td>Politics</td>
                        <td>4,850</td>
                        <td><span class="badge bg-success text-white py-1 fs-9">Published</span></td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="/admin/news/create" class="btn btn-xs btn-outline-secondary border-secondary-subtle p-1" title="Edit Article"><i class="fa-solid fa-pen-to-square"></i></a>
                                <button class="btn btn-xs btn-outline-danger border-0 p-1" onclick="deleteArticleRow(this)" title="Delete Article"><i class="fa-solid fa-trash-can"></i></button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 2 -->
                    <tr data-category="technology">
                        <td>
                            <img src="https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=80&q=80" class="rounded object-fit-cover" style="width: 50px; height: 35px;" alt="Banner">
                        </td>
                        <td class="fw-bold headline-col">
                            <a href="/news/tech-quantum-computing-breakthrough" class="text-reset text-decoration-none hover-primary">Silicon Foundries Commit Bilateral Manufacturing expansion</a>
                            <span class="d-block text-muted small fw-normal">By Ananya S. • July 10, 2026</span>
                        </td>
                        <td><span class="badge bg-secondary-subtle text-secondary text-uppercase fs-9">Technology</span></td>
                        <td>Software</td>
                        <td>3,120</td>
                        <td><span class="badge bg-success text-white py-1 fs-9">Published</span></td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="/admin/news/create" class="btn btn-xs btn-outline-secondary border-secondary-subtle p-1" title="Edit Article"><i class="fa-solid fa-pen-to-square"></i></a>
                                <button class="btn btn-xs btn-outline-danger border-0 p-1" onclick="deleteArticleRow(this)" title="Delete Article"><i class="fa-solid fa-trash-can"></i></button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 3 -->
                    <tr data-category="business">
                        <td>
                            <img src="https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?auto=format&fit=crop&w=80&q=80" class="rounded object-fit-cover" style="width: 50px; height: 35px;" alt="Banner">
                        </td>
                        <td class="fw-bold headline-col">
                            <a href="#" class="text-reset text-decoration-none hover-primary" onclick="event.preventDefault(); alert('Draft view (Simulated)');">Union Budget Provisions: Green Hydrogen Capital Investment</a>
                            <span class="d-block text-muted small fw-normal">By Vikram M. • Draft</span>
                        </td>
                        <td><span class="badge bg-secondary-subtle text-secondary text-uppercase fs-9">Business</span></td>
                        <td>Economy</td>
                        <td>—</td>
                        <td><span class="badge bg-secondary-subtle text-secondary border py-1 fs-9">Draft</span></td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="/admin/news/create" class="btn btn-xs btn-outline-secondary border-secondary-subtle p-1" title="Edit Article"><i class="fa-solid fa-pen-to-square"></i></a>
                                <button class="btn btn-xs btn-outline-danger border-0 p-1" onclick="deleteArticleRow(this)" title="Delete Article"><i class="fa-solid fa-trash-can"></i></button>
                            </div>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

    </div>

</div>

<!-- Script to handle dynamic filtering and row deletion -->
<script>
    function filterArticlesList() {
        const query = document.getElementById('articleSearchInput').value.toLowerCase();
        const cat = document.getElementById('catFilter').value;
        const rows = document.querySelectorAll('#articlesListBody tr');
        let count = 0;
        
        rows.forEach(row => {
            const headline = row.querySelector('.headline-col').innerText.toLowerCase();
            const rowCat = row.getAttribute('data-category');
            
            const matchesSearch = headline.includes(query);
            const matchesCat = (cat === 'all' || rowCat === cat);
            
            if (matchesSearch && matchesCat) {
                row.classList.remove('d-none');
                count++;
            } else {
                row.classList.add('d-none');
            }
        });
        
        document.getElementById('recordCounter').innerText = `Showing ${count} active articles`;
    }

    function deleteArticleRow(btn) {
        const row = btn.closest('tr');
        row.remove();
        showNotification('Article successfully removed from index.');
        
        // Recount
        const activeRows = document.querySelectorAll('#articlesListBody tr:not(.d-none)').length;
        document.getElementById('recordCounter').innerText = `Showing ${activeRows} active articles`;
    }
</script>
@endsection
