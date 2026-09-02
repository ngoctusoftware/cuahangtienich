@extends('admin.layouts.app')
@section('title', 'Khách hàng')
@section('content')
<div class="panel">
    <div class="panel-header d-flex justify-content-between align-items-center">
        <form method="GET"><input type="text" name="search" class="form-control form-control-sm" placeholder="Tìm khách hàng..." value="{{ request('search') }}"></form>
        <a href="{{ route('admin.customers.create') }}" class="btn btn-admin-primary btn-sm"><i class="fas fa-plus"></i> Thêm khách hàng</a>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>Tên</th><th>Email</th><th>SĐT</th><th>Nhóm</th><th>Trạng thái</th><th></th></tr></thead>
            <tbody>
                @foreach($customers as $c)
                    <tr>
                        <td>{{ $c->name }}</td>
                        <td>{{ $c->email }}</td>
                        <td>{{ $c->phone }}</td>
                        <td>{{ $c->group?->name ?? '—' }}</td>
                        <td>{!! $c->is_active ? '<span class="badge bg-success">Hoạt động</span>' : '<span class="badge bg-secondary">Khoá</span>' !!}</td>
                        <td>
                            <a href="{{ route('admin.customers.edit', $c) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.customers.destroy', $c) }}" method="POST" class="d-inline" onsubmit="return confirm('Xoá khách hàng này?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-3">{{ $customers->links() }}</div>
</div>
@endsection
