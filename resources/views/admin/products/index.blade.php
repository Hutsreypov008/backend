@extends('admin.layout')

@section('title', 'Products')
@section('page-title', 'Products')

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

    .prod-header-left h1 i {
        margin-right: 0.4rem;
    }

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

    .prod-btn-primary {
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

    .prod-btn-primary:hover {
        background: rgba(255,255,255,0.28);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(63, 81, 181, 0.3);
    }

    .prod-btn-primary i { font-size: 0.9rem; }

    /* ==================== TABLE CARD ==================== */
    .prod-table-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        border: none;
        overflow: hidden;
    }

    .prod-table-card .card-head {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #F0F0F5;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .prod-table-card .card-head h5 {
        margin: 0;
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-dark);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .prod-table-card .card-head h5 i { color: #3F51B5; }

    .prod-table-card .card-head .prod-count-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.3rem 0.85rem;
        background: #E8EAF6;
        color: #3F51B5;
        border-radius: 100px;
        font-size: 0.78rem;
        font-weight: 600;
    }

    /* ==================== TABLE ==================== */
    .table-prod {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table-prod thead th {
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

    .table-prod thead th:first-child { border-radius: 10px 0 0 10px; padding-left: 1.25rem; }
    .table-prod thead th:last-child { border-radius: 0 10px 10px 0; padding-right: 1.25rem; }

    .table-prod tbody tr { transition: background 0.2s ease; }
    .table-prod tbody tr:hover { background: #F8F9FE; }

    .table-prod tbody td {
        padding: 0.9rem 1rem;
        border-bottom: 1px solid #F0F0F5;
        font-size: 0.88rem;
        color: var(--text-dark);
        vertical-align: middle;
    }

    .table-prod tbody tr:last-child td:first-child { border-radius: 0 0 0 10px; }
    .table-prod tbody tr:last-child td:last-child { border-radius: 0 0 10px 0; }
    .table-prod tbody tr:last-child td { border-bottom: none; }

    /* ==================== ROW ELEMENTS ==================== */
    .prod-id-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 10px;
        background: #E8EAF6;
        color: #3F51B5;
        font-weight: 700;
        font-size: 0.8rem;
    }

    .prod-thumb-wrap {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        overflow: hidden;
        background: #F5F5F5;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border: 1px solid #F0F0F5;
    }

    .prod-thumb-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .prod-thumb-wrap .no-img {
        color: #CCC;
        font-size: 1.2rem;
    }

    .prod-info-cell {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .prod-info-text .prod-name {
        font-weight: 600;
        color: var(--text-dark);
        font-size: 0.9rem;
    }

    .prod-info-text .prod-desc {
        font-size: 0.78rem;
        color: var(--text-muted);
        max-width: 220px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .prod-category-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.25rem 0.7rem;
        background: #E8EAF6;
        border-radius: 100px;
        font-size: 0.75rem;
        font-weight: 600;
        color: #3F51B5;
    }

    .prod-category-badge i { font-size: 0.65rem; }

    .prod-price {
        font-weight: 700;
        font-size: 0.95rem;
        color: var(--text-dark);
    }

    .prod-price .currency {
        font-size: 0.7rem;
        font-weight: 600;
        color: var(--text-muted);
    }

    .prod-stock {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.3rem 0.75rem;
        border-radius: 100px;
        font-size: 0.78rem;
        font-weight: 600;
    }

    .prod-stock.in-stock {
        background: #E8F5E9;
        color: #2E7D32;
    }

    .prod-stock.low-stock {
        background: #FFF3E0;
        color: #E65100;
    }

    .prod-stock.out-of-stock {
        background: #FFEBEE;
        color: #C62828;
    }

    .prod-stock i { font-size: 0.65rem; }

    /* ==================== ACTIONS ==================== */
    .prod-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 0.4rem;
    }

    .prod-btn-icon {
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

    .prod-btn-icon.edit {
        background: #EEF2FF;
        color: #6C63FF;
    }

    .prod-btn-icon.edit:hover {
        background: #6C63FF;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(108, 99, 255, 0.3);
    }

    .prod-btn-icon.delete {
        background: #FEF2F2;
        color: #EF4444;
    }

    .prod-btn-icon.delete:hover {
        background: #EF4444;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    /* ==================== EMPTY STATE ==================== */
    .prod-empty {
        text-align: center;
        padding: 3rem 1.5rem;
    }

    .prod-empty-icon {
        font-size: 3rem;
        display: block;
        margin-bottom: 0.75rem;
        opacity: 0.3;
    }

    .prod-empty h6 {
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0.3rem;
    }

    .prod-empty p {
        font-size: 0.85rem;
        color: var(--text-muted);
        margin: 0;
    }

    /* ==================== PAGINATION ==================== */
    .prod-pagination-wrap {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.85rem;
        padding: 1.25rem 1.5rem;
        border-top: 1px solid #F0F0F5;
    }

    .prod-pagination-info {
        font-size: 0.82rem;
        color: var(--text-muted);
    }

    .prod-pagination-info strong {
        color: var(--text-dark);
        font-weight: 700;
    }

    .prod-pagination {
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    .prod-page-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 36px;
        height: 36px;
        padding: 0 0.55rem;
        border: 2px solid #E8E8E8;
        border-radius: 10px;
        background: white;
        color: var(--text-dark);
        font-size: 0.82rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .prod-page-btn:hover:not(.active):not(.disabled) {
        border-color: #3F51B5;
        color: #3F51B5;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(63, 81, 181, 0.12);
    }

    .prod-page-btn.active {
        background: #3F51B5;
        border-color: #3F51B5;
        color: white;
        cursor: default;
        box-shadow: 0 4px 12px rgba(63, 81, 181, 0.25);
    }

    .prod-page-btn.disabled {
        opacity: 0.35;
        pointer-events: none;
        cursor: default;
    }

    .prod-page-ellipsis {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 24px;
        color: var(--text-muted);
        font-size: 0.82rem;
        font-weight: 600;
        letter-spacing: 1px;
    }

    /* ==================== ANIMATION ==================== */
    @keyframes fadeSlideUp {
        from { opacity: 0; transform: translateY(12px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .prod-table-card { animation: fadeSlideUp 0.4s ease both; }
    .prod-header { animation: fadeSlideUp 0.4s ease 0.05s both; }
</style>

{{-- ==================== PAGE HEADER ==================== --}}
<div class="prod-header">
    <div class="prod-header-content">
        <div class="prod-header-left">
            <h1><i class="bi bi-box-seam-fill"></i>Products</h1>
            <p>Manage your product inventory, pricing, and stock levels.</p>
        </div>
        <div class="prod-header-right">
            <a href="{{ route('admin.products.create') }}" class="prod-btn-primary">
                <i class="bi bi-plus-lg"></i>
                <span>Add Product</span>
            </a>
        </div>
    </div>
</div>

{{-- ==================== PRODUCTS TABLE ==================== --}}
<div class="prod-table-card">
    <div class="card-head">
        <h5>
            <i class="bi bi-grid-3x3-gap-fill"></i>
            All Products
        </h5>
        <span class="prod-count-badge">
            <i class="bi bi-box-seam"></i>
            {{ $products->total() }} total
        </span>
    </div>
    <div class="table-responsive">
        <table class="table-prod">
            <thead>
                <tr>
                    <th style="width: 60px;">#</th>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th style="width: 100px; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $index => $product)
                    @php
                        $stockClass = 'in-stock';
                        $stockIcon = 'bi-check-circle-fill';
                        if ($product->stock == 0) {
                            $stockClass = 'out-of-stock';
                            $stockIcon = 'bi-x-circle-fill';
                        } elseif ($product->stock <= 5) {
                            $stockClass = 'low-stock';
                            $stockIcon = 'bi-exclamation-circle-fill';
                        }
                        $rowNumber = ($products->currentPage() - 1) * $products->perPage() + $loop->iteration;
                    @endphp
                    <tr>
                        <td><span class="prod-id-badge">{{ $rowNumber }}</span></td>
                        <td>
                            <div class="prod-info-cell">
                                <div class="prod-thumb-wrap">
                                    @if ($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                    @else
                                        <span class="no-img"><i class="bi bi-box"></i></span>
                                    @endif
                                </div>
                                <div class="prod-info-text">
                                    <div class="prod-name">{{ $product->name }}</div>
                                    <div class="prod-desc">{{ $product->description ?? 'No description' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="prod-category-badge">
                                <i class="bi bi-tag-fill"></i>
                                {{ $product->category->name }}
                            </span>
                        </td>
                        <td>
                            <span class="prod-price">
                                <span class="currency">$</span>{{ number_format($product->price, 2) }}
                            </span>
                        </td>
                        <td>
                            <span class="prod-stock {{ $stockClass }}">
                                <i class="bi {{ $stockIcon }}"></i>
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td>
                            <div class="prod-actions">
                                <a href="{{ route('admin.products.edit', $product->id) }}"
                                   class="prod-btn-icon edit"
                                   title="Edit product">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Delete &quot;{{ $product->name }}&quot;? This action cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="prod-btn-icon delete"
                                            title="Delete product">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="prod-empty">
                                <span class="prod-empty-icon">📦</span>
                                <h6>No products yet</h6>
                                <p>Start adding products to populate your inventory.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ==================== PAGINATION ==================== --}}
    @if ($products->hasPages())
    <div class="prod-pagination-wrap">
        <div class="prod-pagination-info">
            Showing <strong>{{ $products->firstItem() }}</strong>–<strong>{{ $products->lastItem() }}</strong> of <strong>{{ $products->total() }}</strong> products
        </div>
        <div class="prod-pagination">
            {{-- Previous --}}
            <a href="{{ $products->previousPageUrl() }}" class="prod-page-btn {{ $products->onFirstPage() ? 'disabled' : '' }}" rel="prev">
                <i class="bi bi-chevron-left"></i>
            </a>

            {{-- Page numbers --}}
            @php
                $currentPage = $products->currentPage();
                $lastPage = $products->lastPage();
                $start = max(1, $currentPage - 2);
                $end = min($lastPage, $currentPage + 2);

                if ($start > 1) {
                    echo '<a href="' . $products->url(1) . '" class="prod-page-btn">1</a>';
                    if ($start > 2) echo '<span class="prod-page-ellipsis">...</span>';
                }

                for ($i = $start; $i <= $end; $i++) {
                    $active = $i === $currentPage ? 'active' : '';
                    echo '<a href="' . $products->url($i) . '" class="prod-page-btn ' . $active . '">' . $i . '</a>';
                }

                if ($end < $lastPage) {
                    if ($end < $lastPage - 1) echo '<span class="prod-page-ellipsis">...</span>';
                    echo '<a href="' . $products->url($lastPage) . '" class="prod-page-btn">' . $lastPage . '</a>';
                }
            @endphp

            {{-- Next --}}
            <a href="{{ $products->nextPageUrl() }}" class="prod-page-btn {{ $products->hasMorePages() ? '' : 'disabled' }}" rel="next">
                <i class="bi bi-chevron-right"></i>
            </a>
        </div>
    </div>
    @endif
</div>
@endsection
