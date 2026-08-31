@extends('admin.layouts.app')
@section('title', 'Don hang')
@section('content')
<form class="d-flex gap-2 mb-3" method="GET">
    <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Tim theo ma don...">
    <select name="status" class="form-select" style="max-width:200px">
        <option value="">-- Tat ca trang thai --</option>
        @foreach (['pending'=>'Cho xu ly','confirmed'=>'Da xac nhan','shipping'=>'Dang giao','completed'=>'Hoan thanh','cancelled'=>'Da huy'] as $k=>$v)
            <option value="{{ $k }}" @selected(request('status')==$k)>{{ $v }}</option>
        @endforeach
    </select>
    <button class="btn btn-outline-secondary">Loc</button>
</form>

<div class="card shadow-sm">
    <table class="table mb-0 align-middle">
        <thead><tr><th>Ma don</th><th>Nguoi nhan</th><th>Tong tien</th><th>PT thanh toan</th><th>Trang thai TT</th><th>Trang thai don</th><th>Ngay</th><th></th></tr></thead>
        <tbody>
        @foreach ($orders as $order)
            <tr>
                <td>{{ $order->code }}</td>
                <td>{{ $order->receiver_name }}<br><small class="text-muted">{{ $order->receiver_phone }}</small></td>
                <td>{{ number_format($order->total_amount) }}₫</td>
                <td>{{ strtoupper($order->payment_method) }}</td>
                <td><span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }}">{{ $order->payment_status }}</span></td>
                <td><span class="badge bg-info text-dark">{{ $order->status }}</span></td>
                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                <td><a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">Chi tiet</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="mt-3">{{ $orders->links() }}</div>
@endsection
