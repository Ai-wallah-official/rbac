@extends('layouts.admin')

@section('title', 'Products')
@section('page-title', 'Products')
@section('page-subtitle', 'Manage your product catalog')

@section('content')
<div class="card">
    <div class="card-header bg-white border-0 pt-4 px-4 pb-3 d-flex justify-content-between align-items-center">
        <h6 class="fw-semibold mb-0">All Products
            <span class="badge bg-primary ms-2">{{ $products->total() }}</span>
        </h6>
        @can('create products')
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg"></i> Add Product
        </a>
        @endcan
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Added By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td class="text-muted small">{{ $product->id }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                @if($product->image)
                                    <img src="{{ asset('storage/'.$product->image) }}"
                                         class="avatar" alt="{{ $product->name }}">
                                @else
                                    <div class="avatar bg-light d-flex align-items-center justify-content-center">
                                        <i class="bi bi-image text-muted"></i>
                                    </div>
                                @endif
                                <div>
                                    <div class="fw-medium">{{ $product->name }}</div>
                                    <div class="text-muted small">
                                        {{ Str::limit($product->description, 40) }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark">{{ $product->category->name }}</span>
                        </td>
                        <td class="fw-semibold text-primary">${{ number_format($product->price, 2) }}</td>
                        <td>
                            @if($product->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td class="text-muted small">{{ $product->creator->name }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.products.show', $product) }}"
                                   class="btn btn-sm btn-light" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @can('edit products')
                                <a href="{{ route('admin.products.edit', $product) }}"
                                   class="btn btn-sm btn-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @endcan
                                @can('delete products')
                                <form method="POST"
                                      action="{{ route('admin.products.destroy', $product) }}"
                                      onsubmit="return confirm('Delete this product?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="bi bi-box-seam fs-1 d-block mb-2"></i>
                            No products found.
                            @can('create products')
                            <a href="{{ route('admin.products.create') }}">Add one now</a>
                            @endcan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection