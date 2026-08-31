@extends('admin.layouts.app')
@section('title', 'Don hang '.$order->code)
@section('content')
<div class="row g-3">
    <div class="col-md-8">
        <div class="card shadow-sm mb-3">
            <div class="card-header">San pham trong don</div>
            <table class="table mb-0">
                <thead><tr><th>San pham</th><th>Gia</th><th>SL</th><th>Thanh tien</th></tr></thead>
                <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $item->product_name }}</td>
                        <td>{{ number_format($item->price) }}₫</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->subtotal) }}₫</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                    <tr><th colspan="3" class="text-end">Tong cong</th><th>{{ number_format($order->total_amount) }}₫</th></tr>
                </tfoot>
            </table>
        </div>

        <div class="card shadow-sm">
            <div class="card-header">Lich su thanh toan</div>
            <table class="table mb-0">
                <thead><tr><th>PT</th><th>Ma GD</th><th>So tien</th><th>Trang thai</th><th>Thoi gian</th></tr></thead>
                <tbody>
                @foreach ($order->payments as $payment)
                    <tr>
                        <td>{{ strtoupper($payment->method) }}</td>
                        <td>{{ $payment->transaction_id ?? '-' }}</td>
                        <td>{{ number_format($payment->amount) }}₫</td>
                        <td><span class="badge bg-{{ $payment->status === 'success' ? 'success' : ($payment->status === 'failed' ? 'danger' : 'warning') }}">{{ $payment->status }}</span></td>
                        <td>{{ $payment->paid_at?->format('d/m/Y H:i') ?? '-' }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm mb-3">
            <div class="card-header">Thong tin nhan hang</div>
            <div class="card-body">
                <p class="mb-1"><strong>{{ $order->receiver_name }}</strong></p>
                <p class="mb-1">{{ $order->receiver_phone }}</p>
                <p class="mb-1">{{ $order->receiver_address }}</p>
                @if ($order->note)
                    <p class="mb-0 text-muted">Ghi chu: {{ $order->note }}</p>
                @endif
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header">Cap nhat trang thai</div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}">
                    @csrf @method('PATCH')
                    <select name="status" class="form-select mb-2">
                        @foreach (['pending'=>'Cho xu ly','confirmed'=>'Da xac nhan','shipping'=>'Dang giao','completed'=>'Hoan thanh','cancelled'=>'Da huy'] as $k=>$v)
                            <option value="{{ $k }}" @selected($order->status===$k)>{{ $v }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-primary w-100">Cap nhat</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
