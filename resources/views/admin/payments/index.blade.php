@extends('admin.layouts.app')
@section('title', 'Thanh toan')
@section('content')
<form class="d-flex gap-2 mb-3" method="GET">
    <select name="status" class="form-select" style="max-width:220px">
        <option value="">-- Tat ca trang thai --</option>
        <option value="pending" @selected(request('status')=='pending')>Cho thanh toan</option>
        <option value="success" @selected(request('status')=='success')>Thanh cong</option>
        <option value="failed" @selected(request('status')=='failed')>That bai</option>
    </select>
    <button class="btn btn-outline-secondary">Loc</button>
</form>

<div class="card shadow-sm">
    <table class="table mb-0 align-middle">
        <thead><tr><th>Don hang</th><th>Phuong thuc</th><th>Ma GD</th><th>So tien</th><th>Trang thai</th><th>Thoi gian</th><th></th></tr></thead>
        <tbody>
        @foreach ($payments as $payment)
            <tr>
                <td>{{ $payment->order->code ?? '-' }}</td>
                <td>{{ strtoupper($payment->method) }}</td>
                <td>{{ $payment->transaction_id ?? '-' }}</td>
                <td>{{ number_format($payment->amount) }}₫</td>
                <td><span class="badge bg-{{ $payment->status === 'success' ? 'success' : ($payment->status === 'failed' ? 'danger' : 'warning') }}">{{ $payment->status }}</span></td>
                <td>{{ $payment->paid_at?->format('d/m/Y H:i') ?? '-' }}</td>
                <td>
                    @if ($payment->status !== 'success')
                        <form method="POST" action="{{ route('admin.payments.markPaid', $payment) }}" onsubmit="return confirm('Xac nhan da thanh toan?')">
                            @csrf @method('PATCH')
                            <button class="btn btn-sm btn-outline-success">Xac nhan da thu tien</button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="mt-3">{{ $payments->links() }}</div>
@endsection
