@extends('admin.layouts.app')
@section('title', 'Hồ sơ cá nhân')
@section('content')
<div class="admin-panel" style="max-width:500px">
    <div class="panel-title"><span>Hồ sơ cá nhân</span></div>
    <form method="POST" action="{{ route('admin.profile.update') }}">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Họ tên</label>
            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
        </div>
        <div class="mb-3">
            <label>Số điện thoại</label>
            <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
        </div>
        <div class="mb-3">
            <label>Mật khẩu mới (để trống nếu không đổi)</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="mb-3">
            <label>Nhập lại mật khẩu mới</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>
        <button class="btn btn-admin-primary">LƯU</button>
    </form>
</div>
@endsection
