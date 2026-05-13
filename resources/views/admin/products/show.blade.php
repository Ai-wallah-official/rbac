@extends('layouts.admin')

@section('title', $product->name)
@section('page-title', $product->name)
@section('page-subtitle', 'Product Details')

@section('content')
<div class="row g-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body p-0">
                @if($product->image)
                    <img src="{{ asset('storage/'.$product->image) }}"
                         class="img-fluid rounded" alt="{{ $product->name }}">
                @else
                    <div class="d-flex align-items-center justify-content-center bg-light rounded"
                         style="height:280px;">
                        <i class="bi bi-image text-muted" style="font-size:4rem;"></i>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h4 class="fw-bold mb-1">{{ $product->name }}</h4>
                        <span class="badge bg-light text-dark">{{ $product->category->name }}</span>
                    </div>
                    <div class="d-flex gap-2">
                        @can('edit products')
                        <a href="{{ route('admin.products.edit', $product) }}"
                           class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        @endcan
                        @can('delete products')
                        <form method="POST"
                              action="{{ route('admin.products.destroy', $product) }}"
                              onsubmit="return confirm('Delete this product?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                        @endcan
                    </div>
                </div>

                <div class="fs-3 fw-bold text-primary mb-3">
                    ${{ number_format($product->price, 2) }}
                </div>

                <p class="text-muted mb-4">{{ $product->description ?? 'No description provided.' }}</p>

                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="bg-light rounded p-3">
                            <div class="text-muted small">Status</div>
                            @if($product->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="bg-light rounded p-3">
                            <div class="text-muted small">Added By</div>
                            <div class="fw-medium">{{ $product->creator->name }}</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="bg-light rounded p-3">
                            <div class="text-muted small">Created</div>
                            <div class="fw-medium">{{ $product->created_at->format('M d, Y') }}</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="bg-light rounded p-3">
                            <div class="text-muted small">Last Updated</div>
                            <div class="fw-medium">{{ $product->updated_at->format('M d, Y') }}</div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-light">
                        <i class="bi bi-arrow-left"></i> Back to Products
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection