@extends('backend.layout.app')
@section('title', 'Brands Management')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Brands Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Brands</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-tags"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Brands</span>
                            <span class="info-box-number">{{ $brands->total() }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-check-circle"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Active Brands</span>
                            <span class="info-box-number">{{ $brands->where('is_active', 1)->count() }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-pause-circle"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Inactive Brands</span>
                            <span class="info-box-number">{{ $brands->where('is_active', 0)->count() }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-image"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">With Logo</span>
                            <span class="info-box-number">{{ $brands->whereNotNull('logo')->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-tags mr-1"></i>
                        All Brands
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('brands.create') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> Create New Brand
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Search and Filter Bar -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                                <input type="text" class="form-control" placeholder="Search brands..." id="searchBrands">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control" id="statusFilter">
                                <option value="">All Status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control" id="logoFilter">
                                <option value="">All Brands</option>
                                <option value="with-logo">With Logo</option>
                                <option value="without-logo">Without Logo</option>
                            </select>
                        </div>
                    </div>

                    <!-- Brands Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="brandsTable">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Brand Name</th>
                                    <th style="width: 80px">Logo</th>
                                    <th style="width: 100px">Status</th>
                                    <th style="width: 200px">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($brands as $brand)
                                    <tr>
                                        <td>{{ $brand->id }}</td>
                                        <td>
                                            <strong>{{ $brand->name }}</strong>
                                            @if($brand->description)
                                                <br><small class="text-muted">{{ Str::limit($brand->description, 50) }}</small>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($brand->logo)
                                                <img src="{{ asset('storage/' . $brand->logo) }}"
                                                     alt="{{ $brand->name }}"
                                                     class="brand-image img-circle elevation-3"
                                                     width="40" height="40"
                                                     data-toggle="tooltip"
                                                     title="{{ $brand->name }}">
                                            @else
                                                <span class="badge badge-light">
                                                    <i class="fas fa-image text-muted"></i>
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($brand->is_active)
                                                <span class="badge badge-success">
                                                    <i class="fas fa-check-circle"></i> Active
                                                </span>
                                            @else
                                                <span class="badge badge-warning">
                                                    <i class="fas fa-pause-circle"></i> Inactive
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">

                                                <a href="{{ route('brands.edit', $brand->id) }}"
                                                   class="btn btn-warning btn-sm"
                                                   data-toggle="tooltip"
                                                   title="Edit Brand">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button"
                                                        class="btn btn-danger btn-sm"
                                                        data-toggle="modal"
                                                        data-target="#deleteModal{{ $brand->id }}"
                                                        title="Delete Brand">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>

                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="deleteModal{{ $brand->id }}" tabindex="-1">
                                                <div class="modal-dialog modal-sm">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Confirm Delete</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to delete <strong>{{ $brand->name }}</strong>?</p>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                            <form action="{{ route('brands.destroy', $brand->id) }}" method="POST" style="display: inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">Delete</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            <div class="py-4">
                                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                                <h5 class="text-muted">No brands found</h5>
                                                <p class="text-muted">Get started by creating your first brand.</p>
                                                <a href="{{ route('brands.create') }}" class="btn btn-primary">
                                                    <i class="fas fa-plus"></i> Create Brand
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($brands->hasPages())
                    <div class="card-footer clearfix">
                        <div class="float-right">
                            {{ $brands->appends(request()->query())->links() }}
                        </div>
                        <div class="float-left">
                            <small class="text-muted">
                                Showing {{ $brands->firstItem() }} to {{ $brands->lastItem() }} of {{ $brands->total() }} results
                            </small>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // Search functionality
    $('#searchBrands').on('keyup', function() {
        const value = $(this).val().toLowerCase();
        $('#brandsTable tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    // Status filter
    $('#statusFilter').on('change', function() {
        const value = $(this).val();
        $('#brandsTable tbody tr').show();

        if (value !== '') {
            $('#brandsTable tbody tr').each(function() {
                const status = $(this).find('.badge').hasClass('badge-success') ? '1' : '0';
                if (status !== value) {
                    $(this).hide();
                }
            });
        }
    });

    // Logo filter
    $('#logoFilter').on('change', function() {
        const value = $(this).val();
        $('#brandsTable tbody tr').show();

        if (value === 'with-logo') {
            $('#brandsTable tbody tr').each(function() {
                if ($(this).find('img').length === 0) {
                    $(this).hide();
                }
            });
        } else if (value === 'without-logo') {
            $('#brandsTable tbody tr').each(function() {
                if ($(this).find('img').length > 0) {
                    $(this).hide();
                }
            });
        }
    });
});
</script>
@endpush
@endsection
