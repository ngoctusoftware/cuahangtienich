@extends('shop.layouts.app')
@section('title', 'Cong thanh toan')
@section('content')
<section class="shop-section">
<div class="container">
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="bg-white rounded-4 shadow-sm p-4 text-center">
            <i class="bi bi-credit-card-2-front fs-1" style="color:var(--brand-red);"></i>
            <h4 class="mt-2 display-title">Cong thanh toan (Demo)</h4>
            <p class="text-muted">Day la trang thanh toan mo phong dung de kiem thu luong "thanh toan tu dong".
                Khi ket noi cong that (VNPay/Momo), buoc nay se duoc thay bang trang thanh toan cua ngan hang/vi dien tu.</p>
            <hr>
            <p>Ma don hang: <strong>{{ $order->code }}</strong></p>
            <p>So tien can thanh toan: <strong class="price-new fs-4">{{ number_format($order->total_amount) }}₫</strong></p>

            <form method="POST" action="{{ route('payment.demo.confirm', $order->code) }}">
                @csrf
                <input type="hidden" name="confirm" value="1">
                <button class="btn btn-cta w-100 mb-2">Xac nhan thanh toan thanh cong</button>
            </form>
            <form method="POST" action="{{ route('payment.demo.confirm', $order->code) }}">
                @csrf
                <input type="hidden" name="confirm" value="0">
                <button class="btn btn-outline-danger w-100">Gia lap thanh toan that bai</button>
            </form>
        </div>
    </div>
</div>
</div>
</section>
@endsection
