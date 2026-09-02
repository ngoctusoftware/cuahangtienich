@extends('layouts.app')

@section('title', ($category?->translation()?->name ?? 'Sản phẩm') . ' - ' . ($siteName ?? 'ZEK SHOP'))

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active">{{ $category?->translation()?->name ?? 'Sản phẩm' }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        <div class="col-lg-3">
            <div class="filter-box">
                <h6 class="text-uppercase fw-bold mb-3">Danh mục</h6>
                <ul class="list-unstyled">
                    @foreach($allCategories ?? [] as $cat)
                        <li class="mb-2">
                            <a href="{{ route('products.byCategory', $cat->translation()?->slug) }}"
                               class="{{ isset($category) && $category->id === $cat->id ? 'fw-bold text-primary' : '' }}">
                                {{ $cat->translation()?->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="row g-4">
                @forelse($products as $product)
                    @include('products.partials.card', ['product' => $product])
                @empty
                    <p class="text-muted">Không có sản phẩm nào.</p>
                @endforelse
            </div>
            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
