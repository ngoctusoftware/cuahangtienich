@extends('layouts.app')

@section('title', (($searchQuery ?? null) ? __('storefront.products.search_title', ['query' => $searchQuery]) : ($category?->translation()?->name ?? __('storefront.products.title'))) . ' - ' . ($siteName ?? 'ZEK SHOP'))

@section('content')
<div class="container category-page py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('storefront.products.home') }}</a></li>
            <li class="breadcrumb-item active">{{ ($searchQuery ?? null) ? __('storefront.products.search_title', ['query' => $searchQuery]) : ($category?->translation()?->name ?? __('storefront.products.title')) }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        <div class="col-lg-3">
            <div class="filter-box">
                <h6 class="text-uppercase fw-bold mb-3">{{ __('storefront.products.categories') }}</h6>
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
                    <p class="text-muted">{{ ($searchQuery ?? null) ? __('storefront.products.no_search_results') : __('storefront.products.no_products') }}</p>
                @endforelse
            </div>
            @if ($products instanceof \Illuminate\Contracts\Pagination\Paginator)
                <div class="mt-4">
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
