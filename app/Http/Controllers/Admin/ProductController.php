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
        $data               = $request->validated();
        $data['created_by'] = auth()->id();

        // Handle checkbox — if not submitted it won't exist in request
        $data['is_active']  = $request->has('is_active') ? 1 : 0;

        // Only process image if a real base64 string was submitted
        if ($request->filled('image') && $this->isValidBase64Image($request->image)) {
            $data['image'] = $this->saveBase64Image($request->image);
        } else {
            // No image submitted — remove from data so it stays null
            unset($data['image']);
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
        $data = $request->validated();

        // Fix Bug 1: Handle checkbox properly
        // Checkbox is only in request when checked, use has() not boolean()
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        // Fix Bug 2: Only update image if a NEW valid base64 image was submitted
        if ($request->filled('image') && $this->isValidBase64Image($request->image)) {
            // Delete old image from storage first
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            // Save the new cropped image
            $data['image'] = $this->saveBase64Image($request->image);
        } else {
            // No new image submitted — keep the existing image
            // Remove image key entirely so update() won't touch it
            unset($data['image']);
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

    /**
     * Check if the submitted string is a real base64 image
     * and not an empty string or junk value
     */
    private function isValidBase64Image(string $value): bool
    {
        // Must start with data URI or be a long base64 string
        if (str_starts_with($value, 'data:image')) {
            return true;
        }

        // Raw base64 — must be at least 100 chars to be a real image
        return strlen($value) >= 100;
    }

    /**
     * Decode base64 image string and save to storage
     */
    private function saveBase64Image(string $base64String): string
    {
        // Strip the data URI prefix if present (data:image/jpeg;base64,...)
        if (str_contains($base64String, ',')) {
            [, $base64String] = explode(',', $base64String);
        }

        $imageData = base64_decode($base64String);
        $fileName  = 'products/' . Str::uuid() . '.jpg';

        Storage::disk('public')->put($fileName, $imageData);

        return $fileName;
    }
}