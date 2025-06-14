@extends('backend.layout.app')
@section('title', 'Create New Product')

@section('content')
<style>
.image-preview-item {
    position: relative;
    display: inline-block;
    margin: 5px;
    border: 2px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    transition: all 0.3s ease;
}
.image-preview-item:hover {
    border-color: #007bff;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
.image-preview-item.primary {
    border-color: #28a745;
    box-shadow: 0 0 0 2px rgba(40, 167, 69, 0.25);
}
.remove-image {
    position: absolute;
    top: 5px;
    right: 5px;
    background: rgba(220, 53, 69, 0.9);
    color: white;
    border: none;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    font-size: 12px;
    line-height: 1;
    cursor: pointer;
}
.drag-drop-area {
    border: 2px dashed #ddd;
    border-radius: 8px;
    padding: 20px;
    text-align: center;
    transition: all 0.3s ease;
}
.drag-drop-area:hover, .drag-drop-area.dragover {
    border-color: #007bff;
    background-color: rgba(0, 123, 255, 0.05);
}
</style>

<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-plus-circle mr-2"></i>
                        Create New Product
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
                @csrf

                <div class="row">
                    <!-- Left Column -->
                    <div class="col-lg-8">
                        <!-- Basic Information -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    Basic Information
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Product Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                           value="{{ old('name') }}" required placeholder="Enter product name">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="sku">SKU <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" name="sku" id="sku" class="form-control @error('sku') is-invalid @enderror"
                                               value="{{ old('sku') }}" required placeholder="e.g., PRD-001">
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-outline-secondary" id="generateSku">
                                                <i class="fas fa-magic"></i> Generate
                                            </button>
                                        </div>
                                    </div>
                                    @error('sku')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="short_description">Short Description</label>
                                    <textarea name="short_description" id="short_description" class="form-control @error('short_description') is-invalid @enderror"
                                              rows="2" placeholder="Brief product description">{{ old('short_description') }}</textarea>
                                    @error('short_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="description">Detailed Description</label>
                                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                                              rows="5" placeholder="Detailed product description">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Pricing -->
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-dollar-sign mr-2"></i>
                                    Pricing Information
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="price">Selling Price <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">$</span>
                                                </div>
                                                <input type="number" step="0.01" name="price" id="price"
                                                       class="form-control @error('price') is-invalid @enderror"
                                                       value="{{ old('price') }}" required min="0">
                                            </div>
                                            @error('price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="compare_price">Compare Price</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">$</span>
                                                </div>
                                                <input type="number" step="0.01" name="compare_price" id="compare_price"
                                                       class="form-control @error('compare_price') is-invalid @enderror"
                                                       value="{{ old('compare_price') }}" min="0">
                                            </div>
                                            @error('compare_price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="cost_price">Cost Price</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">$</span>
                                                </div>
                                                <input type="number" step="0.01" name="cost_price" id="cost_price"
                                                       class="form-control @error('cost_price') is-invalid @enderror"
                                                       value="{{ old('cost_price') }}" min="0">
                                            </div>
                                            @error('cost_price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle mr-2"></i>
                                            <span id="profit-margin">Profit margin will be calculated automatically</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Inventory -->
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-boxes mr-2"></i>
                                    Inventory Management
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="stock_quantity">Stock Quantity <span class="text-danger">*</span></label>
                                            <input type="number" name="stock_quantity" id="stock_quantity"
                                                   class="form-control @error('stock_quantity') is-invalid @enderror"
                                                   value="{{ old('stock_quantity', 0) }}" required min="0">
                                            @error('stock_quantity')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="min_stock_level">Minimum Stock Level <span class="text-danger">*</span></label>
                                            <input type="number" name="min_stock_level" id="min_stock_level"
                                                   class="form-control @error('min_stock_level') is-invalid @enderror"
                                                   value="{{ old('min_stock_level', 5) }}" required min="0">
                                            @error('min_stock_level')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Specifications -->
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-list-ul mr-2"></i>
                                    Product Specifications
                                </h3>
                            </div>
                            <div class="card-body">
                                <div id="specifications-container">
                                    <div class="specification-row mb-3">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <input type="text" name="specifications[0][spec_name]"
                                                       class="form-control" placeholder="Specification Name">
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" name="specifications[0][spec_value]"
                                                       class="form-control" placeholder="Specification Value">
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" name="specifications[0][spec_group]"
                                                       class="form-control" placeholder="Group (optional)">
                                            </div>
                                            <div class="col-md-3">
                                                <button type="button" class="btn btn-danger btn-sm remove-spec">
                                                    <i class="fas fa-trash"></i> Remove
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" id="add-spec" class="btn btn-outline-info">
                                    <i class="fas fa-plus mr-2"></i>Add Specification
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-lg-4">
                        <!-- Product Images -->
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-images mr-2"></i>
                                    Product Images
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="drag-drop-area" id="dragDropArea">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Drag & drop images here or click to browse</p>
                                    <input type="file" name="images[]" id="images" class="d-none" multiple accept="image/*">
                                    <button type="button" class="btn btn-outline-primary" onclick="document.getElementById('images').click()">
                                        <i class="fas fa-upload mr-2"></i>Choose Images
                                    </button>
                                </div>

                                <div class="form-group mt-3">
                                    <label for="primary_image_index">Primary Image</label>
                                    <select name="primary_image_index" id="primary_image_index" class="form-control">
                                        <option value="">Select after uploading images</option>
                                    </select>
                                </div>

                                <div id="image-preview-container" class="mt-3"></div>
                            </div>
                        </div>

                        <!-- Organization -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-sitemap mr-2"></i>
                                    Organization
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="category_id">Category <span class="text-danger">*</span></label>
                                    <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="brand_id">Brand <span class="text-danger">*</span></label>
                                    <select name="brand_id" id="brand_id" class="form-control @error('brand_id') is-invalid @enderror" required>
                                        <option value="">Select Brand</option>
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                                {{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('brand_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="condition">Condition <span class="text-danger">*</span></label>
                                    <select name="condition" id="condition" class="form-control @error('condition') is-invalid @enderror" required>
                                        <option value="new" {{ old('condition') == 'new' ? 'selected' : '' }}>New</option>
                                        <option value="used" {{ old('condition') == 'used' ? 'selected' : '' }}>Used</option>
                                        <option value="refurbished" {{ old('condition') == 'refurbished' ? 'selected' : '' }}>Refurbished</option>
                                    </select>
                                    @error('condition')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Shipping Information -->
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-shipping-fast mr-2"></i>
                                    Shipping Information
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="weight">Weight (kg)</label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" name="weight" id="weight"
                                               class="form-control @error('weight') is-invalid @enderror"
                                               value="{{ old('weight') }}" min="0">
                                        <div class="input-group-append">
                                            <span class="input-group-text">kg</span>
                                        </div>
                                    </div>
                                    @error('weight')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="dimensions">Dimensions (L × W × H)</label>
                                    <input type="text" name="dimensions" id="dimensions"
                                           class="form-control @error('dimensions') is-invalid @enderror"
                                           value="{{ old('dimensions') }}" placeholder="e.g., 30×20×10 cm">
                                    @error('dimensions')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Warranty -->
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-shield-alt mr-2"></i>
                                    Warranty Information
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="warranty_period">Warranty Period</label>
                                    <div class="input-group">
                                        <input type="number" name="warranty_period" id="warranty_period"
                                               class="form-control @error('warranty_period') is-invalid @enderror"
                                               value="{{ old('warranty_period') }}" min="0">
                                        <div class="input-group-append">
                                            <span class="input-group-text">months</span>
                                        </div>
                                    </div>
                                    @error('warranty_period')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Status & Visibility -->
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-toggle-on mr-2"></i>
                                    Status & Visibility
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" name="is_active" id="is_active"
                                               class="custom-control-input" {{ old('is_active', true) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_active">
                                            <strong>Active Product</strong>
                                            <br><small class="text-muted">Product will be visible on store</small>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" name="is_featured" id="is_featured"
                                               class="custom-control-input" {{ old('is_featured') ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_featured">
                                            <strong>Featured Product</strong>
                                            <br><small class="text-muted">Show in featured section</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SEO -->
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-search mr-2"></i>
                                    SEO Settings
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="meta_title">Meta Title</label>
                                    <input type="text" name="meta_title" id="meta_title"
                                           class="form-control @error('meta_title') is-invalid @enderror"
                                           value="{{ old('meta_title') }}" maxlength="60">
                                    <small class="text-muted">
                                        <span id="meta-title-count">0</span>/60 characters
                                    </small>
                                    @error('meta_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="meta_description">Meta Description</label>
                                    <textarea name="meta_description" id="meta_description"
                                              class="form-control @error('meta_description') is-invalid @enderror"
                                              rows="3" maxlength="160">{{ old('meta_description') }}</textarea>
                                    <small class="text-muted">
                                        <span id="meta-desc-count">0</span>/160 characters
                                    </small>
                                    @error('meta_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body text-center">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fas fa-save mr-2"></i>Create Product
                                </button>
                                <button type="button" class="btn btn-outline-secondary btn-sm ml-2" id="saveDraft">
                                    <i class="fas fa-edit mr-2"></i>Save as Draft
                                </button>
                                <a href="{{ route('products.index') }}" class="btn btn-outline-danger btn-sm ml-2">
                                    <i class="fas fa-times mr-2"></i>Cancel
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // SKU Generation
    document.getElementById('generateSku').addEventListener('click', function() {
        const timestamp = Date.now().toString().slice(-6);
        const random = Math.random().toString(36).substr(2, 3).toUpperCase();
        document.getElementById('sku').value = `PRD-${timestamp}-${random}`;
    });

    // Profit Margin Calculation
    function calculateProfitMargin() {
        const price = parseFloat(document.getElementById('price').value) || 0;
        const cost = parseFloat(document.getElementById('cost_price').value) || 0;
        const profitDisplay = document.getElementById('profit-margin');

        if (price > 0 && cost > 0) {
            const margin = ((price - cost) / price * 100).toFixed(2);
            const profit = (price - cost).toFixed(2);
            profitDisplay.innerHTML = `Profit: ${profit} | Margin: ${margin}%`;
            profitDisplay.className = margin > 20 ? 'text-success' : margin > 10 ? 'text-warning' : 'text-danger';
        } else {
            profitDisplay.innerHTML = 'Profit margin will be calculated automatically';
            profitDisplay.className = '';
        }
    }

    document.getElementById('price').addEventListener('input', calculateProfitMargin);
    document.getElementById('cost_price').addEventListener('input', calculateProfitMargin);

    // Specifications Management
    let specIndex = 1;
    document.getElementById('add-spec').addEventListener('click', function() {
        const container = document.getElementById('specifications-container');
        const newRow = document.createElement('div');
        newRow.className = 'specification-row mb-3';
        newRow.innerHTML = `
            <div class="row">
                <div class="col-md-3">
                    <input type="text" name="specifications[${specIndex}][spec_name]"
                           class="form-control" placeholder="Specification Name">
                </div>
                <div class="col-md-3">
                    <input type="text" name="specifications[${specIndex}][spec_value]"
                           class="form-control" placeholder="Specification Value">
                </div>
                <div class="col-md-3">
                    <input type="text" name="specifications[${specIndex}][spec_group]"
                           class="form-control" placeholder="Group (optional)">
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-danger btn-sm remove-spec">
                        <i class="fas fa-trash"></i> Remove
                    </button>
                </div>
            </div>
        `;
        container.appendChild(newRow);
        specIndex++;
    });

    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('remove-spec')) {
            e.target.closest('.specification-row').remove();
        }
    });

    // Image Upload with Drag & Drop
    const dragDropArea = document.getElementById('dragDropArea');
    const fileInput = document.getElementById('images');
    const previewContainer = document.getElementById('image-preview-container');
    const primarySelect = document.getElementById('primary_image_index');

    let selectedFiles = [];

    // Drag & Drop Events
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dragDropArea.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dragDropArea.addEventListener(eventName, () => dragDropArea.classList.add('dragover'));
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dragDropArea.addEventListener(eventName, () => dragDropArea.classList.remove('dragover'));
    });

    dragDropArea.addEventListener('drop', handleDrop);
    dragDropArea.addEventListener('click', () => fileInput.click());

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        handleFiles(files);
    }

    fileInput.addEventListener('change', function(e) {
        handleFiles(e.target.files);
    });

    function handleFiles(files) {
        selectedFiles = Array.from(files);
        updateImagePreviews();
        updatePrimaryImageSelect();
    }

    function updateImagePreviews() {
        previewContainer.innerHTML = '';

        selectedFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewItem = document.createElement('div');
                previewItem.className = 'image-preview-item';
                previewItem.innerHTML = `
                    <img src="${e.target.result}" style="width: 80px; height: 80px; object-fit: cover;">
                    <button type="button" class="remove-image" onclick="removeImage(${index})">&times;</button>
                `;
                previewContainer.appendChild(previewItem);
            };
            reader.readAsDataURL(file);
        });
    }

    function updatePrimaryImageSelect() {
        primarySelect.innerHTML = '<option value="">Select primary image</option>';
        selectedFiles.forEach((file, index) => {
            const option = document.createElement('option');
            option.value = index;
            option.textContent = `Image ${index + 1}`;
            primarySelect.appendChild(option);
        });
    }

    // Global function for removing images
    window.removeImage = function(index) {
        selectedFiles.splice(index, 1);
        updateImagePreviews();
        updatePrimaryImageSelect();

        // Update file input
        const dt = new DataTransfer();
        selectedFiles.forEach(file => dt.items.add(file));
        fileInput.files = dt.files;
    };

    // Primary image selection
    primarySelect.addEventListener('change', function() {
        const selectedIndex = this.value;
        document.querySelectorAll('.image-preview-item').forEach((item, index) => {
            item.classList.toggle('primary', index == selectedIndex);
        });
    });

    // SEO Character Counters
    document.getElementById('meta_title').addEventListener('input', function() {
        document.getElementById('meta-title-count').textContent = this.value.length;
    });

    document.getElementById('meta_description').addEventListener('input', function() {
        document.getElementById('meta-desc-count').textContent = this.value.length;
    });

    // Save as Draft
    document.getElementById('saveDraft').addEventListener('click', function() {
        const form = document.getElementById('productForm');
        const draftInput = document.createElement('input');
        draftInput.type = 'hidden';
        draftInput.name = 'save_as_draft';
        draftInput.value = '1';
        form.appendChild(draftInput);
        form.submit();
    });

    // Form Validation Enhancement
    document.getElementById('productForm').addEventListener('submit', function(e) {
        const requiredFields = this.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });

        if (!isValid) {
            e.preventDefault();
            // Scroll to first invalid field
            const firstInvalid = this.querySelector('.is-invalid');
            if (firstInvalid) {
                firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstInvalid.focus();
            }
        }
    });

    // Auto-populate meta fields from product name
    document.getElementById('name').addEventListener('input', function() {
        const name = this.value;
        const metaTitle = document.getElementById('meta_title');
        const metaDesc = document.getElementById('meta_description');

        if (!metaTitle.value && name) {
            metaTitle.value = name.substring(0, 60);
            document.getElementById('meta-title-count').textContent = metaTitle.value.length;
        }

        if (!metaDesc.value && name) {
            metaDesc.value = `Buy ${name} at the best price. High quality product with warranty.`.substring(0, 160);
            document.getElementById('meta-desc-count').textContent = metaDesc.value.length;
        }
    });
});
</script>
@endsection
