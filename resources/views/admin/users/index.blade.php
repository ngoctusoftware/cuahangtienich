@extends('admin.layouts.app')
@section('title', 'Người dùng')
@section('content')
<div class="panel">
    <div class="panel-header d-flex justify-content-between align-items-center">
        Quản lý người dùng (Admin/Nhân viên)
        <a href="{{ route('admin.users.create') }}" class="btn btn-admin-primary btn-sm"><i class="fas fa-plus"></i> Thêm người dùng</a>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>Tên</th><th>Email</th><th>Vai trò</th><th>Trạng thái</th><th></th></tr></thead>
            <tbody>
                @foreach($users as $u)
                    <tr>
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
