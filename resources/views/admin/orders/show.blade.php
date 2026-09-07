@extends('admin.layouts.app')
@section('title', 'Chi tiết đơn hàng #' . $order->order_code)
@section('content')
<div class="row g-4">
    <div class="col-lg-8">
        <div class="panel">
            <div class="panel-header">Sản phẩm trong đơn</div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead><tr><th>Sản phẩm</th><th>Giá</th><th>SL</th><th>Thành tiền</th></tr></thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>{{ $item->product_name }}</td>
                                <td>{{ number_format($item->price) }}₫</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->line_total) }}₫</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="panel mb-4">
            <div class="panel-header">Thông tin giao hàng</div>
            <div class="p-3">
                <p><strong>Người nhận:</strong> {{ $order->receiver_name }}</p>
                <p><strong>SĐT:</strong> {{ $order->receiver_phone }}</p>
                <p><strong>Địa chỉ:</strong> {{ $order->receiver_address }}</p>
                <p><strong>Ghi chú:</strong> {{ $order->note ?? '—' }}</p>
                <p><strong>Tổng tiền:</strong> {{ number_format($order->total) }}₫</p>
            </div>
        </div>
        <div class="panel">
            <div class="panel-header">Cập nhật trạng thái</div>
            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="p-3">
                @csrf @method('PUT')
                <select name="status" class="form-select mb-3">
                    @foreach(['pending'=>'Chờ xử lý','confirmed'=>'Đã xác nhận','shipping'=>'Đang giao','completed'=>'Hoàn thành','cancelled'=>'Đã huỷ'] as $key => $label)
                        <option value="{{ $key }}" {{ $order->status === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                <button class="btn btn-admin-primary w-100">Cập nhật</button>
            </form>
        </div>
    </div>
</div>
@endsection
