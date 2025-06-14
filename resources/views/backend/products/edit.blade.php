@extends('backend.layout.app')
@section('title', 'Product Edit')

@section('content')
<div class="container-wrapper">
    <h1>Edit Product</h1>

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">Basic Information</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Product Name *</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}" required>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control" rows="4">{{ $product->description }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="short_description">Short Description</label>
                            <textarea name="short_description" id="short_description" class="form-control" rows="2">{{ $product->short_description }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="sku">SKU *</label>
                            <input type="text" name="sku" id="sku" class="form-control" value="{{ $product->sku }}" required>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">Pricing</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="price">Price *</label>
                                    <input type="number" step="0.01" name="price" id="price" class="form-control" value="{{ $product->price }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="compare_price">Compare Price</label>
                                    <input type="number" step="0.01" name="compare_price" id="compare_price" class="form-control" value="{{ $product->compare_price }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cost_price">Cost Price</label>
                                    <input type="number" step="0.01" name="cost_price" id="cost_price" class="form-control" value="{{ $product->cost_price }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">Inventory</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="stock_quantity">Stock Quantity *</label>
                                    <input type="number" name="stock_quantity" id="stock_quantity" class="form-control" value="{{ $product->stock_quantity }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="min_stock_level">Minimum Stock Level *</label>
                                    <input type="number" name="min_stock_level" id="min_stock_level" class="form-control" value="{{ $product->min_stock_level }}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">Specifications</div>
                    <div class="card-body">
                        <div id="specifications-container">
                            @foreach($product->specifications as $index => $spec)
                                <div class="specification-row mb-3">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <input type="hidden" name="specifications[{{ $index }}][id]" value="{{ $spec->id }}">
                                            <input type="text" name="specifications[{{ $index }}][spec_name]" class="form-control" value="{{ $spec->spec_name }}" placeholder="Spec Name">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" name="specifications[{{ $index }}][spec_value]" class="form-control" value="{{ $spec->spec_value }}" placeholder="Spec Value">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" name="specifications[{{ $index }}][spec_group]" class="form-control" value="{{ $spec->spec_group }}" placeholder="Group (optional)">
                                        </div>
                                        <div class="col-md-3">
                                            <button type="button" class="btn btn-danger remove-spec">Remove</button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" id="add-spec" class="btn btn-secondary">Add Specification</button>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">Product Images</div>
                    <div class="card-body">
                        @foreach($product->images as $image)
                            <div class="mb-3 image-container">
                                <img src="{{ asset('storage/' . $image->image_path) }}" class="img-thumbnail" style="max-height: 100px;">
                                <div class="form-group mt-2">
                                    <input type="text" name="alt_texts[{{ $image->id }}]" class="form-control" value="{{ $image->alt_text }}" placeholder="Alt text">
                                </div>
                                <div class="form-check">
                                    <input type="radio" name="primary_image_id" id="primary_image_{{ $image->id }}" value="{{ $image->id }}" class="form-check-input" {{ $image->is_primary ? 'checked' : '' }}>
                                    <label class="form-check-label" for="primary_image_{{ $image->id }}">Primary Image</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="deleted_image_ids[]" id="delete_image_{{ $image->id }}" value="{{ $image->id }}" class="form-check-input">
                                    <label class="form-check-label" for="delete_image_{{ $image->id }}">Delete Image</label>
                                </div>
                            </div>
                        @endforeach

                        <div class="form-group">
                            <label>Upload Additional Images</label>
                            <input type="file" name="new_images[]" id="new_images" class="form-control-file" multiple>
                        </div>
                        <div id="new-image-preview-container" class="mb-3"></div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">Organization</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="category_id">Category *</label>
                            <select name="category_id" id="category_id" class="form-control" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="brand_id">Brand *</label>
                            <select name="brand_id" id="brand_id" class="form-control" required>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="condition">Condition *</label>
                            <select name="condition" id="condition" class="form-control" required>
                                <option value="new" {{ $product->condition == 'new' ? 'selected' : '' }}>New</option>
                                <option value="used" {{ $product->condition == 'used' ? 'selected' : '' }}>Used</option>
                                <option value="refurbished" {{ $product->condition == 'refurbished' ? 'selected' : '' }}>Refurbished</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">Shipping</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="weight">Weight (kg)</label>
                            <input type="number" step="0.01" name="weight" id="weight" class="form-control" value="{{ $product->weight }}">
                        </div>

                        <div class="form-group">
                            <label for="dimensions">Dimensions (L x W x H)</label>
                            <input type="text" name="dimensions" id="dimensions" class="form-control" value="{{ $product->dimensions }}" placeholder="e.g., 10x5x2">
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">Warranty</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="warranty_period">Warranty Period (months)</label>
                            <input type="number" name="warranty_period" id="warranty_period" class="form-control" value="{{ $product->warranty_period }}">
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">Status</div>
                    <div class="card-body">
                        <div class="form-group form-check">
                            <input type="checkbox" name="is_featured" id="is_featured" class="form-check-input" {{ $product->is_featured ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">Featured Product</label>
                        </div>

                        <div class="form-group form-check">
                            <input type="checkbox" name="is_active" id="is_active" class="form-check-input" {{ $product->is_active ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">SEO</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="meta_title">Meta Title</label>
                            <input type="text" name="meta_title" id="meta_title" class="form-control" value="{{ $product->meta_title }}">
                        </div>

                        <div class="form-group">
                            <label for="meta_description">Meta Description</label>
                            <textarea name="meta_description" id="meta_description" class="form-control" rows="2">{{ $product->meta_description }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Update Product</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Specifications
    let specIndex = {{ count($product->specifications) }};
    document.getElementById('add-spec').addEventListener('click', function() {
        const container = document.getElementById('specifications-container');
        const newRow = document.createElement('div');
        newRow.className = 'specification-row mb-3';
        newRow.innerHTML = `
            <div class="row">
                <div class="col-md-3">
                    <input type="text" name="specifications[${specIndex}][spec_name]" class="form-control" placeholder="Spec Name">
                </div>
                <div class="col-md-3">
                    <input type="text" name="specifications[${specIndex}][spec_value]" class="form-control" placeholder="Spec Value">
                </div>
                <div class="col-md-3">
                    <input type="text" name="specifications[${specIndex}][spec_group]" class="form-control" placeholder="Group (optional)">
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-danger remove-spec">Remove</button>
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

    // New image handling
    document.getElementById('new_images').addEventListener('change', function(e) {
        const files = e.target.files;
        const previewContainer = document.getElementById('new-image-preview-container');

        previewContainer.innerHTML = '';

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const reader = new FileReader();

            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.maxWidth = '100px';
                img.style.maxHeight = '100px';
                img.style.marginRight = '10px';
                previewContainer.appendChild(img);
            };

            reader.readAsDataURL(file);
        }
    });
});
</script>
@endsection
