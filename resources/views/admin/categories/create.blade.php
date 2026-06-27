@extends('admin.layout')

@section('title', 'Create Category')
@section('page-title', 'Create Category')

@section('content')
<style>
    /* ==================== PAGE HEADER ==================== */
    .cat-header {
        background: linear-gradient(135deg, #E91E63, #FF6B9D, #FF9E80);
        border-radius: 20px;
        padding: 1.75rem 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .cat-header::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(circle at 20% 30%, rgba(255,255,255,0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 70%, rgba(255,255,255,0.06) 0%, transparent 50%);
    }

    .cat-header::after {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            radial-gradient(circle at 30% 40%, rgba(255,255,255,0.07) 1px, transparent 1px),
            radial-gradient(circle at 70% 60%, rgba(255,255,255,0.05) 1px, transparent 1px);
        background-size: 60px 60px, 80px 80px;
    }

    .cat-header-content {
        position: relative;
        z-index: 1;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .cat-header-left h1 {
        color: white;
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0 0 0.25rem;
        letter-spacing: -0.3px;
    }

    .cat-header-left h1 i {
        margin-right: 0.4rem;
    }

    .cat-header-left p {
        color: rgba(255,255,255,0.8);
        margin: 0;
        font-size: 0.85rem;
    }

    .cat-header-right {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .cat-btn-back {
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

    .cat-btn-back:hover {
        background: rgba(255,255,255,0.25);
        color: white;
        transform: translateY(-2px);
    }

    /* ==================== FORM CARD ==================== */
    .cat-form-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        border: none;
        overflow: hidden;
    }

    .cat-form-card .card-head {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #F0F0F5;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .cat-form-card .card-head h5 {
        margin: 0;
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-dark);
    }

    .cat-form-card .card-head i {
        color: #E91E63;
    }

    .cat-form-card .card-body {
        padding: 1.5rem;
    }

    /* ==================== FORM ELEMENTS ==================== */
    .cat-form-group {
        margin-bottom: 1.25rem;
    }

    .cat-form-group:last-of-type {
        margin-bottom: 1.5rem;
    }

    .cat-label {
        display: block;
        font-size: 0.82rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.45rem;
    }

    .cat-label .required {
        color: #EF4444;
        margin-left: 0.15rem;
    }

    .cat-label i {
        color: #E91E63;
        margin-right: 0.3rem;
        font-size: 0.78rem;
    }

    .cat-input {
        width: 100%;
        padding: 0.7rem 1rem;
        border: 1.5px solid #E8E8EF;
        border-radius: 12px;
        font-size: 0.9rem;
        color: var(--text-dark);
        background: #FAFAFE;
        transition: all 0.2s ease;
        outline: none;
    }

    .cat-input:focus {
        border-color: #E91E63;
        background: white;
        box-shadow: 0 0 0 3px rgba(233, 30, 99, 0.08);
    }

    .cat-input::placeholder {
        color: #BBB;
    }

    textarea.cat-input {
        resize: vertical;
        min-height: 100px;
        font-family: inherit;
    }

    .cat-hint {
        font-size: 0.75rem;
        color: var(--text-muted);
        margin-top: 0.35rem;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    .cat-hint i {
        font-size: 0.7rem;
        opacity: 0.6;
    }

    /* ==================== SUBMIT BUTTON ==================== */
    .cat-btn-submit {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 2rem;
        background: linear-gradient(135deg, #E91E63, #FF6B9D);
        border: none;
        border-radius: 12px;
        color: white;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.25s ease;
    }

    .cat-btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(233, 30, 99, 0.3);
    }

    .cat-btn-submit:active {
        transform: translateY(0);
    }

    .cat-btn-submit i {
        font-size: 1rem;
    }

    /* ==================== ANIMATION ==================== */
    @keyframes fadeSlideUp {
        from { opacity: 0; transform: translateY(12px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .cat-header, .cat-form-card {
        animation: fadeSlideUp 0.4s ease both;
    }

    .cat-form-card {
        animation-delay: 0.05s;
    }
</style>

{{-- ==================== PAGE HEADER ==================== --}}
<div class="cat-header">
    <div class="cat-header-content">
        <div class="cat-header-left">
            <h1><i class="bi bi-plus-circle-fill"></i>Create Category</h1>
            <p>Add a new category to organize your products.</p>
        </div>
        <div class="cat-header-right">
            <a href="{{ route('admin.categories.index') }}" class="cat-btn-back">
                <i class="bi bi-arrow-left"></i>
                <span>Back</span>
            </a>
        </div>
    </div>
</div>

{{-- ==================== FORM ==================== --}}
<div class="cat-form-card">
    <div class="card-head">
        <i class="bi bi-info-circle-fill"></i>
        <h5>Category Details</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf

            <div class="cat-form-group">
                <label for="name" class="cat-label">
                    <i class="bi bi-tag-fill"></i>Name<span class="required">*</span>
                </label>
                <input id="name"
                       type="text"
                       name="name"
                       class="cat-input"
                       value="{{ old('name') }}"
                       placeholder="e.g. Electronics, Clothing, Home & Garden"
                       required>
                <div class="cat-hint">
                    <i class="bi bi-info-circle"></i>
                    A unique name to identify this category.
                </div>
            </div>

            <div class="cat-form-group">
                <label for="description" class="cat-label">
                    <i class="bi bi-text-paragraph"></i>Description
                </label>
                <textarea id="description"
                          name="description"
                          class="cat-input"
                          placeholder="Briefly describe what products belong in this category..."
                          rows="4">{{ old('description') }}</textarea>
                <div class="cat-hint">
                    <i class="bi bi-info-circle"></i>
                    Optional. Helps customers understand what this category includes.
                </div>
            </div>

            <button type="submit" class="cat-btn-submit">
                <i class="bi bi-check-lg"></i>
                Save Category
            </button>
        </form>
    </div>
</div>
@endsection
