@extends('admin.layouts.app')
@section('title', 'Phân quyền')
@section('content')
<div class="panel">
    <div class="panel-header d-flex justify-content-between align-items-center">
        Quản lý vai trò & phân quyền
        <a href="{{ route('admin.roles.create') }}" class="btn btn-admin-primary btn-sm"><i class="fas fa-plus"></i> Thêm vai trò</a>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>Tên vai trò</th><th>Số người dùng</th><th></th></tr></thead>
            <tbody>
                @foreach($roles as $role)
                    <tr>
                        <td>{{ $role->name }}</td>
                        <td>{{ $role->users_count }}</td>
                        <td>
                            <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            @if($role->slug !== 'super-admin')
                            <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" class="d-inline" onsubmit="return confirm('Xoá vai trò này?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
