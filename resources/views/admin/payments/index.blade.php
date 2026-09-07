@extends('admin.layouts.app')
@section('title', 'Thanh toán')
@section('content')
<div class="panel">
    <div class="panel-header">Danh sách thanh toán</div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>Mã đơn</th><th>Phương thức</th><th>Số tiền</th><th>Mã giao dịch</th><th>Trạng thái</th><th></th></tr></thead>
            <tbody>
                @foreach($payments as $payment)
                    <tr>
                        <td>{{ $payment->order->order_code }}</td>
                        <td>{{ $payment->method }}</td>
                        <td>{{ number_format($payment->amount) }}₫</td>
                        <td>{{ $payment->transaction_code ?? '—' }}</td>
                        <td>
                            <form action="{{ route('admin.payments.updateStatus', $payment) }}" method="POST" class="d-flex gap-2">
                                @csrf @method('PUT')
                                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                    @foreach(['pending'=>'Chờ','paid'=>'Đã thanh toán','failed'=>'Thất bại','refunded'=>'Hoàn tiền'] as $key => $label)
                                        <option value="{{ $key }}" {{ $payment->status === $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-3">{{ $payments->links() }}</div>
</div>
@endsection
