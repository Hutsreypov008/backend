@extends('admin.layout')

@section('title', 'Categories')
@section('page-title', 'Categories')

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

    .cat-btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.6rem 1.4rem;
        background: rgba(255,255,255,0.18);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255,255,255,0.15);
        border-radius: 100px;
        color: white;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.25s ease;
    }

    .cat-btn-primary:hover {
        background: rgba(255,255,255,0.28);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(233, 30, 99, 0.25);
    }

    .cat-btn-primary i {
        font-size: 0.9rem;
    }

    /* ==================== TABLE CARD ==================== */
    .cat-table-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        border: none;
        overflow: hidden;
    }

    .cat-table-card .card-head {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #F0F0F5;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .cat-table-card .card-head h5 {
        margin: 0;
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-dark);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .cat-table-card .card-head h5 i {
        color: #E91E63;
    }

    .cat-table-card .card-head .cat-count-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.3rem 0.85rem;
        background: #FCE4EC;
        color: #E91E63;
        border-radius: 100px;
        font-size: 0.78rem;
        font-weight: 600;
    }

    /* ==================== TABLE ==================== */
    .table-cat {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table-cat thead th {
        background: #F8F9FE;
        padding: 0.85rem 1rem;
        font-size: 0.72rem;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.8px;
        border: none;
        text-align: left;
    }

    .table-cat thead th:first-child { border-radius: 10px 0 0 10px; padding-left: 1.25rem; }
    .table-cat thead th:last-child { border-radius: 0 10px 10px 0; padding-right: 1.25rem; }

    .table-cat tbody tr {
        transition: background 0.2s ease;
    }

    .table-cat tbody tr:hover {
        background: #F8F9FE;
    }

    .table-cat tbody td {
        padding: 1rem;
        border-bottom: 1px solid #F0F0F5;
        font-size: 0.88rem;
        color: var(--text-dark);
        vertical-align: middle;
    }

    .table-cat tbody tr:last-child td:first-child { border-radius: 0 0 0 10px; }
    .table-cat tbody tr:last-child td:last-child { border-radius: 0 0 10px 0; }
    .table-cat tbody tr:last-child td { border-bottom: none; }

    .cat-id-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 10px;
        background: #FCE4EC;
        color: #E91E63;
        font-weight: 700;
        font-size: 0.8rem;
    }

    .cat-name-display {
        font-weight: 600;
        color: var(--text-dark);
    }

    .cat-name-display i {
        color: #E91E63;
        font-size: 0.85rem;
        margin-right: 0.4rem;
    }

    .cat-desc {
        color: var(--text-muted);
        font-size: 0.82rem;
        max-width: 300px;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .cat-desc.empty {
        color: #CCC;
        font-style: italic;
    }

    .cat-product-count {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.25rem 0.65rem;
        background: #F0F0F5;
        border-radius: 100px;
        font-size: 0.78rem;
        font-weight: 600;
        color: var(--text-muted);
    }

    .cat-product-count i {
        font-size: 0.7rem;
        color: #E91E63;
    }

    /* ==================== ACTION BUTTONS ==================== */
    .cat-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 0.4rem;
    }

    .cat-btn-icon {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .cat-btn-icon.edit {
        background: #EEF2FF;
        color: #6C63FF;
    }

    .cat-btn-icon.edit:hover {
        background: #6C63FF;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(108, 99, 255, 0.3);
    }

    .cat-btn-icon.delete {
        background: #FEF2F2;
        color: #EF4444;
    }

    .cat-btn-icon.delete:hover {
        background: #EF4444;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    /* ==================== EMPTY STATE ==================== */
    .cat-empty {
        text-align: center;
        padding: 3rem 1.5rem;
    }

    .cat-empty-icon {
        font-size: 3rem;
        display: block;
        margin-bottom: 0.75rem;
        opacity: 0.3;
    }

    .cat-empty h6 {
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0.3rem;
    }

    .cat-empty p {
        font-size: 0.85rem;
        color: var(--text-muted);
        margin: 0;
    }

    /* ==================== ANIMATION ==================== */
    @keyframes fadeSlideUp {
        from { opacity: 0; transform: translateY(12px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .cat-table-card {
        animation: fadeSlideUp 0.4s ease both;
    }

    .cat-header {
        animation: fadeSlideUp 0.4s ease 0.05s both;
    }
</style>

{{-- ==================== PAGE HEADER ==================== --}}
<div class="cat-header">
    <div class="cat-header-content">
        <div class="cat-header-left">
            <h1><i class="bi bi-tags-fill" style="margin-right: 0.4rem;"></i>Categories</h1>
            <p>Organize your products with categories.</p>
        </div>
        <div class="cat-header-right">
            <a href="{{ route('admin.categories.create') }}" class="cat-btn-primary">
                <i class="bi bi-plus-lg"></i>
                <span>Add Category</span>
            </a>
        </div>
    </div>
</div>

{{-- ==================== CATEGORIES TABLE ==================== --}}
<div class="cat-table-card">
    <div class="card-head">
        <h5>
            <i class="bi bi-grid-3x3-gap-fill"></i>
            All Categories
        </h5>
        <span class="cat-count-badge">
            <i class="bi bi-layers"></i>
            {{ $categories->count() }} total
        </span>
    </div>
    <div class="table-responsive">
        <table class="table-cat">
            <thead>
                <tr>
                    <th style="width: 60px;">#</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th style="width: 100px; text-align: center;">Products</th>
                    <th style="width: 100px; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $index => $category)
                    <tr>
                        <td>
                            <span class="cat-id-badge">{{ $index + 1 }}</span>
                        </td>
                        <td>
                            <span class="cat-name-display">
                                <i class="bi bi-tag-fill"></i>
                                {{ $category->name }}
                            </span>
                        </td>
                        <td>
                            <div class="cat-desc {{ !$category->description ? 'empty' : '' }}">
                                {{ $category->description ?? 'No description' }}
                            </div>
                        </td>
                        <td style="text-align: center;">
                            <span class="cat-product-count">
                                <i class="bi bi-box-seam"></i>
                                {{ $category->products_count ?? 0 }}
                            </span>
                        </td>
                        <td>
                            <div class="cat-actions">
                                <a href="{{ route('admin.categories.edit', $category->id) }}"
                                   class="cat-btn-icon edit"
                                   title="Edit category">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Delete &quot;{{ $category->name }}&quot;? This action cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="cat-btn-icon delete"
                                            title="Delete category">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="cat-empty">
                                <span class="cat-empty-icon">🏷️</span>
                                <h6>No categories yet</h6>
                                <p>Create your first category to start organizing your products.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
