@extends('admin.layouts.app')
@section('title', 'Menu header')
@section('content')
    <div class="panel">
        <div class="panel-header d-flex justify-content-between align-items-center">
            <span>Quản lý menu header</span>
            <a href="{{ route('admin.header-menu.create') }}" class="btn btn-admin-primary btn-sm"><i
                    class="fas fa-plus"></i> Thêm mục menu</a>
        </div>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Key</th>
                        <th>Nhãn hiện tại</th>
                        <th>Kiểu liên kết</th>
                        <th>Thứ tự</th>
                        <th>Trạng thái</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($menuItems as $item)
                        <tr>
                            <td>{{ $item->key }}</td>
                            <td><i class="{{ $item->icon }} me-1"></i>{{ $item->translation()?->label }}</td>
                            <td>{{ $item->is_category ? 'Danh mục sản phẩm' : strtoupper($item->link_type) }}</td>
                            <td>{{ $item->sort_order }}</td>
                            <td>{!! $item->is_active ? '<span class="badge bg-success">Hiển thị</span>' : '<span class="badge bg-secondary">Ẩn</span>' !!}
                            </td>
                            <td>
                                <a href="{{ route('admin.header-menu.edit', $item) }}" class="btn btn-sm btn-outline-primary"><i
                                        class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.header-menu.destroy', $item) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Xoá mục menu này?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">Chưa có mục menu.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection