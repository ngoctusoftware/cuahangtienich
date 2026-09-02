@extends('admin.layouts.app')
@section('title', 'Đơn hàng')
@section('content')
<div class="panel">
    <div class="panel-header d-flex justify-content-between align-items-center">
        <form class="d-flex gap-2" method="GET">
            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">Tất cả trạng thái</option>
                @foreach(['pending'=>'Chờ xử lý','confirmed'=>'Đã xác nhận','shipping'=>'Đang giao','completed'=>'Hoàn thành','cancelled'=>'Đã huỷ'] as $key => $label)
                    <option value="{{ $key }}" {{ request('status') === $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>Mã đơn</th><th>Khách nhận</th><th>SĐT</th><th>Ngày đặt</th><th>Tổng tiền</th><th>Thanh toán</th><th>Trạng thái</th><th></th></tr></thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->order_code }}</td>
                        <td>{{ $order->receiver_name }}</td>
                        <td>{{ $order->receiver_phone }}</td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ number_format($order->total) }}₫</td>
                        <td>{{ $order->payment_method }}</td>
                        <td><span class="badge bg-info">{{ $order->status }}</span></td>
                        <td><a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-3">{{ $orders->links() }}</div>
</div>
@endsection
