@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('products.index') }}">Products</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('products.index', ['category' => $product->category_id]) }}">
                    {{ $product->category->name }}
                </a>
            </li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-5">
        <div class="col-md-5">
            @if($product->image)
                <img src="{{ asset('storage/'.$product->image) }}"
                     class="img-fluid rounded-3 shadow" alt="{{ $product->name }}">
            @else
                <div class="d-flex align-items-center justify-content-center bg-light rounded-3"
                     style="height:350px;">
                    <i class="bi bi-image text-muted" style="font-size:5rem;"></i>
                </div>
            @endif
        </div>

        <div class="col-md-7">
            <span class="badge bg-primary mb-2">{{ $product->category->name }}</span>
            <h2 class="fw-bold mb-2">{{ $product->name }}</h2>
            <div class="fs-2 fw-bold text-primary mb-4">
                ${{ number_format($product->price, 2) }}
            </div>

            <div class="mb-4">
                <h6 class="fw-semibold mb-2">Description</h6>
                <p class="text-muted">{{ $product->description ?? 'No description available.' }}</p>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-sm-6">
                    <div class="bg-light rounded p-3">
                        <div class="text-muted small mb-1">Category</div>
                        <div class="fw-medium">{{ $product->category->name }}</div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="bg-light rounded p-3">
                        <div class="text-muted small mb-1">Availability</div>
                        <div class="fw-medium text-success">
                            <i class="bi bi-check-circle"></i> In Stock
                        </div>
                    </div>
                </div>
            </div>

            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to Products
            </a>
        </div>
    </div>

    <!-- Related Products -->
    @if($related->count() > 0)
    <div class="mt-5">
        <h4 class="fw-bold mb-4">Related Products</h4>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
            @foreach($related as $relProduct)
            <div class="col">
                <div class="product-card card h-100">
                    <a href="{{ route('products.show', $relProduct) }}">
                        @if($relProduct->image)
                            <img src="{{ asset('storage/'.$relProduct->image) }}"
                                 alt="{{ $relProduct->name }}">
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-light"
                                 style="height:180px;">
                                <i class="bi bi-image text-muted" style="font-size:2rem;"></i>
                            </div>
                        @endif
                    </a>
                    <div class="card-body">
                        <h6 class="card-title fw-semibold">
                            <a href="{{ route('products.show', $relProduct) }}"
                               class="text-decoration-none text-dark">
                                {{ $relProduct->name }}
                            </a>
                        </h6>
                        <div class="price-badge">${{ number_format($relProduct->price, 2) }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection