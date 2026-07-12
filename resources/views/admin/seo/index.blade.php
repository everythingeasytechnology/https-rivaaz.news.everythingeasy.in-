@extends('layouts.admin')

@section('title', 'SEO & Sitemaps Control - Rivaaz Admin')

@section('admin-content')
<div class="fade-in-up">
    
    <!-- Title Area -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="m-0 fw-bold">Search Engine Optimization</h3>
            <p class="text-muted small m-0">Setup sitemaps, edit robots.txt, and configure redirect routes for organic indexing.</p>
        </div>
        <button class="btn btn-sm btn-outline-secondary border-secondary-subtle" onclick="alert('XML Sitemaps rebuilt. Updated in public path.');">
            <i class="fa-solid fa-arrows-rotate"></i> Rebuild Sitemaps
        </button>
    </div>

    <div class="row g-4">
        
        <!-- Left: Redirects Manager -->
        <div class="col-lg-7">
            <div class="card border border-secondary-subtle shadow-sm rounded-3 p-4">
                <h5 class="fw-bold mb-3 border-bottom pb-2">Redirect Route Manager</h5>
                
                <!-- Redirect addition form -->
                <form class="row g-2 mb-4 align-items-end" id="redirectForm" onsubmit="addRedirectEntry(event)">
                    <div class="col-md-5">
                        <label class="form-label small fw-bold">Source Path</label>
                        <input type="text" class="form-control form-control-sm" id="sourcePath" placeholder="/old-news/fiscal-reforms" required>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label small fw-bold">Target Path</label>
                        <input type="text" class="form-control form-control-sm" id="targetPath" placeholder="/news/union-budget-reforms" required>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-sm w-100 fw-bold">Add</button>
                    </div>
                </form>

                <!-- Redirect logs list table -->
                <div class="table-responsive">
                    <table class="table align-middle table-hover small">
                        <thead>
                            <tr class="text-muted">
                                <th>Source URL</th>
                                <th>Redirect Target</th>
                                <th>Status Code</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="redirectsTableBody">
                            <tr>
                                <td class="font-monospace">/old-news/datia-snub</td>
                                <td class="font-monospace">/news/narottam-mishra-mp-bjp</td>
                                <td><span class="badge bg-success-subtle text-success fs-9">301 (Permanent)</span></td>
                                <td>
                                    <button class="btn btn-xs btn-outline-danger border-0 p-1" onclick="this.closest('tr').remove(); showNotification('Redirect entry deleted');"><i class="fa-solid fa-trash-can"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-monospace">/category/old-tech</td>
                                <td class="font-monospace">/category/technology</td>
                                <td><span class="badge bg-success-subtle text-success fs-9">301 (Permanent)</span></td>
                                <td>
                                    <button class="btn btn-xs btn-outline-danger border-0 p-1" onclick="this.closest('tr').remove(); showNotification('Redirect entry deleted');"><i class="fa-solid fa-trash-can"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        <!-- Right: Sitemap & Meta Configs -->
        <div class="col-lg-5">
            
            <!-- Sitemap options box -->
            <div class="card border border-secondary-subtle shadow-sm rounded-3 p-4 mb-4">
                <h5 class="fw-bold mb-3 border-bottom pb-2">Dynamic XML Sitemaps</h5>
                <p class="text-muted small">Auto-generated XML pathways verified on search engine indexes.</p>
                
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <strong class="d-block small">XML Core Sitemap</strong>
                            <a href="#" class="fs-8 text-decoration-none" onclick="event.preventDefault(); alert('Opening sitemap XML file...');">/sitemap.xml</a>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" checked>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <strong class="d-block small">Google News XML Sitemap</strong>
                            <a href="#" class="fs-8 text-decoration-none" onclick="event.preventDefault(); alert('Opening sitemap XML file...');">/sitemap-news.xml</a>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" checked>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <strong class="d-block small">Image XML Sitemap</strong>
                            <a href="#" class="fs-8 text-decoration-none" onclick="event.preventDefault(); alert('Opening sitemap XML file...');">/sitemap-images.xml</a>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" checked>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Global Meta tags settings -->
            <div class="card border border-secondary-subtle shadow-sm rounded-3 p-4">
                <h5 class="fw-bold mb-3 border-bottom pb-2">Indexing Metadata</h5>
                
                <form onsubmit="event.preventDefault(); showNotification('Meta index properties saved.');">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Global Canonical Domain</label>
                        <input type="text" class="form-control form-control-sm" value="https://rivaaz.news.everythingeasy.in">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Search Crawling Rules (Robots.txt)</label>
                        <textarea class="form-control font-monospace form-control-sm bg-body-tertiary" rows="3">User-agent: *
Allow: /
Disallow: /admin/
Sitemap: https://rivaaz.news.everythingeasy.in/sitemap.xml</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4 fw-bold">Save Headers</button>
                </form>
            </div>

        </div>

    </div>

</div>

<!-- Script to handle sitemaps and redirect adding simulation -->
<script>
    function addRedirectEntry(e) {
        e.preventDefault();
        
        const src = document.getElementById('sourcePath').value.trim();
        const tgt = document.getElementById('targetPath').value.trim();
        const tableBody = document.getElementById('redirectsTableBody');
        
        if(!src || !tgt) return;
        
        const trHtml = `
            <tr class="fade-in-up">
                <td class="font-monospace">${src}</td>
                <td class="font-monospace">${tgt}</td>
                <td><span class="badge bg-success-subtle text-success fs-9">301 (Permanent)</span></td>
                <td>
                    <button class="btn btn-xs btn-outline-danger border-0 p-1" onclick="this.closest('tr').remove(); showNotification('Redirect entry deleted');"><i class="fa-solid fa-trash-can"></i></button>
                </td>
            </tr>
        `;
        
        tableBody.insertAdjacentHTML('beforeend', trHtml);
        
        // Reset form inputs
        document.getElementById('sourcePath').value = '';
        document.getElementById('targetPath').value = '';
        
        showNotification('Redirect route added successfully.');
    }
</script>
@endsection
