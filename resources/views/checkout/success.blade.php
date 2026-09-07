@extends('layouts.app')
@section('title', 'Đặt hàng thành công')
@section('content')
<div class="container py-5 text-center">
    <i class="fas fa-check-circle text-success" style="font-size: 64px;"></i>
    <h2 class="mt-3">Đặt hàng thành công!</h2>
    <p>Mã đơn hàng của bạn: <strong>{{ $orderCode }}</strong></p>
    <p>Chúng tôi sẽ liên hệ xác nhận đơn hàng trong thời gian sớm nhất.</p>
    <a href="{{ route('home') }}" class="btn btn-hero-cta mt-3">Tiếp tục mua sắm</a>
</div>
@endsection
