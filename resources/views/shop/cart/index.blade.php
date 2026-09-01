@extends('shop.layouts.app')
@section('title', 'Gio hang')
@section('content')
<section class="shop-section">
<div class="container">
    <div class="section-heading">
        <h2>Gio hang cua ban</h2>
        <div class="rule"></div>
    </div>

    @if (empty($items))
        <p class="text-center text-muted">Gio hang dang trong. <a href="{{ route('products.index') }}">Tiep tuc mua sam</a></p>
    @else
    <div class="bg-white rounded-4 shadow-sm p-2">
        <table class="table align-middle mb-0">
            <thead><tr><th>San pham</th><th>Gia</th><th>So luong</th><th>Thanh tien</th><th></th></tr></thead>
            <tbody>
            @foreach ($items as $item)
                <tr>
                    <td>{{ $item['product']->name }}</td>
                    <td>{{ number_format($item['product']->final_price) }}₫</td>
                    <td style="max-width:120px">
                        <form method="POST" action="{{ route('cart.update', $item['product']->id) }}" class="d-flex gap-1">
                            @csrf @method('PATCH')
                            <input type="number" name="qty" value="{{ $item['qty'] }}" min="0" class="form-control form-control-sm">
                            <button class="btn btn-sm btn-outline-secondary">OK</button>
                        </form>
                    </td>
                    <td class="price-new">{{ number_format($item['subtotal']) }}₫</td>
                    <td>
                        <form method="POST" action="{{ route('cart.remove', $item['product']->id) }}" onsubmit="return confirm('Xoa san pham nay?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
                <tr><th colspan="3" class="text-end">Tong cong</th><th colspan="2" class="price-new fs-5">{{ number_format($total) }}₫</th></tr>
            </tfoot>
        </table>
    </div>

    <div class="text-end mt-3">
        <a href="{{ route('cart.checkout') }}" class="btn btn-cta">Tien hanh dat hang <i class="bi bi-arrow-right"></i></a>
    </div>
    @endif
</div>
</section>
@endsection
