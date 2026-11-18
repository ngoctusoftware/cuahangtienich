@extends('admin.layouts.app')
@section('title', 'Người dùng')
@section('content')
@php($bulkDeleteFormId = 'bulk-delete-users')
<div class="panel">
    <div class="panel-header d-flex justify-content-between align-items-center">
        Quản lý người dùng (Admin/Nhân viên)
        <a href="{{ route('admin.users.create') }}" class="btn btn-admin-primary btn-sm"><i class="fas fa-plus"></i> Thêm người dùng</a>
    </div>
    @include('admin.partials.bulk-delete-toolbar', ['formId' => $bulkDeleteFormId, 'routeName' => 'admin.users.bulk-destroy'])
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th><input type="checkbox" class="form-check-input" data-bulk-select="{{ $bulkDeleteFormId }}" aria-label="Chọn tất cả trên trang"></th><th>Tên</th><th>Email</th><th>Vai trò</th><th>Trạng thái</th><th></th></tr></thead>
            <tbody>
                @foreach($users as $u)
                    <tr>
                        <td><input type="checkbox" class="form-check-input" name="ids[]" value="{{ $u->id }}" form="{{ $bulkDeleteFormId }}" data-bulk-delete-form="{{ $bulkDeleteFormId }}" aria-label="Chọn người dùng {{ $u->name }}"></td>
                        <td>{{ $u->name }}</td>
                        <td>{{ $u->email }}</td>
                        <td>{{ $u->roles->pluck('name')->join(', ') }}</td>
                        <td>{!! $u->is_active ? '<span class="badge bg-success">Hoạt động</span>' : '<span class="badge bg-secondary">Khoá</span>' !!}</td>
                        <td>
                            <a href="{{ route('admin.users.edit', $u) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.users.destroy', $u) }}" method="POST" class="d-inline" onsubmit="return confirm('Xoá người dùng này?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-3">{{ $users->links() }}</div>
</div>
@endsection
