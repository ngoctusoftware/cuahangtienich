@extends('admin.layouts.app')
@section('title', 'Tìm kiếm')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">Tìm kiếm</h1>
        <div class="page-subtitle">
            Kết quả cho: <strong>{{ $query ?: 'tất cả' }}</strong>
        </div>
    </div>
</div>

@if($query === '')
    <div class="panel search-empty">
        <i class="fas fa-search"></i>
        <h2>Nhập từ khóa để tìm kiếm</h2>
        <p>Tìm sản phẩm, danh mục hoặc hóa đơn từ thanh tìm kiếm phía trên.</p>
    </div>
@else
    <div class="row g-4">
        <div class="col-12 col-xl-4">
            <div class="panel search-results-panel">
                <div class="panel-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-box me-2"></i>Sản phẩm</span>
                    <span class="badge bg-info">{{ $products->count() }}</span>
                </div>
                @forelse($products as $product)
                    <a class="search-result-item" href="{{ route('admin.products.edit', $product) }}">
                        <span>
                            <strong>{{ $product->translation()?->name ?? $product->sku }}</strong>
                            <small>SKU: {{ $product->sku }}</small>
                        </span>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                @empty
                    <div class="search-no-results">Không tìm thấy sản phẩm.</div>
                @endforelse
            </div>
        </div>

        <div class="col-12 col-xl-4">
            <div class="panel search-results-panel">
                <div class="panel-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-sitemap me-2"></i>Danh mục</span>
                    <span class="badge bg-info">{{ $categories->count() }}</span>
                </div>
                @forelse($categories as $category)
                    <a class="search-result-item" href="{{ route('admin.categories.edit', $category) }}">
                        <span><strong>{{ $category->translation()?->name }}</strong></span>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                @empty
                    <div class="search-no-results">Không tìm thấy danh mục.</div>
                @endforelse
            </div>
        </div>

        <div class="col-12 col-xl-4">
            <div class="panel search-results-panel">
                <div class="panel-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-receipt me-2"></i>Hóa đơn</span>
                    <span class="badge bg-info">{{ $orders->count() }}</span>
                </div>
                @forelse($orders as $order)
                    <a class="search-result-item" href="{{ route('admin.orders.show', $order) }}">
                        <span>
                            <strong>{{ $order->order_code }}</strong>
                            <small>{{ $order->receiver_name }} · {{ number_format($order->total) }}₫</small>
                        </span>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                @empty
                    <div class="search-no-results">Không tìm thấy hóa đơn.</div>
                @endforelse
            </div>
        </div>
    </div>
@endif
@endsection
