@extends('shop.layouts.app')
@section('title', 'Gio hang')
@section('content')
<h4 class="mb-3">Gio hang cua ban</h4>

@if (empty($items))
    <p class="text-muted">Gio hang dang trong. <a href="{{ route('products.index') }}">Tiep tuc mua sam</a></p>
@else
<div class="card shadow-sm">
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
                <td>{{ number_format($item['subtotal']) }}₫</td>
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
            <tr><th colspan="3" class="text-end">Tong cong</th><th colspan="2">{{ number_format($total) }}₫</th></tr>
        </tfoot>
    </table>
</div>

<div class="text-end mt-3">
    <a href="{{ route('cart.checkout') }}" class="btn btn-primary btn-lg">Tien hanh dat hang <i class="bi bi-arrow-right"></i></a>
</div>
@endif
@endsection
