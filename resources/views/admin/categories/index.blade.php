@extends('admin.layouts.app')
@section('title', 'Danh mục')
@section('content')
<div class="panel">
    <div class="panel-header d-flex justify-content-between align-items-center">
        Quản lý danh mục
        <a href="{{ route('admin.categories.create') }}" class="btn btn-admin-primary btn-sm"><i class="fas fa-plus"></i> Thêm danh mục</a>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>Tên</th><th>Danh mục cha</th><th>Thứ tự</th><th>Trạng thái</th><th></th></tr></thead>
            <tbody>
                @foreach($categories as $cat)
                    <tr>
                        <td>{{ $cat->translation()?->name }}</td>
                        <td>{{ $cat->parent?->translation()?->name ?? '—' }}</td>
                        <td>{{ $cat->sort_order }}</td>
                        <td>{!! $cat->is_active ? '<span class="badge bg-success">Hoạt động</span>' : '<span class="badge bg-secondary">Ẩn</span>' !!}</td>
                        <td>
                            <a href="{{ route('admin.categories.edit', $cat) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" class="d-inline" onsubmit="return confirm('Xoá danh mục này?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-3">{{ $categories->links() }}</div>
</div>
@endsection
