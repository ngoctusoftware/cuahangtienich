@extends('admin.layouts.app')
@section('title', $user->exists ? 'Sửa người dùng' : 'Thêm người dùng')
@section('content')
<div class="form-card">
    <h4 class="mb-4">{{ $user->exists ? 'Sửa người dùng' : 'Thêm người dùng' }}</h4>
    <form action="{{ $user->exists ? route('admin.users.update', $user) : route('admin.users.store') }}" method="POST">
        @csrf
        @if($user->exists) @method('PUT') @endif
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Họ tên</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Mật khẩu {{ $user->exists ? '(để trống nếu không đổi)' : '' }}</label>
                <input type="password" name="password" class="form-control" {{ $user->exists ? '' : 'required' }}>
            </div>
            <div class="col-md-6 d-flex align-items-end">
                <div class="form-check">
                    <input type="checkbox" name="is_active" value="1" class="form-check-input" {{ $user->is_active || !$user->exists ? 'checked' : '' }}>
                    <label class="form-check-label">Kích hoạt tài khoản</label>
                </div>
            </div>
            <div class="col-12">
                <label class="form-label">Vai trò</label>
                <div class="d-flex flex-wrap gap-3">
                    @foreach($roles as $role)
                        <div class="form-check">
                            <input type="checkbox" name="roles[]" value="{{ $role->id }}" class="form-check-input"
                                   {{ $user->roles->contains($role->id) ? 'checked' : '' }}>
                            <label class="form-check-label">{{ $role->name }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <button class="btn btn-admin-primary mt-4">Lưu</button>
    </form>
</div>
@endsection
