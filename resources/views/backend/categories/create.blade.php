@extends('backend.layout.app')
@section('title', 'Create Category')
@section('content')
<div class="content-wrapper">
    <!-- Enhanced Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-4 align-items-center">
                <div class="col-sm-6">
                    <div class="d-flex align-items-center">
                        <div class="bg-success rounded-circle p-3 mr-3">
                            <i class="fas fa-plus text-white fa-lg"></i>
                        </div>
                        <div>
                            <h1 class="m-0 text-dark font-weight-bold">Create Category</h1>
                            <p class="text-muted mb-0">Add a new category to organize your content</p>
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
                            <li class="breadcrumb-item active" aria-current="page">Create Category</li>
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
                                <i class="fas fa-folder-plus mr-2 text-success"></i>
                                Category Information
                            </h3>
                        </div>

                        <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
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
                                                   value="{{ old('name') }}"
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
                                                   value="{{ old('slug') }}"
                                                   placeholder="category-slug (auto-generated)">
                                            <small class="form-text text-muted">Leave empty to auto-generate from name</small>
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
                                              placeholder="Enter category description (optional)">{{ old('description') }}</textarea>
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
                                                @if(isset($parentCategories))
                                                    @foreach($parentCategories as $category)
                                                        <option value="{{ $category->id }}"
                                                                {{ old('parent_id') == $category->id ? 'selected' : '' }}>
                                                            {{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
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
                                                <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>
                                                    Active
                                                </option>
                                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>
                                                    Inactive
                                                </option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Category Image -->
                                <div class="form-group">
                                    <label for="image" class="form-label font-weight-bold">
                                        <i class="fas fa-image mr-1 text-purple"></i>
                                        Category Image
                                    </label>
                                    <div class="custom-file">
                                        <input type="file"
                                               class="custom-file-input @error('image') is-invalid @enderror"
                                               id="image"
                                               name="image"
                                               accept="image/*">
                                        <label class="custom-file-label" for="image">Choose image file...</label>
                                    </div>
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Supported formats: JPG, PNG, GIF. Max size: 2MB
                                    </small>
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                            </div>

                            <div class="card-footer bg-light">
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="{{ route('categories.index') }}"
                                           class="btn btn-secondary">
                                            <i class="fas fa-arrow-left mr-2"></i>
                                            Back to Categories
                                        </a>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <button type="reset" class="btn btn-outline-secondary mr-2">
                                            <i class="fas fa-undo mr-2"></i>
                                            Reset
                                        </button>
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-save mr-2"></i>
                                            Create Category
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
    // Auto-generate slug from name
    $('#name').on('input', function() {
        var name = $(this).val();
        var slug = name.toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .replace(/^-|-$/g, '');
        $('#slug').val(slug);
    });

    // Custom file input label update
    $('.custom-file-input').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).siblings('.custom-file-label').addClass('selected').html(fileName || 'Choose image file...');
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
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
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
</style>
@endpush
@endsection
