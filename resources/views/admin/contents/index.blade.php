@extends('admin.layouts.app')
@section('title', 'Nội dung')
@section('content')
<div class="panel">
    <div class="panel-header d-flex justify-content-between align-items-center">
        Quản lý nội dung website
        <a href="{{ route('admin.contents.create') }}" class="btn btn-admin-primary btn-sm"><i class="fas fa-plus"></i> Thêm nội dung</a>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>Key</th><th>Loại</th><th>Tiêu đề</th><th>Trạng thái</th><th></th></tr></thead>
            <tbody>
                @foreach($contents as $c)
                    <tr>
                        <td><code>{{ $c->key }}</code></td>
                        <td>{{ $c->type }}</td>
                        <td>{{ $c->translation()?->title }}</td>
                        <td>{!! $c->is_active ? '<span class="badge bg-success">Hiển thị</span>' : '<span class="badge bg-secondary">Ẩn</span>' !!}</td>
                        <td>
                            <a href="{{ route('admin.contents.edit', $c) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.contents.destroy', $c) }}" method="POST" class="d-inline" onsubmit="return confirm('Xoá nội dung này?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-3">{{ $contents->links() }}</div>
</div>
@endsection
