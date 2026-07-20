@extends('layouts.admin')

@section('page_title', 'Category Management')

@section('content')
<div class="admin-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0">Portal Categories</h5>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary rounded-pill px-4">
            <i class="fas fa-plus me-2"></i>Create New Category
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle border-top">
            <thead class="table-light">
                <tr>
                    <th scope="col" style="width: 30%;">Name</th>
                    <th scope="col" style="width: 25%;">Slug</th>
                    <th scope="col" style="width: 15%;">SEO Configuration</th>
                    <th scope="col" style="width: 15%;">Type</th>
                    <th scope="col" style="width: 15%;" class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <!-- Parent Category Row -->
                    <tr class="fw-semibold">
                        <td>
                            <i class="fas fa-folder text-warning me-2"></i>{{ $category->name }}
                        </td>
                        <td>
                            <span class="text-muted">/category/</span>{{ $category->slug }}
                        </td>
                        <td>
                            @if($category->meta_title || $category->meta_description)
                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Configured</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill">Not Set</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill">Parent</span>
                        </td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-outline-secondary rounded-circle" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category? All subcategories will also be deleted!');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    <!-- Child Subcategories Rows -->
                    @foreach($category->subcategories as $sub)
                        <tr>
                            <td class="ps-5 text-muted">
                                <span class="me-1 text-secondary-emphasis">↳</span>
                                <i class="far fa-folder text-info me-2"></i>{{ $sub->name }}
                            </td>
                            <td>
                                <span class="text-muted">/category/{{ $category->slug }}/</span>{{ $sub->slug }}
                            </td>
                            <td>
                                @if($sub->meta_title || $sub->meta_description)
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Configured</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill">Not Set</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-info-subtle text-info border border-info-subtle rounded-pill">Subcategory</span>
                            </td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.categories.edit', $sub->id) }}" class="btn btn-sm btn-outline-secondary rounded-circle" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $sub->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this subcategory?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="fas fa-folder-open fs-2 mb-3"></i>
                            <p class="mb-0">No categories found in the database. Get started by creating one!</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
