@extends('admin.layouts.app')
@section('title', $customer->exists ? 'Sửa khách hàng' : 'Thêm khách hàng')
@section('content')
<div class="form-card">
    <h4 class="mb-4">{{ $customer->exists ? 'Sửa khách hàng' : 'Thêm khách hàng' }}</h4>
    <form action="{{ $customer->exists ? route('admin.customers.update', $customer) : route('admin.customers.store') }}" method="POST">
        @csrf
        @if($customer->exists) @method('PUT') @endif
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Họ tên</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $customer->name) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $customer->email) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Số điện thoại</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $customer->phone) }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Nhóm khách hàng</label>
                <select name="customer_group_id" class="form-select">
                    <option value="">-- Không có --</option>
                    @foreach($groups as $g)
                        <option value="{{ $g->id }}" {{ old('customer_group_id', $customer->customer_group_id) == $g->id ? 'selected' : '' }}>{{ $g->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Mật khẩu {{ $customer->exists ? '(để trống nếu không đổi)' : '' }}</label>
                <input type="password" name="password" class="form-control" {{ $customer->exists ? '' : 'required' }}>
            </div>
            <div class="col-md-6 d-flex align-items-end">
                <div class="form-check">
                    <input type="checkbox" name="is_active" value="1" class="form-check-input" {{ $customer->is_active || !$customer->exists ? 'checked' : '' }}>
                    <label class="form-check-label">Kích hoạt tài khoản</label>
                </div>
            </div>
        </div>
        <button class="btn btn-admin-primary mt-4">Lưu</button>
    </form>
</div>
@endsection
