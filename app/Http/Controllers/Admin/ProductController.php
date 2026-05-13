<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category', 'creator')
                           ->latest()
                           ->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request)
    {
        $data             = $request->validated();
        $data['created_by'] = auth()->id();
        $data['is_active']  = $request->boolean('is_active', true);

        if ($request->filled('image')) {
            $data['image'] = $this->saveBase64Image($request->image);
        }

        Product::create($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        $product->load('category', 'creator');
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $data              = $request->validated();
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->filled('image')) {
            // Delete old image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $this->saveBase64Image($request->image);
        }

        $product->update($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    private function saveBase64Image(string $base64String): string
    {
        // Strip data URI prefix
        if (str_contains($base64String, ',')) {
            [, $base64String] = explode(',', $base64String);
        }

        $imageData  = base64_decode($base64String);
        $fileName   = 'products/' . Str::uuid() . '.jpg';

        Storage::disk('public')->put($fileName, $imageData);

        return $fileName;
    }
}