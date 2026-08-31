@extends('admin.layouts.app')
@section('title', $user->exists ? 'Sua nguoi dung' : 'Them nguoi dung')
@section('content')
<form method="POST" action="{{ $user->exists ? route('admin.users.update', $user) : route('admin.users.store') }}" class="card shadow-sm p-4">
    @csrf
    @if ($user->exists) @method('PUT') @endif

    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Ho ten</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">So dien thoai</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
        </div>
        <div class="col-md-6">
            <label class="form-label">Vai tro</label>
            <select name="role_id" class="form-select" required>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" @selected(old('role_id', $user->role_id) == $role->id)>{{ $role->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12">
            <label class="form-label">Dia chi</label>
            <textarea name="address" class="form-control" rows="2">{{ old('address', $user->address) }}</textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label">Mat khau {{ $user->exists ? '(de trong neu khong doi)' : '' }}</label>
            <input type="password" name="password" class="form-control" {{ $user->exists ? '' : 'required' }}>
        </div>
        <div class="col-md-6 d-flex align-items-end">
            <div class="form-check">
                <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" @checked(old('is_active', $user->is_active ?? true))>
                <label class="form-check-label" for="is_active">Tai khoan hoat dong</label>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <button class="btn btn-primary">Luu</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Huy</a>
    </div>
</form>
@endsection
