@extends('layouts.admin')

@section('title', 'Categories')
@section('page-title', 'Categories')
@section('page-subtitle', 'Manage product categories')

@section('content')
<div class="card">
    <div class="card-header bg-white border-0 pt-4 px-4 pb-3 d-flex justify-content-between align-items-center">
        <h6 class="fw-semibold mb-0">All Categories
            <span class="badge bg-primary ms-2">{{ $categories->total() }}</span>
        </h6>
        @can('create categories')
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg"></i> Add Category
        </a>
        @endcan
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Description</th>
                        <th>Products</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr>
                        <td class="text-muted small">{{ $category->id }}</td>
                        <td class="fw-medium">{{ $category->name }}</td>
                        <td><code>{{ $category->slug }}</code></td>
                        <td class="text-muted small">{{ Str::limit($category->description, 50) }}</td>
                        <td>
                            <span class="badge bg-light text-dark">
                                {{ $category->products_count }} products
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                @can('edit categories')
                                <a href="{{ route('admin.categories.edit', $category) }}"
                                   class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @endcan
                                @can('delete categories')
                                <form method="POST"
                                      action="{{ route('admin.categories.destroy', $category) }}"
                                      onsubmit="return confirm('Delete this category?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            <i class="bi bi-tags fs-1 d-block mb-2"></i>
                            No categories found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $categories->links() }}</div>
    </div>
</div>
@endsection