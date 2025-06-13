@extends('backend.layout.app')

@section('title', 'Categories Management')

@section('content')
<div class="content-wrapper">
    <!-- Enhanced Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-4 align-items-center">
                <div class="col-sm-6">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary rounded-circle p-3 mr-3">
                            <i class="fas fa-layer-group text-white fa-lg"></i>
                        </div>
                        <div>
                            <h4 class="m-0 text-dark font-weight-bold">Categories</h4>
                            <p class="text-muted mb-0">Manage your product categories and subcategories</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 text-sm-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent p-0 float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}" class="text-primary">
                                    <i class="fas fa-home mr-1"></i>Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Categories</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Filters and Actions Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <form method="GET" action="{{ route('categories.index') }}" class="form-inline">
                                <!-- Search Input -->
                                <div class="input-group mr-3 mb-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    </div>
                                    <input type="text" name="search" class="form-control"
                                           value="{{ request('search') }}" placeholder="Search categories...">
                                </div>

                                <!-- Status Filter -->
                                <select name="status" class="form-control mr-3 mb-2">
                                    <option value="">All Status</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>

                                <!-- Parent Filter -->
                                <select name="parent" class="form-control mr-3 mb-2">
                                    <option value="">All Categories</option>
                                    <option value="root" {{ request('parent') == 'root' ? 'selected' : '' }}>Root Categories</option>
                                    @foreach($parentCategories as $parent)
                                        <option value="{{ $parent->id }}" {{ request('parent') == $parent->id ? 'selected' : '' }}>
                                            {{ $parent->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <button type="submit" class="btn btn-primary mb-2 mr-2">
                                    <i class="fas fa-filter mr-1"></i>Filter
                                </button>
                                <a href="{{ route('categories.index') }}" class="btn btn-secondary mb-2">
                                    <i class="fas fa-times mr-1"></i>Clear
                                </a>
                            </form>
                        </div>
                        <div class="col-md-4 text-right">
                            <a href="{{ route('categories.create') }}" class="btn btn-success">
                                <i class="fas fa-plus mr-2"></i>Add New Category
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Categories Table Card -->
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient-primary text-white">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-list mr-2"></i>Categories List
                    </h3>
                    <div class="card-tools">
                        <span class="badge badge-light">{{ $categories->total() }} Total</span>
                    </div>
                </div>

                <div class="card-body p-0">
                    @if($categories->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th style="width: 60px;">#</th>
                                        <th style="width: 80px;">Image</th>
                                        <th>Category</th>
                                        <th>Hierarchy</th>
                                        <th>Parent</th>
                                        <th style="width: 100px;">Status</th>
                                        <th style="width: 120px;">Children</th>
                                        <th style="width: 150px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $index => $category)
                                        <tr>
                                            <td class="align-middle">
                                                {{ $categories->firstItem() + $index }}
                                            </td>
                                            <td class="align-middle">
                                                <div class="category-image">
                                                    <img src="{{ $category->image_url }}"
                                                         alt="{{ $category->name }}"
                                                         class="img-thumbnail rounded-circle"
                                                         style="width: 50px; height: 50px; object-fit: cover;">
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <div>
                                                    <h6 class="mb-1 font-weight-bold">{{ $category->name }}</h6>
                                                    @if($category->description)
                                                        <small class="text-muted">{{ Str::limit($category->description, 50) }}</small>
                                                    @endif
                                                    <div class="mt-1">
                                                        <small class="text-info">
                                                            <i class="fas fa-link mr-1"></i>{{ $category->slug }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <span class="badge badge-outline-secondary">
                                                    {{ $category->hierarchy }}
                                                </span>
                                            </td>
                                            <td class="align-middle">
                                                @if($category->parent)
                                                    <span class="badge badge-info">
                                                        <i class="fas fa-arrow-up mr-1"></i>{{ $category->parent->name }}
                                                    </span>
                                                @else
                                                    <span class="badge badge-dark">
                                                        <i class="fas fa-tree mr-1"></i>Root
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="align-middle">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox"
                                                           class="custom-control-input status-toggle"
                                                           id="status{{ $category->id }}"
                                                           data-id="{{ $category->id }}"
                                                           {{ $category->is_active ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="status{{ $category->id }}"></label>
                                                </div>
                                                <small class="d-block text-center mt-1">
                                                    <span class="badge badge-{{ $category->is_active ? 'success' : 'danger' }}">
                                                        {{ $category->is_active ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </small>
                                            </td>
                                            <td class="align-middle text-center">
                                                @if($category->hasChildren())
                                                    <span class="badge badge-primary">
                                                        <i class="fas fa-sitemap mr-1"></i>{{ $category->children->count() }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">
                                                        <i class="fas fa-leaf"></i>
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="align-middle">
                                                <div class="btn-group" role="group">

                                                    <a href="{{ route('categories.edit', $category) }}"
                                                       class="btn btn-warning btn-sm" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button"
                                                            class="btn btn-danger btn-sm delete-category"
                                                            data-id="{{ $category->id }}"
                                                            data-name="{{ $category->name }}"
                                                            title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="card-footer bg-light">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <p class="text-muted mb-0">
                                        Showing {{ $categories->firstItem() }} to {{ $categories->lastItem() }}
                                        of {{ $categories->total() }} categories
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    {{ $categories->links() }}
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-layer-group fa-4x text-muted"></i>
                            </div>
                            <h5 class="text-muted">No Categories Found</h5>
                            <p class="text-muted">Get started by creating your first category.</p>
                            <a href="{{ route('categories.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus mr-2"></i>Create First Category
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the category <strong id="categoryName"></strong>?</p>
                <p class="text-danger"><small>This action cannot be undone.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customJs')
<script>
$(document).ready(function() {
    // Status toggle
    $('.status-toggle').change(function() {
        const categoryId = $(this).data('id');
        const isChecked = $(this).is(':checked');

        $.post(`/admin/categories/${categoryId}/toggle-status`, {
            _token: '{{ csrf_token() }}'
        })
        .done(function(response) {
            if (response.success) {
                toastr.success(response.message);
                // Update badge
                const badge = $(`.status-toggle[data-id="${categoryId}"]`)
                    .closest('td').find('.badge');

                if (response.status) {
                    badge.removeClass('badge-danger').addClass('badge-success').text('Active');
                } else {
                    badge.removeClass('badge-success').addClass('badge-danger').text('Inactive');
                }
            }
        })
        .fail(function() {
            toastr.error('Failed to update status');
            // Revert toggle
            $(this).prop('checked', !isChecked);
        });
    });

    // Delete category
    $('.delete-category').click(function() {
        const categoryId = $(this).data('id');
        const categoryName = $(this).data('name');

        $('#categoryName').text(categoryName);
        $('#deleteForm').attr('action', `/admin/categories/${categoryId}`);
        $('#deleteModal').modal('show');
    });

    // Auto-submit search after typing
    let searchTimer;
    $('input[name="search"]').on('input', function() {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(function() {
            $('form').submit();
        }, 500);
    });
});
</script>

<style>
.bg-gradient-primary {
    background: linear-gradient(45deg, #007bff, #0056b3);
}

.badge-outline-secondary {
    color: #6c757d;
    border: 1px solid #6c757d;
    background-color: transparent;
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
}

.category-image img {
    border: 2px solid #e9ecef;
}

.btn-group .btn {
    margin-right: 2px;
}

.custom-control-label::before {
    border-radius: 0.5rem;
}

.custom-control-label::after {
    border-radius: 0.5rem;
}
</style>
@endsection
