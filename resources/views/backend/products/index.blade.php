@extends('backend.layout.app')
@section('title', 'Products Management')

@section('content')
<style>
.product-image {
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: transform 0.2s ease;
}
.product-image:hover {
    transform: scale(1.1);
}
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Products Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Products</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Success Alert -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon fas fa-check"></i>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Main Card -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-boxes mr-2"></i>
                        All Products
                    </h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 250px;">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="Search products...">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <!-- Action Bar -->
                    <div class="p-3 bg-light border-bottom">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <a href="{{ route('products.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus mr-2"></i>
                                    Add New Product
                                </a>
                                <button class="btn btn-outline-secondary ml-2">
                                    <i class="fas fa-download mr-2"></i>
                                    Export
                                </button>
                            </div>
                            <div class="col-md-6 text-right">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-filter"></i> Filter
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-sort"></i> Sort
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Products Table -->
                    <div class="table-responsive">
                        <table class="table table-hover table-striped m-0">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 40px;">
                                        <div class="icheck-primary">
                                            <input type="checkbox" id="selectAll">
                                            <label for="selectAll"></label>
                                        </div>
                                    </th>
                                    <th style="width: 60px;">ID</th>
                                    <th style="width: 80px;">Image</th>
                                    <th>Product Name</th>
                                    <th style="width: 120px;">SKU</th>
                                    <th style="width: 100px;">Price</th>
                                    <th style="width: 80px;">Stock</th>
                                    <th style="width: 100px;">Status</th>
                                    <th style="width: 180px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                    <tr>
                                        <td>
                                            <div class="icheck-primary">
                                                <input type="checkbox" id="check{{ $product->id }}" class="product-checkbox">
                                                <label for="check{{ $product->id }}"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-light">#{{ $product->id }}</span>
                                        </td>
                                        <td>
                                            @if($product->primaryImage)
                                                <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}"
                                                     alt="{{ $product->name }}"
                                                     class="product-image"
                                                     width="50" height="50">
                                            @else
                                                <div class="bg-light d-flex align-items-center justify-content-center"
                                                     style="width: 50px; height: 50px; border-radius: 8px;">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <div>
                                                <strong>{{ $product->name }}</strong>
                                                @if($product->description)
                                                    <br>
                                                    <small class="text-muted">{{ Str::limit($product->description, 50) }}</small>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <code class="bg-light px-2 py-1 rounded">{{ $product->sku }}</code>
                                        </td>
                                        <td>
                                            <span class="font-weight-bold text-success">
                                                ${{ number_format($product->price, 2) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($product->stock_quantity > 10)
                                                <span class="badge badge-success">{{ $product->stock_quantity }}</span>
                                            @elseif($product->stock_quantity > 0)
                                                <span class="badge badge-warning">{{ $product->stock_quantity }}</span>
                                            @else
                                                <span class="badge badge-danger">Out of Stock</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($product->is_active)
                                                <span class="badge badge-success">
                                                    <i class="fas fa-check mr-1"></i>Active
                                                </span>
                                            @else
                                                <span class="badge badge-secondary">
                                                    <i class="fas fa-times mr-1"></i>Inactive
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('products.show', $product->id) }}"
                                                   class="btn btn-info btn-sm"
                                                   data-toggle="tooltip"
                                                   title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('products.edit', $product->id) }}"
                                                   class="btn btn-warning btn-sm"
                                                   data-toggle="tooltip"
                                                   title="Edit Product">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button"
                                                        class="btn btn-danger btn-sm"
                                                        data-toggle="modal"
                                                        data-target="#deleteModal{{ $product->id }}"
                                                        title="Delete Product">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>

                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Confirm Delete</h4>
                                                            <button type="button" class="close" data-dismiss="modal">
                                                                <span>&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to delete <strong>{{ $product->name }}</strong>?</p>
                                                            <p class="text-muted">This action cannot be undone.</p>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">
                                                                    <i class="fas fa-trash mr-2"></i>Delete
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-box-open fa-3x mb-3"></i>
                                                <h5>No products found</h5>
                                                <p>Start by creating your first product.</p>
                                                <a href="{{ route('products.create') }}" class="btn btn-primary">
                                                    <i class="fas fa-plus mr-2"></i>Add Product
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                @if($products->hasPages())
                    <div class="card-footer clearfix">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <small class="text-muted">
                                    Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} results
                                </small>
                            </div>
                            <div class="col-md-6">
                                {{ $products->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection
