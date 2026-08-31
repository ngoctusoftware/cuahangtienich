@extends('shop.layouts.app')
@section('title', 'Thanh toan')
@section('content')
<div class="row g-4">
    <div class="col-md-7">
        <div class="card shadow-sm p-4">
            <h5 class="mb-3">Thong tin nhan hang</h5>
            <form method="POST" action="{{ route('checkout.place') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Ho ten nguoi nhan</label>
                    <input type="text" name="receiver_name" class="form-control" value="{{ old('receiver_name', auth()->user()->name) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">So dien thoai</label>
                    <input type="text" name="receiver_phone" class="form-control" value="{{ old('receiver_phone', auth()->user()->phone) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Dia chi nhan hang</label>
                    <textarea name="receiver_address" class="form-control" rows="2" required>{{ old('receiver_address', auth()->user()->address) }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Ghi chu</label>
                    <textarea name="note" class="form-control" rows="2">{{ old('note') }}</textarea>
                </div>

                <label class="form-label d-block">Phuong thuc thanh toan</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="payment_method" value="cod" id="pm_cod" checked>
                    <label class="form-check-label" for="pm_cod">Thanh toan khi nhan hang (COD)</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="payment_method" value="vnpay" id="pm_vnpay">
                    <label class="form-check-label" for="pm_vnpay">Thanh toan online qua VNPay</label>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="payment_method" value="bank_transfer" id="pm_bank">
                    <label class="form-check-label" for="pm_bank">Chuyen khoan ngan hang</label>
                </div>

                <button class="btn btn-primary btn-lg w-100">Dat hang</button>
            </form>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card shadow-sm p-4">
            <h5 class="mb-3">Don hang cua ban</h5>
            @foreach ($products as $product)
                <div class="d-flex justify-content-between mb-2">
                    <span>{{ $product->name }} x {{ $cart[$product->id]['qty'] }}</span>
                    <span>{{ number_format($product->final_price * $cart[$product->id]['qty']) }}₫</span>
                </div>
            @endforeach
            <hr>
            <div class="d-flex justify-content-between fw-bold fs-5">
                <span>Tong cong</span>
                <span class="text-danger">{{ number_format($total) }}₫</span>
            </div>
        </div>
    </div>
</div>
@endsection
