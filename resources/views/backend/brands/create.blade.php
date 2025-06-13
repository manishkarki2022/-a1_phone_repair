@extends('backend.layout.app')
@section('title', 'Create Brand')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Create New Brand</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('brands.index') }}">Brands</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <!-- Main Form Card -->
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-plus mr-1"></i>
                                Brand Information
                            </h3>
                        </div>

                        <form action="{{ route('brands.store') }}" method="POST" enctype="multipart/form-data" id="brandForm">
                            @csrf
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
                                               value="{{ old('name') }}"
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
                                              placeholder="Enter brand description (optional)">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Provide a brief description of the brand</small>
                                </div>

                                <!-- Logo Upload -->
                                <div class="form-group">
                                    <label for="logo">Brand Logo</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file"
                                                   name="logo"
                                                   id="logo"
                                                   class="custom-file-input @error('logo') is-invalid @enderror"
                                                   accept="image/*">
                                            <label class="custom-file-label" for="logo">Choose logo file</label>
                                        </div>
                                    </div>
                                    @error('logo')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle"></i>
                                        Supported formats: JPG, PNG, GIF. Max size: 2MB
                                    </small>

                                    <!-- Image Preview -->
                                    <div id="imagePreview" class="mt-3" style="display: none;">
                                        <div class="text-center">
                                            <img id="preview" src="" alt="Logo Preview" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                            <div class="mt-2">
                                                <button type="button" class="btn btn-sm btn-danger" id="removeImage">
                                                    <i class="fas fa-times"></i> Remove
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="form-group">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input type="checkbox"
                                               name="is_active"
                                               id="is_active"
                                               class="custom-control-input"
                                               {{ old('is_active', true) ? 'checked' : '' }}
                                               value="1">
                                        <label class="custom-control-label" for="is_active">
                                            <span class="font-weight-normal">Brand Status</span>
                                        </label>
                                    </div>
                                    <small class="form-text text-muted">Toggle to activate/deactivate the brand</small>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Create Brand
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
                    <!-- Help Card -->
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-question-circle"></i>
                                Quick Help
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <div class="list-group-item border-0 px-0">
                                    <h6 class="mb-1"><i class="fas fa-lightbulb text-warning"></i> Brand Name Tips</h6>
                                    <small>Use a unique, memorable name that represents your brand identity.</small>
                                </div>
                                <div class="list-group-item border-0 px-0">
                                    <h6 class="mb-1"><i class="fas fa-image text-info"></i> Logo Guidelines</h6>
                                    <small>Upload high-quality images in PNG or JPG format. Square images work best.</small>
                                </div>
                                <div class="list-group-item border-0 px-0">
                                    <h6 class="mb-1"><i class="fas fa-toggle-on text-success"></i> Brand Status</h6>
                                    <small>Active brands will be visible to customers. Inactive brands are hidden.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Preview Card -->
                    <div class="card card-success" id="brandPreview" style="display: none;">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-eye"></i>
                                Brand Preview
                            </h3>
                        </div>
                        <div class="card-body text-center">
                            <div id="previewLogo" class="mb-3">
                                <i class="fas fa-image fa-3x text-muted"></i>
                            </div>
                            <h5 id="previewName" class="text-muted">Brand Name</h5>
                            <p id="previewDescription" class="text-muted small">Brand Description</p>
                            <span id="previewStatus" class="badge badge-success">Active</span>
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
    // Custom file input label update
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).siblings('.custom-file-label').addClass('selected').html(fileName);

        // Show image preview
        if (this.files && this.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                $('#preview').attr('src', e.target.result);
                $('#imagePreview').show();

                // Update preview card
                $('#previewLogo').html('<img src="' + e.target.result + '" class="img-circle" width="60" height="60">');
                updatePreview();
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    // Remove image
    $('#removeImage').on('click', function() {
        $('#logo').val('');
        $('.custom-file-label').removeClass('selected').html('Choose logo file');
        $('#imagePreview').hide();
        $('#previewLogo').html('<i class="fas fa-image fa-3x text-muted"></i>');
        updatePreview();
    });

    // Real-time preview updates
    $('#name').on('input', function() {
        let name = $(this).val() || 'Brand Name';
        $('#previewName').text(name);
        updatePreview();
    });

    $('#description').on('input', function() {
        let desc = $(this).val() || 'Brand Description';
        $('#previewDescription').text(desc.substring(0, 100) + (desc.length > 100 ? '...' : ''));
        updatePreview();
    });

    $('#is_active').on('change', function() {
        let status = $(this).is(':checked');
        let badge = status ?
            '<span class="badge badge-success">Active</span>' :
            '<span class="badge badge-warning">Inactive</span>';
        $('#previewStatus').replaceWith(badge);
        updatePreview();
    });

    function updatePreview() {
        let hasContent = $('#name').val() || $('#description').val() || $('#logo').val();
        if (hasContent) {
            $('#brandPreview').show();
        }
    }

    // Form validation
    $('#brandForm').on('submit', function(e) {
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
