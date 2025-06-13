@extends('backend.layout.app')
@section('title', 'Edit Category')
@section('content')
<div class="content-wrapper">
    <!-- Enhanced Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-4 align-items-center">
                <div class="col-sm-6">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary rounded-circle p-3 mr-3">
                            <i class="fas fa-edit text-white fa-lg"></i>
                        </div>
                        <div>
                            <h1 class="m-0 text-dark font-weight-bold">Edit Category</h1>
                            <p class="text-muted mb-0">Modify category information</p>
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
                            <li class="breadcrumb-item">
                                <a href="{{ route('categories.index') }}" class="text-primary">Categories</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Category</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white border-bottom">
                            <h3 class="card-title font-weight-bold text-dark">
                                <i class="fas fa-folder-open mr-2 text-primary"></i>
                                Category Information
                            </h3>
                            <div class="card-tools">
                                <span class="badge badge-info">ID: {{ $category->id }}</span>
                                <span class="badge badge-{{ $category->status ? 'success' : 'danger' }}">
                                    {{ $category->status ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>

                        <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <!-- Success Message -->
                                @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <i class="fas fa-check-circle mr-2"></i>
                                        {{ session('success') }}
                                        <button type="button" class="close" data-dismiss="alert">
                                            <span>&times;</span>
                                        </button>
                                    </div>
                                @endif

                                <!-- Error Messages -->
                                @if($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <i class="fas fa-exclamation-triangle mr-2"></i>
                                        <strong>Please fix the following errors:</strong>
                                        <ul class="mb-0 mt-2">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="close" data-dismiss="alert">
                                            <span>&times;</span>
                                        </button>
                                    </div>
                                @endif

                                <div class="row">
                                    <!-- Category Name -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name" class="form-label font-weight-bold">
                                                <i class="fas fa-tag mr-1 text-primary"></i>
                                                Category Name <span class="text-danger">*</span>
                                            </label>
                                            <input type="text"
                                                   class="form-control @error('name') is-invalid @enderror"
                                                   id="name"
                                                   name="name"
                                                   value="{{ old('name', $category->name) }}"
                                                   placeholder="Enter category name"
                                                   required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Category Slug -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="slug" class="form-label font-weight-bold">
                                                <i class="fas fa-link mr-1 text-info"></i>
                                                Category Slug
                                            </label>
                                            <input type="text"
                                                   class="form-control @error('slug') is-invalid @enderror"
                                                   id="slug"
                                                   name="slug"
                                                   value="{{ old('slug', $category->slug) }}"
                                                   placeholder="category-slug">
                                            <small class="form-text text-muted">URL-friendly version of the name</small>
                                            @error('slug')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Category Description -->
                                <div class="form-group">
                                    <label for="description" class="form-label font-weight-bold">
                                        <i class="fas fa-align-left mr-1 text-secondary"></i>
                                        Description
                                    </label>
                                    <textarea class="form-control @error('description') is-invalid @enderror"
                                              id="description"
                                              name="description"
                                              rows="4"
                                              placeholder="Enter category description (optional)">{{ old('description', $category->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <!-- Parent Category -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="parent_id" class="form-label font-weight-bold">
                                                <i class="fas fa-sitemap mr-1 text-warning"></i>
                                                Parent Category
                                            </label>
                                            <select class="form-control @error('parent_id') is-invalid @enderror"
                                                    id="parent_id"
                                                    name="parent_id">
                                                <option value="">Select Parent Category (Optional)</option>
                                                @if(isset($categories))
                                                    @foreach($categories as $cat)
                                                        @if($cat->id != $category->id)
                                                            <option value="{{ $cat->id }}"
                                                                    {{ old('parent_id', $category->parent_id) == $cat->id ? 'selected' : '' }}>
                                                                {{ $cat->name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </select>
                                            <small class="form-text text-muted">Cannot select itself as parent</small>
                                            @error('parent_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Status -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status" class="form-label font-weight-bold">
                                                <i class="fas fa-toggle-on mr-1 text-success"></i>
                                                Status <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control @error('status') is-invalid @enderror"
                                                    id="status"
                                                    name="status"
                                                    required>
                                                <option value="1" {{ old('status', $category->status) == '1' ? 'selected' : '' }}>
                                                    Active
                                                </option>
                                                <option value="0" {{ old('status', $category->status) == '0' ? 'selected' : '' }}>
                                                    Inactive
                                                </option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Current Image & New Image Upload -->
                                <div class="form-group">
                                    <label class="form-label font-weight-bold">
                                        <i class="fas fa-image mr-1 text-purple"></i>
                                        Category Image
                                    </label>

                                    <!-- Current Image Display -->
                                    @if($category->image)
                                        <div class="current-image mb-3">
                                            <div class="card" style="max-width: 300px;">
                                                <div class="card-header bg-light">
                                                    <h6 class="card-title mb-0">
                                                        <i class="fas fa-eye mr-1"></i>Current Image
                                                    </h6>
                                                </div>
                                                <div class="card-body p-2">
                                                    <img src="{{ asset('storage/' . $category->image) }}"
                                                         alt="{{ $category->name }}"
                                                         class="img-fluid rounded"
                                                         style="max-height: 150px;">
                                                    <div class="mt-2">
                                                        <small class="text-muted">
                                                            <i class="fas fa-file mr-1"></i>
                                                            {{ basename($category->image) }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle mr-2"></i>
                                            No image uploaded for this category.
                                        </div>
                                    @endif

                                    <!-- New Image Upload -->
                                    <div class="custom-file">
                                        <input type="file"
                                               class="custom-file-input @error('image') is-invalid @enderror"
                                               id="image"
                                               name="image"
                                               accept="image/*">
                                        <label class="custom-file-label" for="image">
                                            {{ $category->image ? 'Choose new image file...' : 'Choose image file...' }}
                                        </label>
                                    </div>
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Supported formats: JPG, PNG, GIF. Max size: 2MB.
                                        {{ $category->image ? 'Leave empty to keep current image.' : '' }}
                                    </small>
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    <!-- Remove Image Option -->
                                    @if($category->image)
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" id="remove_image" name="remove_image" value="1">
                                            <label class="form-check-label text-danger" for="remove_image">
                                                <i class="fas fa-trash mr-1"></i>
                                                Remove current image
                                            </label>
                                        </div>
                                    @endif
                                </div>

                                <!-- SEO Fields -->
                                <div class="card mt-4">
                                    <div class="card-header bg-light">
                                        <h5 class="card-title mb-0">
                                            <i class="fas fa-search mr-2 text-primary"></i>
                                            SEO Settings (Optional)
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="meta_title" class="form-label font-weight-bold">
                                                Meta Title
                                            </label>
                                            <input type="text"
                                                   class="form-control @error('meta_title') is-invalid @enderror"
                                                   id="meta_title"
                                                   name="meta_title"
                                                   value="{{ old('meta_title', $category->meta_title) }}"
                                                   placeholder="SEO meta title">
                                            @error('meta_title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="meta_description" class="form-label font-weight-bold">
                                                Meta Description
                                            </label>
                                            <textarea class="form-control @error('meta_description') is-invalid @enderror"
                                                      id="meta_description"
                                                      name="meta_description"
                                                      rows="3"
                                                      placeholder="SEO meta description">{{ old('meta_description', $category->meta_description) }}</textarea>
                                            @error('meta_description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Category Statistics -->
                                @if(isset($category->posts_count) || isset($category->created_at))
                                    <div class="card mt-4">
                                        <div class="card-header bg-light">
                                            <h5 class="card-title mb-0">
                                                <i class="fas fa-chart-bar mr-2 text-info"></i>
                                                Category Statistics
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                @if(isset($category->posts_count))
                                                    <div class="col-md-4">
                                                        <div class="info-box bg-info">
                                                            <span class="info-box-icon"><i class="fas fa-file-alt"></i></span>
                                                            <div class="info-box-content">
                                                                <span class="info-box-text">Total Posts</span>
                                                                <span class="info-box-number">{{ $category->posts_count ?? 0 }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="col-md-4">
                                                    <div class="info-box bg-success">
                                                        <span class="info-box-icon"><i class="fas fa-calendar-plus"></i></span>
                                                        <div class="info-box-content">
                                                            <span class="info-box-text">Created</span>
                                                            <span class="info-box-number">{{ $category->created_at->format('M d, Y') }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="info-box bg-warning">
                                                        <span class="info-box-icon"><i class="fas fa-edit"></i></span>
                                                        <div class="info-box-content">
                                                            <span class="info-box-text">Last Updated</span>
                                                            <span class="info-box-number">{{ $category->updated_at->format('M d, Y') }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="card-footer bg-light">
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="{{ route('categories.index') }}"
                                           class="btn btn-secondary">
                                            <i class="fas fa-arrow-left mr-2"></i>
                                            Back to Categories
                                        </a>
                                        <a href="{{ route('categories.show', $category->id) }}"
                                           class="btn btn-info ml-2">
                                            <i class="fas fa-eye mr-2"></i>
                                            View Details
                                        </a>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <button type="reset" class="btn btn-outline-secondary mr-2">
                                            <i class="fas fa-undo mr-2"></i>
                                            Reset Changes
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save mr-2"></i>
                                            Update Category
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Auto-generate slug from name (only if slug is empty or matches the pattern)
    var originalSlug = '{{ $category->slug }}';
    $('#name').on('input', function() {
        var name = $(this).val();
        var currentSlug = $('#slug').val();

        // Only auto-generate if slug is empty or user hasn't manually edited it
        if (!currentSlug || currentSlug === originalSlug) {
            var slug = name.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .replace(/^-|-$/g, '');
            $('#slug').val(slug);
        }
    });

    // Custom file input label update
    $('.custom-file-input').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        var hasCurrentImage = {{ $category->image ? 'true' : 'false' }};
        var defaultText = hasCurrentImage ? 'Choose new image file...' : 'Choose image file...';
        $(this).siblings('.custom-file-label').addClass('selected').html(fileName || defaultText);
    });

    // Handle remove image checkbox
    $('#remove_image').on('change', function() {
        if ($(this).is(':checked')) {
            $('#image').prop('disabled', true).val('');
            $('.custom-file-label').html('Current image will be removed');
        } else {
            $('#image').prop('disabled', false);
            $('.custom-file-label').html('Choose new image file...');
        }
    });

    // Form validation
    $('form').on('submit', function(e) {
        var name = $('#name').val().trim();
        if (!name) {
            e.preventDefault();
            alert('Please enter a category name.');
            $('#name').focus();
            return false;
        }

        // Confirm if removing image
        if ($('#remove_image').is(':checked')) {
            if (!confirm('Are you sure you want to remove the current image?')) {
                e.preventDefault();
                return false;
            }
        }
    });

    // Reset form functionality
    $('button[type="reset"]').on('click', function(e) {
        e.preventDefault();
        if (confirm('Are you sure you want to reset all changes?')) {
            location.reload();
        }
    });
});
</script>
@endpush

@push('styles')
<style>
.content-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 10px;
    margin-bottom: 20px;
}

.card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.btn {
    border-radius: 8px;
    padding: 10px 20px;
    font-weight: 600;
}

.custom-file-label::after {
    border-radius: 0 8px 8px 0;
}

.alert {
    border-radius: 10px;
    border: none;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: "→";
}

.info-box {
    border-radius: 10px;
    margin-bottom: 15px;
}

.current-image .card {
    border: 2px dashed #dee2e6;
}

.current-image img {
    transition: transform 0.3s ease;
}

.current-image img:hover {
    transform: scale(1.05);
}

.badge {
    font-size: 0.85em;
}
</style>
@endpush
@endsection
