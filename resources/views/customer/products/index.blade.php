@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="container py-5">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">Our Products</h2>
            <p class="text-muted">Browse our complete product catalog</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body">
            <form method="GET" action="{{ route('products.index') }}" class="row g-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text"
                               name="search"
                               class="form-control"
                               placeholder="Search products..."
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <select name="category" class="form-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                        @if(request()->anyFilled(['search', 'category']))
                        <a href="{{ route('products.index') }}" class="btn btn-light">
                            <i class="bi bi-x"></i>
                        </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Products Grid -->
    @if($products->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-box-seam" style="font-size:4rem; color:#cbd5e0;"></i>
            <h5 class="mt-3 text-muted">No products found</h5>
            <p class="text-muted">Try adjusting your search or filters</p>
        </div>
    @else
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 g-4">
            @foreach($products as $product)
            <div class="col">
                <div class="product-card card h-100">
                    <a href="{{ route('products.show', $product) }}">
                        @if($product->image)
                            <img src="{{ asset('storage/'.$product->image) }}"
                                 alt="{{ $product->name }}">
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-light"
                                 style="height:220px;">
                                <i class="bi bi-image text-muted" style="font-size:3rem;"></i>
                            </div>
                        @endif
                    </a>
                    <div class="card-body d-flex flex-column">
                        <span class="badge bg-light text-dark mb-2" style="width:fit-content;">
                            {{ $product->category->name }}
                        </span>
                        <h6 class="card-title fw-semibold mb-1">
                            <a href="{{ route('products.show', $product) }}"
                               class="text-decoration-none text-dark">
                                {{ $product->name }}
                            </a>
                        </h6>
                        <p class="card-text text-muted small mb-3 flex-grow-1">
                            {{ Str::limit($product->description, 60) }}
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="price-badge">${{ number_format($product->price, 2) }}</span>
                            <a href="{{ route('products.show', $product) }}"
                               class="btn btn-sm btn-outline-primary">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-5 d-flex justify-content-center">
            {{ $products->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection