@extends('layouts.app')
@section('title', __('storefront.orders.title'))
@section('content')
<div class="container py-5">
    <h2 class="mb-4">{{ __('storefront.orders.title') }}</h2>
    <div class="table-responsive">
        <table class="table">
            <thead><tr><th>{{ __('storefront.orders.code') }}</th><th>{{ __('storefront.orders.date') }}</th><th>{{ __('storefront.orders.total') }}</th><th>{{ __('storefront.orders.status') }}</th></tr></thead>
            <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>{{ $order->order_code }}</td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ number_format($order->total) }}₫</td>
                    <td><span class="badge bg-info">{{ __('storefront.orders.' . $order->status) }}</span></td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center text-muted">{{ __('storefront.orders.empty') }}</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $orders->links() }}
</div>
@endsection
