@extends('backend.layout.app')
@section('title', 'Edit Brand')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Brand</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('brands.index') }}">Brands</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <!-- Error Messages -->
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-ban"></i> Validation Error!</h5>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                <div class="col-md-8">
                    <!-- Main Form Card -->
                    <div class="card card-warning card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-edit mr-1"></i>
                                Edit Brand Information
                            </h3>
                            <div class="card-tools">
                                <span class="badge badge-info">ID: {{ $brand->id }}</span>
                            </div>
                        </div>

                        <form action="{{ route('brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data" id="brandEditForm">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <!-- Brand Name -->
                                <div class="form-group">
                                    <label for="name">
                                        Brand Name <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                        </div>
                                        <input type="text"
                                               name="name"
                                               id="name"
                                               class="form-control @error('name') is-invalid @enderror"
                                               placeholder="Enter brand name"
                                               value="{{ old('name', $brand->name) }}"
                                               required>
                                    </div>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Enter a unique and memorable brand name</small>
                                </div>

                                <!-- Description -->
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description"
                                              id="description"
                                              class="form-control @error('description') is-invalid @enderror"
                                              rows="4"
                                              placeholder="Enter brand description (optional)">{{ old('description', $brand->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Provide a brief description of the brand</small>
                                </div>

                                <!-- Logo Upload -->
                                <div class="form-group">
                                    <label for="logo">Brand Logo</label>

                                    <!-- Current Logo Display -->
                                    @if($brand->logo)
                                        <div class="current-logo mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="mr-3">
                                                    <img src="{{ asset('storage/' . $brand->logo) }}"
                                                         alt="{{ $brand->name }}"
                                                         class="img-thumbnail"
                                                         style="max-width: 120px; max-height: 120px;"
                                                         id="currentLogo">
                                                </div>
                                                <div>
                                                    <h6 class="mb-1">Current Logo</h6>
                                                    <small class="text-muted">
                                                        <i class="fas fa-info-circle"></i>
                                                        Upload a new image to replace current logo
                                                    </small>
                                                    <br>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- File Upload -->
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file"
                                                   name="logo"
                                                   id="logo"
                                                   class="custom-file-input @error('logo') is-invalid @enderror"
                                                   accept="image/*">
                                            <label class="custom-file-label" for="logo">
                                                {{ $brand->logo ? 'Choose new logo file' : 'Choose logo file' }}
                                            </label>
                                        </div>
                                    </div>
                                    @error('logo')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle"></i>
                                        Supported formats: JPG, PNG, GIF. Max size: 2MB
                                    </small>

                                    <!-- New Image Preview -->
                                    <div id="newImagePreview" class="mt-3" style="display: none;">
                                        <div class="alert alert-info">
                                            <h6><i class="fas fa-eye"></i> New Logo Preview</h6>
                                            <div class="text-center">
                                                <img id="newPreview" src="" alt="New Logo Preview" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                                <div class="mt-2">
                                                    <button type="button" class="btn btn-sm btn-secondary" id="cancelNewImage">
                                                        <i class="fas fa-times"></i> Cancel
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Hidden input for logo removal -->
                                    <input type="hidden" name="remove_logo" id="remove_logo" value="0">
                                </div>

                                <!-- Status -->
                                <div class="form-group">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input type="checkbox"
                                               name="is_active"
                                               id="is_active"
                                               class="custom-control-input"
                                               {{ old('is_active', $brand->is_active) ? 'checked' : '' }}
                                               value="1">
                                        <label class="custom-control-label" for="is_active">
                                            <span class="font-weight-normal">Brand Status</span>
                                        </label>
                                    </div>
                                    <small class="form-text text-muted">Toggle to activate/deactivate the brand</small>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save"></i> Update Brand
                                </button>
                                <a href="{{ route('brands.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-md-4">
                    <!-- Brand Info Card -->
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-info-circle"></i>
                                Brand Details
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4"><strong>Created:</strong></div>
                                <div class="col-sm-8">{{ $brand->created_at->format('M d, Y') }}</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-4"><strong>Updated:</strong></div>
                                <div class="col-sm-8">{{ $brand->updated_at->format('M d, Y') }}</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-4"><strong>Status:</strong></div>
                                <div class="col-sm-8">
                                    @if($brand->is_active)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-warning">Inactive</span>
                                    @endif
                                </div>
                            </div>
                            @if($brand->logo)
                                <hr>
                                <div class="row">
                                    <div class="col-sm-4"><strong>Logo:</strong></div>
                                    <div class="col-sm-8">
                                        <span class="badge badge-success">
                                            <i class="fas fa-check"></i> Uploaded
                                        </span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


@push('scripts')
<script>
$(document).ready(function() {
    // Cancel new image
    $('#cancelNewImage').on('click', function() {
        $('#logo').val('');
        $('.custom-file-label').removeClass('selected').html('{{ $brand->logo ? "Choose new logo file" : "Choose logo file" }}');
        $('#newImagePreview').hide();

        // Restore original preview
        @if($brand->logo)
            $('#previewLogo').html('<img src="{{ asset("storage/" . $brand->logo) }}" class="img-circle" width="60" height="60">');
        @else
            $('#previewLogo').html('<i class="fas fa-image fa-3x text-muted"></i>');
        @endif
    });



    // Real-time preview updates
    $('#name').on('input', function() {
        let name = $(this).val() || '{{ $brand->name }}';
        $('#previewName').text(name);
    });

    $('#description').on('input', function() {
        let desc = $(this).val() || 'No description provided';
        $('#previewDescription').text(desc.substring(0, 100) + (desc.length > 100 ? '...' : ''));
    });

    $('#is_active').on('change', function() {
        let status = $(this).is(':checked');
        let badge = status ?
            '<span class="badge badge-success">Active</span>' :
            '<span class="badge badge-warning">Inactive</span>';
        $('#previewStatus').replaceWith(badge);
    });

    // Form validation
    $('#brandEditForm').on('submit', function(e) {
        let isValid = true;
        let name = $('#name').val().trim();

        if (name === '') {
            $('#name').addClass('is-invalid');
            isValid = false;
        } else {
            $('#name').removeClass('is-invalid');
        }

        if (!isValid) {
            e.preventDefault();
            toastr.error('Please fill in all required fields.');
        }
    });

    // Character counter for description
    $('#description').on('input', function() {
        let length = $(this).val().length;
        let maxLength = 500;
        let remaining = maxLength - length;

        if (remaining < 50) {
            $(this).siblings('.form-text').html(
                '<i class="fas fa-info-circle"></i> ' + remaining + ' characters remaining'
            ).removeClass('text-muted').addClass('text-warning');
        } else {
            $(this).siblings('.form-text').html(
                'Provide a brief description of the brand'
            ).removeClass('text-warning').addClass('text-muted');
        }
    });
});
</script>
@endpush
@endsection
