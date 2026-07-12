@extends('layouts.admin')

@section('title', 'Categories Manager - Rivaaz Admin')

@section('admin-content')
<div class="fade-in-up">
    
    <!-- Header -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="m-0 fw-bold">Categories & Subcategories</h3>
            <p class="text-muted small m-0">Setup taxonomies, category highlight markers, and custom links for the main navigation bar.</p>
        </div>
        <button class="btn btn-sm btn-primary d-flex align-items-center gap-2" onclick="alert('Creating custom taxonomy nodes...');">
            <i class="fa-solid fa-plus"></i> Add Category
        </button>
    </div>

    <div class="row g-4">
        
        <!-- Category items list (Left - 7 Grid Units) -->
        <div class="col-lg-7">
            <div class="card border border-secondary-subtle shadow-sm rounded-3 p-4">
                <h5 class="fw-bold mb-3 border-bottom pb-2">Active Categories</h5>
                
                <div class="table-responsive">
                    <table class="table align-middle table-hover small">
                        <thead>
                            <tr class="text-muted">
                                <th>Category Name</th>
                                <th>Slug path</th>
                                <th>Subcategories Count</th>
                                <th>Marker Color</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="categoryTableBody">
                            <tr>
                                <td class="fw-bold"><i class="fa-solid fa-globe text-primary me-2"></i> India</td>
                                <td class="font-monospace">/category/india</td>
                                <td>3 Subs (National, State, Rural)</td>
                                <td><span class="d-inline-block rounded-circle" style="width:12px; height:12px; background-color:#FF4E4E;"></span></td>
                                <td>
                                    <button class="btn btn-xs btn-outline-danger border-0 p-1" onclick="this.closest('tr').remove(); showNotification('Category node deleted');"><i class="fa-solid fa-trash-can"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold"><i class="fa-solid fa-laptop text-primary me-2"></i> Technology</td>
                                <td class="font-monospace">/category/technology</td>
                                <td>2 Subs (Gadgets, AI)</td>
                                <td><span class="d-inline-block rounded-circle" style="width:12px; height:12px; background-color:#00D2FC;"></span></td>
                                <td>
                                    <button class="btn btn-xs btn-outline-danger border-0 p-1" onclick="this.closest('tr').remove(); showNotification('Category node deleted');"><i class="fa-solid fa-trash-can"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold"><i class="fa-solid fa-briefcase text-primary me-2"></i> Business</td>
                                <td class="font-monospace">/category/business</td>
                                <td>4 Subs (Stocks, Economy)</td>
                                <td><span class="d-inline-block rounded-circle" style="width:12px; height:12px; background-color:#FDBA74;"></span></td>
                                <td>
                                    <button class="btn btn-xs btn-outline-danger border-0 p-1" onclick="this.closest('tr').remove(); showNotification('Category node deleted');"><i class="fa-solid fa-trash-can"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        <!-- Add Category & Subcategory Forms (Right - 5 Grid Units) -->
        <div class="col-lg-5">
            
            <!-- Category Form -->
            <div class="card border border-secondary-subtle shadow-sm rounded-3 p-4 mb-4">
                <h5 class="fw-bold mb-3 border-bottom pb-2">Add New Category</h5>
                
                <form id="categoryAddForm" onsubmit="addCategoryEntry(event)">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Category Title</label>
                        <input type="text" class="form-control" id="catTitle" placeholder="e.g. Sports" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Slug Name</label>
                        <input type="text" class="form-control" id="catSlug" placeholder="e.g. sports" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Marker Tag Color</label>
                        <input type="color" class="form-control form-control-color border-secondary-subtle w-100" id="catColor" value="#2ec4b6">
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4 fw-bold">Save Category</button>
                </form>
            </div>

            <!-- Subcategory Form -->
            <div class="card border border-secondary-subtle shadow-sm rounded-3 p-4">
                <h5 class="fw-bold mb-3 border-bottom pb-2">Add New Subcategory</h5>
                
                <form id="subcategoryAddForm" onsubmit="addSubcategoryEntry(event)">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Select Parent Category</label>
                        <select class="form-select" id="subParentSelect">
                            <option value="india">India</option>
                            <option value="politics">Politics</option>
                            <option value="technology">Technology</option>
                            <option value="business">Business</option>
                            <option value="entertainment" selected>Entertainment</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Subcategory Title</label>
                        <input type="text" class="form-control" id="subTitle" placeholder="e.g. Bollywood" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Slug Path</label>
                        <input type="text" class="form-control" id="subSlug" placeholder="e.g. bollywood" required>
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4 fw-bold">Save Subcategory</button>
                </form>
            </div>

        </div>

    </div>

</div>

<!-- Script to handle dynamic categories creation -->
<script>
    function addCategoryEntry(e) {
        e.preventDefault();
        
        const title = document.getElementById('catTitle').value.trim();
        const slug = document.getElementById('catSlug').value.trim();
        const color = document.getElementById('catColor').value;
        const tableBody = document.getElementById('categoryTableBody');
        
        if(!title || !slug) return;
        
        const trHtml = `
            <tr class="fade-in-up">
                <td class="fw-bold"><i class="fa-solid fa-circle text-primary me-2" style="font-size:8px;"></i> ${title}</td>
                <td class="font-monospace">/category/${slug}</td>
                <td>0 Subs</td>
                <td><span class="d-inline-block rounded-circle" style="width:12px; height:12px; background-color:${color};"></span></td>
                <td>
                    <button class="btn btn-xs btn-outline-danger border-0 p-1" onclick="this.closest('tr').remove(); showNotification('Category node deleted');"><i class="fa-solid fa-trash-can"></i></button>
                </td>
            </tr>
        `;
        
        tableBody.insertAdjacentHTML('beforeend', trHtml);
        
        // Reset form inputs
        document.getElementById('catTitle').value = '';
        document.getElementById('catSlug').value = '';
        
        showNotification(`New category: ${title} created successfully.`);
    }

    function addSubcategoryEntry(e) {
        e.preventDefault();
        
        const parent = document.getElementById('subParentSelect');
        const parentText = parent.options[parent.selectedIndex].text;
        const title = document.getElementById('subTitle').value.trim();
        const slug = document.getElementById('subSlug').value.trim();
        
        if(!title || !slug) return;
        
        showNotification(`New subcategory: "${title}" created under parent: "${parentText}". URL: /category/${parent.value}/${slug}`);
        
        // Reset form inputs
        document.getElementById('subTitle').value = '';
        document.getElementById('subSlug').value = '';
    }
</script>
@endsection
