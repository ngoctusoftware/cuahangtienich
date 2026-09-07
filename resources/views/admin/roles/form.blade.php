@extends('admin.layouts.app')
@section('title', $role->exists ? 'Sửa vai trò' : 'Thêm vai trò')
@section('content')
<div class="form-card">
    <h4 class="mb-4">{{ $role->exists ? 'Sửa vai trò' : 'Thêm vai trò' }}</h4>
    <form action="{{ $role->exists ? route('admin.roles.update', $role) : route('admin.roles.store') }}" method="POST">
        @csrf
        @if($role->exists) @method('PUT') @endif
        <div class="mb-4">
            <label class="form-label">Tên vai trò</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $role->name) }}" required>
        </div>

        <label class="form-label">Phân quyền chi tiết</label>
        @foreach($permissions as $group => $items)
            <div class="mb-3">
                <div class="fw-bold text-uppercase small text-muted mb-2">{{ $group }}</div>
                <div class="d-flex flex-wrap gap-3">
                    @foreach($items as $perm)
                        <div class="form-check">
                            <input type="checkbox" name="permissions[]" value="{{ $perm->id }}" class="form-check-input"
                                   {{ $role->exists && $role->permissions->contains($perm->id) ? 'checked' : '' }}>
                            <label class="form-check-label">{{ $perm->slug }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <button class="btn btn-admin-primary mt-3">Lưu vai trò</button>
    </form>
</div>
@endsection
