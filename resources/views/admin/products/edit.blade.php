@extends('admin.layout')

@section('title', 'Edit Product')
@section('page-title', 'Edit Product')

@section('content')
<style>
    /* ==================== PAGE HEADER ==================== */
    .prod-header {
        background: linear-gradient(135deg, #3F51B5, #5C6BC0, #7986CB);
        border-radius: 20px;
        padding: 1.75rem 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .prod-header::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(circle at 20% 30%, rgba(255,255,255,0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 70%, rgba(255,255,255,0.06) 0%, transparent 50%);
    }

    .prod-header::after {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            radial-gradient(circle at 30% 40%, rgba(255,255,255,0.07) 1px, transparent 1px),
            radial-gradient(circle at 70% 60%, rgba(255,255,255,0.05) 1px, transparent 1px);
        background-size: 60px 60px, 80px 80px;
    }

    .prod-header-content {
        position: relative;
        z-index: 1;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .prod-header-left h1 {
        color: white;
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0 0 0.25rem;
        letter-spacing: -0.3px;
    }

    .prod-header-left h1 i { margin-right: 0.4rem; }

    .prod-header-left p {
        color: rgba(255,255,255,0.8);
        margin: 0;
        font-size: 0.85rem;
    }

    .prod-header-right {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .prod-btn-back {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.6rem 1.4rem;
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 100px;
        color: white;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.25s ease;
    }

    .prod-btn-back:hover {
        background: rgba(255,255,255,0.25);
        color: white;
        transform: translateY(-2px);
    }

    /* ==================== FORM CARD ==================== */
    .prod-form-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        border: none;
        overflow: hidden;
    }

    .prod-form-card .card-head {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #F0F0F5;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .prod-form-card .card-head h5 {
        margin: 0;
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-dark);
    }

    .prod-form-card .card-head i { color: #3F51B5; }

    .prod-form-card .card-body {
        padding: 1.5rem;
    }

    /* ==================== FORM ELEMENTS ==================== */
    .prod-form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .prod-form-row.single { grid-template-columns: 1fr; }

    .prod-form-group { margin-bottom: 0; }

    .prod-label {
        display: block;
        font-size: 0.82rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.4rem;
    }

    .prod-label .required { color: #EF4444; margin-left: 0.15rem; }

    .prod-label i {
        color: #3F51B5;
        margin-right: 0.3rem;
        font-size: 0.78rem;
    }

    .prod-input {
        width: 100%;
        padding: 0.65rem 1rem;
        border: 1.5px solid #E8E8EF;
        border-radius: 12px;
        font-size: 0.9rem;
        color: var(--text-dark);
        background: #FAFAFE;
        transition: all 0.2s ease;
        outline: none;
    }

    .prod-input:focus {
        border-color: #3F51B5;
        background: white;
        box-shadow: 0 0 0 3px rgba(63, 81, 181, 0.08);
    }

    .prod-input::placeholder { color: #BBB; }

    select.prod-input {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23636E72' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        padding-right: 2.2rem;
    }

    textarea.prod-input {
        resize: vertical;
        min-height: 100px;
        font-family: inherit;
    }

    .prod-file-input .prod-input {
        padding-top: 0.6rem;
        padding-bottom: 0.6rem;
    }

    .prod-file-input .prod-input::file-selector-button,
    .prod-file-input .prod-input::-webkit-file-upload-button,
    .prod-file-input .prod-input::file-upload-button {
        padding: 0.35rem 0.9rem;
        border: none;
        border-radius: 8px;
        background: #E8EAF6;
        color: #3F51B5;
        font-weight: 600;
        font-size: 0.78rem;
        cursor: pointer;
        margin-right: 0.75rem;
        transition: all 0.2s ease;
    }

    .prod-file-input .prod-input::file-selector-button:hover,
    .prod-file-input .prod-input::-webkit-file-upload-button:hover,
    .prod-file-input .prod-input::file-upload-button:hover {
        background: #3F51B5;
        color: white;
    }

    .prod-hint {
        font-size: 0.75rem;
        color: var(--text-muted);
        margin-top: 0.35rem;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    .prod-hint i { font-size: 0.7rem; opacity: 0.6; }

    /* ==================== IMAGE PREVIEW ==================== */
    .prod-image-section {
        margin-top: 1rem;
        padding: 1.25rem;
        background: #F8F9FE;
        border-radius: 12px;
        border: 1.5px dashed #E0E0E8;
    }

    .prod-image-section-title {
        font-size: 0.82rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .prod-image-section-title i { color: #3F51B5; font-size: 0.78rem; }

    .prod-image-current {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .prod-image-current img {
        width: 80px;
        height: 80px;
        border-radius: 12px;
        object-fit: cover;
        border: 2px solid white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }

    .prod-image-current .no-img-icon {
        width: 80px;
        height: 80px;
        border-radius: 12px;
        background: #F0F0F5;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #CCC;
        font-size: 1.8rem;
    }

    .prod-image-current .img-info {
        font-size: 0.82rem;
        color: var(--text-muted);
    }

    .prod-image-current .img-info strong {
        color: var(--text-dark);
        display: block;
        font-weight: 600;
        margin-bottom: 0.15rem;
    }

    /* ==================== SUBMIT BUTTON ==================== */
    .prod-btn-submit {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 2rem;
        background: linear-gradient(135deg, #3F51B5, #5C6BC0);
        border: none;
        border-radius: 12px;
        color: white;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.25s ease;
        margin-top: 0.5rem;
    }

    .prod-btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(63, 81, 181, 0.3);
    }

    .prod-btn-submit:active { transform: translateY(0); }
    .prod-btn-submit i { font-size: 1rem; }

    /* ==================== ANIMATION ==================== */
    @keyframes fadeSlideUp {
        from { opacity: 0; transform: translateY(12px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .prod-header, .prod-form-card {
        animation: fadeSlideUp 0.4s ease both;
    }

    .prod-form-card { animation-delay: 0.05s; }
</style>

{{-- ==================== PAGE HEADER ==================== --}}
<div class="prod-header">
    <div class="prod-header-content">
        <div class="prod-header-left">
            <h1><i class="bi bi-pencil-square"></i>Edit Product</h1>
            <p>Updating "{{ $product->name }}".</p>
        </div>
        <div class="prod-header-right">
            <a href="{{ route('admin.products.index') }}" class="prod-btn-back">
                <i class="bi bi-arrow-left"></i>
                <span>Back</span>
            </a>
        </div>
    </div>
</div>

{{-- ==================== FORM ==================== --}}
<div class="prod-form-card">
    <div class="card-head">
        <i class="bi bi-info-circle-fill"></i>
        <h5>Edit Product Details</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="prod-form-row">
                <div class="prod-form-group">
                    <label for="name" class="prod-label">
                        <i class="bi bi-box-seam-fill"></i>Name<span class="required">*</span>
                    </label>
                    <input id="name" type="text" name="name" class="prod-input"
                           value="{{ old('name', $product->name) }}" placeholder="e.g. Wireless Headphones" required>
                    <div class="prod-hint"><i class="bi bi-info-circle"></i>Product title customers will see.</div>
                </div>

                <div class="prod-form-group">
                    <label for="category_id" class="prod-label">
                        <i class="bi bi-tags-fill"></i>Category<span class="required">*</span>
                    </label>
                    <select id="category_id" name="category_id" class="prod-input" required>
                        <option value="">Select a category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="prod-hint"><i class="bi bi-info-circle"></i>Which category does this belong to?</div>
                </div>
            </div>

            <div class="prod-form-row">
                <div class="prod-form-group">
                    <label for="price" class="prod-label">
                        <i class="bi bi-currency-dollar"></i>Price<span class="required">*</span>
                    </label>
                    <input id="price" type="number" name="price" step="0.01" min="0" class="prod-input"
                           value="{{ old('price', $product->price) }}" placeholder="0.00" required>
                    <div class="prod-hint"><i class="bi bi-info-circle"></i>Selling price in USD.</div>
                </div>

                <div class="prod-form-group">
                    <label for="stock" class="prod-label">
                        <i class="bi bi-boxes"></i>Stock<span class="required">*</span>
                    </label>
                    <input id="stock" type="number" name="stock" min="0" class="prod-input"
                           value="{{ old('stock', $product->stock) }}" placeholder="0" required>
                    <div class="prod-hint"><i class="bi bi-info-circle"></i>Quantity available for sale.</div>
                </div>
            </div>

            <div class="prod-form-row single">
                <div class="prod-form-group">
                    <label for="description" class="prod-label">
                        <i class="bi bi-text-paragraph"></i>Description
                    </label>
                    <textarea id="description" name="description" class="prod-input" rows="4"
                              placeholder="Describe your product's features, specifications, and details...">{{ old('description', $product->description) }}</textarea>
                    <div class="prod-hint"><i class="bi bi-info-circle"></i>Optional. Helps customers learn more about the product.</div>
                </div>
            </div>

            <div class="prod-form-row single">
                <div class="prod-form-group">
                    <label for="image" class="prod-label">
                        <i class="bi bi-image"></i>Product Image
                    </label>

                    <div class="prod-image-section">
                        <div class="prod-image-section-title">
                            <i class="bi bi-camera"></i> Current Image
                        </div>
                        <div class="prod-image-current">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                <div class="img-info">
                                    <strong>Current image</strong>
                                    Upload a new image below to replace it.
                                </div>
                            @else
                                <div class="no-img-icon"><i class="bi bi-image"></i></div>
                                <div class="img-info">
                                    <strong>No image</strong>
                                    No image is currently set. Upload one below.
                                </div>
                            @endif
                        </div>
                    </div>

                    <div style="margin-top: 0.75rem;">
                        <div class="prod-file-input">
                            <input id="image" type="file" name="image" class="prod-input"
                                   accept="image/jpg,image/jpeg,image/png,image/webp">
                        </div>
                        <div class="prod-hint"><i class="bi bi-info-circle"></i>JPG, PNG, or WebP. Max 2MB. Leave blank to keep current image.</div>
                    </div>
                </div>
            </div>

            <button type="submit" class="prod-btn-submit">
                <i class="bi bi-check-lg"></i>
                Update Product
            </button>
        </form>
    </div>
</div>
@endsection
