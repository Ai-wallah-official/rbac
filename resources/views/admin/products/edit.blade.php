@extends('layouts.admin')

@section('title', 'Edit Product')
@section('page-title', 'Edit Product')
@section('page-subtitle', $product->name)

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
<style>
    .image-upload-area {
        border: 2px dashed #cbd5e0;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
        background: #f8fafc;
    }
    .image-upload-area:hover { border-color: #4f46e5; background: #f0f0ff; }
    #cropperContainer { max-height: 400px; overflow: hidden; }
</style>
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.products.update', $product) }}" id="productForm">
                    @csrf @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-medium">Product Name <span class="text-danger">*</span></label>
                            <input type="text"
                                   name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $product->name) }}"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-medium">Price <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number"
                                       name="price"
                                       class="form-control @error('price') is-invalid @enderror"
                                       value="{{ old('price', $product->price) }}"
                                       step="0.01"
                                       min="0"
                                       required>
                            </div>
                            @error('price')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-medium">Category <span class="text-danger">*</span></label>
                            <select name="category_id"
                                    class="form-select @error('category_id') is-invalid @enderror"
                                    required>
                                <option value="">Select category...</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-medium">Status</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox"
                                       name="is_active" id="isActive" value="1"
                                       {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="isActive">Active</label>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-medium">Description</label>
                            <textarea name="description"
                                      class="form-control @error('description') is-invalid @enderror"
                                      rows="4">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-medium">Product Image</label>
                            <input type="hidden" name="image" id="croppedImageData">

                            <!-- Current Image -->
                            @if($product->image)
                            <div class="mb-3" id="currentImageBox">
                                <p class="text-muted small mb-1">Current image:</p>
                                <img src="{{ asset('storage/'.$product->image) }}"
                                     style="height:120px; border-radius:8px;" alt="Current">
                            </div>
                            @endif

                            <div class="image-upload-area" id="uploadArea"
                                 onclick="document.getElementById('imageInput').click()">
                                <i class="bi bi-cloud-upload fs-1 text-muted"></i>
                                <p class="mb-1 fw-medium">
                                    {{ $product->image ? 'Click to replace image' : 'Click to upload image' }}
                                </p>
                                <p class="text-muted small mb-0">Image will be cropped before saving</p>
                            </div>

                            <input type="file" id="imageInput" accept="image/*" class="d-none">

                            <div id="preview-container" class="mt-3" style="display:none;">
                                <div class="d-flex align-items-center gap-3">
                                    <img id="imagePreview" src="" alt="Preview"
                                         style="height:100px; border-radius:8px;">
                                    <div>
                                        <p class="mb-1 fw-medium text-success">
                                            <i class="bi bi-check-circle"></i> New image ready
                                        </p>
                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                                onclick="openCropModal()">
                                            <i class="bi bi-crop"></i> Re-crop
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                                onclick="clearImage()">
                                            <i class="bi bi-x"></i> Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-light">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg"></i> Update Product
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Crop Modal -->
<div class="modal fade" id="cropModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-crop"></i> Crop Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="cropperContainer">
                    <img id="cropperImage" src="" alt="Crop">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="applyCrop()">
                    <i class="bi bi-check-lg"></i> Apply Crop
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
<script>
let cropper = null;
let originalImageSrc = null;
const cropModal = new bootstrap.Modal(document.getElementById('cropModal'));

document.getElementById('imageInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(e) {
        originalImageSrc = e.target.result;
        openCropModal();
    };
    reader.readAsDataURL(file);
});

function openCropModal() {
    const cropperImage = document.getElementById('cropperImage');
    cropperImage.src = originalImageSrc;
    cropModal.show();
    document.getElementById('cropModal').addEventListener('shown.bs.modal', function initCropper() {
        if (cropper) { cropper.destroy(); }
        cropper = new Cropper(cropperImage, { aspectRatio: 1, viewMode: 1, autoCropArea: 0.9 });
        document.getElementById('cropModal').removeEventListener('shown.bs.modal', initCropper);
    }, { once: true });
}

function applyCrop() {
    if (!cropper) return;
    const canvas = cropper.getCroppedCanvas({ width: 800, height: 800, imageSmoothingQuality: 'high' });
    const base64 = canvas.toDataURL('image/jpeg', 0.85);
    document.getElementById('croppedImageData').value = base64;
    document.getElementById('imagePreview').src = base64;
    document.getElementById('preview-container').style.display = 'block';
    document.getElementById('uploadArea').style.display = 'none';
    const currentBox = document.getElementById('currentImageBox');
    if (currentBox) currentBox.style.display = 'none';
    cropper.destroy(); cropper = null;
    cropModal.hide();
}

function clearImage() {
    document.getElementById('croppedImageData').value = '';
    document.getElementById('imageInput').value = '';
    document.getElementById('imagePreview').src = '';
    document.getElementById('preview-container').style.display = 'none';
    document.getElementById('uploadArea').style.display = 'block';
    originalImageSrc = null;
}
</script>
@endpush